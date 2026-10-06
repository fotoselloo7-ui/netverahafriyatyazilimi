<?php

declare(strict_types=1);

namespace App\Services;

/**
 * Blog yazıları için SEO puanlayıcı (100 üzerinden) + öneri listesi.
 * Kriterler yorumhizmeti standardına göre: odak anahtar kelime, meta uzunlukları,
 * içerik yapısı, görsel alt metinleri, iç/dış link, ilişkili hizmet, schema vb.
 */
class SeoAnalyzer
{
    /**
     * @param array  $post Form/DB alanları (title, slug, focus_keyword, seo_title,
     *                     seo_description, canonical_url, og_image, cover_image,
     *                     cover_image_alt, related_service_id, faq_json ...)
     * @param string $markdown Ham markdown içerik
     * @return array{score:int, suggestions:string[]}
     */
    public static function analyze(array $post, string $markdown): array
    {
        $score = 0;
        $suggestions = [];
        $add = function (int $points, bool $ok, string $suggestion) use (&$score, &$suggestions) {
            if ($ok) {
                $score += $points;
            } else {
                $suggestions[] = $suggestion;
            }
        };

        $fk = mb_strtolower(trim((string) ($post['focus_keyword'] ?? '')), 'UTF-8');
        $title = mb_strtolower((string) ($post['title'] ?? ''), 'UTF-8');
        $slug = (string) ($post['slug'] ?? '');
        $seoTitle = (string) (($post['seo_title'] ?? '') ?: ($post['title'] ?? ''));
        $metaDesc = (string) ($post['seo_description'] ?? '');
        $plain = mb_strtolower(preg_replace('/\s+/', ' ', strip_tags($markdown)), 'UTF-8');
        $words = preg_split('/\s+/', trim(strip_tags($markdown)), -1, PREG_SPLIT_NO_EMPTY);
        $wordCount = count($words);
        $first100 = implode(' ', array_slice(array_map(fn ($w) => mb_strtolower($w, 'UTF-8'), $words), 0, 100));

        // Başlıklar (H2/H3)
        preg_match_all('/^#{2,3}\s+(.+)$/m', $markdown, $hm);
        $headings = array_map(fn ($h) => mb_strtolower($h, 'UTF-8'), $hm[1] ?? []);

        // Görseller
        preg_match_all('/!\[(.*?)\]\((\S+?)(?:\s+".*?")?\)/', $markdown, $im, PREG_SET_ORDER);
        $imageCount = count($im);
        $imagesWithAlt = count(array_filter($im, fn ($m) => trim($m[1]) !== ''));

        // Linkler (görselleri hariç tut)
        preg_match_all('/(?<!\!)\[(?:.+?)\]\((.+?)\)/', $markdown, $lm);
        $links = $lm[1] ?? [];
        $internal = array_filter($links, fn ($u) => str_starts_with($u, '/') || str_contains($u, (string) parse_url(base_url(), PHP_URL_HOST)));
        $external = array_filter($links, fn ($u) => preg_match('#^https?://#', $u) && !str_contains($u, (string) parse_url(base_url(), PHP_URL_HOST)));

        // Paragraf uzunlukları
        $paragraphs = array_filter(array_map('trim', preg_split('/\n\s*\n/', $markdown)));
        $longParas = array_filter($paragraphs, fn ($p) => !str_starts_with($p, '#') && mb_strlen($p) > 900);

        $faqs = json_decode_safe((string) ($post['faq_json'] ?? ''));

        // --- Odak anahtar kelime (34 puan) ---
        if ($fk === '') {
            $suggestions[] = 'Odak anahtar kelime belirleyin — SEO puanlamasının temelidir.';
        }
        $add(8, $fk !== '' && str_contains($title, $fk), 'Odak anahtar kelime yazı başlığında geçmiyor.');
        $add(6, $fk !== '' && str_contains($slug, slugify($fk)), 'Odak anahtar kelime slug (URL) içinde geçmiyor.');
        $add(8, $fk !== '' && str_contains($first100, $fk), 'Odak anahtar kelime ilk paragrafta (ilk 100 kelime) geçmiyor.');
        $add(6, $fk !== '' && (bool) array_filter($headings, fn ($h) => str_contains($h, $fk)), 'Odak anahtar kelime en az bir H2/H3 başlıkta geçmiyor.');
        $add(6, $fk !== '' && str_contains(mb_strtolower($metaDesc, 'UTF-8'), $fk), 'Odak anahtar kelime meta açıklamada geçmiyor.');

        // --- Meta / başlık uzunlukları (13 puan) ---
        $mdLen = mb_strlen($metaDesc);
        $add(7, $mdLen >= 50 && $mdLen <= 160, $mdLen === 0 ? 'Meta açıklama (description) girilmemiş.' : 'Meta açıklama uzunluğu 50–160 karakter arasında olmalı (şu an: ' . $mdLen . ').');
        $stLen = mb_strlen($seoTitle);
        $add(6, $stLen >= 30 && $stLen <= 65, 'SEO başlığı 30–65 karakter arasında olmalı (şu an: ' . $stLen . ').');

        // --- İçerik yapısı (20 puan) ---
        if ($wordCount >= 600) {
            $score += 10;
        } elseif ($wordCount >= 300) {
            $score += 5;
            $suggestions[] = 'İçerik ' . $wordCount . ' kelime — en az 600 kelime hedefleyin.';
        } else {
            $suggestions[] = 'İçerik çok kısa (' . $wordCount . ' kelime). En az 600 kelime yazın.';
        }
        $add(6, count($headings) >= 2, 'İçerikte en az iki H2/H3 alt başlık kullanın.');
        $add(4, count($longParas) === 0, 'Bazı paragraflar çok uzun — paragrafları bölerek okunabilirliği artırın.');

        // --- Görseller (9 puan) ---
        if ($imageCount === 0) {
            $suggestions[] = 'Makale içine en az bir görsel ekleyin (alt etiketiyle).';
        } else {
            $add(5, $imagesWithAlt === $imageCount, 'Bazı makale görsellerinde alt etiketi eksik.');
            $score += 2; // görsel var
        }
        $add(2, trim((string) ($post['cover_image_alt'] ?? '')) !== '' || empty($post['cover_image']), 'Kapak görseli alt etiketi eksik.');

        // --- Linkler (9 puan) ---
        $add(5, count($internal) > 0, 'İçerikte en az bir iç bağlantı (kendi sayfalarınıza link) ekleyin.');
        $add(4, count($external) > 0, 'İçerikte güvenilir bir dış kaynağa bağlantı ekleyin.');

        // --- İlişkilendirme & teknik (15 puan) ---
        $add(4, !empty($post['related_service_id']), 'İlgili hizmet bağlantısı seçilmemiş.');
        $add(3, true, ''); // canonical otomatik üretilir (manuel girilmemişse yazı URL'si)
        $add(4, !empty($post['og_image']) || !empty($post['cover_image']), 'OG/paylaşım görseli veya kapak görseli ekleyin.');
        $add(4, $slug !== '' && strlen($slug) <= 75 && preg_match('/^[a-z0-9-]+$/', $slug), 'Slug kısa (≤75) ve yalnızca küçük harf/rakam/tire içermeli.');

        // --- SSS / FAQ schema (4 puan) ---
        $add(4, count($faqs) > 0, 'Yazıya SSS bloğu ekleyin — FAQ schema üretilerek zengin sonuç şansı artar.');

        return ['score' => max(0, min(100, $score)), 'suggestions' => array_values(array_filter($suggestions))];
    }

    public static function scoreLabel(int $score): array
    {
        return match (true) {
            $score >= 90 => ['Çok İyi', '#16a34a'],
            $score >= 75 => ['İyi', '#65a30d'],
            $score >= 50 => ['Geliştirilmeli', '#d97706'],
            default      => ['Zayıf', '#dc2626'],
        };
    }
}
