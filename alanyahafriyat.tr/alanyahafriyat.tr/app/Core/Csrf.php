<?php

declare(strict_types=1);

namespace App\Core;

class Csrf
{
    public static function token(): string
    {
        if (!Session::has('_csrf')) {
            Session::set('_csrf', bin2hex(random_bytes(32)));
        }
        return Session::get('_csrf');
    }

    public static function field(): string
    {
        $token = htmlspecialchars(static::token(), ENT_QUOTES);
        return '<input type="hidden" name="_csrf" value="' . $token . '">';
    }

    public static function verify(?string $token): bool
    {
        $sessionToken = Session::get('_csrf');
        return is_string($token) && is_string($sessionToken) && hash_equals($sessionToken, $token);
    }

    public static function check(): void
    {
        $token = $_POST['_csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? null);
        if (!static::verify($token)) {
            http_response_code(419);
            die('Oturum süresi doldu ya da geçersiz istek (CSRF).');
        }
    }
}
