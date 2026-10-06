<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Session;
use App\Models\ServiceRegion;

class AdminRegionController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/regions/index', [
            'pageTitle' => 'Çalışma Bölgeleri',
            'regions' => ServiceRegion::all('sort_order ASC, id ASC'),
        ]);
    }

    public function save(): void
    {
        $this->verifyCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        if ($title === '') {
            Session::flash('flash_err', 'Bölge adı zorunludur.');
            $this->redirect('yonetim/bolgeler');
            return;
        }
        $slug = trim((string) ($_POST['slug'] ?? '')) ?: slugify($title);
        // benzersiz slug
        $existing = Database::selectOne('SELECT id FROM service_regions WHERE slug = ? AND id <> ?', [$slug, $id]);
        if ($existing) {
            $slug .= '-' . substr((string) time(), -4);
        }
        $data = [
            'title' => $title,
            'slug' => $slug,
            'city' => trim((string) ($_POST['city'] ?? '')),
            'district' => trim((string) ($_POST['district'] ?? '')),
            'neighborhood' => trim((string) ($_POST['neighborhood'] ?? '')),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if ($id > 0) {
            ServiceRegion::update($id, $data);
        } else {
            ServiceRegion::create($data);
        }
        Session::flash('flash_ok', 'Bölge kaydedildi.');
        $this->redirect('yonetim/bolgeler');
    }

    public function destroy(): void
    {
        $this->verifyCsrf();
        ServiceRegion::delete((int) ($_POST['id'] ?? 0));
        Session::flash('flash_ok', 'Bölge silindi.');
        $this->redirect('yonetim/bolgeler');
    }
}
