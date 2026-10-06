<?php

declare(strict_types=1);

use App\Controllers\Admin\AdminBlogController;
use App\Controllers\Admin\AdminController;
use App\Controllers\Admin\AdminEquipmentController;
use App\Controllers\Admin\AdminFaqController;
use App\Controllers\Admin\AdminGalleryController;
use App\Controllers\Admin\AdminHomeController;
use App\Controllers\Admin\AdminLeadController;
use App\Controllers\Admin\AdminMediaController;
use App\Controllers\Admin\AdminMenuController;
use App\Controllers\Admin\AdminNotificationController;
use App\Controllers\Admin\AdminPageController;
use App\Controllers\Admin\AdminPopupController;
use App\Controllers\Admin\AdminProjectController;
use App\Controllers\Admin\AdminServiceController;
use App\Controllers\Admin\AdminSettingController;
use App\Controllers\Admin\AdminThemeController;
use App\Controllers\Admin\AuthController;
use App\Controllers\BlogController;
use App\Controllers\ContactController;
use App\Controllers\EquipmentController;
use App\Controllers\EventController;
use App\Controllers\FaqController;
use App\Controllers\GalleryController;
use App\Controllers\HomeController;
use App\Controllers\LeadController;
use App\Controllers\PageController;
use App\Controllers\ProjectController;
use App\Controllers\ServiceController;
use App\Controllers\SitemapController;

/** @var App\Core\Router $router */

// ---------------- Frontend ----------------
$router->get('/', [HomeController::class, 'index']);
$router->get('/hakkimizda', [PageController::class, 'about']);

$router->get('/hizmetler', [ServiceController::class, 'index']);
$router->get('/hizmetler/{slug}', [ServiceController::class, 'show']);

$router->get('/makine-parkuru', [EquipmentController::class, 'index']);
$router->get('/makine-parkuru/{slug}', [EquipmentController::class, 'show']);

$router->get('/projeler', [ProjectController::class, 'index']);
$router->get('/projeler/{slug}', [ProjectController::class, 'show']);

$router->get('/galeri', [GalleryController::class, 'index']);

$router->get('/blog', [BlogController::class, 'index']);
$router->get('/blog/kategori/{slug}', [BlogController::class, 'category']);
$router->get('/blog/{slug}', [BlogController::class, 'show']);

$router->get('/sss', [FaqController::class, 'index']);

$router->get('/iletisim', [ContactController::class, 'index']);
$router->post('/iletisim', [ContactController::class, 'submit']);

// Lead / event
$router->post('/teklif', [LeadController::class, 'store']);
$router->post('/event', [EventController::class, 'store']);

// SEO
$router->get('/sitemap.xml', [SitemapController::class, 'index']);
$router->get('/robots.txt', [SitemapController::class, 'robots']);

// Genel sayfalar (en sona: slug yakalayıcı)
$router->get('/sayfa/{slug}', [PageController::class, 'show']);

// ---------------- Admin ----------------
$router->get('/yonetim/giris', [AuthController::class, 'showLogin']);
$router->post('/yonetim/giris', [AuthController::class, 'login']);
$router->get('/yonetim/cikis', [AuthController::class, 'logout']);

$router->get('/yonetim', [AdminController::class, 'dashboard']);

// Ayarlar
$router->get('/yonetim/ayarlar', [AdminSettingController::class, 'index']);
$router->post('/yonetim/ayarlar', [AdminSettingController::class, 'save']);

// Tema
$router->get('/yonetim/tema', [AdminThemeController::class, 'index']);
$router->post('/yonetim/tema', [AdminThemeController::class, 'save']);
$router->post('/yonetim/tema/palet', [AdminThemeController::class, 'applyPalette']);

// Menü
$router->get('/yonetim/menu', [AdminMenuController::class, 'index']);
$router->post('/yonetim/menu/kaydet', [AdminMenuController::class, 'save']);
$router->post('/yonetim/menu/sil', [AdminMenuController::class, 'destroy']);

// Ana sayfa bölümleri
$router->get('/yonetim/anasayfa', [AdminHomeController::class, 'index']);
$router->get('/yonetim/anasayfa/{id}', [AdminHomeController::class, 'edit']);
$router->post('/yonetim/anasayfa/{id}', [AdminHomeController::class, 'update']);

// Sayfalar
$router->get('/yonetim/sayfalar', [AdminPageController::class, 'index']);
$router->get('/yonetim/sayfalar/yeni', [AdminPageController::class, 'create']);
$router->post('/yonetim/sayfalar/yeni', [AdminPageController::class, 'store']);
$router->get('/yonetim/sayfalar/{id}', [AdminPageController::class, 'edit']);
$router->post('/yonetim/sayfalar/{id}', [AdminPageController::class, 'update']);
$router->post('/yonetim/sayfalar/{id}/sil', [AdminPageController::class, 'destroy']);

// Hizmetler
$router->get('/yonetim/hizmetler', [AdminServiceController::class, 'index']);
$router->get('/yonetim/hizmetler/yeni', [AdminServiceController::class, 'create']);
$router->post('/yonetim/hizmetler/yeni', [AdminServiceController::class, 'store']);
$router->get('/yonetim/hizmetler/{id}', [AdminServiceController::class, 'edit']);
$router->post('/yonetim/hizmetler/{id}', [AdminServiceController::class, 'update']);
$router->post('/yonetim/hizmetler/{id}/sil', [AdminServiceController::class, 'destroy']);

