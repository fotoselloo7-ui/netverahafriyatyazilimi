<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Session;
use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\Media;
use App\Models\Redirect;
use App\Models\Service;
use App\Services\SeoAnalyzer;
use App\Services\UploadService;

class AdminBlogController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/blog/index', [
            'pageTitle' => 'Blog',
            'posts' => Database::select("SELECT p.*, c.title AS category_title FROM blog_posts p LEFT JOIN blog_categories c ON c.id=p.category_id ORDER BY p.id DESC"),
            'categories' => BlogCategory::all('sort_order ASC'),
        ]);
    }

    public function create(): void
    {
        $this->adminView('admin/blog/form', $this->formData(null));
    }

    public function edit(array $params): void
    {
        $post = BlogPost::find((int) $params['id']);
        if (!$post) { $this->redirect('yonetim/blog'); return; }
        $this->adminView('admin/blog/form', $this->formData($post));
    }

    protected function formData(?array $post): array
    {
        return [
            'pageTitle' => $post ? 'Yazı Düzenle' : 'Yeni Yazı',
            'post' => $post,
            'categories' => BlogCategory::all('sort_order ASC'),
            'services' => Service::active('sort_order ASC'),
            'allPosts' => Database::select('SELECT id, title FROM blog_posts' . ($post ? ' WHERE id <> ' . (int) $post['id'] : '') . ' ORDER BY id DESC'),
            'mediaItems' => Media::all('id DESC'),
            'faqs' => json_decode_safe($post['faq_json'] ?? null),
            'relatedPosts' => json_decode_safe($post['related_posts_json'] ?? null),
            'seoSuggestions' => json_decode_safe($post['seo_suggestions_json'] ?? null),
        ];
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $id = BlogPost::create($this->data());
        Session::flash('flash_ok', 'Yazı eklendi.');
        $this->redirect('yonetim/blog/' . $id);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $post = BlogPost::find((int) $params['id']);
        if (!$post) { $this->redirect('yonetim/blog'); return; }
        BlogPost::update((int) $post['id'], $this->data($post));
        Session::flash('flash_ok', 'Yazı güncellendi.');
        $this->redirect('yonetim/blog/' . $post['id']);
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        BlogPost::delete((int) $params['id']);
        Session::flash('flash_ok', 'Yazı silindi.');
        $this->redirect('yonetim/blog');
    }

    public function saveCategory(): void
    {
        $this->verifyCsrf();
        $id = (int) ($_POST['id'] ?? 0);
        $title = trim((string) ($_POST['title'] ?? ''));
        if ($title === '') { $this->back('/yonetim/blog'); return; }
        $payload = [
            'title' => $title,
            'slug' => trim((string) ($_POST['slug'] ?? '')) ?: slugify($title),
            'description' => trim((string) ($_POST['description'] ?? '')),
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => 1,
        ];
        if ($id > 0) { BlogCategory::update($id, $payload); }
        else { BlogCategory::create($payload); }
        Session::flash('flash_ok', 'Kategori kaydedildi.');
        $this->redirect('yonetim/blog');
    }

    protected function data(?array $existing = null): array
    {
        $title = trim((string) ($_POST['title'] ?? ''));
        $md = (string) ($_POST['content_markdown'] ?? '');
        $status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
        $wordCount = str_word_count(strip_tags($md));

        // Slug: otomatik + benzersiz
        $slug = trim((string) ($_POST['slug'] ?? '')) ?: slugify($title);
        $slug = slugify($slug);
        $dupe = Database::selectOne('SELECT id FROM blog_posts WHERE slug = ? AND id <> ?', [$slug, (int) ($existing['id'] ?? 0)]);
        if ($dupe) {
            $base = $slug; $n = 2;
            while (Database::selectOne('SELECT id FROM blog_posts WHERE slug = ? AND id <> ?', [$slug, (int) ($existing['id'] ?? 0)])) {
                $slug = $base . '-' . $n++;
            }
        }

        // Slug değiştiyse opsiyonel 301 kaydı
        if ($existing && $existing['slug'] !== $slug && !empty($_POST['create_redirect'])) {
            Redirect::create([
                'old_url' => '/blog/' . $existing['slug'],
                'new_url' => '/blog/' . $slug,
                'status_code' => 301,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        }

        $publishedAt = $existing['published_at'] ?? null;
        if ($status === 'published' && !$publishedAt) {
            $publishedAt = date('Y-m-d H:i:s');
        }
        if (!empty($_POST['published_at'])) {
            $publishedAt = date('Y-m-d H:i:s', strtotime((string) $_POST['published_at']));
        }

        // SSS blokları
        $faqOut = [];
        foreach (($_POST['faq_question'] ?? []) as $i => $q) {
            $q = trim((string) $q);
            if ($q !== '') {
                $faqOut[] = ['question' => $q, 'answer' => trim((string) ($_POST['faq_answer'][$i] ?? ''))];
            }
        }

        $relatedPosts = array_values(array_map('intval', (array) ($_POST['related_posts'] ?? [])));

        $data = [
            'category_id' => (int) ($_POST['category_id'] ?? 0) ?: null,
            'title' => $title,
            'slug' => $slug,
            'excerpt' => trim((string) ($_POST['excerpt'] ?? '')) ?: str_excerpt($md, 150),
            'content_markdown' => $md,
            'author_name' => trim((string) ($_POST['author_name'] ?? '')),
            'cover_image_alt' => trim((string) ($_POST['cover_image_alt'] ?? '')),
            'cover_image_title' => trim((string) ($_POST['cover_image_title'] ?? '')),
            'focus_keyword' => trim((string) ($_POST['focus_keyword'] ?? '')),
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'canonical_url' => trim((string) ($_POST['canonical_url'] ?? '')),
            'og_title' => trim((string) ($_POST['og_title'] ?? '')),
            'og_description' => trim((string) ($_POST['og_description'] ?? '')),
            'twitter_title' => trim((string) ($_POST['twitter_title'] ?? '')),
            'twitter_description' => trim((string) ($_POST['twitter_description'] ?? '')),
            'robots_index' => isset($_POST['robots_index']) ? 1 : 0,
            'robots_follow' => isset($_POST['robots_follow']) ? 1 : 0,
            'schema_type' => in_array($_POST['schema_type'] ?? '', ['Article', 'BlogPosting', 'NewsArticle'], true) ? $_POST['schema_type'] : 'BlogPosting',
            'related_service_id' => (int) ($_POST['related_service_id'] ?? 0) ?: null,
            'related_posts_json' => json_encode($relatedPosts),
            'faq_json' => json_encode($faqOut, JSON_UNESCAPED_UNICODE),
            'reading_time' => max(1, (int) ceil($wordCount / 200)),
            'status' => $status,
            'published_at' => $publishedAt,
        ];

        foreach (['cover_image' => 'blog', 'og_image' => 'blog', 'twitter_image' => 'blog'] as $field => $dir) {
            if (!empty($_FILES[$field]['name'])) {
                $res = UploadService::image($_FILES[$field], $dir);
                if (isset($res['path'])) { $data[$field] = $res['path']; }
                else { Session::flash('flash_err', $res['error']); }
            }
        }

        // SEO skoru sunucu tarafında hesaplanır ve kaydedilir
        $analysis = SeoAnalyzer::analyze(array_merge($existing ?? [], $data), $md);
        $data['seo_score'] = $analysis['score'];
        $data['seo_suggestions_json'] = json_encode($analysis['suggestions'], JSON_UNESCAPED_UNICODE);

        return $data;
    }
}
