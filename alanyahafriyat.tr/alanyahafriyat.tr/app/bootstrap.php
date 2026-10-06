<?php
/**
 * Ersan Hafriyat - Uygulama önyükleme (bootstrap)
 */

declare(strict_types=1);

define('EH_START', microtime(true));

// Yollar
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
define('CONFIG_PATH', BASE_PATH . '/config');
define('STORAGE_PATH', BASE_PATH . '/storage');
define('PUBLIC_PATH', BASE_PATH . '/public');
define('UPLOAD_PATH', PUBLIC_PATH . '/uploads');
define('VIEW_PATH', APP_PATH . '/Views');

// Basit PSR-4 benzeri autoloader (App\ => app/)
spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $relative = substr($class, strlen($prefix));
    $file = APP_PATH . '/' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($file)) {
        require $file;
    }
});

// Ortam değişkenlerini yükle
App\Core\Env::load(BASE_PATH . '/.env');

// Konfigürasyonu yükle
$config = require CONFIG_PATH . '/app.php';
App\Core\Config::set($config);

// Hata gösterimi
if (App\Core\Config::get('app.debug')) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
    ini_set('display_errors', '0');
}
ini_set('log_errors', '1');
ini_set('error_log', STORAGE_PATH . '/logs/php-error.log');

date_default_timezone_set('Europe/Istanbul');

// Yardımcı fonksiyonlar
require APP_PATH . '/Core/helpers.php';

// Veritabanını hazırla (sqlite için otomatik kurulum)
App\Core\Database::boot();
