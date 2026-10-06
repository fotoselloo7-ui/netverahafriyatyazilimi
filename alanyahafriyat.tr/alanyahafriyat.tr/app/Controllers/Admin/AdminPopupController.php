<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Popup;
use App\Services\UploadService;

class AdminPopupController extends AdminBaseController
{
    public function index(): void
    {
        $popup = Popup::find(1) ?: (Popup::all('id ASC')[0] ?? null);
        if (!$popup) {
            $id = Popup::create(['title' => 'Yeni Popup', 'button_type' => 'whatsapp', 'is_active' => 0, 'delay_seconds' => 5, 'repeat_after_hours' => 24, 'target_pages' => 'all', 'show_on_mobile' => 1, 'overlay_opacity' => '0.6']);
            $popup = Popup::find($id);
        }
        $this->adminView('admin/popup/index', ['pageTitle' => 'Popup Yönetimi', 'popup' => $popup]);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $popup = Popup::find((int) $params['id']);
        if (!$popup) { $this->redirect('yonetim/popup'); return; }
        $data = [
            'title' => trim((string) ($_POST['title'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'button_text' => trim((string) ($_POST['button_text'] ?? '')),
            'button_url' => trim((string) ($_POST['button_url'] ?? '')),
            'button_type' => trim((string) ($_POST['button_type'] ?? 'whatsapp')),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
            'delay_seconds' => (int) ($_POST['delay_seconds'] ?? 3),
            'repeat_after_hours' => (int) ($_POST['repeat_after_hours'] ?? 24),
            'target_pages' => trim((string) ($_POST['target_pages'] ?? 'all')),
            'show_on_mobile' => isset($_POST['show_on_mobile']) ? 1 : 0,
            'overlay_opacity' => trim((string) ($_POST['overlay_opacity'] ?? '0.6')),
        ];
        if (!empty($_FILES['image']['name'])) {
            $res = UploadService::image($_FILES['image'], 'popup');
            if (isset($res['path'])) { $data['image'] = $res['path']; }
            else { Session::flash('flash_err', $res['error']); }
        }
        if (!empty($_POST['remove_image'])) { $data['image'] = ''; }
        Popup::update((int) $popup['id'], $data);
        Session::flash('flash_ok', 'Popup ayarları kaydedildi.');
        $this->redirect('yonetim/popup');
    }
}
