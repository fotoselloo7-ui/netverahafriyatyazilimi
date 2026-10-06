<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    protected static array $shared = [];

    public static function share(string $key, mixed $value): void
    {
        static::$shared[$key] = $value;
    }

    public static function render(string $template, array $data = [], ?string $layout = 'layouts/app'): string
    {
        $data = array_merge(static::$shared, $data);
        $content = static::renderPartial($template, $data);

        if ($layout === null) {
            return $content;
        }

        $data['content'] = $content;
        return static::renderPartial($layout, $data);
    }

    public static function renderPartial(string $template, array $data = []): string
    {
        $data = array_merge(static::$shared, $data);
        $file = VIEW_PATH . '/' . $template . '.php';
        if (!is_file($file)) {
            throw new \RuntimeException("Görünüm bulunamadı: {$template}");
        }
        extract($data, EXTR_SKIP);
        ob_start();
        include $file;
        return (string) ob_get_clean();
    }

    public static function display(string $template, array $data = [], ?string $layout = 'layouts/app'): void
    {
        echo static::render($template, $data, $layout);
    }
}
