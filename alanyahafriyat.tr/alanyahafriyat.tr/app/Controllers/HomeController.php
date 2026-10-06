<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\BlogPost;
use App\Models\Equipment;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\HomeSection;
use App\Models\Popup;
use App\Models\Project;
use App\Models\Service;

class HomeController extends Controller
{
    public function index(): void
    {
        $sections = HomeSection::map();

        $this->view('home', [
            'sections'    => $sections,
            'serviceRegions' => \App\Models\ServiceRegion::active('sort_order ASC, id ASC'),
            'services'    => Service::featured(6),
            'equipment'   => Equipment::active(),
            'gallery'     => Gallery::active(),
            'projects'    => array_slice(Project::active('project_date DESC, id DESC'), 0, 3),
            'posts'       => BlogPost::published(3),
            'faqs'        => Faq::active(),
            'popup'       => Popup::activeOne(),
            'seo'         => [
                'title'       => setting('seo_title', site_name()),
                'description' => setting('seo_description'),
                'is_home'     => true,
            ],
        ]);
    }
}
