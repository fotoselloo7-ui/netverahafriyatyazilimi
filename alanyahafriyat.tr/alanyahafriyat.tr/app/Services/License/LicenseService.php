<?php

declare(strict_types=1);

namespace App\Services\License;

use App\Core\Config;
use App\Core\Database;
use App\Services\SettingsService;

/**
 * DijiKey License Center istemci servisi (merkezi lisans doğrulama).
 *
 * Akış: activate -> verify (24 saatte bir, HMAC imzalı cache) -> heartbeat.
 * API'ye ulaşılamazsa son başarılı doğrulamadan itibaren 7 gün grace period
 * uygulanır; grace dolunca sistem fail-closed davranır.
 *
 * Güvenlik:
 *  - Lisans anahtarı DB'de AES-256-CBC ile şifreli tutulur, ekranda maskeli gösterilir.
 *  - Cache dosyası HMAC-SHA256 imzalıdır; imza bozuksa cache geçersiz sayılır.
 *  - Kod içinde bypass sabiti / sahte anahtar YOKTUR. DIGIKEY_ENV=local yalnızca
 *    yerel geliştirme modudur (kilitleme yapmaz, sahte lisans üretmez).
 */
class LicenseService
{
    /** İstek başına durum önbelleği (aynı istekte tekrar API'ye gitmeyi önler). */
    protected static ?array $memo = null;

    // ---------------- Konfigürasyon ----------------

    public static function mode(): string
    {
        return strtolower((string) Config::get('digikey.env', 'production'));
    }

    /** Lisans zorunluluğu yalnızca production modda uygulanır. */
    public static function enforced(): bool
    {
        return static::mode() === 'production';
    }

    public static function baseUrl(): string
    {
        return rtrim((string) Config::get('digikey.base_url', ''), '/');
    }

    public static function productSlug(): string
    {
        return (string) Config::get('digikey.product_slug', 'ersan-hafriyat-cms');
    }

    public static function graceDays(): int
    {
        return max(1, (int) Config::get('digikey.grace_days', 7));
    }

    public static function verifyIntervalHours(): int
    {
        return max(1, (int) Config::get('digikey.verify_interval_hours', 24));
    }

    /**
     * API uç yolları — tek noktadan (config/app.php > digikey.endpoints) yönetilir,
     * .env ile tek tek override edilebilir. Kodda hardcoded endpoint yoktur.
     * @return array{activate:string,verify:string,heartbeat:string,health:string}
     */
    public static function endpoints(): array
    {
        $defaults = [
            'activate'  => '/api/v1/activate',
            'verify'    => '/api/v1/verify',
            'heartbeat' => '/api/v1/heartbeat',
            'health'    => '/api/v1/public-settings',
        ];
        $cfg = Config::get('digikey.endpoints', []);
        return array_merge($defaults, is_array($cfg) ? array_filter($cfg) : []);
    }

    /** Tam endpoint URL'si (base_url boşsa boş döner). */
    public static function endpointUrl(string $name): string
    {
        $base = static::baseUrl();
        if ($base === '') {
            return '';
        }
        $path = static::endpoints()[$name] ?? ('/api/v1/' . $name);
        return $base . '/' . ltrim($path, '/');
    }

    protected static function timeout(): int
    {
        return max(3, (int) Config::get('digikey.timeout', 10));
    }

    /** HMAC / şifreleme sırrı. Boşsa APP_KEY, o da yoksa kurulum yoluna bağlı türetilir. */
    protected static function secret(): string
    {
        $s = (string) Config::get('digikey.cache_secret', '');
        if ($s === '') {
            $s = (string) Config::get('app.key', '');
        }
        if ($s === '') {
            $s = hash('sha256', 'eh-lic|' . BASE_PATH);
        }
        return $s;
    }

    // ---------------- Anahtar yönetimi ----------------

    public static function getKey(): string
    {
        $enc = (string) SettingsService::get('license_key_encrypted', '');
        if ($enc === '') {
            return '';
        }
        return (string) (static::decrypt($enc) ?? '');
    }

    public static function setKey(string $key): void
    {
        $key = trim($key);
        SettingsService::set('license_key_encrypted', $key === '' ? '' : static::encrypt($key), 'license', 'text');
        static::$memo = null;
    }

