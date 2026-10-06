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
                'title' => 'Alanya Hafriyat Hizmetleri | Kepçe, Kazı ve Moloz | ' . site_name(),
                'description' => 'Alanya’da kepçe ve mini kepçe kiralama, temel ve kanal kazısı, moloz taşıma, arsa tesviye, dolgu ve düzenleme hizmetlerini inceleyin.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Hizmetlerimiz', null]],
        ]);
    }

    public function show(array $params): void
    {
        $slug = (string) ($params['slug'] ?? '');
        // Ana sorgu "Alanya Hafriyat" ana sayfada sahiplenilir; eski hizmet URL'si
        // keyword cannibalization oluşturmaması için ana sayfaya kalıcı yönlenir.
        if ($slug === 'alanya-hafriyat-hizmeti') {
            header('Location: ' . base_url(), true, 301);
            exit;
        }

        $service = Service::findBySlug($slug);
        if (!$service || (int) $service['is_active'] !== 1) {
            $this->abort(404);
            return;
        }

        $related = Database::select(
            'SELECT * FROM projects WHERE is_active = 1 AND service_type LIKE ? ORDER BY id DESC LIMIT 3',
            ['%' . explode(' ', $service['title'])[0] . '%']
        );

        $faqs = Service::faqs((int) $service['id']);

        // Service + FAQ yapılandırılmış verileri yalnız ekrandaki gerçek içerikten üretilir.
        $regions = \App\Models\ServiceRegion::active('sort_order ASC, id ASC');
        $areaServed = array_values(array_map(fn ($r) => (string) $r['title'], $regions));
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['hero_title'] ?: $service['title'],
            'description' => strip_tags((string) $service['short_description']),
            'url' => base_url('hizmetler/' . $service['slug']),
            'provider' => [
                '@type' => 'LocalBusiness',
                'name' => site_name(),
                'telephone' => setting('phone', ''),
                'url' => base_url(),
            ],
            'areaServed' => $areaServed,
        ];
        $faqJsonLd = $faqs ? [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_values(array_map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['answer']],
            ], $faqs)),
        ] : null;

        $this->view('services/show', [
            'service' => $service,
            'services' => Service::active('sort_order ASC'),
            'serviceRegions' => $regions,
            'advantages' => json_decode_safe($service['advantages_json']),
            'usageAreas' => json_decode_safe($service['usage_areas_json']),
            'process' => json_decode_safe($service['process_json']),
            'faqs' => $faqs,
            'related' => $related,
            'posts' => BlogPost::published(3),
            'jsonLd' => $jsonLd,
            'faqJsonLd' => $faqJsonLd,
            'seo' => [
                'title' => $service['seo_title'] ?: ($service['title'] . ' | ' . site_name()),
                'description' => $service['seo_description'] ?: str_excerpt($service['short_description'], 155),
                'og_image' => $service['og_image'] ?: $service['cover_image'],
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Hizmetlerimiz', base_url('hizmetler')], [$service['title'], null]],
        ]);
    }
}
