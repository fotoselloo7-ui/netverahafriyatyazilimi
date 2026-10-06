<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class NotificationSetting extends Model
{
    protected static string $table = 'notification_settings';

    public static function current(): ?array
    {
        return Database::selectOne('SELECT * FROM notification_settings ORDER BY id ASC LIMIT 1');
    }
}
