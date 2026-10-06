<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Database;
use App\Models\Lead;

class AdminController extends AdminBaseController
{
    public function dashboard(): void
    {
        $count = fn (string $t, string $w = '1=1') => (int) (Database::selectOne("SELECT COUNT(*) c FROM `$t` WHERE $w")['c'] ?? 0);

        $stats = [
            'leads' => $count('leads'),
            'leads_new' => $count('leads', "status = 'new'"),
            'services' => $count('services', 'is_active = 1'),
            'projects' => $count('projects', 'is_active = 1'),
            'posts' => $count('blog_posts', "status = 'published'"),
            'equipment' => $count('equipment', 'is_active = 1'),
            'wa_clicks' => $count('site_events', "event_type = 'whatsapp_click'"),
            'gallery' => $count('gallery', 'is_active = 1'),
        ];

        $recentLeads = Lead::paginate(1, 6)['rows'];
        $recentEvents = Database::select("SELECT * FROM site_events ORDER BY id DESC LIMIT 8");

        $this->adminView('admin/dashboard', [
            'pageTitle' => 'Dashboard',
            'stats' => $stats,
            'recentLeads' => $recentLeads,
            'recentEvents' => $recentEvents,
        ]);
    }
}
