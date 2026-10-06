<?php
/**
 * database/database.sql üretici (MySQL/MariaDB).
 *
 * Şema tanımlarını (Migrator/Schema) MySQL modunda çalıştırıp CREATE TABLE
 * ifadelerini toplar; seed verisini geçici bir SQLite üzerinde üretip
 * INSERT ifadelerine dönüştürür. Çıktı tek dosya: database/database.sql
 *
 * Çalıştırma:  php database/build_install_sql.php
 */

declare(strict_types=1);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('STORAGE_PATH', BASE_PATH . '/storage');

spl_autoload_register(function (string $class): void {
    if (!str_starts_with($class, 'App\\')) {
        return;
    }
    $file = APP_PATH . '/' . str_replace('\\', '/', substr($class, 4)) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

require APP_PATH . '/Core/helpers.php';

use App\Core\Migrator;
use App\Core\Schema;

/** CREATE ifadelerini yakalayan sahte PDO (mysql sürücüsü gibi davranır). */
class DdlCapturePDO extends PDO
{
    public array $statements = [];
    private PDO $mem;
    public function __construct() { $this->mem = new PDO('sqlite::memory:'); }
    public function getAttribute(int $attribute): mixed { return 'mysql'; }
    public function exec(string $statement): int|false { $this->statements[] = $statement; return 0; }
    // Boş ama geçerli bir PDOStatement döndür (SHOW COLUMNS taklidi → kolon yok)
    public function query(string $q, ?int $m = null, mixed ...$a): PDOStatement|false { return $this->mem->query('SELECT 1 WHERE 0'); }
}

// 1) MySQL DDL topla
$ddlPdo = new DdlCapturePDO();
$ddlMig = new Migrator($ddlPdo);
$ddlMig->run(); // tüm create() + upgrade() çağrılır
$creates = [];
foreach ($ddlPdo->statements as $sql) {
    $sql = trim($sql);
    if (stripos($sql, 'CREATE TABLE') === 0) {
        // ipucu: IF NOT EXISTS zaten var; tekrar kaldırıp DROP ile temiz kurulum yapacağız
        $creates[] = $sql;
    }
}

// tablo adını CREATE'ten çıkar
function table_name(string $create): string
{
    if (preg_match('/CREATE TABLE IF NOT EXISTS `([^`]+)`/i', $create, $m)) {
        return $m[1];
    }
    return '';
}

// 2) Seed verisini geçici SQLite'ta üret
$tmp = STORAGE_PATH . '/_install_seed.sqlite';
@unlink($tmp);
$sqlite = new PDO('sqlite:' . $tmp);
$sqlite->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sqlite->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
$sqlite->exec('PRAGMA foreign_keys=OFF');
(new Migrator($sqlite))->run();
(new \App\Core\Seeder($sqlite))->run();

// MySQL değer kaçışı
function mysql_val($v): string
{
    if ($v === null) {
        return 'NULL';
    }
    if (is_int($v) || is_float($v)) {
        return (string) $v;
    }
    $s = (string) $v;
    $s = str_replace(['\\', "'"], ['\\\\', "\\'"], $s);
    $s = str_replace(["\r\n", "\r", "\n"], ['\\n', '\\n', '\\n'], $s);
    return "'" . $s . "'";
}

// tablo -> kolon sırası
function columns_of(PDO $sqlite, string $table): array
{
    $cols = [];
    foreach ($sqlite->query("PRAGMA table_info(`$table`)") as $c) {
        $cols[] = $c['name'];
    }
    return $cols;
}

$order = Migrator::tableNames(); // FK açısından güvenli sıra

// 3) database.sql yaz
$out = [];
$out[] = "-- =====================================================================";
$out[] = "--  Netvera Hafriyat CMS — Tek Dosya Kurulum (MySQL / MariaDB)";
$out[] = "--  Üretim: " . date('Y-m-d H:i');
$out[] = "--  phpMyAdmin > İçe Aktar ile yükleyin. Boş bir veritabanına import edin.";
$out[] = "-- =====================================================================";
$out[] = "SET NAMES utf8mb4;";
$out[] = "SET FOREIGN_KEY_CHECKS=0;";
$out[] = "SET sql_mode='NO_AUTO_VALUE_ON_ZERO';";
$out[] = "";

// CREATE'leri tablo sırasına göre diz
$createByTable = [];
foreach ($creates as $c) {
    $createByTable[table_name($c)] = $c;
}

foreach ($order as $table) {
    if (!isset($createByTable[$table])) {
        continue;
    }
    $create = $createByTable[$table];
    // temiz kurulum: DROP + IF NOT EXISTS'i kaldır (net CREATE)
    $create = preg_replace('/CREATE TABLE IF NOT EXISTS/i', 'CREATE TABLE', $create);
    $out[] = "-- ----- Tablo: $table -----";
    $out[] = "DROP TABLE IF EXISTS `$table`;";
    $out[] = rtrim($create, ';') . ';';
    $out[] = "";

    // veriler
    $rows = $sqlite->query("SELECT * FROM `$table`")->fetchAll();
    if ($rows) {
        $cols = columns_of($sqlite, $table);
        $colList = '`' . implode('`, `', $cols) . '`';
        foreach (array_chunk($rows, 50) as $chunk) {
            $valuesSql = [];
            foreach ($chunk as $row) {
                $vals = [];
                foreach ($cols as $col) {
                    $vals[] = mysql_val($row[$col] ?? null);
                }
                $valuesSql[] = '(' . implode(', ', $vals) . ')';
            }
            $out[] = "INSERT INTO `$table` ($colList) VALUES";
            $out[] = implode(",\n", $valuesSql) . ';';
        }
        $out[] = "";
    }
}

$out[] = "SET FOREIGN_KEY_CHECKS=1;";
$out[] = "";

file_put_contents(BASE_PATH . '/database/database.sql', implode("\n", $out));
@unlink($tmp);

$tableCount = count(array_filter($order, fn ($t) => isset($createByTable[$t])));
echo "database.sql üretildi. Tablo sayısı: $tableCount\n";
