<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Models\Lead;

class AdminLeadController extends AdminBaseController
{
    public function index(): void
    {
        $page = max(1, (int) ($_GET['sayfa'] ?? 1));
        $search = trim((string) ($_GET['q'] ?? ''));
        $status = trim((string) ($_GET['durum'] ?? ''));
        $data = Lead::paginate($page, 20, $search, $status);
        $this->adminView('admin/leads/index', array_merge($data, [
            'pageTitle' => 'Teklifler / Leadler',
            'search' => $search,
            'status' => $status,
        ]));
    }

    public function show(array $params): void
    {
        $lead = Lead::find((int) $params['id']);
        if (!$lead) { $this->redirect('yonetim/teklifler'); return; }
        $this->adminView('admin/leads/show', ['pageTitle' => 'Teklif Detayı', 'lead' => $lead]);
    }

    public function update(array $params): void
    {
        $this->verifyCsrf();
        $lead = Lead::find((int) $params['id']);
        if (!$lead) { $this->redirect('yonetim/teklifler'); return; }
        Lead::update((int) $lead['id'], [
            'status' => trim((string) ($_POST['status'] ?? 'new')),
            'admin_note' => trim((string) ($_POST['admin_note'] ?? '')),
        ]);
        Session::flash('flash_ok', 'Teklif güncellendi.');
        $this->redirect('yonetim/teklifler/' . $lead['id']);
    }

    public function export(): void
    {
        $rows = Lead::all('id DESC');
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="teklifler-' . date('Y-m-d') . '.csv"');
        $out = fopen('php://output', 'w');
        fprintf($out, "\xEF\xBB\xBF"); // UTF-8 BOM
        fputcsv($out, ['ID', 'Ad', 'Telefon', 'E-posta', 'Hizmet', 'Bölge', 'Mesaj', 'Kaynak', 'Durum', 'Tarih']);
        foreach ($rows as $r) {
            fputcsv($out, [$r['id'], $r['name'], $r['phone'], $r['email'], $r['service_type'], $r['region'], $r['message'], $r['source'], $r['status'], $r['created_at']]);
        }
        fclose($out);
        exit;
    }
}
