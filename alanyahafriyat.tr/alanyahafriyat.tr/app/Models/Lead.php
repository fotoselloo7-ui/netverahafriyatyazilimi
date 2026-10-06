<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use App\Core\Model;

class Lead extends Model
{
    protected static string $table = 'leads';

    public static function paginate(int $page = 1, int $perPage = 20, string $search = '', string $status = ''): array
    {
        $where = '1=1';
        $params = [];
        if ($search !== '') {
            $where .= ' AND (name LIKE ? OR phone LIKE ? OR message LIKE ?)';
            $like = '%' . $search . '%';
            $params = [$like, $like, $like];
        }
        if ($status !== '') {
            $where .= ' AND status = ?';
            $params[] = $status;
        }
        $total = (int) (Database::selectOne("SELECT COUNT(*) c FROM leads WHERE $where", $params)['c'] ?? 0);
        $offset = ($page - 1) * $perPage;
        $rows = Database::select("SELECT * FROM leads WHERE $where ORDER BY id DESC LIMIT $perPage OFFSET $offset", $params);
        return ['rows' => $rows, 'total' => $total, 'page' => $page, 'perPage' => $perPage, 'pages' => (int) ceil($total / $perPage)];
    }
}
