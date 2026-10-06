<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Service extends Model
{
    protected static string $table = 'services';

    public static function featured(int $limit = 6): array
    {
        return Database::select(
            'SELECT * FROM services WHERE is_active = 1 ORDER BY is_featured DESC, sort_order ASC, id ASC LIMIT ' . (int) $limit
        );
    }

    public static function faqs(int $serviceId): array
    {
        return Database::select(
            'SELECT * FROM service_faqs WHERE service_id = ? AND is_active = 1 ORDER BY sort_order ASC',
            [$serviceId]
        );
    }
}
