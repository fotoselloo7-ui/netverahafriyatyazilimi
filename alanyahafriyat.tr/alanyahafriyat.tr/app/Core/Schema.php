<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Basit, taşınabilir şema oluşturucu (sqlite + mysql).
 */
class Blueprint
{
    public array $columns = [];
    public array $indexes = [];

    public function id(string $name = 'id'): void
    {
        $this->columns[] = ['name' => $name, 'type' => 'id'];
    }

    public function string(string $name, int $length = 255): self
    {
        return $this->add($name, "VARCHAR($length)");
    }

    public function text(string $name): self
    {
        return $this->add($name, 'TEXT');
    }

    public function integer(string $name): self
    {
        return $this->add($name, 'INT');
    }

    public function boolean(string $name): self
    {
        return $this->add($name, 'TINYINT');
    }

    public function decimal(string $name, int $p = 8, int $s = 2): self
    {
        return $this->add($name, "DECIMAL($p,$s)");
    }

    public function datetime(string $name): self
    {
        return $this->add($name, 'DATETIME');
    }

    public function timestamps(): void
    {
        $this->add('created_at', 'DATETIME')->nullable();
        $this->add('updated_at', 'DATETIME')->nullable();
    }

    protected function add(string $name, string $type): self
    {
        $this->columns[] = ['name' => $name, 'type' => $type, 'nullable' => false, 'default' => null, 'unique' => false];
        return $this;
    }

    public function nullable(bool $value = true): self
    {
        $this->columns[count($this->columns) - 1]['nullable'] = $value;
        return $this;
    }

    public function default(mixed $value): self
    {
        $this->columns[count($this->columns) - 1]['default'] = $value;
        return $this;
    }

    public function unique(): self
    {
        $this->columns[count($this->columns) - 1]['unique'] = true;
        return $this;
    }

    public function index(string $column): void
    {
        $this->indexes[] = $column;
    }
}

class Schema
{
    protected PDO $pdo;
    protected string $driver;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->driver = $pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }

    public function create(string $table, callable $callback): void
    {
        $bp = new Blueprint();
        $callback($bp);

        $isSqlite = $this->driver === 'sqlite';
        $defs = [];

        foreach ($bp->columns as $col) {
            if ($col['type'] === 'id') {
                $defs[] = $isSqlite
                    ? "`{$col['name']}` INTEGER PRIMARY KEY AUTOINCREMENT"
                    : "`{$col['name']}` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY";
                continue;
            }
            $line = "`{$col['name']}` {$col['type']}";
            $line .= ($col['nullable'] ?? false) ? ' NULL' : ' NOT NULL';
            if (($col['default'] ?? null) !== null) {
                $d = $col['default'];
                if (is_bool($d)) {
                    $d = $d ? 1 : 0;
                }
                $line .= is_numeric($d) ? " DEFAULT $d" : " DEFAULT '" . str_replace("'", "''", (string) $d) . "'";
            }
            if ($col['unique'] ?? false) {
                $line .= ' UNIQUE';
            }
            $defs[] = $line;
        }

        $sql = "CREATE TABLE IF NOT EXISTS `$table` (\n  " . implode(",\n  ", $defs) . "\n)";
        if (!$isSqlite) {
            $sql .= ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci';
        }
        $this->pdo->exec($sql);

        foreach ($bp->indexes as $idx) {
            $idxName = "idx_{$table}_{$idx}";
            $this->pdo->exec("CREATE INDEX IF NOT EXISTS `$idxName` ON `$table` (`$idx`)");
        }
    }

    /** Var olan tabloya kolon yoksa ekler (sqlite + mysql). */
    public function addColumnIfMissing(string $table, string $column, string $type, ?string $default = null): void
    {
        $existing = [];
        if ($this->driver === 'sqlite') {
            foreach ($this->pdo->query("PRAGMA table_info(`$table`)") as $c) {
                $existing[] = $c['name'];
            }
        } else {
            foreach ($this->pdo->query("SHOW COLUMNS FROM `$table`") as $c) {
                $existing[] = $c['Field'];
            }
        }
        if (in_array($column, $existing, true)) {
            return;
        }
        $def = "`$column` $type";
        if ($default !== null) {
            $def .= " DEFAULT '" . str_replace("'", "''", $default) . "'";
        }
        $this->pdo->exec("ALTER TABLE `$table` ADD COLUMN $def");
    }

    public function dropAll(array $tables): void
    {
        if ($this->driver !== 'sqlite') {
            $this->pdo->exec('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($tables as $t) {
            $this->pdo->exec("DROP TABLE IF EXISTS `$t`");
        }
        if ($this->driver !== 'sqlite') {
            $this->pdo->exec('SET FOREIGN_KEY_CHECKS=1');
        }
    }
}
