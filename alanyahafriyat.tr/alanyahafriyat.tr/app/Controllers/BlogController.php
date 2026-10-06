<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Services\Markdown;

class BlogController extends Controller
{
    public function index(): void
    {
        $this->renderList(BlogPost::published(), null);
    }

    public function category(array $params): void
    {
        $cat = BlogCategory::findBySlug($params['slug'] ?? '');
        if (!$cat) {
            $this->abort(404);
            return;
        }
        $this->renderList(BlogPost::published(0, (int) $cat['id']), $cat);
    }

    protected function renderList(array $posts, ?array $cat): void
    {
        $title = $cat ? ($cat['title'] . ' | Blog') : 'Blog';
        $this->view('blog/index', [
            'posts' => $posts,
            'categories' => BlogCategory::withCounts(),
            'recent' => BlogPost::recent(5),
            'activeCat' => $cat,
            'seo' => [
                'title' => $title . ' | ' . site_name(),
                'description' => 'Hafriyat, kepçe kiralama ve iş makineleri hakkında güncel yazılar.',
            ],
            'breadcrumb' => array_filter([['Ana Sayfa', base_url()], ['Blog', base_url('blog')], $cat ? [$cat['title'], null] : null]),
        ]);
    }

    public function show(array $params): void
    {
        $post = BlogPost::publishedBySlug($params['slug'] ?? '');
        if (!$post) {
            $this->abort(404);
            return;
        }

        $html = Markdown::toHtml((string) $post['content_markdown']);
        $toc = Markdown::headings();
        $faqs = json_decode_safe($post['faq_json'] ?? null);

        $schemaType = in_array($post['schema_type'] ?? '', ['Article', 'BlogPosting', 'NewsArticle'], true) ? $post['schema_type'] : 'BlogPosting';
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@type' => $schemaType,
            'headline' => $post['title'],
            'description' => strip_tags((string) $post['excerpt']),
            'datePublished' => $post['published_at'],
            'dateModified' => $post['updated_at'] ?: $post['published_at'],
            'mainEntityOfPage' => base_url('blog/' . $post['slug']),
            'author' => ['@type' => ($post['author_name'] ?? '') !== '' ? 'Person' : 'Organization', 'name' => ($post['author_name'] ?? '') !== '' ? $post['author_name'] : site_name()],
            'publisher' => ['@type' => 'Organization', 'name' => site_name()],
        ];
        if (!empty($post['cover_image'])) {
            $jsonLd['image'] = upload_url($post['cover_image']);
        }

        // İlgili hizmet + ilgili yazılar
        $relatedService = null;
        if (!empty($post['related_service_id'])) {
            $relatedService = \App\Models\Service::find((int) $post['related_service_id']);
        }
        $relatedPosts = [];
        $relatedIds = array_filter(array_map('intval', json_decode_safe($post['related_posts_json'] ?? null)));
        if ($relatedIds) {
            $in = implode(',', $relatedIds);
            $relatedPosts = \App\Core\Database::select("SELECT id, title, slug, cover_image, excerpt, published_at FROM blog_posts WHERE status='published' AND id IN ($in)");
        }

        $this->view('blog/show', [
            'post' => $post,
            'contentHtml' => $html,
            'toc' => $toc,
            'faqs' => $faqs,
            'relatedService' => $relatedService,
            'relatedPosts' => $relatedPosts,
            'categories' => BlogCategory::withCounts(),
            'recent' => BlogPost::recent(5),
            'jsonLd' => $jsonLd,
            'faqJsonLd' => $faqs ? [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => array_map(fn ($f) => [
                    '@type' => 'Question', 'name' => $f['question'] ?? '',
                    'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags((string) ($f['answer'] ?? ''))],
                ], $faqs),
            ] : null,
            'seo' => [
                'title' => $post['seo_title'] ?: ($post['title'] . ' | ' . site_name()),
                'description' => $post['seo_description'] ?: str_excerpt($post['excerpt'], 155),
                'og_title' => $post['og_title'] ?: null,
                'og_description' => $post['og_description'] ?: null,
                'og_image' => $post['og_image'] ?: $post['cover_image'],
                'twitter_title' => $post['twitter_title'] ?: null,
                'twitter_description' => $post['twitter_description'] ?: null,
                'twitter_image' => $post['twitter_image'] ?: null,
                'canonical' => $post['canonical_url'] ?: null,
                'robots' => (int) ($post['robots_index'] ?? 1) === 1,
                'robots_follow' => (int) ($post['robots_follow'] ?? 1) === 1,
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Blog', base_url('blog')], [$post['title'], null]],
        ]);
    }
}
