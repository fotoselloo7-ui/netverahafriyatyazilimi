<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Gallery extends Model
{
    protected static string $table = 'gallery';

    public static function categories(): array
    {
        $rows = Database::select("SELECT DISTINCT category FROM gallery WHERE is_active = 1 AND category IS NOT NULL AND category <> '' ORDER BY category");
        return array_column($rows, 'category');
    }
}
