<?php

declare(strict_types=1);

namespace App\Services;

use App\Core\Database;

class SettingsService
{
    protected static ?array $settings = null;
    protected static ?array $themeCache = null;

    protected static function load(): array
    {
        if (static::$settings === null) {
            static::$settings = [];
            try {
                foreach (Database::select('SELECT setting_key, setting_value FROM settings') as $row) {
                    static::$settings[$row['setting_key']] = $row['setting_value'];
                }
            } catch (\Throwable $e) {
                static::$settings = [];
            }
        }
        return static::$settings;
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $all = static::load();
        $val = $all[$key] ?? null;
        return ($val === null || $val === '') ? $default : $val;
    }

    public static function set(string $key, mixed $value, string $group = 'general', string $type = 'text'): void
    {
        $exists = Database::selectOne('SELECT id FROM settings WHERE setting_key = ?', [$key]);
        $now = date('Y-m-d H:i:s');
        if ($exists) {
            Database::execute('UPDATE settings SET setting_value = ?, updated_at = ? WHERE setting_key = ?', [$value, $now, $key]);
        } else {
            Database::execute(
                'INSERT INTO settings (setting_key, setting_value, setting_group, input_type, created_at, updated_at) VALUES (?,?,?,?,?,?)',
                [$key, $value, $group, $type, $now, $now]
            );
        }
        static::$settings = null; // önbelleği temizle
    }

    public static function theme(string $key, mixed $default = null): mixed
    {
        if (static::$themeCache === null) {
            static::$themeCache = Database::selectOne('SELECT * FROM theme_settings ORDER BY id ASC LIMIT 1') ?: [];
        }
        $val = static::$themeCache[$key] ?? null;
        return ($val === null || $val === '') ? $default : $val;
    }

    public static function all(): array
    {
        return static::load();
    }

    public static function clearCache(): void
    {
        static::$settings = null;
        static::$themeCache = null;
    }
}
