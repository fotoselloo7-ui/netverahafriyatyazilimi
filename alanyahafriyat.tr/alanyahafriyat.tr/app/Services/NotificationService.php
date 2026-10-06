<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\NotificationLog;
use App\Models\NotificationSetting;

/**
 * Bildirim servisi. Kimlik bilgileri girilmemişse sistem kırılmaz;
 * log'a "skipped_missing_credentials" olarak düşer.
 */
class NotificationService
{
    protected static ?array $config = null;

    protected static function config(): array
    {
        if (static::$config === null) {
            static::$config = NotificationSetting::current() ?: [];
        }
        return static::$config;
    }

    /** Bir olay için ilgili kanallara bildirim gönderir. */
    public static function dispatch(string $eventType, string $message, ?int $relatedId = null): void
    {
        $cfg = static::config();
        $flagMap = [
            'new_lead'      => 'notify_on_new_lead',
            'contact_form'  => 'notify_on_contact_form',
            'whatsapp_click'=> 'notify_on_whatsapp_click',
            'popup_click'   => 'notify_on_popup_click',
            'admin_login'   => 'notify_on_admin_login',
            'new_visitor'   => 'notify_on_new_visitor',
        ];
        $flag = $flagMap[$eventType] ?? null;
        if ($flag !== null && (int) ($cfg[$flag] ?? 0) !== 1) {
            return; // bu olay için bildirim kapalı
        }

        // Etkin kanal var mı? Yoksa denetim için tek bir "atlandı" kaydı düş.
        $anyChannelEnabled = (int) ($cfg['whatsapp_api_enabled'] ?? 0) === 1
            || (int) ($cfg['telegram_enabled'] ?? 0) === 1
            || (int) ($cfg['email_enabled'] ?? 0) === 1
            || (int) ($cfg['sms_enabled'] ?? 0) === 1;

        if (!$anyChannelEnabled) {
            static::log($eventType, 'none', $cfg['owner_phone'] ?? null, $message, 'skipped_missing_credentials', null, $relatedId);
            return;
        }

        static::sendWhatsApp($message, $relatedId, $eventType);
        static::sendTelegram($message, $relatedId, $eventType);
        static::sendEmail('Ersan Hafriyat Bildirim', $message, $relatedId, $eventType);
        static::sendSms($message, $relatedId, $eventType);
    }

    public static function sendWhatsApp(string $message, ?int $relatedId = null, string $eventType = 'manual'): void
    {
        $cfg = static::config();
        if ((int) ($cfg['whatsapp_api_enabled'] ?? 0) !== 1) {
            return; // WhatsApp API kapalı, sessizce geç
        }
        $token = $cfg['whatsapp_api_token'] ?? '';
        $phoneId = $cfg['whatsapp_phone_number_id'] ?? '';
        $to = $cfg['owner_phone'] ?? '';
        if ($token === '' || $phoneId === '' || $to === '') {
            static::log($eventType, 'whatsapp', $to, $message, 'skipped_missing_credentials', null, $relatedId);
            return;
        }
        // Gerçek gönderim (WhatsApp Cloud API). Hata olsa bile sistemi bozma.
        $url = "https://graph.facebook.com/v18.0/{$phoneId}/messages";
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => preg_replace('/[^0-9]/', '', $to),
            'type' => 'text',
            'text' => ['body' => $message],
        ];
        [$ok, $resp] = static::httpPost($url, json_encode($payload), [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ]);
        static::log($eventType, 'whatsapp', $to, $message, $ok ? 'sent' : 'failed', $resp, $relatedId);
    }

    public static function sendTelegram(string $message, ?int $relatedId = null, string $eventType = 'manual'): void
    {
        $cfg = static::config();
        if ((int) ($cfg['telegram_enabled'] ?? 0) !== 1) {
            return;
        }
        $token = $cfg['telegram_bot_token'] ?? '';
        $chatId = $cfg['telegram_chat_id'] ?? '';
        if ($token === '' || $chatId === '') {
            static::log($eventType, 'telegram', $chatId, $message, 'skipped_missing_credentials', null, $relatedId);
            return;
        }
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        [$ok, $resp] = static::httpPost($url, http_build_query(['chat_id' => $chatId, 'text' => $message]), []);
        static::log($eventType, 'telegram', $chatId, $message, $ok ? 'sent' : 'failed', $resp, $relatedId);
    }

    public static function sendEmail(string $subject, string $message, ?int $relatedId = null, string $eventType = 'manual'): void
    {
        $cfg = static::config();
        if ((int) ($cfg['email_enabled'] ?? 0) !== 1) {
            return;
        }
        $to = $cfg['owner_email'] ?? '';
        if ($to === '' || empty($cfg['smtp_host'])) {
            static::log($eventType, 'email', $to, $message, 'skipped_missing_credentials', null, $relatedId);
            return;
        }
        // PHP mail() fallback (SMTP kütüphanesi olmadan). Başarısızsa loglar.
        $headers = 'From: ' . ($cfg['smtp_user'] ?? 'noreply@ersanhafriyat.local') . "\r\n" .
                   'Content-Type: text/plain; charset=UTF-8';
        $ok = @mail($to, $subject, $message, $headers);
        static::log($eventType, 'email', $to, $message, $ok ? 'sent' : 'failed', null, $relatedId);
    }

    public static function sendSms(string $message, ?int $relatedId = null, string $eventType = 'manual'): void
    {
        $cfg = static::config();
        if ((int) ($cfg['sms_enabled'] ?? 0) !== 1) {
            return;
        }
        $to = $cfg['owner_phone'] ?? '';
        if (empty($cfg['sms_api_key']) || $to === '') {
            static::log($eventType, 'sms', $to, $message, 'skipped_missing_credentials', null, $relatedId);
            return;
        }
        // Sağlayıcıya özel entegrasyon gerektiği için sadece log düşülür.
        static::log($eventType, 'sms', $to, $message, 'queued', null, $relatedId);
    }

    public static function log(string $eventType, string $channel, ?string $recipient, string $message, string $status, ?string $providerResponse = null, ?int $relatedId = null): void
    {
        try {
            NotificationLog::create([
                'event_type' => $eventType,
                'channel' => $channel,
                'recipient' => $recipient,
                'message' => $message,
                'status' => $status,
                'provider_response' => $providerResponse,
                'related_id' => $relatedId,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            // loglama bile başarısız olursa sessizce geç
        }
    }

    protected static function httpPost(string $url, string $body, array $headers): array
    {
        if (!function_exists('curl_init')) {
            return [false, 'curl_unavailable'];
        }
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 8,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);
        $resp = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);
        $ok = $code >= 200 && $code < 300;
        return [$ok, $ok ? (string) $resp : ($err ?: (string) $resp)];
    }
}
