<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\BlogPost;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index(): void
    {
        $this->view('services/index', [
            'services' => Service::active('sort_order ASC'),
            'seo' => [
                'title' => 'Hizmetlerimiz | ' . site_name(),
                'description' => 'Alanya ve Mahmutlar’da hafriyat, kepçe kiralama, temel kazısı, moloz taşıma, altyapı ve çevre düzenleme hizmetlerimiz.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Hizmetlerimiz', null]],
        ]);
    }

    public function show(array $params): void
    {
        $service = Service::findBySlug($params['slug'] ?? '');
        if (!$service || (int) $service['is_active'] !== 1) {
            $this->abort(404);
            return;
        }

        $related = Database::select(
            'SELECT * FROM projects WHERE is_active = 1 AND service_type LIKE ? ORDER BY id DESC LIMIT 3',
            ['%' . explode(' ', $service['title'])[0] . '%']
        );

        $faqs = Service::faqs((int) $service['id']);

        // FAQ + Service schema
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['title'],
            'description' => strip_tags((string) $service['short_description']),
            'provider' => ['@type' => 'LocalBusiness', 'name' => site_name()],
            'areaServed' => 'Alanya, Mahmutlar',
        ];

        $this->view('services/show', [
            'service' => $service,
            'services' => Service::active('sort_order ASC'),
            'serviceRegions' => \App\Models\ServiceRegion::active('sort_order ASC, id ASC'),
            'advantages' => json_decode_safe($service['advantages_json']),
            'usageAreas' => json_decode_safe($service['usage_areas_json']),
            'process' => json_decode_safe($service['process_json']),
            'faqs' => $faqs,
            'related' => $related,
            'posts' => BlogPost::published(3),
            'jsonLd' => $jsonLd,
            'seo' => [
                'title' => $service['seo_title'] ?: ($service['title'] . ' | ' . site_name()),
                'description' => $service['seo_description'] ?: str_excerpt($service['short_description'], 155),
                'og_image' => $service['og_image'] ?: $service['cover_image'],
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Hizmetlerimiz', base_url('hizmetler')], [$service['title'], null]],
        ]);
    }
}
