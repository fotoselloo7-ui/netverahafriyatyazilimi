<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Models\SiteEvent;
use App\Services\LeadService;
use App\Services\NotificationService;

class EventController extends Controller
{
    public function store(): void
    {
        // Basit token kontrolü (header). Başarısız olsa da event kaydını engelleyip 204 döneriz.
        $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (!Csrf::verify($token)) {
            $this->json(['ok' => false], 419);
            return;
        }

        $type = preg_replace('/[^a-z_]/', '', (string) ($_POST['event_type'] ?? ''));
        $allowed = ['whatsapp_click', 'popup_click', 'phone_click'];
        if (!in_array($type, $allowed, true)) {
            $this->json(['ok' => false], 400);
            return;
        }

        $pageUrl = mb_substr((string) ($_POST['page_url'] ?? ''), 0, 250);
        $meta = mb_substr((string) ($_POST['meta'] ?? ''), 0, 250);

        try {
            SiteEvent::create([
                'event_type' => $type,
                'page_url' => $pageUrl,
                'source' => 'frontend',
                'ip_hash' => LeadService::ipHash(),
                'user_agent' => mb_substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 250),
                'metadata_json' => $meta !== '' ? json_encode(['meta' => $meta], JSON_UNESCAPED_UNICODE) : null,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {}

        // Olay bazlı bildirim (ayarda açıksa)
        if ($type === 'whatsapp_click') {
            NotificationService::dispatch('whatsapp_click', "Web sitesinden WhatsApp butonuna tıklandı. Sayfa: {$pageUrl}");
        } elseif ($type === 'popup_click') {
            NotificationService::dispatch('popup_click', "Popup butonuna tıklandı. Sayfa: {$pageUrl}");
        }

        $this->json(['ok' => true]);
    }
}
