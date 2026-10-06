<?php

declare(strict_types=1);

use App\Core\Router;
use App\Core\Session;
use App\Core\View;
use App\Models\FooterSetting;
use App\Models\Menu;
use App\Models\SocialLink;
use App\Services\SettingsService;

require dirname(__DIR__) . '/app/bootstrap.php';

Session::start();

// Tüm görünümlerde paylaşılan ortak veriler (header/footer/menüler)
View::share('site_name', site_name());

// Ana navigasyonda yalnızca standart kurumsal sayfaları göster.
// SSS gibi içerik sayfaları silinmez; yalnızca ana menüyü kalabalıklaştırmaz.
$standardHeaderUrls = ['/', '/hakkimizda', '/hizmetler', '/makine-parkuru', '/projeler', '/galeri', '/blog', '/iletisim'];
$headerMenu = array_values(array_filter(
    Menu::byLocation('header'),
    static fn (array $item): bool => in_array((string) ($item['url'] ?? ''), $standardHeaderUrls, true)
));
View::share('headerMenu', $headerMenu);
View::share('footerMenu', Menu::byLocation('footer'));
View::share('mobileBar', Menu::byLocation('mobile_bar'));
View::share('footerSettings', FooterSetting::current());
View::share('socialLinks', SocialLink::active('sort_order ASC'));
View::share('settings', SettingsService::all());
View::share('navServices', \App\Models\Service::active('sort_order ASC')); // mobil menü hizmet accordion'ı

// ---- Sistem lisansı: frontend koruması ----
// Üretim modunda lisans geçerli değilse (grace dahil değil) site ön yüzü
// güvenli bir bilgilendirme ekranına düşer. /yonetim yolları hariçtir ki
// yönetici giriş yapıp lisansı etkinleştirebilsin.
$reqPath = '/' . trim((string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH), '/');
if (!str_starts_with($reqPath, '/yonetim') && \App\Services\License\LicenseService::frontendBlocked()) {
    http_response_code(503);
    header('Retry-After: 3600');
    echo View::renderPartial('errors/license-blocked', [
        'licStatus' => \App\Services\License\LicenseService::getStatus(false),
    ]);
    exit;
}

$router = new Router();
require dirname(__DIR__) . '/routes/web.php';

$router->setNotFound(function () {
    View::display('errors/404', ['pageTitle' => 'Sayfa Bulunamadı'], 'layouts/app');
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