// Makine
$router->get('/yonetim/makine', [AdminEquipmentController::class, 'index']);
$router->get('/yonetim/makine/yeni', [AdminEquipmentController::class, 'create']);
$router->post('/yonetim/makine/yeni', [AdminEquipmentController::class, 'store']);
$router->get('/yonetim/makine/{id}', [AdminEquipmentController::class, 'edit']);
$router->post('/yonetim/makine/{id}', [AdminEquipmentController::class, 'update']);
$router->post('/yonetim/makine/{id}/sil', [AdminEquipmentController::class, 'destroy']);

// Projeler
$router->get('/yonetim/projeler', [AdminProjectController::class, 'index']);
$router->get('/yonetim/projeler/yeni', [AdminProjectController::class, 'create']);
$router->post('/yonetim/projeler/yeni', [AdminProjectController::class, 'store']);
$router->get('/yonetim/projeler/{id}', [AdminProjectController::class, 'edit']);
$router->post('/yonetim/projeler/{id}', [AdminProjectController::class, 'update']);
$router->post('/yonetim/projeler/{id}/sil', [AdminProjectController::class, 'destroy']);

// Galeri
$router->get('/yonetim/galeri', [AdminGalleryController::class, 'index']);
$router->post('/yonetim/galeri/yeni', [AdminGalleryController::class, 'store']);
$router->post('/yonetim/galeri/{id}/sil', [AdminGalleryController::class, 'destroy']);

// Blog
$router->get('/yonetim/blog', [AdminBlogController::class, 'index']);
$router->get('/yonetim/blog/yeni', [AdminBlogController::class, 'create']);
$router->post('/yonetim/blog/yeni', [AdminBlogController::class, 'store']);
$router->get('/yonetim/blog/{id}', [AdminBlogController::class, 'edit']);
$router->post('/yonetim/blog/{id}', [AdminBlogController::class, 'update']);
$router->post('/yonetim/blog/{id}/sil', [AdminBlogController::class, 'destroy']);
$router->post('/yonetim/blog-kategori/kaydet', [AdminBlogController::class, 'saveCategory']);

// SSS
$router->get('/yonetim/sss', [AdminFaqController::class, 'index']);
$router->post('/yonetim/sss/kaydet', [AdminFaqController::class, 'save']);
$router->post('/yonetim/sss/sil', [AdminFaqController::class, 'destroy']);

// Popup
$router->get('/yonetim/popup', [AdminPopupController::class, 'index']);
$router->post('/yonetim/popup/{id}', [AdminPopupController::class, 'update']);

// Leadler
$router->get('/yonetim/teklifler', [AdminLeadController::class, 'index']);
$router->get('/yonetim/teklifler/disa-aktar', [AdminLeadController::class, 'export']);
$router->get('/yonetim/teklifler/{id}', [AdminLeadController::class, 'show']);
$router->post('/yonetim/teklifler/{id}', [AdminLeadController::class, 'update']);

// Bildirim
$router->get('/yonetim/bildirim', [AdminNotificationController::class, 'index']);
$router->post('/yonetim/bildirim', [AdminNotificationController::class, 'save']);

// Sistem Lisansı (DijiKey)
$router->get('/yonetim/lisans', [\App\Controllers\Admin\LicenseController::class, 'index']);
$router->get('/yonetim/lisans/aktif-et', [\App\Controllers\Admin\LicenseController::class, 'activateForm']);
$router->post('/yonetim/lisans/aktif-et', [\App\Controllers\Admin\LicenseController::class, 'doActivate']);
$router->get('/yonetim/lisans/degistir', [\App\Controllers\Admin\LicenseController::class, 'changeForm']);
$router->post('/yonetim/lisans/degistir', [\App\Controllers\Admin\LicenseController::class, 'doActivate']);
$router->get('/yonetim/lisans/dogrula', [\App\Controllers\Admin\LicenseController::class, 'verifyGet']);
$router->post('/yonetim/lisans/dogrula', [\App\Controllers\Admin\LicenseController::class, 'verify']);
$router->get('/yonetim/lisans/sunucu-testi', [\App\Controllers\Admin\LicenseController::class, 'serverTest']);
$router->post('/yonetim/lisans/sunucu-testi', [\App\Controllers\Admin\LicenseController::class, 'serverTest']);

// Çalışma Bölgeleri
$router->get('/yonetim/bolgeler', [\App\Controllers\Admin\AdminRegionController::class, 'index']);
$router->post('/yonetim/bolgeler/kaydet', [\App\Controllers\Admin\AdminRegionController::class, 'save']);
$router->post('/yonetim/bolgeler/sil', [\App\Controllers\Admin\AdminRegionController::class, 'destroy']);

// Müşteri Yorumları
$router->get('/yonetim/yorumlar', [\App\Controllers\Admin\AdminTestimonialController::class, 'index']);
$router->post('/yonetim/yorumlar/kaydet', [\App\Controllers\Admin\AdminTestimonialController::class, 'save']);
$router->post('/yonetim/yorumlar/sil', [\App\Controllers\Admin\AdminTestimonialController::class, 'destroy']);

// Medya
$router->get('/yonetim/medya', [AdminMediaController::class, 'index']);
$router->post('/yonetim/medya/yukle', [AdminMediaController::class, 'upload']);
$router->post('/yonetim/medya/{id}/sil', [AdminMediaController::class, 'destroy']);
