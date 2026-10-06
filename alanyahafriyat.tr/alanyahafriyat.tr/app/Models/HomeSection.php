<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class HomeSection extends Model
{
    protected static string $table = 'home_sections';

    public static function byKey(string $key): ?array
    {
        return Database::selectOne('SELECT * FROM home_sections WHERE section_key = ?', [$key]);
    }

    public static function map(): array
    {
        $out = [];
        foreach (static::all('sort_order ASC') as $row) {
            $out[$row['section_key']] = $row;
        }
        return $out;
    }
}
