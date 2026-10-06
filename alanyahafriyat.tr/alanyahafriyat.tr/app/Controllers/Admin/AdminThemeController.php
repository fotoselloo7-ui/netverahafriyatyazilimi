<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Core\Session;
use App\Services\SettingsService;

class AdminThemeController extends AdminBaseController
{
    /** Palet + manuel formda yönetilen tüm renk alanları. */
    protected array $colorFields = [
        'primary_color', 'primary_hover_color', 'primary_text_color',
        'secondary_color', 'secondary_text_color', 'dark_color', 'accent_color',
        'background_color', 'surface_color', 'text_color', 'muted_text_color',
        'border_color', 'button_primary_bg', 'button_primary_text',
        'button_dark_bg', 'button_dark_text', 'whatsapp_color',
    ];
    protected array $otherFields = ['border_radius', 'card_radius', 'shadow_strength'];

    /**
     * Profesyonel, WCAG-kontrastlı hazır paletler. Her palet buton metin
     * renklerini de içerir; açık primary'de koyu metin, koyu primary'de beyaz.
     */
    public static function palettes(): array
    {
        return [
            'hafriyat' => ['name' => 'Hafriyat Sarısı', 'colors' => [
                'primary_color' => '#F5A400', 'primary_hover_color' => '#D98A00', 'primary_text_color' => '#111827',
                'secondary_color' => '#111827', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#080B0F',
                'accent_color' => '#FFB703', 'background_color' => '#F7F4EF', 'surface_color' => '#FFFFFF',
                'text_color' => '#111827', 'muted_text_color' => '#64748B', 'border_color' => '#E5E7EB',
                'button_primary_bg' => '#F5A400', 'button_primary_text' => '#111827',
                'button_dark_bg' => '#080B0F', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'kurumsal' => ['name' => 'Kurumsal Mavi', 'colors' => [
                'primary_color' => '#2563EB', 'primary_hover_color' => '#1D4ED8', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#0F172A', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#020617',
                'accent_color' => '#F59E0B', 'background_color' => '#F8FAFC', 'surface_color' => '#FFFFFF',
                'text_color' => '#0F172A', 'muted_text_color' => '#64748B', 'border_color' => '#E2E8F0',
                'button_primary_bg' => '#2563EB', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#0F172A', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'zumrut' => ['name' => 'Zümrüt Yeşil', 'colors' => [
                'primary_color' => '#059669', 'primary_hover_color' => '#047857', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#064E3B', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#022C22',
                'accent_color' => '#FBBF24', 'background_color' => '#F0FDF4', 'surface_color' => '#FFFFFF',
                'text_color' => '#052E16', 'muted_text_color' => '#64748B', 'border_color' => '#D1FAE5',
                'button_primary_bg' => '#059669', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#022C22', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'turuncu' => ['name' => 'Şantiye Turuncu', 'colors' => [
                'primary_color' => '#EA580C', 'primary_hover_color' => '#C2410C', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#1C1917', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#0C0A09',
                'accent_color' => '#FACC15', 'background_color' => '#FFF7ED', 'surface_color' => '#FFFFFF',
                'text_color' => '#1C1917', 'muted_text_color' => '#78716C', 'border_color' => '#FED7AA',
                'button_primary_bg' => '#EA580C', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#1C1917', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'bordo' => ['name' => 'Bordo Kırmızı', 'colors' => [
                'primary_color' => '#B91C1C', 'primary_hover_color' => '#991B1B', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#18181B', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#09090B',
                'accent_color' => '#F59E0B', 'background_color' => '#FEF2F2', 'surface_color' => '#FFFFFF',
                'text_color' => '#111827', 'muted_text_color' => '#6B7280', 'border_color' => '#FECACA',
                'button_primary_bg' => '#B91C1C', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#18181B', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'mor' => ['name' => 'Modern Mor', 'colors' => [
                'primary_color' => '#7C3AED', 'primary_hover_color' => '#6D28D9', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#1E1B4B', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#0F0A2A',
                'accent_color' => '#F59E0B', 'background_color' => '#F5F3FF', 'surface_color' => '#FFFFFF',
                'text_color' => '#1E1B4B', 'muted_text_color' => '#6B7280', 'border_color' => '#DDD6FE',
                'button_primary_bg' => '#7C3AED', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#1E1B4B', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'teal' => ['name' => 'Okyanus Teal', 'colors' => [
                'primary_color' => '#0F766E', 'primary_hover_color' => '#115E59', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#134E4A', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#042F2E',
                'accent_color' => '#F59E0B', 'background_color' => '#F0FDFA', 'surface_color' => '#FFFFFF',
                'text_color' => '#134E4A', 'muted_text_color' => '#64748B', 'border_color' => '#CCFBF1',
                'button_primary_bg' => '#0F766E', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#042F2E', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'altin' => ['name' => 'Gece Altını', 'colors' => [
                'primary_color' => '#EAB308', 'primary_hover_color' => '#CA8A04', 'primary_text_color' => '#111827',
                'secondary_color' => '#111827', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#030712',
                'accent_color' => '#FACC15', 'background_color' => '#F9FAFB', 'surface_color' => '#FFFFFF',
                'text_color' => '#111827', 'muted_text_color' => '#6B7280', 'border_color' => '#E5E7EB',
                'button_primary_bg' => '#EAB308', 'button_primary_text' => '#111827',
                'button_dark_bg' => '#030712', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'amber' => ['name' => 'Kömür & Amber', 'colors' => [
                'primary_color' => '#F59E0B', 'primary_hover_color' => '#D97706', 'primary_text_color' => '#111827',
                'secondary_color' => '#1F2937', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#111827',
                'accent_color' => '#FBBF24', 'background_color' => '#F3F4F6', 'surface_color' => '#FFFFFF',
                'text_color' => '#111827', 'muted_text_color' => '#6B7280', 'border_color' => '#D1D5DB',
                'button_primary_bg' => '#F59E0B', 'button_primary_text' => '#111827',
                'button_dark_bg' => '#111827', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'petrol' => ['name' => 'Petrol Yeşili', 'colors' => [
                'primary_color' => '#0D9488', 'primary_hover_color' => '#0F766E', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#0F172A', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#020617',
                'accent_color' => '#F59E0B', 'background_color' => '#F8FAFC', 'surface_color' => '#FFFFFF',
                'text_color' => '#0F172A', 'muted_text_color' => '#64748B', 'border_color' => '#CBD5E1',
                'button_primary_bg' => '#0D9488', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#0F172A', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
            'gece' => ['name' => 'Gece Modu', 'colors' => [
                'primary_color' => '#F59E0B', 'primary_hover_color' => '#D97706', 'primary_text_color' => '#111827',
                'secondary_color' => '#E5E7EB', 'secondary_text_color' => '#111827', 'dark_color' => '#020617',
                'accent_color' => '#FBBF24', 'background_color' => '#0F172A', 'surface_color' => '#111827',
                'text_color' => '#F8FAFC', 'muted_text_color' => '#CBD5E1', 'border_color' => '#334155',
                'button_primary_bg' => '#F59E0B', 'button_primary_text' => '#111827',
                'button_dark_bg' => '#E5E7EB', 'button_dark_text' => '#111827', 'whatsapp_color' => '#25D366',
            ]],
            'lacivert' => ['name' => 'Denizci Lacivert', 'colors' => [
                'primary_color' => '#0284C7', 'primary_hover_color' => '#0369A1', 'primary_text_color' => '#FFFFFF',
                'secondary_color' => '#0C4A6E', 'secondary_text_color' => '#FFFFFF', 'dark_color' => '#082F49',
                'accent_color' => '#F59E0B', 'background_color' => '#F0F9FF', 'surface_color' => '#FFFFFF',
                'text_color' => '#082F49', 'muted_text_color' => '#64748B', 'border_color' => '#BAE6FD',
                'button_primary_bg' => '#0284C7', 'button_primary_text' => '#FFFFFF',
                'button_dark_bg' => '#082F49', 'button_dark_text' => '#FFFFFF', 'whatsapp_color' => '#25D366',
            ]],
        ];
    }

    public function index(): void
    {
        $this->adminView('admin/theme/index', [
            'pageTitle' => 'Tema / Renk Ayarları',
            'theme' => Database::selectOne('SELECT * FROM theme_settings ORDER BY id ASC LIMIT 1') ?: [],
            'palettes' => static::palettes(),
        ]);
    }

    public function applyPalette(): void
    {
        $this->verifyCsrf();
        $key = trim((string) ($_POST['palette'] ?? ''));
        $palettes = static::palettes();
        if (!isset($palettes[$key])) {
            Session::flash('flash_err', 'Palet bulunamadı.');
            $this->redirect('yonetim/tema');
            return;
        }
        $data = $palettes[$key]['colors'];
        $this->persist($data);
        Session::flash('flash_ok', '"' . $palettes[$key]['name'] . '" paleti tüm siteye uygulandı.');
        $this->redirect('yonetim/tema');
    }

    public function save(): void
    {
        $this->verifyCsrf();
        $data = [];
        foreach ($this->colorFields as $f) {
            $val = trim((string) ($_POST[$f] ?? ''));
            if (preg_match('/^#[0-9a-fA-F]{6}$/', $val)) {
                $data[$f] = $val;
            }
        }
        // Zemin rengi değişmiş ama ona bağlı metin rengi elle değiştirilmemişse
        // eski metin rengini taşımak yerine yeni zemin için okunabilir kontrast üret.
        $current = Database::selectOne('SELECT * FROM theme_settings ORDER BY id ASC LIMIT 1') ?: [];
        $contrastPairs = [
            ['primary_color', 'primary_text_color'],
            ['secondary_color', 'secondary_text_color'],
            ['button_primary_bg', 'button_primary_text'],
            ['button_dark_bg', 'button_dark_text'],
        ];
        foreach ($contrastPairs as [$bgKey, $textKey]) {
            if (empty($data[$bgKey])) {
                continue;
            }
            $oldBg = strtolower((string) ($current[$bgKey] ?? ''));
            $oldText = strtolower((string) ($current[$textKey] ?? ''));
            $newBg = strtolower((string) $data[$bgKey]);
            $newText = strtolower((string) ($data[$textKey] ?? ''));
            $backgroundChanged = $oldBg !== '' && $newBg !== $oldBg;
            $textWasNotChanged = $newText === '' || $newText === $oldText;
            if (($backgroundChanged && $textWasNotChanged) || $newText === '') {
                $data[$textKey] = get_contrast_text($data[$bgKey]);
            }
        }
        foreach ($this->otherFields as $f) {
            if (isset($_POST[$f])) {
                $data[$f] = trim((string) $_POST[$f]);
            }
        }
        $this->persist($data);
        Session::flash('flash_ok', 'Tema ayarları kaydedildi. Renkler tüm sitede güncellendi.');
        $this->redirect('yonetim/tema');
    }

    protected function persist(array $data): void
    {
        $row = Database::selectOne('SELECT id FROM theme_settings ORDER BY id ASC LIMIT 1');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($row) {
            $sets = implode(', ', array_map(fn ($k) => "`$k` = ?", array_keys($data)));
            $params = array_values($data);
            $params[] = $row['id'];
            Database::execute("UPDATE theme_settings SET $sets WHERE id = ?", $params);
        } else {
            $cols = '`' . implode('`, `', array_keys($data)) . '`';
            $ph = implode(', ', array_fill(0, count($data), '?'));
            Database::execute("INSERT INTO theme_settings ($cols) VALUES ($ph)", array_values($data));
        }
        SettingsService::clearCache();
    }
}
