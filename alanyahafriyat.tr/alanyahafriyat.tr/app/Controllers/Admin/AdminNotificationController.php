<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Session;
use App\Models\NotificationSetting;

class AdminNotificationController extends AdminBaseController
{
    protected array $textFields = [
        'owner_name', 'owner_phone', 'owner_email', 'whatsapp_provider',
        'whatsapp_api_token', 'whatsapp_phone_number_id', 'whatsapp_template_name',
        'custom_webhook_url', 'sms_provider', 'sms_api_key', 'smtp_host', 'smtp_user',
        'smtp_password', 'smtp_port', 'telegram_bot_token', 'telegram_chat_id',
    ];
    protected array $boolFields = [
        'whatsapp_api_enabled', 'sms_enabled', 'email_enabled', 'telegram_enabled',
        'notify_on_new_lead', 'notify_on_contact_form', 'notify_on_whatsapp_click',
        'notify_on_popup_click', 'notify_on_admin_login', 'notify_on_new_visitor',
    ];

    public function index(): void
    {
        $this->adminView('admin/notifications/index', [
            'pageTitle' => 'Bildirim Ayarları',
            'n' => NotificationSetting::current() ?: [],
            'logs' => Database::select('SELECT * FROM notification_logs ORDER BY id DESC LIMIT 20'),
        ]);
    }

    public function save(): void
    {
        $this->verifyCsrf();
        $row = NotificationSetting::current();
        $data = [];
        foreach ($this->textFields as $f) {
            $data[$f] = trim((string) ($_POST[$f] ?? ''));
        }
        foreach ($this->boolFields as $f) {
            $data[$f] = isset($_POST[$f]) ? 1 : 0;
        }
        $data['visitor_notification_throttle_minutes'] = (int) ($_POST['visitor_notification_throttle_minutes'] ?? 30);

        if ($row) {
            NotificationSetting::update((int) $row['id'], $data);
        } else {
            NotificationSetting::create($data);
        }
        Session::flash('flash_ok', 'Bildirim ayarları kaydedildi.');
        $this->redirect('yonetim/bildirim');
    }
}
