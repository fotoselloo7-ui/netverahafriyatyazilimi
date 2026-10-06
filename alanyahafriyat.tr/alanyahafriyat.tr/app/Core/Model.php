<?php

declare(strict_types=1);

namespace App\Core;

abstract class Model
{
    protected static string $table = '';

    public static function table(): string
    {
        return static::$table;
    }

    public static function all(string $orderBy = 'id ASC'): array
    {
        return Database::select('SELECT * FROM `' . static::$table . "` ORDER BY $orderBy");
    }

    public static function active(string $orderBy = 'sort_order ASC, id ASC'): array
    {
        return Database::select('SELECT * FROM `' . static::$table . "` WHERE is_active = 1 ORDER BY $orderBy");
    }

    public static function find(int $id): ?array
    {
        return Database::selectOne('SELECT * FROM `' . static::$table . '` WHERE id = ?', [$id]);
    }

    public static function findBy(string $column, mixed $value): ?array
    {
        return Database::selectOne('SELECT * FROM `' . static::$table . "` WHERE `$column` = ?", [$value]);
    }

    public static function findBySlug(string $slug): ?array
    {
        return static::findBy('slug', $slug);
    }

    public static function create(array $data): int
    {
        $data = static::withTimestamps($data, true);
        $columns = array_keys($data);
        $placeholders = implode(', ', array_fill(0, count($columns), '?'));
        $cols = '`' . implode('`, `', $columns) . '`';
        $sql = 'INSERT INTO `' . static::$table . "` ($cols) VALUES ($placeholders)";
        return Database::insert($sql, array_values($data));
    }

    public static function update(int $id, array $data): int
    {
        $data = static::withTimestamps($data, false);
        $sets = implode(', ', array_map(fn ($c) => "`$c` = ?", array_keys($data)));
        $sql = 'UPDATE `' . static::$table . "` SET $sets WHERE id = ?";
        $params = array_values($data);
        $params[] = $id;
        return Database::execute($sql, $params);
    }

    public static function delete(int $id): int
    {
        return Database::execute('DELETE FROM `' . static::$table . '` WHERE id = ?', [$id]);
    }

    public static function count(string $where = '1=1', array $params = []): int
    {
        $row = Database::selectOne('SELECT COUNT(*) AS c FROM `' . static::$table . "` WHERE $where", $params);
        return (int) ($row['c'] ?? 0);
    }

    protected static function withTimestamps(array $data, bool $creating): array
    {
        $now = date('Y-m-d H:i:s');
        $columns = static::columns();
        if ($creating && in_array('created_at', $columns, true) && !isset($data['created_at'])) {
            $data['created_at'] = $now;
        }
        if (in_array('updated_at', $columns, true)) {
            $data['updated_at'] = $now;
        }
        return $data;
    }

    protected static function columns(): array
    {
        static $cache = [];
        $table = static::$table;
        if (isset($cache[$table])) {
            return $cache[$table];
        }
        $cols = [];
        if (Database::isSqlite()) {
            foreach (Database::select("PRAGMA table_info(`$table`)") as $c) {
                $cols[] = $c['name'];
            }
        } else {
            foreach (Database::select("SHOW COLUMNS FROM `$table`") as $c) {
                $cols[] = $c['Field'];
            }
        }
        return $cache[$table] = $cols;
    }
}
