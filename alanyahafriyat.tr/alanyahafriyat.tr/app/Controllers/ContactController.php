<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Models\Service;
use App\Services\LeadService;

class ContactController extends Controller
{
    public function index(): void
    {
        $this->view('contact/index', [
            'services' => Service::active('sort_order ASC'),
            'seo' => [
                'title' => 'İletişim | ' . site_name(),
                'description' => 'Alanya ve Mahmutlar hafriyat ve kepçe hizmetleri için bize ulaşın. Telefon, WhatsApp ve iletişim formu.',
            ],
            'breadcrumb' => [['Ana Sayfa', base_url()], ['İletişim', null]],
        ]);
    }

    public function submit(): void
    {
        Csrf::check();
        $data = $_POST;
        $data['source'] = 'contact';
        $result = LeadService::create($data);

        $isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
        if ($isAjax) {
            $this->json(['ok' => $result['ok'], 'message' => $result['message']]);
            return;
        }
        Session::flash($result['ok'] ? 'flash_ok' : 'flash_err', $result['message']);
        if (!$result['ok']) {
            Session::flash('_old', $_POST);
        }
        $this->redirect('iletisim');
    }
}
