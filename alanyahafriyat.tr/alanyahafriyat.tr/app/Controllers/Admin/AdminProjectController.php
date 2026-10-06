<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Project;
use App\Services\UploadService;

class AdminProjectController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/projects/index', ['pageTitle' => 'Projeler', 'items' => Project::all('id DESC')]);
    }

    public function create(): void
    {
        $this->adminView('admin/projects/form', ['pageTitle' => 'Yeni Proje', 'item' => null]);
    }

    public function edit(array $params): void
    {
        $item = Project::find((int) $params['id']);
        if (!$item) { $this->redirect('yonetim/projeler'); return; }
        $this->adminView('admin/projects/form', ['pageTitle' => 'Proje Düzenle', 'item' => $item]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $id = Project::create($this->data());
        Session::flash('flash_ok', 'Proje eklendi.');
        $this->redirect('yonetim/projeler/' . $id);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $item = Project::find((int) $params['id']);
        if (!$item) { $this->redirect('yonetim/projeler'); return; }
        Project::update((int) $item['id'], $this->data($item));
        Session::flash('flash_ok', 'Proje güncellendi.');
        $this->redirect('yonetim/projeler/' . $item['id']);
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        Project::delete((int) $params['id']);
        Session::flash('flash_ok', 'Proje silindi.');
        $this->redirect('yonetim/projeler');
    }

    protected function data(?array $existing = null): array
    {
        $title = trim((string) ($_POST['title'] ?? ''));
        $data = [
            'title' => $title,
            'slug' => trim((string) ($_POST['slug'] ?? '')) ?: slugify($title),
            'region' => trim((string) ($_POST['region'] ?? '')),
            'service_type' => trim((string) ($_POST['service_type'] ?? '')),
            'short_description' => trim((string) ($_POST['short_description'] ?? '')),
            'content' => (string) ($_POST['content'] ?? ''),
            'project_date' => trim((string) ($_POST['project_date'] ?? '')),
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        foreach (['cover_image', 'before_image', 'after_image'] as $field) {
            if (!empty($_FILES[$field]['name'])) {
                $res = UploadService::image($_FILES[$field], 'projeler');
                if (isset($res['path'])) { $data[$field] = $res['path']; }
                else { Session::flash('flash_err', $res['error']); }
            }
        }
        return $data;
    }
}
