<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Equipment;
use App\Services\UploadService;

class AdminEquipmentController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/equipment/index', ['pageTitle' => 'Makine Parkuru', 'items' => Equipment::all('sort_order ASC')]);
    }

    public function create(): void
    {
        $this->adminView('admin/equipment/form', ['pageTitle' => 'Yeni Makine', 'item' => null]);
    }

    public function edit(array $params): void
    {
        $item = Equipment::find((int) $params['id']);
        if (!$item) { $this->redirect('yonetim/makine'); return; }
        $this->adminView('admin/equipment/form', ['pageTitle' => 'Makine Düzenle', 'item' => $item]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $id = Equipment::create($this->data());
        Session::flash('flash_ok', 'Makine eklendi.');
        $this->redirect('yonetim/makine/' . $id);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $item = Equipment::find((int) $params['id']);
        if (!$item) { $this->redirect('yonetim/makine'); return; }
        Equipment::update((int) $item['id'], $this->data($item));
        Session::flash('flash_ok', 'Makine güncellendi.');
        $this->redirect('yonetim/makine/' . $item['id']);
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        Equipment::delete((int) $params['id']);
        Session::flash('flash_ok', 'Makine silindi.');
        $this->redirect('yonetim/makine');
    }

    protected function data(?array $existing = null): array
    {
        $title = trim((string) ($_POST['title'] ?? ''));
        $data = [
            'title' => $title,
            'slug' => trim((string) ($_POST['slug'] ?? '')) ?: slugify($title),
            'brand_model' => trim((string) ($_POST['brand_model'] ?? '')),
            'usage_area' => trim((string) ($_POST['usage_area'] ?? '')),
            'attachments' => trim((string) ($_POST['attachments'] ?? '')),
            'short_description' => trim((string) ($_POST['short_description'] ?? '')),
            'content' => (string) ($_POST['content'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if (!empty($_FILES['image']['name'])) {
            $res = UploadService::image($_FILES['image'], 'makine');
            if (isset($res['path'])) { $data['image'] = $res['path']; }
            else { Session::flash('flash_err', $res['error']); }
        }
        return $data;
    }
}
