<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;

class Auth
{
    public static function attempt(string $email, string $password): bool
    {
        $user = User::findByEmail($email);
        if (!$user || $user['status'] !== 'active') {
            return false;
        }
        if (!password_verify($password, $user['password_hash'])) {
            return false;
        }
        Session::regenerate();
        Session::set('user_id', (int) $user['id']);
        Session::set('user_name', $user['name']);
        Session::set('user_role', $user['role']);
        User::touchLogin((int) $user['id']);
        return true;
    }

    public static function check(): bool
    {
        return Session::has('user_id');
    }

    public static function user(): ?array
    {
        if (!static::check()) {
            return null;
        }
        return User::find((int) Session::get('user_id'));
    }

    public static function id(): ?int
    {
        return Session::has('user_id') ? (int) Session::get('user_id') : null;
    }

    public static function logout(): void
    {
        Session::forget('user_id');
        Session::forget('user_name');
        Session::forget('user_role');
        Session::regenerate();
    }

    public static function requireLogin(): void
    {
        if (!static::check()) {
            Session::flash('intended', $_SERVER['REQUEST_URI'] ?? '/yonetim');
            header('Location: ' . base_url('yonetim/giris'));
            exit;
        }
    }
}
