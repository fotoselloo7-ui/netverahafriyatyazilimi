<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Session;
use App\Services\SettingsService;
use App\Services\UploadService;

class AdminSettingController extends AdminBaseController
{
    protected array $fields = [
        'site_name' => 'general', 'site_tagline' => 'general', 'top_bar_text' => 'general',
        'phone' => 'contact', 'whatsapp_number' => 'contact', 'email' => 'contact',
        'address' => 'contact', 'working_hours' => 'contact', 'map_embed' => 'contact',
        'seo_title' => 'seo', 'seo_description' => 'seo', 'seo_keywords' => 'seo',
        'footer_about' => 'general',
        'web_design_credit_text' => 'footer', 'web_design_credit_url' => 'footer',
        'about_counter_experience' => 'about', 'about_counter_projects' => 'about',
        'about_counter_staff' => 'about', 'about_counter_support' => 'about',
    ];

    /** Checkbox/toggle olarak yönetilen ayarlar (POST'ta yoksa 0 yazılır). */
    protected array $toggles = [
        'floating_whatsapp_enabled' => 'general',
    ];

    public function index(): void
    {
        $this->adminView('admin/settings/index', [
            'pageTitle' => 'Genel Ayarlar',
            'settings' => SettingsService::all(),
            'socialLinks' => Database::select('SELECT * FROM social_links ORDER BY sort_order ASC, id ASC'),
        ]);
    }

    public function save(): void
    {
        $this->verifyCsrf();
        foreach ($this->fields as $key => $group) {
            if (array_key_exists($key, $_POST)) {
                $value = trim((string) $_POST[$key]);
                if ($key === 'map_embed') {
                    $value = map_embed_url($value);
                }
                SettingsService::set($key, $value, $group);
            }
        }
        foreach ($this->toggles as $key => $group) {
            SettingsService::set($key, isset($_POST[$key]) ? '1' : '0', $group, 'toggle');
        }

        // Logo / OG görsel yükleme
        foreach (['logo' => 'logo', 'og_image' => 'og_image'] as $inputName => $settingKey) {
            if (!empty($_FILES[$inputName]['name'])) {
                $res = UploadService::image($_FILES[$inputName], 'genel');
                if (isset($res['path'])) {
                    SettingsService::set($settingKey, $res['path'], 'general', 'image');
                } else {
                    Session::flash('flash_err', $res['error']);
                }
            }
        }
        if (!empty($_POST['remove_logo'])) { SettingsService::set('logo', '', 'general', 'image'); }

        // Footer sosyal medya bağlantıları
        if (isset($_POST['social_platform']) && is_array($_POST['social_platform'])) {
            Database::execute('DELETE FROM social_links');
            $platforms = (array) $_POST['social_platform'];
            $urls = (array) ($_POST['social_url'] ?? []);
            $icons = (array) ($_POST['social_icon'] ?? []);
            $sorts = (array) ($_POST['social_sort'] ?? []);
            $statuses = (array) ($_POST['social_status'] ?? []);

            foreach ($platforms as $i => $platformRaw) {
                $platform = strtolower(trim((string) $platformRaw));
                $platform = preg_replace('/[^a-z0-9_-]/', '', $platform) ?: '';
                if ($platform === '') { continue; }

                $url = trim((string) ($urls[$i] ?? ''));
                $icon = strtolower(trim((string) ($icons[$i] ?? $platform)));
                $icon = preg_replace('/[^a-z0-9_-]/', '', $icon) ?: $platform;
                $sort = (int) ($sorts[$i] ?? $i);
                $active = (int) ($statuses[$i] ?? 1) === 1 ? 1 : 0;

                // WhatsApp URL boş veya # ise footer global WhatsApp numarasını kullanır.
                if ($platform !== 'whatsapp' && $url === '') {
                    $active = 0;
                }

                Database::insert(
                    'INSERT INTO social_links (platform, url, icon, sort_order, is_active) VALUES (?, ?, ?, ?, ?)',
                    [$platform, $url === '' ? '#' : $url, $icon, $sort, $active]
                );
            }
        }

        SettingsService::clearCache();
        Session::flash('flash_ok', 'Ayarlar kaydedildi.');
        $this->redirect('yonetim/ayarlar');
    }
}
