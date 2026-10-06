<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class SitemapController extends Controller
{
    public function index(): void
    {
        header('Content-Type: application/xml; charset=utf-8');
        $urls = [];
        $seen = [];
        $add = function (string $loc, string $lastmod = '', string $freq = 'weekly', string $prio = '0.7') use (&$urls, &$seen) {
            if (isset($seen[$loc])) {
                return;
            }
            $seen[$loc] = true;
            $urls[] = compact('loc', 'lastmod', 'freq', 'prio');
        };

        $add(base_url(), date('Y-m-d'), 'daily', '1.0');
        $add(base_url('hakkimizda'), '', 'monthly', '0.7');
        $add(base_url('hizmetler'), '', 'weekly', '0.9');
        $add(base_url('blog'), '', 'weekly', '0.8');
        $add(base_url('sss'), '', 'monthly', '0.6');
        $add(base_url('iletisim'), '', 'monthly', '0.7');

        // Boş vitrin sayfalarını sitemap'a sokma. Gerçek veri eklendiğinde otomatik dahil edilir.
        $projectCount = (int) (Database::selectOne("SELECT COUNT(*) AS c FROM projects WHERE is_active=1")['c'] ?? 0);
        $equipmentCount = (int) (Database::selectOne("SELECT COUNT(*) AS c FROM equipment WHERE is_active=1")['c'] ?? 0);
        $galleryCount = (int) (Database::selectOne("SELECT COUNT(*) AS c FROM gallery WHERE is_active=1")['c'] ?? 0);

        if ($projectCount > 0) {
            $add(base_url('projeler'), '', 'weekly', '0.7');
        }
        if ($equipmentCount > 0) {
            $add(base_url('makine-parkuru'), '', 'monthly', '0.6');
        }
        if ($galleryCount > 0) {
            $add(base_url('galeri'), '', 'monthly', '0.5');
        }

        foreach (Database::select("SELECT slug, updated_at FROM services WHERE is_active=1 AND slug <> 'alanya-hafriyat-hizmeti' ORDER BY sort_order ASC, id ASC") as $r) {
            $add(base_url('hizmetler/' . $r['slug']), substr((string) $r['updated_at'], 0, 10), 'monthly', '0.8');
        }
        foreach (Database::select("SELECT slug, updated_at FROM projects WHERE is_active=1 ORDER BY project_date DESC, id DESC") as $r) {
            $add(base_url('projeler/' . $r['slug']), substr((string) $r['updated_at'], 0, 10), 'monthly', '0.7');
        }
        foreach (Database::select("SELECT slug, updated_at FROM equipment WHERE is_active=1 ORDER BY sort_order ASC, id ASC") as $r) {
            $add(base_url('makine-parkuru/' . $r['slug']), substr((string) $r['updated_at'], 0, 10), 'monthly', '0.6');
        }
        foreach (Database::select("SELECT slug, updated_at FROM blog_posts WHERE status='published' AND robots_index=1 ORDER BY published_at DESC") as $r) {
            $add(base_url('blog/' . $r['slug']), substr((string) $r['updated_at'], 0, 10), 'weekly', '0.8');
        }
        foreach (Database::select("SELECT slug FROM blog_categories WHERE is_active=1 ORDER BY sort_order ASC, id ASC") as $r) {
            $add(base_url('blog/kategori/' . $r['slug']), '', 'monthly', '0.6');
        }
        foreach (Database::select("SELECT slug, updated_at FROM pages WHERE is_active=1 AND robots_index=1 AND slug <> 'hakkimizda'") as $r) {
            $add(base_url('sayfa/' . $r['slug']), substr((string) $r['updated_at'], 0, 10), 'yearly', '0.4');
        }

        echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
        foreach ($urls as $u) {
            echo "  <url>\n    <loc>" . e($u['loc']) . "</loc>\n";
            if ($u['lastmod']) { echo "    <lastmod>" . e($u['lastmod']) . "</lastmod>\n"; }
            echo "    <changefreq>" . $u['freq'] . "</changefreq>\n    <priority>" . $u['prio'] . "</priority>\n  </url>\n";
        }
        echo '</urlset>';
        exit;
    }

    public function robots(): void
    {
        header('Content-Type: text/plain; charset=utf-8');
        echo "User-agent: *\n";
        echo "Allow: /\n";
        echo "Disallow: /yonetim\n";
        echo "Disallow: /yonetim/\n\n";
        echo 'Sitemap: ' . base_url('sitemap.xml') . "\n";
        exit;
    }
}
