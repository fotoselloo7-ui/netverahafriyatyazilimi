<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Core\View;
use App\Services\License\LicenseService;

abstract class AdminBaseController extends Controller
{
    public function __construct()
    {
        Auth::requireLogin();
        $this->licenseGuard();
        View::share('adminUser', Auth::user());
        View::share('siteName', site_name());
        View::share('flashOk', Session::flash('flash_ok'));
        View::share('flashErr', Session::flash('flash_err'));
        View::share('currentAdminPath', current_path());
    }

    /**
     * Lisans middleware'i: tüm admin sayfalarını korur.
     * Lisans geçerli değilse yalnızca /yonetim/lisans* sayfalarına izin verilir
     * (aktivasyon, durum, değiştirme). Çıkış zaten guard dışındadır.
     * DIGIKEY_ENV=local modunda kilitleme yapılmaz.
     */
    protected function licenseGuard(): void
    {
        $path = current_path();
        if (str_starts_with($path, '/yonetim/lisans')) {
            return; // lisans ekranlarının kendisi asla kilitlenmez (lockout önlenir)
        }

        $status = LicenseService::getStatus(true);
        View::share('licenseStatus', $status);

        if (!($status['locked'] ?? false)) {
            // Lisans geçerli: günde bir heartbeat gönder (yalnızca production).
            if (LicenseService::enforced() && in_array($status['state'] ?? '', ['active'], true)) {
                LicenseService::heartbeatIfDue();
            }
            return;
        }

        if (($status['state'] ?? '') === 'needs_activation') {
            $this->redirect('yonetim/lisans/aktif-et');
        }
        $this->redirect('yonetim/lisans');
    }

    protected function adminView(string $template, array $data = []): void
    {
        View::display($template, $data, 'admin/layout');
    }

    protected function verifyCsrf(): void
    {
        Csrf::check();
    }

    protected function back(string $fallback = '/yonetim'): void
    {
        $this->redirect($_SERVER['HTTP_REFERER'] ?? base_url(ltrim($fallback, '/')));
    }
}
