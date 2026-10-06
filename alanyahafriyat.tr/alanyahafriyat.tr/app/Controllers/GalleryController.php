<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index(): void
    {
        $cat = trim((string) ($_GET['kategori'] ?? ''));
        if ($cat !== '') {
            $items = Database::select('SELECT * FROM gallery WHERE is_active=1 AND category=? ORDER BY sort_order ASC, id DESC', [$cat]);
        } else {
            $items = Gallery::active('sort_order ASC, id DESC');
        }

        $this->view('gallery/index', [
            'items' => $items,
            'categories' => Gallery::categories(),
            'activeCat' => $cat,
            'seo' => [
                'title' => 'Galeri | ' . site_name(),
                'description' => 'Sahadaki hafriyat ve iş makinesi çalışmalarımızdan görüntüler.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Galeri', null]],
        ]);
    }
}
