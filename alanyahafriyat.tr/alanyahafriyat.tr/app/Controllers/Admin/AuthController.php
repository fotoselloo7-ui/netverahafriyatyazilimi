<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Csrf;
use App\Core\Session;
use App\Services\NotificationService;

class AuthController extends Controller
{
    public function showLogin(): void
    {
        if (Auth::check()) {
            $this->redirect('yonetim');
            return;
        }
        $this->view('admin/auth/login', [
            'seo' => ['title' => 'Yönetim Girişi | ' . site_name(), 'robots' => false],
            'error' => Session::flash('login_err'),
        ], null);
    }

    public function login(): void
    {
        Csrf::check();
        $email = trim((string) ($_POST['email'] ?? ''));
        $password = (string) ($_POST['password'] ?? '');

        if (Auth::attempt($email, $password)) {
            $user = Auth::user();
            NotificationService::dispatch('admin_login', 'Admin paneline giriş yapıldı. Kullanıcı: ' . ($user['name'] ?? '') . ' - Tarih: ' . date('d.m.Y H:i'));
            $intended = Session::flash('intended') ?: base_url('yonetim');
            $this->redirect($intended);
            return;
        }
        Session::flash('login_err', 'E-posta veya şifre hatalı.');
        $this->redirect('yonetim/giris');
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('yonetim/giris');
    }
}
