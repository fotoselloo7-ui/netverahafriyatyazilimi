<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Config;
use App\Core\Session;
use App\Services\License\LicenseService;
use App\Services\SettingsService;

class LicenseController extends AdminBaseController
{
    /** Lisans Durumu ekranı. */
    public function index(): void
    {
        $status = LicenseService::getStatus(true);
        $cache = LicenseService::readCache();
        $payload = json_decode_safe((string) SettingsService::get('license_payload_json', ''));

        $this->adminView('admin/license/index', [
            'pageTitle'   => 'Lisans Durumu',
            'status'      => $status,
            'mode'        => LicenseService::mode(),
            'enforced'    => LicenseService::enforced(),
            'maskedKey'   => LicenseService::maskKey(),
            'domain'      => LicenseService::normalizeDomain(),
            'baseUrl'     => LicenseService::baseUrl(),
            'productSlug' => LicenseService::productSlug(),
            'appVersion'  => (string) Config::get('app.version', '1.0.0'),
            'lastVerified'=> (string) SettingsService::get('license_last_verified_at', ''),
            'lastHeartbeat'=> (string) SettingsService::get('license_last_heartbeat_at', ''),
            'graceUntil'  => (string) SettingsService::get('license_grace_until', ''),
            'graceDays'   => LicenseService::graceDays(),
            'verifyHours' => LicenseService::verifyIntervalHours(),
            'cacheAt'     => $cache ? date('d.m.Y H:i', (int) ($cache['last_verified'] ?? 0)) : '',
            'cacheState'  => LicenseService::cacheState(),
            'endpoints'   => [
                'health'    => LicenseService::endpointUrl('health'),
                'verify'    => LicenseService::endpointUrl('verify'),
                'activate'  => LicenseService::endpointUrl('activate'),
                'heartbeat' => LicenseService::endpointUrl('heartbeat'),
            ],
            'payload'     => $payload,
            'logs'        => LicenseService::logs(15),
        ]);
    }

    /** Lisans Anahtarı Gir / Aktif Et ekranı. */
    public function activateForm(): void
    {
        $this->adminView('admin/license/activate', [
            'pageTitle'   => 'Lisans Aktivasyonu',
            'mode'        => LicenseService::mode(),
            'enforced'    => LicenseService::enforced(),
            'domain'      => LicenseService::normalizeDomain(),
            'productSlug' => LicenseService::productSlug(),
            'baseUrl'     => LicenseService::baseUrl(),
            'hasKey'      => LicenseService::getKey() !== '',
            'change'      => false,
        ]);
    }

    /** Lisans Değiştir ekranı (mevcut anahtar maskeli + durum + son doğrulama). */
    public function changeForm(): void
    {
        $status = LicenseService::getStatus(true);
        $this->adminView('admin/license/activate', [
            'pageTitle'   => 'Lisans Değiştir',
            'mode'        => LicenseService::mode(),
            'enforced'    => LicenseService::enforced(),
            'domain'      => LicenseService::normalizeDomain(),
            'productSlug' => LicenseService::productSlug(),
            'baseUrl'     => LicenseService::baseUrl(),
            'hasKey'      => LicenseService::getKey() !== '',
            'maskedKey'   => LicenseService::maskKey(),
            'curState'    => (string) ($status['state'] ?? ''),
            'lastVerified'=> (string) SettingsService::get('license_last_verified_at', ''),
            'change'      => true,
        ]);
    }

