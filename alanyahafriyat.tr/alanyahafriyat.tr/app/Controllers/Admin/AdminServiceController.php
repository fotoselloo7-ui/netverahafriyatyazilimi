<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Service;
use App\Models\ServiceFaq;
use App\Services\UploadService;

class AdminServiceController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/services/index', [
            'pageTitle' => 'Hizmetler',
            'services' => Service::all('sort_order ASC'),
        ]);
    }

    public function create(): void
    {
        $this->adminView('admin/services/form', ['pageTitle' => 'Yeni Hizmet', 'service' => null, 'faqs' => []]);
    }

    public function edit(array $params): void
    {
        $service = Service::find((int) $params['id']);
        if (!$service) { $this->redirect('yonetim/hizmetler'); return; }
        $this->adminView('admin/services/form', [
            'pageTitle' => 'Hizmet Düzenle',
            'service' => $service,
            'faqs' => Service::faqs((int) $service['id']),
        ]);
    }

    public function store(): void
    {
        $this->verifyCsrf();
        $id = Service::create($this->data());
        $this->syncFaqs($id);
        Session::flash('flash_ok', 'Hizmet eklendi.');
        $this->redirect('yonetim/hizmetler/' . $id);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $service = Service::find((int) $params['id']);
        if (!$service) { $this->redirect('yonetim/hizmetler'); return; }
        Service::update((int) $service['id'], $this->data($service));
        $this->syncFaqs((int) $service['id']);
        Session::flash('flash_ok', 'Hizmet güncellendi.');
        $this->redirect('yonetim/hizmetler/' . $service['id']);
    }

    public function destroy(array $params): void
    {
        $this->verifyCsrf();
        Service::delete((int) $params['id']);
        Session::flash('flash_ok', 'Hizmet silindi.');
        $this->redirect('yonetim/hizmetler');
    }

    protected function data(?array $existing = null): array
    {
        $title = trim((string) ($_POST['title'] ?? ''));
        $slug = trim((string) ($_POST['slug'] ?? '')) ?: slugify($title);
        $linesToJson = fn (string $key) => json_encode(array_values(array_filter(array_map('trim', explode("\n", (string) ($_POST[$key] ?? ''))))), JSON_UNESCAPED_UNICODE);

        $process = [];
        $ptitles = $_POST['process_title'] ?? [];
        $ptexts = $_POST['process_text'] ?? [];
        foreach ($ptitles as $i => $pt) {
            $pt = trim((string) $pt);
            if ($pt !== '') { $process[] = ['title' => $pt, 'text' => trim((string) ($ptexts[$i] ?? ''))]; }
        }

        $data = [
            'title' => $title,
            'slug' => $slug,
            'short_description' => trim((string) ($_POST['short_description'] ?? '')),
            'content' => (string) ($_POST['content'] ?? ''),
            'icon' => trim((string) ($_POST['icon'] ?? 'excavator')),
            'hero_title' => trim((string) ($_POST['hero_title'] ?? '')),
            'hero_subtitle' => trim((string) ($_POST['hero_subtitle'] ?? '')),
            'advantages_json' => $linesToJson('advantages'),
            'usage_areas_json' => $linesToJson('usage_areas'),
            'process_json' => json_encode($process, JSON_UNESCAPED_UNICODE),
            'seo_title' => trim((string) ($_POST['seo_title'] ?? '')),
            'seo_description' => trim((string) ($_POST['seo_description'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_featured' => isset($_POST['is_featured']) ? 1 : 0,
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        foreach (['card_image' => 'hizmetler', 'cover_image' => 'hizmetler', 'hero_image' => 'hizmetler'] as $field => $dir) {
            if (!empty($_FILES[$field]['name'])) {
                $res = UploadService::image($_FILES[$field], $dir);
                if (isset($res['path'])) { $data[$field] = $res['path']; }
                else { Session::flash('flash_err', $res['error']); }
            }
        }
        return $data;
    }

    protected function syncFaqs(int $serviceId): void
    {
        \App\Core\Database::execute('DELETE FROM service_faqs WHERE service_id = ?', [$serviceId]);
        $questions = $_POST['faq_question'] ?? [];
        $answers = $_POST['faq_answer'] ?? [];
        foreach ($questions as $i => $q) {
            $q = trim((string) $q);
            if ($q === '') { continue; }
            ServiceFaq::create([
                'service_id' => $serviceId,
                'question' => $q,
                'answer' => trim((string) ($answers[$i] ?? '')),
                'sort_order' => $i,
                'is_active' => 1,
            ]);
        }
    }
}
