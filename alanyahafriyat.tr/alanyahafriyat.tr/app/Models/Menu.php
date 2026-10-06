<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Menu extends Model
{
    protected static string $table = 'menus';

    public static function byLocation(string $location): array
    {
        return Database::select(
            'SELECT * FROM menus WHERE menu_location = ? AND is_active = 1 ORDER BY sort_order ASC, id ASC',
            [$location]
        );
    }

    public static function byLocationAll(string $location): array
    {
        return Database::select(
            'SELECT * FROM menus WHERE menu_location = ? ORDER BY sort_order ASC, id ASC',
            [$location]
        );
    }
}
