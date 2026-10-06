<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    protected function view(string $template, array $data = [], ?string $layout = 'layouts/app'): void
    {
        View::display($template, $data, $layout);
    }

    protected function redirect(string $path): void
    {
        if (!preg_match('#^https?://#', $path)) {
            $path = base_url($path);
        }
        header('Location: ' . $path);
        exit;
    }

    protected function json(mixed $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    protected function input(string $key, mixed $default = null): mixed
    {
        $value = $_POST[$key] ?? $_GET[$key] ?? $default;
        if (is_string($value)) {
            $value = trim($value);
        }
        return $value;
    }

    protected function abort(int $code): void
    {
        http_response_code($code);
        if ($code === 404) {
            View::display('errors/404', [], 'layouts/app');
        }
        exit;
    }
}
