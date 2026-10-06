<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\HomeSection;
use App\Services\UploadService;

class AdminHomeController extends AdminBaseController
{
    public function index(): void
    {
        $this->adminView('admin/home/index', [
            'pageTitle' => 'Ana Sayfa Bölümleri',
            'sections' => HomeSection::all('sort_order ASC'),
        ]);
    }

    public function edit(array $params): void
    {
        $section = HomeSection::find((int) $params['id']);
        if (!$section) { $this->redirect('yonetim/anasayfa'); return; }
        $this->adminView('admin/home/edit', [
            'pageTitle' => 'Bölüm Düzenle: ' . $section['title'],
            'section' => $section,
            'content' => json_decode_safe($section['content_json']),
        ]);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $section = HomeSection::find((int) $params['id']);
        if (!$section) { $this->redirect('yonetim/anasayfa'); return; }

        $data = [
            'title' => trim((string) ($_POST['title'] ?? '')),
            'subtitle' => trim((string) ($_POST['subtitle'] ?? '')),
            'cta_text' => trim((string) ($_POST['cta_text'] ?? '')),
            'cta_url' => trim((string) ($_POST['cta_url'] ?? '')),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];

        $sectionKey = (string) $section['section_key'];

        // Hero: butonlar + teklif formu + güven rozetleri aynı ekrandan yönetilir.
        if ($sectionKey === 'hero') {
            $existing = json_decode_safe($section['content_json']);
            $existing['button_1_text'] = trim((string) ($_POST['button_1_text'] ?? ''));
            $existing['button_1_url'] = trim((string) ($_POST['button_1_url'] ?? ''));
            $existing['button_1_type'] = trim((string) ($_POST['button_1_type'] ?? 'whatsapp'));
            $existing['button_2_text'] = trim((string) ($_POST['button_2_text'] ?? ''));
            $existing['button_2_url'] = trim((string) ($_POST['button_2_url'] ?? ''));
            $existing['button_2_type'] = trim((string) ($_POST['button_2_type'] ?? 'internal'));
            $existing['overlay_opacity'] = trim((string) ($_POST['overlay_opacity'] ?? '0.6'));
            $existing['show_form'] = isset($_POST['show_form']) ? '1' : '0';
            $existing['show_badges'] = isset($_POST['show_badges']) ? '1' : '0';

            $badgeIcons = $_POST['badge_icon'] ?? [];
            $badgeTitles = $_POST['badge_title'] ?? [];
            $badgeTexts = $_POST['badge_text'] ?? [];
            $badges = [];
            foreach ($badgeTitles as $i => $title) {
                $title = trim((string) $title);
                $text = trim((string) ($badgeTexts[$i] ?? ''));
                if ($title === '' && $text === '') { continue; }
                $badges[] = [
                    'icon' => trim((string) ($badgeIcons[$i] ?? 'check')),
                    'title' => $title,
                    'text' => $text,
                ];
            }
            $existing['badges'] = $badges;
            $data['content_json'] = json_encode($existing, JSON_UNESCAPED_UNICODE);
        }

        // Çalışma süreci kartları eskiden yalnız seed verisindeydi; artık admin yönetir.
        if ($sectionKey === 'process') {
            $stepIcons = $_POST['step_icon'] ?? [];
            $stepTitles = $_POST['step_title'] ?? [];
            $stepTexts = $_POST['step_text'] ?? [];
            $steps = [];
            foreach ($stepTitles as $i => $title) {
                $title = trim((string) $title);
                $text = trim((string) ($stepTexts[$i] ?? ''));
                if ($title === '' && $text === '') { continue; }
                $steps[] = [
                    'icon' => trim((string) ($stepIcons[$i] ?? 'check')),
                    'title' => $title,
                    'text' => $text,
                ];
            }
            $data['content_json'] = json_encode($steps, JSON_UNESCAPED_UNICODE);
        }

        if (!empty($_FILES['image']['name'])) {
            $res = UploadService::image($_FILES['image'], 'anasayfa');
            if (isset($res['path'])) { $data['image'] = $res['path']; }
            else { Session::flash('flash_err', $res['error']); }
        }
        if (!empty($_POST['remove_image'])) { $data['image'] = ''; }

        HomeSection::update((int) $section['id'], $data);
        Session::flash('flash_ok', 'Bölüm güncellendi.');
        $this->redirect('yonetim/anasayfa/' . $section['id']);
    }
}
