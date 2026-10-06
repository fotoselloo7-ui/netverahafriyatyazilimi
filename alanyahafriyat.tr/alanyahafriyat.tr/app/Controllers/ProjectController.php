<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index(): void
    {
        $region = trim((string) ($_GET['bolge'] ?? ''));
        $type = trim((string) ($_GET['hizmet'] ?? ''));

        $where = 'is_active = 1';
        $params = [];
        if ($region !== '') { $where .= ' AND region = ?'; $params[] = $region; }
        if ($type !== '') { $where .= ' AND service_type = ?'; $params[] = $type; }

        $projects = Database::select("SELECT * FROM projects WHERE $where ORDER BY id DESC", $params);

        $this->view('projects/index', [
            'projects' => $projects,
            'regions' => array_column(Database::select("SELECT DISTINCT region FROM projects WHERE is_active=1 AND region<>'' ORDER BY region"), 'region'),
            'types' => array_column(Database::select("SELECT DISTINCT service_type FROM projects WHERE is_active=1 AND service_type<>'' ORDER BY service_type"), 'service_type'),
            'activeRegion' => $region,
            'activeType' => $type,
            'seo' => [
                'title' => 'Projelerimiz | ' . site_name(),
                'description' => 'Alanya ve Mahmutlar’da tamamladığımız hafriyat, temel kazısı ve çevre düzenleme projelerimiz.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Projelerimiz', null]],
        ]);
    }

    public function show(array $params): void
    {
        $project = Project::findBySlug($params['slug'] ?? '');
        if (!$project || (int) $project['is_active'] !== 1) {
            $this->abort(404);
            return;
        }
        $this->view('projects/show', [
            'project' => $project,
            'gallery' => json_decode_safe($project['gallery_json']),
            'related' => Database::select('SELECT * FROM projects WHERE is_active=1 AND id<>? ORDER BY id DESC LIMIT 3', [(int) $project['id']]),
            'seo' => [
                'title' => $project['seo_title'] ?: ($project['title'] . ' | ' . site_name()),
                'description' => $project['seo_description'] ?: str_excerpt($project['short_description'], 155),
                'og_image' => $project['cover_image'],
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['Projelerimiz', base_url('projeler')], [$project['title'], null]],
        ]);
    }
}
