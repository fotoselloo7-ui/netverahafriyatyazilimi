<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Page;
use App\Services\UploadService;

class AdminPageController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/pages/index', ['pageTitle' => 'Sayfalar', 'pages' => Page::all('id ASC')]);
    }

    public function create(): void
    {
        $this->adminView('admin/pages/form', ['pageTitle' => 'Yeni Sayfa', 'page' => null]);
    }

    public function edit(array $params): void
    {
        $page = Page::find((int) $params['id']);
        if (!$page) { $this->redirect('yonetim/sayfalar'); return; }
        $this->adminView('admin/pages/form', ['pageTitle' => 'Sayfa Düzenle', 'page' => $page]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $id = Page::create($this->data());
        Session::flash('flash_ok', 'Sayfa eklendi.');
        $this->redirect('yonetim/sayfalar/' . $id);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $page = Page::find((int) $params['id']);
        if (!$page) { $this->redirect('yonetim/sayfalar'); return; }
        Page::update((int) $page['id'], $this->data($page));
        Session::flash('flash_ok', 'Sayfa güncellendi.');
        $this->redirect('yonetim/sayfalar/' . $page['id']);
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        Page::delete((int) $params['id']);
        Session::flash('flash_ok', 'Sayfa silindi.');
        $this->redirect('yonetim/sayfalar');
    }

    protected function data(?array $existing = null): array
    {
        $title = trim((string) ($_POST['title'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? '')) ?: slugify($title);
        $data = [
            'title' => $title,
            'slug' => $slug,
            'excerpt' => trim((string) ($_POST['excerpt'] ?? '')),
            'content' => (string) ($_POST['content'] ?? ''),
            'hero_title' => trim((string) ($_POST['hero_title'] ?? '')),
            'hero_subtitle' => trim((string) ($_POST['hero_subtitle'] ?? '')),
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'robots_index' => isset($_POST['robots_index']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        foreach (['hero_image', 'cover_image', 'og_image'] as $field) {
            if (!empty($_FILES[$field]['name'])) {
                $res = UploadService::image($_FILES[$field], 'sayfalar');
                if (isset($res['path'])) { $data[$field] = $res['path']; }
                else { Session::flash('flash_err', $res['error']); }
            }
        }
        return $data;
    }
}