    /** Aktivasyon / anahtar değiştirme POST işlemi. */
    public function doActivate(): void
    {
        $this->verifyCsrf();
        $isChange = ($_POST['form_mode'] ?? '') === 'change';
        $backTo = $isChange ? 'yonetim/lisans/degistir' : 'yonetim/lisans/aktif-et';

        $key = trim((string) ($_POST['license_key'] ?? ''));
        if ($key === '') {
            Session::flash('flash_err', 'Lütfen lisans anahtarınızı girin.');
            $this->redirect($backTo);
            return;
        }
        if (LicenseService::baseUrl() === '') {
            Session::flash('flash_err', 'Lisans sunucusu yapılandırılmamış (DIGIKEY_BASE_URL boş). Lütfen .env dosyasını kontrol edin.');
            $this->redirect($backTo);
            return;
        }

        $result = LicenseService::activate($key);

        if (($result['active'] ?? false) === true) {
            Session::flash('flash_ok', $isChange
                ? 'Yeni lisans doğrulandı ve etkinleştirildi. Eski önbellek temizlendi.'
                : 'Lisans başarıyla etkinleştirildi. Hoş geldiniz!');
            $this->redirect('yonetim/lisans');
            return;
        }

        $msg = match ($result['status'] ?? 'invalid') {
            'unreachable'     => 'Lisans sunucusuna ulaşılamadı. Bağlantınızı kontrol edip tekrar deneyin.',
            'domain_mismatch' => 'Bu lisans anahtarı bu alan adı (' . LicenseService::normalizeDomain() . ') için tanımlı değil.',
            'suspended'       => 'Bu lisans askıya alınmış. Lütfen destek ile iletişime geçin.',
            'expired'         => 'Bu lisansın süresi dolmuş. Yenileme için destek ile iletişime geçin.',
            default           => 'Lisans doğrulanamadı: ' . (($result['message'] ?? '') !== '' ? $result['message'] : 'geçersiz anahtar'),
        };
        if ($isChange && LicenseService::getKey() !== '') {
            $msg .= ' Mevcut lisansınız korunmaya devam ediyor.';
        }
        Session::flash('flash_err', $msg);
        $this->redirect($backTo);
    }

    /** Lisans Sunucusu Testi: tüm uçlar ya da tek uç (POST'ta endpoint=health|verify|activate|heartbeat). */
    public function serverTest(): void
    {
        $result = null;
        $single = null;
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
            $this->verifyCsrf();
            $ep = (string) ($_POST['endpoint'] ?? '');
            if (in_array($ep, ['health', 'verify', 'activate', 'heartbeat'], true)) {
                $single = LicenseService::testEndpoint($ep);
            } else {
                $result = LicenseService::testServer();
            }
        }
        $this->adminView('admin/license/server-test', [
            'pageTitle'   => 'Lisans Sunucusu Testi',
            'result'      => $result,
            'single'      => $single,
            'baseUrl'     => LicenseService::baseUrl(),
            'productSlug' => LicenseService::productSlug(),
            'domain'      => LicenseService::normalizeDomain(),
            'timeout'     => (int) Config::get('digikey.timeout', 10),
            'hasSecret'   => (string) Config::get('digikey.api_secret', '') !== '',
            'mode'        => LicenseService::mode(),
            'endpoints'   => [
                'health'    => LicenseService::endpointUrl('health'),
                'verify'    => LicenseService::endpointUrl('verify'),
                'activate'  => LicenseService::endpointUrl('activate'),
                'heartbeat' => LicenseService::endpointUrl('heartbeat'),
            ],
        ]);
    }

    /** Sidebar'dan GET ile gelen "Yeniden Doğrula" — force verify çalıştırır. */
    public function verifyGet(): void
    {
        $this->runVerify();
    }

    /** Manuel "Yeniden Doğrula" (force verify, POST + CSRF). */
    public function verify(): void
    {
        $this->verifyCsrf();
        $this->runVerify();
    }

    protected function runVerify(): void
    {
        if (LicenseService::getKey() === '') {
            Session::flash('flash_err', 'Önce bir lisans anahtarı etkinleştirin.');
            $this->redirect('yonetim/lisans/aktif-et');
            return;
        }
        $result = LicenseService::verify(true);
        if (($result['active'] ?? false) === true) {
            Session::flash('flash_ok', 'Lisans doğrulandı — durum: AKTİF.' . (!empty($result['offline']) ? ' (çevrimdışı önbellekten)' : ''));
        } else {
            Session::flash('flash_err', 'Doğrulama sonucu: ' . ($result['status'] ?? 'geçersiz') . (($result['message'] ?? '') !== '' ? ' — ' . $result['message'] : ''));
        }
        $this->redirect('yonetim/lisans');
    }
}
