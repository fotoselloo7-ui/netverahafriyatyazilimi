<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Gallery;
use App\Models\Page;
use App\Models\Service;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function about(): void
    {
        $page = Page::findBySlug('hakkimizda');
        if (!$page) {
            $this->abort(404);
            return;
        }

        $this->view('about', [
            'page'         => $page,
            'services'     => Service::featured(6),
            'gallery'      => array_slice(Gallery::active(), 0, 3),
            'testimonials' => Testimonial::active('id DESC'),
            'counters'     => [
                'experience' => setting('about_counter_experience', '10+'),
                'projects'   => setting('about_counter_projects', '1000+'),
                'staff'      => setting('about_counter_staff', '15+'),
                'support'    => setting('about_counter_support', '7/24'),
            ],
            'seo' => [
                'title'       => $page['seo_title'] ?: $page['title'] . ' | ' . site_name(),
                'description' => $page['seo_description'] ?: $page['excerpt'],
            ],
        ]);
    }

    public function show(array $params): void
    {
        $page = Page::findBySlug($params['slug'] ?? '');
        if (!$page || (int) $page['is_active'] !== 1) {
            $this->abort(404);
            return;
        }
        $this->view('page', [
            'page' => $page,
            'seo'  => [
                'title'       => $page['seo_title'] ?: $page['title'] . ' | ' . site_name(),
                'description' => $page['seo_description'] ?: $page['excerpt'],
            ],
        ]);
    }
}
