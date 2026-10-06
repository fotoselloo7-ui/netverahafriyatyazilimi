<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Services\LeadService;

class LeadController extends Controller
{
    public function store(): void
    {
        Csrf::check();
        $result = LeadService::create($_POST);

        $isAjax = ($_SERVER['HTTP_X_REQUESTED_WITH'] ?? '') === 'XMLHttpRequest';
        if ($isAjax) {
            $this->json(['ok' => $result['ok'], 'message' => $result['message']]);
            return;
        }

        Session::flash($result['ok'] ? 'flash_ok' : 'flash_err', $result['message']);
        if (!$result['ok']) {
            Session::flash('_old', $_POST);
        }
        $this->redirect($_SERVER['HTTP_REFERER'] ?? base_url('iletisim'));
    }
}
