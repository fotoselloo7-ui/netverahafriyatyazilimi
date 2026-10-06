<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Menu;

class AdminMenuController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/menu/index', [
            'pageTitle' => 'Menü Yönetimi',
            'header' => Menu::byLocationAll('header'),
            'footer' => Menu::byLocationAll('footer'),
            'mobile' => Menu::byLocationAll('mobile_bar'),
        ]);
    }

    public function save(): void
    {
        $this->verifyCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        if ($title === '') { $this->back('/yonetim/menu'); return; }
        $data = [
            'menu_location' => trim((string) ($_POST['menu_location'] ?? 'header')),
            'title' => $title,
            'url' => trim((string) ($_POST['url'] ?? '')),
            'menu_type' => trim((string) ($_POST['menu_type'] ?? 'internal')),
            'icon' => trim((string) ($_POST['icon'] ?? '')),
            'target' => isset($_POST['target_blank']) ? '_blank' : '_self',
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if ($id > 0) { Menu::update($id, $data); }
        else { Menu::create($data); }
        Session::flash('flash_ok', 'Menü öğesi kaydedildi.');
        $this->redirect('yonetim/menu');
    }

    public function destroy(): void
    {
        $this->verifyCsrf();
        Menu::delete((int) ($_POST['id'] ?? 0));
        Session::flash('flash_ok', 'Menü öğesi silindi.');
        $this->redirect('yonetim/menu');
    }
}
