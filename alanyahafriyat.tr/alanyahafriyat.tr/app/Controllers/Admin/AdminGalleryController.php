<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Gallery;
use App\Services\UploadService;

class AdminGalleryController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/gallery/index', [
            'pageTitle' => 'Galeri',
            'items' => Gallery::all('sort_order ASC, id DESC'),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $title = trim((string) ($_POST['title'] ?? ''));
        $category = trim((string) ($_POST['category'] ?? ''));
        $videoUrl = trim((string) ($_POST['video_url'] ?? ''));
        $path = null;

        if (!empty($_FILES['image']['name'])) {
            $res = UploadService::image($_FILES['image'], 'galeri');
            if (isset($res['path'])) { $path = $res['path']; }
            else { Session::flash('flash_err', $res['error']); $this->redirect('yonetim/galeri'); return; }
        }

        if (!$path && $videoUrl === '') {
            Session::flash('flash_err', 'Görsel veya video bağlantısı ekleyin.');
            $this->redirect('yonetim/galeri');
            return;
        }

        Gallery::create([
            'title' => $title,
            'image' => $path,
            'video_url' => $videoUrl,
            'category' => $category,
            'alt_text' => trim((string) ($_POST['alt_text'] ?? '')) ?: $title,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => 1,
        ]);
        Session::flash('flash_ok', 'Görsel eklendi.');
        $this->redirect('yonetim/galeri');
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        Gallery::delete((int) $params['id']);
        Session::flash('flash_ok', 'Görsel silindi.');
        $this->redirect('yonetim/galeri');
    }
}