    public static function maskKey(?string $key = null): string
    {
        $key = $key ?? static::getKey();
        if ($key === '') {
            return '';
        }
        $parts = explode('-', $key);
        if (count($parts) < 3) {
            return substr($key, 0, 4) . str_repeat('*', max(0, strlen($key) - 8)) . substr($key, -4);
        }
        $last = array_key_last($parts);
        foreach ($parts as $i => $p) {
            if ($i > 0 && $i !== $last) {
                $parts[$i] = str_repeat('*', strlen($p));
            }
        }
        return implode('-', $parts);
    }

    // ---------------- Domain normalize ----------------

    /**
     * https://www.ersanhafriyat.com.tr/hakkimizda?x=1 -> ersanhafriyat.com.tr
     */
    public static function normalizeDomain(?string $raw = null): string
    {
        $raw = $raw ?? ($_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost');
        $raw = trim(strtolower($raw));
        $raw = preg_replace('#^https?://#', '', $raw);
        // path / query / hash temizle
        foreach (['/', '?', '#'] as $sep) {
            $pos = strpos($raw, $sep);
            if ($pos !== false) {
                $raw = substr($raw, 0, $pos);
            }
        }
        // port temizle (IPv6 köşeli parantez durumu hariç basit host varsayımı)
        if (substr_count($raw, ':') === 1) {
            $raw = explode(':', $raw)[0];
        }
        $raw = preg_replace('#^www\.#', '', $raw);
        return trim($raw, '.');
    }

    protected static function fingerprint(): string
    {
        $raw = ($_SERVER['SERVER_NAME'] ?? '') . '|' . PHP_OS . '|' . ($_SERVER['DOCUMENT_ROOT'] ?? BASE_PATH);
        return substr(hash('sha256', $raw), 0, 32);
    }

    // ---------------- HMAC imzalı cache ----------------

    protected static function cacheFile(): string
    {
        return STORAGE_PATH . '/license/license_cache.json';
    }

    /** Geçerli imzalı cache'i döner; imza bozuksa null (ve cache temizlenir). */
    public static function readCache(): ?array
    {
        $file = static::cacheFile();
        if (!is_file($file)) {
            return null;
        }
        $decoded = json_decode((string) file_get_contents($file), true);
        if (!is_array($decoded) || !isset($decoded['d'], $decoded['sig'])) {
            static::clearCache();
            return null;
        }
        $expected = hash_hmac('sha256', json_encode($decoded['d']), static::secret());
        if (!hash_equals($expected, (string) $decoded['sig'])) {
            // Elle oynanmış cache: geçersiz say, sil, logla.
            static::clearCache();
            static::log('cache_tamper', 'invalid', 'Lisans önbelleği imzası geçersiz — önbellek yok sayıldı.');
            return null;
        }
        return is_array($decoded['d']) ? $decoded['d'] : null;
    }

    public static function writeCache(array $result): void
    {
        // Cache içine düz lisans anahtarı asla yazılmaz.
        unset($result['license_key']);
        if (isset($result['license']) && is_array($result['license'])) {
            unset($result['license']['license_key'], $result['license']['key']);
        }
        $data = [
            'result'        => $result,
            'last_verified' => time(),
            'last_online'   => time(),
            'domain'        => static::normalizeDomain(),
        ];
        $dir = dirname(static::cacheFile());
        if (!is_dir($dir)) {
            @mkdir($dir, 0775, true);
        }
        $payload = ['d' => $data, 'sig' => hash_hmac('sha256', json_encode($data), static::secret())];
        @file_put_contents(static::cacheFile(), json_encode($payload), LOCK_EX);
        static::$memo = null;
    }

    public static function clearCache(): void
    {
        @unlink(static::cacheFile());
        static::$memo = null;
    }

    protected static function cacheFresh(array $cache): bool
    {
        return (time() - (int) ($cache['last_verified'] ?? 0)) < static::verifyIntervalHours() * 3600;
    }

    public static function isWithinGracePeriod(?array $cache = null): bool
    {
        $cache = $cache ?? static::readCache();
        if (!$cache) {
            return false;
        }
        return (time() - (int) ($cache['last_online'] ?? 0)) < static::graceDays() * 86400;
    }

    public static function graceRemainingDays(?array $cache = null): int
    {
        $cache = $cache ?? static::readCache();
        if (!$cache) {
            return 0;
        }
        $end = (int) ($cache['last_online'] ?? 0) + static::graceDays() * 86400;
        return max(0, (int) ceil(($end - time()) / 86400));
    }

    // ---------------- API ----------------

    protected static function payload(string $key): array
    {
        return [
            'license_key'        => $key,
            'product_slug'       => static::productSlug(),
            'domain'             => static::normalizeDomain(),
            'ip_address'         => $_SERVER['SERVER_ADDR'] ?? '',
            'server_fingerprint' => static::fingerprint(),
            'app_version'        => (string) Config::get('app.version', '1.0.0'),
        ];
    }

    protected static function request(string $endpoint, array $payload): ?array
    {
        $url = static::endpointUrl($endpoint);
        if ($url === '') {
            return null;
        }
        $body = json_encode($payload);
        $signature = hash_hmac('sha256', (string) $body, (string) Config::get('digikey.api_secret', ''));
        $headers = ['Content-Type: application/json', 'Accept: application/json', 'X-Signature: ' . $signature];

        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $body,
                CURLOPT_HTTPHEADER     => $headers,
                CURLOPT_TIMEOUT        => static::timeout(),
                CURLOPT_CONNECTTIMEOUT => 5,
            ]);
            $response = curl_exec($ch);
            $ok = $response !== false && curl_errno($ch) === 0;
            curl_close($ch);
            if (!$ok) {
                return null;
            }
            $decoded = json_decode((string) $response, true);
            return is_array($decoded) ? $decoded : null;
        }

        $ctx = stream_context_create(['http' => [
            'method' => 'POST', 'header' => implode("\r\n", $headers),
            'content' => $body, 'timeout' => static::timeout(), 'ignore_errors' => true,
        ]]);
        $response = @file_get_contents($url, false, $ctx);
        if ($response === false) {
            return null;
        }
        $decoded = json_decode($response, true);
        return is_array($decoded) ? $decoded : null;
    }

    // ---------------- Akışlar ----------------

    /**
     * Lisans aktivasyonu / lisans değiştirme.
     *
     * GÜVENLİ AKIŞ: Yeni anahtar önce sunucuda doğrulanır; anahtar ve cache
     * YALNIZCA aktivasyon başarılı olursa kaydedilir. Böylece "Lisans Değiştir"
     * ekranında yeni anahtar geçersiz çıkarsa mevcut çalışan lisans korunur.
     */
    public static function activate(string $licenseKey): array
    {
        $licenseKey = trim($licenseKey);
        if ($licenseKey === '') {
            return ['success' => false, 'active' => false, 'status' => 'invalid', 'message' => 'Lisans anahtarı boş olamaz.'];
        }

        $res = static::request('activate', static::payload($licenseKey));
        if ($res === null) {
            static::log('activate', 'network_error', 'Lisans sunucusuna ulaşılamadı (activate). Mevcut lisans korunuyor.', null, static::endpointUrl('activate'));
            return ['success' => false, 'active' => false, 'status' => 'unreachable', 'message' => 'Lisans sunucusuna ulaşılamadı. İnternet bağlantısını ve DIGIKEY_BASE_URL ayarını kontrol edin.'];
        }

        $norm = static::normalizeResult($res);
        if ($norm['active']) {
            // Başarılı: eski cache temizlenir, yeni anahtar + cache kaydedilir.
            static::clearCache();
            static::setKey($licenseKey);
            static::writeCache($res);
            static::persistState($norm, $res);
        }
        // Başarısızsa eski anahtar/cache'e DOKUNULMAZ (mevcut lisans boşa düşmez).
        static::log('activate', $norm['status'], $norm['message'] ?: ('Aktivasyon sonucu: ' . $norm['status']), $res, static::endpointUrl('activate'));
        return $norm + ['raw' => $res];
    }

    public static function verify(bool $force = false): array
    {
        $key = static::getKey();
        if ($key === '') {
            return ['success' => false, 'status' => 'needs_activation', 'message' => 'Lisans anahtarı girilmemiş.'];
        }

        $cache = static::readCache();
        if (!$force && $cache && static::cacheFresh($cache)) {
            return static::normalizeResult($cache['result'] ?? []) + ['cached' => true];
        }

        $res = static::request('verify', static::payload($key));
        if ($res !== null) {
            static::writeCache($res);
            $norm = static::normalizeResult($res);
            static::persistState($norm, $res);
            static::log('verify', $norm['status'], $norm['message'] ?: ('Doğrulama sonucu: ' . $norm['status']), $res, static::endpointUrl('verify'));
            return $norm + ['raw' => $res];
        }

        static::log('verify', 'network_error', 'Lisans sunucusuna ulaşılamadı (verify).', null, static::endpointUrl('verify'));
        if ($cache) {
            $norm = static::normalizeResult($cache['result'] ?? []);
            if ($norm['active'] && static::isWithinGracePeriod($cache)) {
                return $norm + ['offline' => true, 'grace_remaining_days' => static::graceRemainingDays($cache)];
            }
            return ['success' => false, 'status' => $norm['active'] ? 'grace_expired' : $norm['status'], 'message' => 'Lisans sunucusuna ulaşılamıyor ve çevrimdışı çalışma süresi doldu.', 'offline' => true];
        }
        return ['success' => false, 'status' => 'unreachable', 'message' => 'Lisans sunucusuna ulaşılamadı ve geçerli bir önbellek yok.', 'offline' => true];
    }

    public static function heartbeat(): array
    {
        $key = static::getKey();
        if ($key === '') {
            return ['success' => false, 'status' => 'needs_activation'];
        }
        $res = static::request('heartbeat', static::payload($key));
        if ($res === null) {
            static::log('heartbeat', 'network_error', 'Heartbeat gönderilemedi (sunucuya ulaşılamadı).', null, static::endpointUrl('heartbeat'));
            return ['success' => false, 'status' => 'unreachable'];
        }
        SettingsService::set('license_last_heartbeat_at', date('Y-m-d H:i:s'), 'license');
        $norm = static::normalizeResult($res);
        static::log('heartbeat', $norm['status'], 'Heartbeat gönderildi.', $res, static::endpointUrl('heartbeat'));
        return $norm;
    }

    /** Fırsatçı heartbeat: son gönderimden bu yana 24 saati geçtiyse gönderir. */
    public static function heartbeatIfDue(): void
    {
        $last = (string) SettingsService::get('license_last_heartbeat_at', '');
        if ($last !== '' && (time() - strtotime($last)) < 24 * 3600) {
            return;
        }
        try {
            static::heartbeat();
        } catch (\Throwable $e) {
            // heartbeat asla sayfayı kırmaz
        }
    }

    // ---------------- Durum makinesi ----------------

    /**
     * Merkezi durum. Dönen dizi:
     *  state: local|unconfigured|needs_activation|active|grace|suspended|expired|
     *         domain_mismatch|invalid|unreachable|grace_expired
     *  locked: bool (admin kilidi), ayrıca meta alanlar.
     */
    public static function getStatus(bool $allowNetwork = true): array
    {
        if (static::$memo !== null) {
            return static::$memo;
        }

        if (!static::enforced()) {
            return static::$memo = ['state' => 'local', 'locked' => false, 'mode' => static::mode()];
        }
        if (static::baseUrl() === '') {
            return static::$memo = ['state' => 'unconfigured', 'locked' => true, 'message' => 'Lisans sunucusu (DIGIKEY_BASE_URL) yapılandırılmamış.'];
        }
        if (static::getKey() === '') {
            return static::$memo = ['state' => 'needs_activation', 'locked' => true];
        }

        $cache = static::readCache();

        // Taze cache -> ağa çıkmadan cevap (olumlu ya da olumsuz karar cache'lenir)
        if ($cache && static::cacheFresh($cache)) {
            $norm = static::normalizeResult($cache['result'] ?? []);
            return static::$memo = static::stateFrom($norm, $cache, false);
        }

        if (!$allowNetwork) {
            if ($cache) {
                $norm = static::normalizeResult($cache['result'] ?? []);
                if ($norm['active'] && static::isWithinGracePeriod($cache)) {
                    return static::$memo = static::stateFrom($norm, $cache, true);
                }
                return static::$memo = ['state' => $norm['active'] ? 'grace_expired' : $norm['status'], 'locked' => true, 'message' => $norm['message']];
            }
            return static::$memo = ['state' => 'unreachable', 'locked' => true, 'message' => 'Doğrulanmış lisans bulunamadı.'];
        }

        $result = static::verify(true);
        $status = (string) ($result['status'] ?? 'invalid');
        if (($result['active'] ?? false) === true) {
            $st = ['state' => 'active', 'locked' => false] + static::metaFrom($result);
            if (!empty($result['offline'])) {
                $st['state'] = 'grace';
                $st['offline'] = true;
                $st['grace_remaining_days'] = $result['grace_remaining_days'] ?? static::graceRemainingDays();
            }
            return static::$memo = $st;
        }
        return static::$memo = ['state' => $status, 'locked' => true, 'message' => (string) ($result['message'] ?? ''), 'offline' => !empty($result['offline'])] + static::metaFrom($result);
    }

    protected static function stateFrom(array $norm, array $cache, bool $offline): array
    {
        if ($norm['active']) {
            $st = ['state' => $offline ? 'grace' : 'active', 'locked' => false] + static::metaFrom($norm);
            if ($offline) {
                $st['offline'] = true;
                $st['grace_remaining_days'] = static::graceRemainingDays($cache);
            }
            return $st;
        }
        return ['state' => $norm['status'], 'locked' => true, 'message' => $norm['message']] + static::metaFrom($norm);
    }

    public static function isLicensed(): bool
    {
        $st = static::getStatus(true);
        return !($st['locked'] ?? true);
    }

    /** Frontend koruması: production'da lisans (grace dahil) geçerli değilse true. */
    public static function frontendBlocked(): bool
    {
        if (!static::enforced()) {
            return false;
        }
        try {
            $st = static::getStatus(true);
            return (bool) ($st['locked'] ?? true);
        } catch (\Throwable $e) {
            return false; // lisans katmanı hatası siteyi asla çökertmesin
        }
    }

    // ---------------- Yardımcılar ----------------

    /**
     * API cevabını esnek şekilde normalize eder.
     * status: active|suspended|expired|invalid|domain_mismatch|...
     */
    public static function normalizeResult(array $res): array
    {
        $success = (bool) ($res['success'] ?? false);
        $status = strtolower((string) ($res['license_status'] ?? $res['status'] ?? ''));
        $reason = strtolower((string) ($res['reason'] ?? ''));
        if ($status === '') {
            $status = $success ? 'active' : ($reason !== '' ? $reason : 'invalid');
        }
        if (in_array($reason, ['domain_mismatch', 'suspended', 'expired'], true)) {
            $status = $reason;
        }
        if (!in_array($status, ['active', 'suspended', 'expired', 'invalid', 'domain_mismatch'], true)) {
            $status = $success ? 'active' : 'invalid';
        }
        return [
            'success' => $success,
            'active'  => $success && $status === 'active',
            'status'  => $status,
            'message' => (string) ($res['message'] ?? $res['reason'] ?? ''),
            'license' => is_array($res['license'] ?? null) ? $res['license'] : [],
            'customer'=> is_array($res['customer'] ?? null) ? $res['customer'] : [],
            'product' => is_array($res['product'] ?? null) ? $res['product'] : [],
            'expires_at' => (string) ($res['license']['expires_at'] ?? $res['expires_at'] ?? ''),
            'allowed_domain' => (string) ($res['license']['domain'] ?? $res['allowed_domain'] ?? ''),
        ];
    }

    protected static function metaFrom(array $norm): array
    {
        return array_filter([
            'expires_at' => $norm['expires_at'] ?? '',
            'allowed_domain' => $norm['allowed_domain'] ?? '',
            'customer' => $norm['customer'] ?? [],
            'product' => $norm['product'] ?? [],
        ]);
    }

    protected static function persistState(array $norm, array $raw): void
    {
        try {
            SettingsService::set('license_status', $norm['status'], 'license');
            SettingsService::set('license_last_verified_at', date('Y-m-d H:i:s'), 'license');
            SettingsService::set('license_grace_until', date('Y-m-d H:i:s', time() + static::graceDays() * 86400), 'license');
            $payload = $raw;
            unset($payload['license_key']);
            if (isset($payload['license']) && is_array($payload['license'])) {
                unset($payload['license']['license_key'], $payload['license']['key']);
            }
            SettingsService::set('license_payload_json', json_encode($payload, JSON_UNESCAPED_UNICODE), 'license');
        } catch (\Throwable $e) {
        }
    }

    public static function log(string $eventType, string $status, string $message, ?array $response = null, ?string $requestUrl = null): void
    {
        try {
            Database::execute(
                'INSERT INTO license_logs (event_type, status, message, request_url, response_json, created_at) VALUES (?,?,?,?,?,?)',
                [$eventType, $status, $message, $requestUrl, $response ? json_encode($response, JSON_UNESCAPED_UNICODE) : null, date('Y-m-d H:i:s')]
            );
        } catch (\Throwable $e) {
            // loglama hatası akışı bozmaz
        }
    }

    /**
     * Lisans sunucusu erişilebilirlik testi.
     * Sonuç: state = success | http_error | timeout | unreachable | unconfigured
     */
    public static function testServer(): array
    {
        $base = static::baseUrl();
        if ($base === '') {
            $res = ['state' => 'unconfigured', 'message' => 'DIGIKEY_BASE_URL yapılandırılmamış (.env).'];
            static::log('server_test', 'unconfigured', $res['message']);
            return $res;
        }

        // Tüm uçları sırayla yokla (yalnızca bağlantı/uç kontrolü — lisans aktive etmez)
        $checks = [];
        foreach (['health', 'verify', 'activate', 'heartbeat'] as $name) {
            $checks[] = static::testEndpoint($name, false);
        }
        $overallOk = (bool) array_filter($checks, fn ($c) => $c['ok']);
        $anyTimeout = (bool) array_filter($checks, fn ($c) => ($c['state'] ?? '') === 'timeout');

        $warnings = [];
        if ((string) Config::get('digikey.api_secret', '') === '') {
            $warnings[] = 'DIGIKEY_API_SECRET boş — imzalı istekler lisans sunucusunda reddedilebilir.';
        }
        if (static::getKey() === '') {
            $warnings[] = 'Henüz lisans anahtarı girilmemiş.';
        }

        $state = $overallOk ? 'success' : ($anyTimeout ? 'timeout' : 'unreachable');
        $res = ['state' => $state, 'checks' => $checks, 'warnings' => $warnings, 'base_url' => $base];
        static::log('server_test', $state, $overallOk ? 'Lisans sunucusu erişilebilir.' : 'Lisans sunucusuna ulaşılamadı.', ['checks' => $checks], $base);
        return $res;
    }

    /**
     * Tek bir API ucunu test eder (yalnızca erişilebilirlik/format kontrolü;
     * lisans aktive ETMEZ). health → GET, diğerleri → boş imzalı POST probe.
     * Sonuç: name, url, ok, ms, state(success|timeout|not_found|unreachable|bad_format|http_error|unconfigured), detail
     */
    public static function testEndpoint(string $name, bool $logIt = true): array
    {
        $url = static::endpointUrl($name);
        if ($url === '') {
            $out = ['name' => $name, 'url' => '', 'ok' => false, 'ms' => 0, 'state' => 'unconfigured', 'detail' => 'DIGIKEY_BASE_URL boş.'];
            if ($logIt) { static::log('endpoint_test', 'unconfigured', "$name ucu test edilemedi: base URL boş."); }
            return $out;
        }

        $t0 = microtime(true);
        if ($name === 'health') {
            [$httpCode, $body, $err, $timedOut] = static::rawGet($url);
            $ms = (int) round((microtime(true) - $t0) * 1000);
            $json = is_string($body) ? json_decode($body, true) : null;
            if ($timedOut) {
                $out = ['ok' => false, 'state' => 'timeout', 'detail' => 'Zaman aşımı (' . static::timeout() . 's).'];
            } elseif ($httpCode === 0) {
                $out = ['ok' => false, 'state' => 'unreachable', 'detail' => 'API bağlantısı kurulamadı: ' . ($err ?: 'bağlantı hatası')];
            } elseif ($httpCode === 404) {
                $out = ['ok' => false, 'state' => 'not_found', 'detail' => 'HTTP 404 — endpoint bulunamadı (yol yanlış olabilir).'];
            } elseif ($httpCode >= 200 && $httpCode < 300 && is_array($json)) {
                $out = ['ok' => true, 'state' => 'success', 'detail' => 'HTTP ' . $httpCode . ' — geçerli JSON yanıt.'];
            } elseif ($httpCode >= 200 && $httpCode < 300) {
                $out = ['ok' => false, 'state' => 'bad_format', 'detail' => 'Yanıt alındı ama JSON formatı geçersiz.'];
            } else {
                $out = ['ok' => false, 'state' => 'http_error', 'detail' => 'HTTP ' . $httpCode . ' yanıtı alındı.'];
            }
        } else {
            // POST uçları: boş anahtarla probe — uç yanıt veriyorsa (404 değilse) mevcuttur.
            $probe = static::request($name, ['license_key' => '', 'product_slug' => static::productSlug(), 'domain' => static::normalizeDomain()]);
            $ms = (int) round((microtime(true) - $t0) * 1000);
            if ($probe === null) {
                $out = ['ok' => false, 'state' => 'unreachable', 'detail' => 'Uca ulaşılamadı (bağlantı/timeout ya da JSON dışı yanıt).'];
            } else {
                $out = ['ok' => true, 'state' => 'success', 'detail' => 'Uç yanıt veriyor (success=' . var_export((bool) ($probe['success'] ?? false), true) . ').'];
            }
        }

        $out = ['name' => $name, 'url' => $url, 'ms' => $ms] + $out;
        if ($logIt) {
            static::log('endpoint_test', $out['state'], "$name: " . $out['detail'], null, $url);
        }
        return $out;
    }

    /**
     * Cache HMAC durumu (readCache'in aksine dosyaya DOKUNMAZ, silmez):
     * valid | invalid | none
     */
    public static function cacheState(): string
    {
        $file = static::cacheFile();
        if (!is_file($file)) {
            return 'none';
        }
        $decoded = json_decode((string) file_get_contents($file), true);
        if (!is_array($decoded) || !isset($decoded['d'], $decoded['sig'])) {
            return 'invalid';
        }
        $expected = hash_hmac('sha256', json_encode($decoded['d']), static::secret());
        return hash_equals($expected, (string) $decoded['sig']) ? 'valid' : 'invalid';
    }

    /** Standart isim takma adları (diğer panellerimizle API uyumu). */
    public static function maskLicenseKey(?string $key = null): string
    {
        return static::maskKey($key);
    }

    public static function logLicenseEvent(string $eventType, string $status, string $message, ?string $requestUrl = null, ?array $response = null): void
    {
        static::log($eventType, $status, $message, $response, $requestUrl);
    }

    /** Basit GET (test amaçlı): [httpCode, body, error, timedOut] */
    protected static function rawGet(string $url): array
    {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT        => static::timeout(),
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_HTTPHEADER     => ['Accept: application/json'],
            ]);
            $body = curl_exec($ch);
            $code = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $errno = curl_errno($ch);
            $err = curl_error($ch);
            curl_close($ch);
            return [$code, $body === false ? null : (string) $body, $err, $errno === CURLE_OPERATION_TIMEDOUT];
        }
        $ctx = stream_context_create(['http' => ['timeout' => static::timeout(), 'ignore_errors' => true]]);
        $body = @file_get_contents($url, false, $ctx);
        $code = 0;
        foreach ($http_response_header ?? [] as $h) {
            if (preg_match('#HTTP/\S+\s+(\d{3})#', $h, $m)) { $code = (int) $m[1]; }
        }
        return [$code, $body === false ? null : $body, $body === false ? 'bağlantı hatası' : '', false];
    }

    public static function logs(int $limit = 15): array
    {
        try {
            return Database::select('SELECT * FROM license_logs ORDER BY id DESC LIMIT ' . (int) $limit);
        } catch (\Throwable $e) {
            return [];
        }
    }

    // ---------------- Şifreleme ----------------

    protected static function encrypt(string $plain): string
    {
        $key = hash('sha256', static::secret(), true);
        $iv = random_bytes(16);
        $ct = openssl_encrypt($plain, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
        return base64_encode($iv . $ct);
    }

    protected static function decrypt(string $enc): ?string
    {
        $raw = base64_decode($enc, true);
        if ($raw === false || strlen($raw) < 17) {
            return null;
        }
        $iv = substr($raw, 0, 16);
        $ct = substr($raw, 16);
        $pt = openssl_decrypt($ct, 'AES-256-CBC', hash('sha256', static::secret(), true), OPENSSL_RAW_DATA, $iv);
        return $pt === false ? null : $pt;
    }
}
