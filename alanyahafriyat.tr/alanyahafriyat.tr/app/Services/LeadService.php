<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Lead;
use App\Models\SiteEvent;

class LeadService
{
    /**
     * Form verisinden lead oluşturur. Sonuç: ['ok'=>bool,'message'=>string,'id'=>?int]
     */
    public static function create(array $data): array
    {
        // Honeypot
        if (!empty($data['website'])) {
            return ['ok' => true, 'message' => 'Talebiniz alındı.', 'id' => null]; // bota başarılı gibi dön
        }

        $name = trim((string) ($data['name'] ?? ''));
        $phone = trim((string) ($data['phone'] ?? ''));
        $email = trim((string) ($data['email'] ?? ''));
        $service = trim((string) ($data['service_type'] ?? ''));
        $region = trim((string) ($data['region'] ?? ''));
        $message = trim((string) ($data['message'] ?? ''));
        $source = trim((string) ($data['source'] ?? 'website'));

        if ($name === '' || mb_strlen($name) < 2) {
            return ['ok' => false, 'message' => 'Lütfen adınızı girin.'];
        }
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($digits) < 10) {
            return ['ok' => false, 'message' => 'Lütfen geçerli bir telefon numarası girin.'];
        }
        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['ok' => false, 'message' => 'E-posta adresi geçersiz.'];
        }
        if (empty($data['kvkk'])) {
            return ['ok' => false, 'message' => 'Devam etmek için KVKK onayı gereklidir.'];
        }

        // XSS temizliği
        $clean = fn (string $s) => strip_tags($s);

        $id = Lead::create([
            'name' => $clean($name),
            'phone' => $clean($phone),
            'email' => $email !== '' ? $clean($email) : null,
            'service_type' => $clean($service),
            'region' => $clean($region),
            'message' => $clean($message),
            'source' => $clean($source),
            'status' => 'new',
            'ip_hash' => self::ipHash(),
            'user_agent' => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 250),
        ]);

        // Olay kaydı
        try {
            SiteEvent::create([
                'event_type' => 'lead',
                'page_url' => $_SERVER['HTTP_REFERER'] ?? $source,
                'source' => $source,
                'ip_hash' => self::ipHash(),
                'user_agent' => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 250),
                'metadata_json' => json_encode(['service' => $service, 'region' => $region], JSON_UNESCAPED_UNICODE),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {}

        // Bildirim
        $msg = "Yeni teklif talebi geldi: {$name} - {$phone} - Hizmet: " . ($service ?: '-') . " - Bölge: " . ($region ?: '-');
        $eventType = $source === 'contact' ? 'contact_form' : 'new_lead';
        NotificationService::dispatch($eventType, $msg, $id);

        return ['ok' => true, 'message' => 'Talebiniz alındı. En kısa sürede sizinle iletişime geçeceğiz.', 'id' => $id];
    }

    public static function ipHash(): string
    {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
        return hash('sha256', $ip . '|ersan-salt');
    }
}
