<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * PDO tabanlı veritabanı katmanı. sqlite (varsayılan) ve mysql destekler.
 */
class Database
{
    protected static ?PDO $pdo = null;
    protected static string $driver = 'sqlite';

    public static function boot(): void
    {
        static::connection();
        // İlk çalıştırmada şema + seed
        if (!static::isInstalled()) {
            static::install();
        } else {
            // Kurulu sistemde sonradan eklenen tabloları tamamla (idempotent)
            (new \App\Core\Migrator(static::connection()))->upgrade();
        }
    }

    public static function connection(): PDO
    {
        if (static::$pdo instanceof PDO) {
            return static::$pdo;
        }

        $driver = (string) Config::get('db.connection', 'sqlite');
        static::$driver = $driver;

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            if ($driver === 'mysql') {
                $host = Config::get('db.host');
                $port = Config::get('db.port');
                $db   = Config::get('db.database');
                $dsn  = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";
                static::$pdo = new PDO($dsn, Config::get('db.username'), Config::get('db.password'), $options);
            } else {
                $path = Config::get('db.sqlite_path', 'storage/database.sqlite');
                if (!str_starts_with($path, '/') && !preg_match('/^[A-Za-z]:/', $path)) {
                    $path = BASE_PATH . '/' . ltrim($path, '/');
                }
                if (!is_dir(dirname($path))) {
                    @mkdir(dirname($path), 0775, true);
                }
                static::$pdo = new PDO('sqlite:' . $path, null, null, $options);
                static::$pdo->exec('PRAGMA foreign_keys = ON');
            }
        } catch (PDOException $e) {
            http_response_code(500);
            die('Veritabanı bağlantı hatası: ' . htmlspecialchars($e->getMessage()));
        }

        return static::$pdo;
    }

    public static function driver(): string
    {
        return static::$driver;
    }

    public static function isSqlite(): bool
    {
        return static::$driver === 'sqlite';
    }

    protected static function isInstalled(): bool
    {
        try {
            $pdo = static::connection();
            if (static::isSqlite()) {
                $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='settings'");
            } else {
                $stmt = $pdo->query("SHOW TABLES LIKE 'settings'");
            }
            return (bool) $stmt->fetch();
        } catch (PDOException $e) {
            return false;
        }
    }

    protected static function install(): void
    {
        $migrator = new \App\Core\Migrator(static::connection());
        $migrator->run();
        $seeder = new \App\Core\Seeder(static::connection());
        $seeder->run();
    }

    /* -------- Sorgu yardımcıları -------- */

    public static function query(string $sql, array $params = []): \PDOStatement
    {
        $stmt = static::connection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    public static function select(string $sql, array $params = []): array
    {
        return static::query($sql, $params)->fetchAll();
    }

    public static function selectOne(string $sql, array $params = []): ?array
    {
        $row = static::query($sql, $params)->fetch();
        return $row === false ? null : $row;
    }

    public static function insert(string $sql, array $params = []): int
    {
        static::query($sql, $params);
        return (int) static::connection()->lastInsertId();
    }

    public static function execute(string $sql, array $params = []): int
    {
        return static::query($sql, $params)->rowCount();
    }
}
