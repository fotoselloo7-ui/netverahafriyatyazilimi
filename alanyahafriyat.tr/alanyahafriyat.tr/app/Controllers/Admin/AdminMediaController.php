<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Session;
use App\Models\Media;
use App\Services\UploadService;

class AdminMediaController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/media/index', ['pageTitle' => 'Medya Kütüphanesi', 'items' => Media::all('id DESC')]);
    }

    public function upload(): void
    {
        $this->verifyCsrf();
        if (empty($_FILES['file']['name'])) {
            Session::flash('flash_err', 'Dosya seçilmedi.');
            $this->redirect('yonetim/medya');
            return;
        }
        $res = UploadService::image($_FILES['file'], 'medya');
        if (!isset($res['path'])) {
            Session::flash('flash_err', $res['error']);
            $this->redirect('yonetim/medya');
            return;
        }
        Media::create([
            'file_name' => $res['name'],
            'file_path' => $res['path'],
            'file_type' => $res['mime'],
            'alt_text' => trim((string) ($_POST['alt_text'] ?? '')),
            'title' => trim((string) ($_POST['title'] ?? '')),
            'uploaded_by' => Auth::id(),
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        Session::flash('flash_ok', 'Dosya yüklendi.');
        $this->redirect('yonetim/medya');
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        $item = Media::find((int) $params['id']);
        if ($item) {
            $full = UPLOAD_PATH . '/' . ltrim((string) $item['file_path'], '/');
            if (is_file($full)) { @unlink($full); }
            Media::delete((int) $item['id']);
        }
        Session::flash('flash_ok', 'Dosya silindi.');
        $this->redirect('yonetim/medya');
    }
}
