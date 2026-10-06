<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function index(): void
    {
        $this->view('equipment/index', [
            'equipment' => Equipment::active('sort_order ASC'),
            'seo' => [
                'title' => 'Makine Parkuru | ' . site_name(),
                'description' => 'Hidromek, JCB, mini ekskavatör ve damper kamyon dahil güçlü ve bakımlı makine parkurumuz.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Makine Parkuru', null]],
        ]);
    }

    public function show(array $params): void
    {
        $item = Equipment::findBySlug($params['slug'] ?? '');
        if (!$item || (int) $item['is_active'] !== 1) {
            $this->abort(404);
            return;
        }
        $this->view('equipment/show', [
            'item' => $item,
            'gallery' => json_decode_safe($item['gallery_json']),
            'seo' => [
                'title' => $item['title'] . ' | Makine Parkuru | ' . site_name(),
                'description' => str_excerpt($item['short_description'], 155),
                'og_image' => $item['image'],
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Makine Parkuru', base_url('makine-parkuru')], [$item['title'], null]],
        ]);
    }
}
