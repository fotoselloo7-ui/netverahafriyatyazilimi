<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Popup extends Model
{
    protected static string $table = 'popups';

    public static function activeOne(): ?array
    {
        return Database::selectOne('SELECT * FROM popups WHERE is_active = 1 ORDER BY id DESC LIMIT 1');
    }
}
