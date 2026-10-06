<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Faq;

class FaqController extends Controller
{
    public function index(): void
    {
        $faqs = Faq::active();
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(fn ($f) => [
                '@type' => 'Question',
                'name' => $f['question'],
                'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags((string) $f['answer'])],
            ], $faqs),
        ];
        $this->view('faq/index', [
            'faqs' => $faqs,
            'jsonLd' => $jsonLd,
            'seo' => [
                'title' => 'Sık Sorulan Sorular | ' . site_name(),
                'description' => 'Hafriyat, kepçe kiralama ve moloz taşıma hizmetleri hakkında sık sorulan sorular ve cevapları.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['SSS', null]],
        ]);
    }
}
