<?php
/**
 * PHP dahili sunucusu (php -S) için yönlendirici.
 * Var olan statik dosyaları doğrudan servis eder; diğer her şeyi index.php'ye yollar.
 *
 * Çalıştırma:  php -S 127.0.0.1:8020 -t public public/router.php
 */

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$file = __DIR__ . $uri;

// Gerçek bir dosyaysa (css, js, resim, sitemap vs.) built-in server servis etsin
if ($uri !== '/' && is_file($file)) {
    return false;
}

require __DIR__ . '/index.php';
