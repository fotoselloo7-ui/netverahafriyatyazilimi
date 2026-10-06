-- =====================================================================
--  Ersan Hafriyat CMS — Tek Dosya Kurulum (MySQL / MariaDB)
--  Üretim: 2026-07-02 15:34
--  phpMyAdmin > İçe Aktar ile yükleyin. Boş bir veritabanına import edin.
-- =====================================================================
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;
SET sql_mode='NO_AUTO_VALUE_ON_ZERO';

-- ----- Tablo: users -----
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `role` VARCHAR(30) NOT NULL DEFAULT 'admin',
  `status` VARCHAR(20) NOT NULL DEFAULT 'active',
  `last_login_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `status`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Ersan Yönetici', 'admin@ersanhafriyat.local', '$2y$10$MKC.WLBq5DAvtJP37RNySee3EPx8caf5/K251hZF9GTujTFq6O3yq', 'admin', 'active', NULL, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: settings -----
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `setting_key` VARCHAR(255) NOT NULL UNIQUE,
  `setting_value` TEXT NULL,
  `setting_group` VARCHAR(60) NOT NULL DEFAULT 'general',
  `input_type` VARCHAR(30) NOT NULL DEFAULT 'text',
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `input_type`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Ersan Hafriyat', 'general', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'site_tagline', 'Alanya & Mahmutlar Profesyonel Hafriyat ve Kepçe Hizmetleri', 'general', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'phone', '+90 532 123 45 67', 'contact', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'whatsapp_number', '905321234567', 'contact', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(5, 'email', 'info@ersanhafriyat.com.tr', 'contact', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(6, 'address', 'Mahmutlar Mah. Alanya / ANTALYA', 'contact', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(7, 'working_hours', 'Pzt - Cmt: 08:00 - 18:00', 'contact', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(8, 'top_bar_text', 'Alanya, Mahmutlar ve Çevresi Hizmetinizde!', 'general', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(9, 'map_embed', 'https://www.google.com/maps?q=Mahmutlar+Alanya+Antalya&output=embed', 'contact', 'textarea', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(10, 'seo_title', 'Ersan Hafriyat | Alanya & Mahmutlar Hafriyat ve Kepçe Kiralama', 'seo', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(11, 'seo_description', 'Alanya ve Mahmutlar’da temel kazısı, moloz taşıma, kepçe kiralama, altyapı ve bahçe düzenleme hizmetleri. Hızlı, güvenli ve ekonomik hafriyat çözümleri.', 'seo', 'textarea', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(12, 'seo_keywords', 'alanya hafriyat, mahmutlar kepçe kiralama, temel kazısı, moloz taşıma', 'seo', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(13, 'og_image', '', 'seo', 'image', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(14, 'footer_about', 'Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, moloz taşıma ve çevre düzenleme hizmetleri sunuyoruz.', 'general', 'textarea', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(15, 'logo', '', 'general', 'image', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(16, 'about_counter_experience', '10+', 'about', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(17, 'about_counter_projects', '1000+', 'about', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(18, 'about_counter_staff', '15+', 'about', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(19, 'about_counter_support', '7/24', 'about', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(20, 'floating_whatsapp_enabled', '0', 'general', 'toggle', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(21, 'web_design_credit_text', 'Netvera Teknoloji Yazılım', 'footer', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(22, 'web_design_credit_url', '', 'footer', 'text', '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: theme_settings -----
DROP TABLE IF EXISTS `theme_settings`;
CREATE TABLE `theme_settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `primary_color` VARCHAR(20) NOT NULL DEFAULT '#F5A400',
  `primary_hover_color` VARCHAR(20) NOT NULL DEFAULT '#D98A00',
  `primary_text_color` VARCHAR(20) NOT NULL DEFAULT '#111827',
  `secondary_color` VARCHAR(20) NOT NULL DEFAULT '#111827',
  `secondary_text_color` VARCHAR(20) NOT NULL DEFAULT '#FFFFFF',
  `dark_color` VARCHAR(20) NOT NULL DEFAULT '#080B0F',
  `accent_color` VARCHAR(20) NOT NULL DEFAULT '#FFB703',
  `background_color` VARCHAR(20) NOT NULL DEFAULT '#F7F4EF',
  `surface_color` VARCHAR(20) NOT NULL DEFAULT '#FFFFFF',
  `text_color` VARCHAR(20) NOT NULL DEFAULT '#111827',
  `muted_text_color` VARCHAR(20) NOT NULL DEFAULT '#64748B',
  `border_color` VARCHAR(20) NOT NULL DEFAULT '#E5E7EB',
  `button_primary_bg` VARCHAR(20) NOT NULL DEFAULT '#F5A400',
  `button_primary_text` VARCHAR(20) NOT NULL DEFAULT '#111827',
  `button_dark_bg` VARCHAR(20) NOT NULL DEFAULT '#080B0F',
  `button_dark_text` VARCHAR(20) NOT NULL DEFAULT '#FFFFFF',
  `whatsapp_color` VARCHAR(20) NOT NULL DEFAULT '#25D366',
  `border_radius` VARCHAR(20) NOT NULL DEFAULT '10px',
  `card_radius` VARCHAR(20) NOT NULL DEFAULT '14px',
  `shadow_strength` VARCHAR(20) NOT NULL DEFAULT 0.10,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `theme_settings` (`id`, `primary_color`, `primary_hover_color`, `primary_text_color`, `secondary_color`, `secondary_text_color`, `dark_color`, `accent_color`, `background_color`, `surface_color`, `text_color`, `muted_text_color`, `border_color`, `button_primary_bg`, `button_primary_text`, `button_dark_bg`, `button_dark_text`, `whatsapp_color`, `border_radius`, `card_radius`, `shadow_strength`, `created_at`, `updated_at`) VALUES
(1, '#F5A400', '#D98A00', '#111827', '#111827', '#FFFFFF', '#080B0F', '#FFB703', '#F7F4EF', '#FFFFFF', '#111827', '#64748B', '#E5E7EB', '#F5A400', '#111827', '#080B0F', '#FFFFFF', '#25D366', '10px', '14px', '0.10', '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: menus -----
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `menu_location` VARCHAR(40) NOT NULL DEFAULT 'header',
  `title` VARCHAR(255) NOT NULL,
  `url` VARCHAR(255) NULL,
  `page_id` INT NULL,
  `menu_type` VARCHAR(30) NOT NULL DEFAULT 'internal',
  `icon` VARCHAR(60) NULL,
  `target` VARCHAR(20) NOT NULL DEFAULT '_self',
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `menus` (`id`, `menu_location`, `title`, `url`, `page_id`, `menu_type`, `icon`, `target`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'header', 'Ana Sayfa', '/', NULL, 'internal', NULL, '_self', 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'header', 'Hakkımızda', '/hakkimizda', NULL, 'internal', NULL, '_self', 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'header', 'Hizmetlerimiz', '/hizmetler', NULL, 'internal', NULL, '_self', 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'header', 'Makine Parkuru', '/makine-parkuru', NULL, 'internal', NULL, '_self', 3, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(5, 'header', 'Projelerimiz', '/projeler', NULL, 'internal', NULL, '_self', 4, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(6, 'header', 'Galeri', '/galeri', NULL, 'internal', NULL, '_self', 5, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(7, 'header', 'Blog', '/blog', NULL, 'internal', NULL, '_self', 6, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(8, 'header', 'SSS', '/sss', NULL, 'internal', NULL, '_self', 7, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(9, 'header', 'İletişim', '/iletisim', NULL, 'internal', NULL, '_self', 8, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(10, 'footer', 'Ana Sayfa', '/', NULL, 'internal', NULL, '_self', 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(11, 'footer', 'Hakkımızda', '/hakkimizda', NULL, 'internal', NULL, '_self', 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(12, 'footer', 'Makine Parkuru', '/makine-parkuru', NULL, 'internal', NULL, '_self', 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(13, 'footer', 'Projelerimiz', '/projeler', NULL, 'internal', NULL, '_self', 3, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(14, 'footer', 'Galeri', '/galeri', NULL, 'internal', NULL, '_self', 4, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(15, 'footer', 'Blog', '/blog', NULL, 'internal', NULL, '_self', 5, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(16, 'mobile_bar', 'Ara', '', NULL, 'phone', 'phone', '_self', 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(17, 'mobile_bar', 'WhatsApp', 'Merhaba, teklif almak istiyorum.', NULL, 'whatsapp', 'whatsapp', '_self', 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(18, 'mobile_bar', 'Konum', '/iletisim', NULL, 'external', 'map-pin', '_self', 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(19, 'mobile_bar', 'Teklif Al', '/iletisim', NULL, 'internal', 'send', '_self', 3, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: pages -----
DROP TABLE IF EXISTS `pages`;
CREATE TABLE `pages` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `excerpt` TEXT NULL,
  `content` TEXT NULL,
  `hero_title` VARCHAR(255) NULL,
  `hero_subtitle` VARCHAR(255) NULL,
  `hero_image` VARCHAR(255) NULL,
  `hero_overlay_opacity` VARCHAR(10) NOT NULL DEFAULT 0.55,
  `hero_button_1_text` VARCHAR(255) NULL,
  `hero_button_1_url` VARCHAR(255) NULL,
  `hero_button_1_type` VARCHAR(20) NOT NULL DEFAULT 'internal',
  `hero_button_2_text` VARCHAR(255) NULL,
  `hero_button_2_url` VARCHAR(255) NULL,
  `hero_button_2_type` VARCHAR(20) NOT NULL DEFAULT 'internal',
  `cover_image` VARCHAR(255) NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `canonical_url` VARCHAR(255) NULL,
  `og_image` VARCHAR(255) NULL,
  `robots_index` TINYINT NOT NULL DEFAULT 1,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `pages` (`id`, `title`, `slug`, `excerpt`, `content`, `hero_title`, `hero_subtitle`, `hero_image`, `hero_overlay_opacity`, `hero_button_1_text`, `hero_button_1_url`, `hero_button_1_type`, `hero_button_2_text`, `hero_button_2_url`, `hero_button_2_type`, `cover_image`, `seo_title`, `seo_description`, `canonical_url`, `og_image`, `robots_index`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hakkımızda', 'hakkimizda', 'Ersan Hafriyat olarak Alanya ve Mahmutlar’da profesyonel hafriyat çözümleri sunuyoruz.', '<p>Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, temel kazısı, moloz taşıma, altyapı ve çevre düzenleme hizmetleri sunuyoruz. Modern makine parkurumuz ve deneyimli ekibimizle projelerinizi güvenle gerçekleştiriyoruz.</p><p>İş güvenliği ve müşteri memnuniyetini ön planda tutarak, her ölçekteki işinizde hızlı, kaliteli ve ekonomik çözümler üretiyoruz.</p>', 'Hakkımızda', 'Alanya ve Mahmutlar’da güvenilir hafriyat çözüm ortağınız', NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Hakkımızda | Ersan Hafriyat', 'Ersan Hafriyat; Alanya ve Mahmutlar’da deneyimli ekip ve modern makine parkuru ile hafriyat, kepçe kiralama ve çevre düzenleme hizmetleri sunar.', NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'Gizlilik Politikası', 'gizlilik-politikasi', NULL, '<p>Kişisel verilerinizin güvenliği bizim için önemlidir. Bu sayfa içeriği yönetim panelinden düzenlenebilir.</p>', 'Gizlilik Politikası', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Gizlilik Politikası | Ersan Hafriyat', NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'KVKK Aydınlatma Metni', 'kvkk', NULL, '<p>6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında aydınlatma metni. İçerik yönetim panelinden düzenlenebilir.</p>', 'KVKK Aydınlatma Metni', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'KVKK Aydınlatma Metni | Ersan Hafriyat', NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'Çerez Politikası', 'cerez-politikasi', NULL, '<p>Web sitemizde deneyiminizi iyileştirmek için çerezler kullanılmaktadır. İçerik yönetim panelinden düzenlenebilir.</p>', 'Çerez Politikası', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Çerez Politikası | Ersan Hafriyat', NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: home_sections -----
DROP TABLE IF EXISTS `home_sections`;
CREATE TABLE `home_sections` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `section_key` VARCHAR(255) NOT NULL UNIQUE,
  `title` VARCHAR(255) NULL,
  `subtitle` VARCHAR(255) NULL,
  `content_json` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `cta_text` VARCHAR(255) NULL,
  `cta_url` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `home_sections` (`id`, `section_key`, `title`, `subtitle`, `content_json`, `image`, `cta_text`, `cta_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hero', 'Alanya ve Mahmutlar’da Profesyonel Hafriyat & Kepçe Hizmetleri', 'Temel kazısı, moloz taşıma, bahçe düzenleme, kanal açma ve kepçe kiralama hizmetlerimizle projelerinizi güvenli, hızlı ve ekonomik şekilde tamamlıyoruz.', '{"button_1_text":"WhatsApp’tan Teklif Al","button_1_url":"Merhaba, hafriyat\\/kepçe hizmeti için teklif almak istiyorum.","button_1_type":"whatsapp","button_2_text":"Hizmetleri İncele","button_2_url":"\\/hizmetler","button_2_type":"internal","overlay_opacity":"0.55","show_form":"1","show_badges":"1","badges":[{"icon":"zap","title":"Hızlı Dönüş","text":"Talebinize anında çözüm sunuyoruz."},{"icon":"users","title":"Deneyimli Ekip","text":"Alanında uzman ve tecrübeli kadro."},{"icon":"truck","title":"Modern Makine","text":"Güçlü ve bakımlı makine parkuru."},{"icon":"shield","title":"Özenli Çalışma","text":"İş güvenliği ve kaliteli önceliğimiz."},{"icon":"tag","title":"Uygun Fiyat","text":"Kaliteli hizmeti uygun fiyatlarla."}]}', '', NULL, NULL, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'services', 'Hizmetlerimiz', 'Alanya ve Mahmutlar genelinde sunduğumuz profesyonel hafriyat hizmetleri', NULL, '', NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'equipment', 'Makine Parkurumuz', 'Güçlü, bakımlı ve modern iş makinelerimizle tüm hafriyat işlerinizi güvenle üstleniyoruz.', NULL, '', NULL, NULL, 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'process', 'Çalışma Sürecimiz', 'Talepten teslime kadar şeffaf ve planlı bir süreç', '[{"icon":"message-circle","title":"Talep Alınır","text":"İhtiyacınızı WhatsApp veya telefon ile bize iletirsiniz."},{"icon":"search","title":"Keşif & Planlama","text":"Uzman ekibimiz keşif yapar ve planlama oluşturur."},{"icon":"clipboard","title":"Makine Planı","text":"Uygun makine ve ekip planlaması yapılır."},{"icon":"hard-hat","title":"Saha Uygulama","text":"İş güvenliği ile hızlı ve düzenli şekilde uygulanır."},{"icon":"check-circle","title":"Teslim & Kontrol","text":"İş teslim edilir, kontrol edilir ve onayınız alınır."}]', '', NULL, NULL, 3, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(5, 'machine_anim', 'Sahada Güç, İşte Verim', 'Kepçe, kamyon ve deneyimli ekibimizle hafriyat işleriniz planlı, hızlı ve güvenli şekilde ilerler.', NULL, '', NULL, NULL, 4, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(6, 'gallery', 'Çalışmalarımızdan Kareler', 'Sahadaki işlerimizden bazı görüntüler', NULL, '', NULL, NULL, 5, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(7, 'regions', 'Çalışma Bölgelerimiz', 'Hizmet verdiğimiz bölgeler', NULL, '', NULL, NULL, 6, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(8, 'blog', 'Son Yazılarımız', 'Hafriyat ve kepçe kiralama hakkında faydalı içerikler', NULL, '', NULL, NULL, 7, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(9, 'faq', 'Sık Sorulan Sorular', 'Merak edilenler', NULL, '', NULL, NULL, 8, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(10, 'final_cta', 'Hafriyat, Kepçe Kiralama ve Daha Fazlası İçin Yanınızdayız!', 'Hemen bize ulaşın, ücretsiz keşif ve en uygun fiyat teklifini alın.', NULL, '', NULL, NULL, 9, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: services -----
DROP TABLE IF EXISTS `services`;
CREATE TABLE `services` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `short_description` TEXT NULL,
  `content` TEXT NULL,
  `icon` VARCHAR(60) NULL,
  `card_image` VARCHAR(255) NULL,
  `cover_image` VARCHAR(255) NULL,
  `hero_title` VARCHAR(255) NULL,
  `hero_subtitle` VARCHAR(255) NULL,
  `hero_image` VARCHAR(255) NULL,
  `advantages_json` TEXT NULL,
  `usage_areas_json` TEXT NULL,
  `process_json` TEXT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `og_image` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_featured` TINYINT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `services` (`id`, `title`, `slug`, `short_description`, `content`, `icon`, `card_image`, `cover_image`, `hero_title`, `hero_subtitle`, `hero_image`, `advantages_json`, `usage_areas_json`, `process_json`, `seo_title`, `seo_description`, `og_image`, `sort_order`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Alanya Hafriyat Hizmeti', 'alanya-hafriyat-hizmeti', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.', '<p>Alanya Hafriyat Hizmeti hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'excavator', NULL, NULL, 'Alanya Hafriyat Hizmeti', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Alanya Hafriyat Hizmeti | Ersan Hafriyat', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.', NULL, 0, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'Kepçe Kiralama', 'kepce-kiralama', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.', '<p>Kepçe Kiralama hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'truck', NULL, NULL, 'Kepçe Kiralama', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Kepçe Kiralama | Ersan Hafriyat', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.', NULL, 1, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'Mini Kepçe Kiralama', 'mini-kepce-kiralama', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.', '<p>Mini Kepçe Kiralama hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'truck', NULL, NULL, 'Mini Kepçe Kiralama', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Mini Kepçe Kiralama | Ersan Hafriyat', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.', NULL, 2, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'Temel Kazısı', 'temel-kazisi', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.', '<p>Temel Kazısı hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'layers', NULL, NULL, 'Temel Kazısı', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Temel Kazısı | Ersan Hafriyat', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.', NULL, 3, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(5, 'Moloz ve Hafriyat Nakliye', 'moloz-hafriyat-nakliye', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.', '<p>Moloz ve Hafriyat Nakliye hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'truck', NULL, NULL, 'Moloz ve Hafriyat Nakliye', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Moloz ve Hafriyat Nakliye | Ersan Hafriyat', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.', NULL, 4, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(6, 'Alt Yapı ve Kanal Açma', 'alt-yapi-kanal-acma', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.', '<p>Alt Yapı ve Kanal Açma hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'git-branch', NULL, NULL, 'Alt Yapı ve Kanal Açma', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Alt Yapı ve Kanal Açma | Ersan Hafriyat', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.', NULL, 5, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(7, 'Çevre ve Bahçe Düzenleme', 'cevre-bahce-duzenleme', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.', '<p>Çevre ve Bahçe Düzenleme hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'trees', NULL, NULL, 'Çevre ve Bahçe Düzenleme', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Çevre ve Bahçe Düzenleme | Ersan Hafriyat', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.', NULL, 6, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(8, 'Arsa Tesviye ve Dolgu', 'arsa-tesviye-dolgu', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.', '<p>Arsa Tesviye ve Dolgu hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'mountain', NULL, NULL, 'Arsa Tesviye ve Dolgu', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Arsa Tesviye ve Dolgu | Ersan Hafriyat', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.', NULL, 7, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(9, 'Drenaj ve Özel Kazı İşleri', 'drenaj-ozel-kazi', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.', '<p>Drenaj ve Özel Kazı İşleri hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'droplet', NULL, NULL, 'Drenaj ve Özel Kazı İşleri', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.', NULL, '["Deneyimli ve uzman ekip","Modern ve bakımlı makine parkuru","Zamanında ve güvenli çalışma","Uygun fiyat politikası","Yerinde ücretsiz keşif"]', '["Konut ve villa projeleri","Ticari yapılar","Arsa ve bahçe alanları","Altyapı çalışmaları"]', '[{"title":"Talep & Keşif","text":"İhtiyacınızı değerlendirir, yerinde keşif yaparız."},{"title":"Planlama","text":"Uygun makine ve ekip planlaması yaparız."},{"title":"Uygulama","text":"İş güvenliği kurallarıyla hızlıca uygularız."},{"title":"Teslim","text":"İşi teslim eder, memnuniyetinizi alırız."}]', 'Drenaj ve Özel Kazı İşleri | Ersan Hafriyat', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.', NULL, 8, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- ----- Tablo: service_faqs -----
DROP TABLE IF EXISTS `service_faqs`;
CREATE TABLE `service_faqs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `service_id` INT NOT NULL,
  `question` VARCHAR(255) NOT NULL,
  `answer` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: equipment -----
DROP TABLE IF EXISTS `equipment`;
CREATE TABLE `equipment` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `brand_model` VARCHAR(255) NULL,
  `usage_area` VARCHAR(255) NULL,
  `attachments` VARCHAR(255) NULL,
  `short_description` TEXT NULL,
  `content` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `gallery_json` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `equipment` (`id`, `title`, `slug`, `brand_model`, `usage_area`, `attachments`, `short_description`, `content`, `image`, `gallery_json`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hidromek 102B', 'hidromek-102b', 'Hidromek 102B', 'Kazıcı Yükleyici', 'Kova, kırıcı, ripper', 'Ağırlık: 20 Ton • Kova Kapasitesi: 1.1 m³ • Güçlü ve Yakıt Tasarruflu', '<p>Hidromek 102B makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'JCB 3CX', 'jcb-3cx', 'JCB 3CX', 'Beko Loder', 'Kova, kırıcı, ripper', 'Yükleyici & Kazıcı • Çok Amaçlı Kullanım • Yüksek Performans', '<p>JCB 3CX makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'Mini Ekskavatör', 'mini-ekskavator', 'Mini Ekskavatör', 'Mini Kepçe', 'Kova, kırıcı, ripper', 'Ağırlık: 3.5 Ton • Dar Alanlarda Yüksek Manevra • Hassas Çalışma', '<p>Mini Ekskavatör makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'Kamyon / Damper', 'kamyon-damper', 'Kamyon / Damper', 'Nakliye', 'Kova, kırıcı, ripper', '6x4 Damper Kamyon • Moloz ve Hafriyat Taşıma • Yüksek Taşıma Kapasitesi', '<p>Kamyon / Damper makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 3, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: projects -----
DROP TABLE IF EXISTS `projects`;
CREATE TABLE `projects` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `region` VARCHAR(255) NULL,
  `service_type` VARCHAR(255) NULL,
  `short_description` TEXT NULL,
  `content` TEXT NULL,
  `cover_image` VARCHAR(255) NULL,
  `before_image` VARCHAR(255) NULL,
  `after_image` VARCHAR(255) NULL,
  `gallery_json` TEXT NULL,
  `project_date` VARCHAR(30) NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `projects` (`id`, `title`, `slug`, `region`, `service_type`, `short_description`, `content`, `cover_image`, `before_image`, `after_image`, `gallery_json`, `project_date`, `seo_title`, `seo_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mahmutlar Temel Kazısı', 'mahmutlar-temel-kazisi', 'Mahmutlar', 'Temel Kazısı', 'Mahmutlar bölgesinde gerçekleştirdiğimiz Temel Kazısı çalışması.', '<p>Mahmutlar bölgesinde tamamladığımız Temel Kazısı projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Mahmutlar Temel Kazısı | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Kestel Arsa Tesviye', 'kestel-arsa-tesviye', 'Kestel', 'Arsa Tesviye', 'Kestel bölgesinde gerçekleştirdiğimiz Arsa Tesviye çalışması.', '<p>Kestel bölgesinde tamamladığımız Arsa Tesviye projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Kestel Arsa Tesviye | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Oba Kanal Açma', 'oba-kanal-acma', 'Oba', 'Altyapı ve Kanal Açma', 'Oba bölgesinde gerçekleştirdiğimiz Altyapı ve Kanal Açma çalışması.', '<p>Oba bölgesinde tamamladığımız Altyapı ve Kanal Açma projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Oba Kanal Açma | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(4, 'Tosmur Moloz Taşıma', 'tosmur-moloz-tasima', 'Tosmur', 'Moloz Taşıma', 'Tosmur bölgesinde gerçekleştirdiğimiz Moloz Taşıma çalışması.', '<p>Tosmur bölgesinde tamamladığımız Moloz Taşıma projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Tosmur Moloz Taşıma | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(5, 'Kargıcak Bahçe Düzenleme', 'kargicak-bahce-duzenleme', 'Kargıcak', 'Bahçe Düzenleme', 'Kargıcak bölgesinde gerçekleştirdiğimiz Bahçe Düzenleme çalışması.', '<p>Kargıcak bölgesinde tamamladığımız Bahçe Düzenleme projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Kargıcak Bahçe Düzenleme | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(6, 'Avsallar Villa Hafriyatı', 'avsallar-villa-hafriyati', 'Avsallar', 'Hafriyat', 'Avsallar bölgesinde gerçekleştirdiğimiz Hafriyat çalışması.', '<p>Avsallar bölgesinde tamamladığımız Hafriyat projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Avsallar Villa Hafriyatı | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: gallery -----
DROP TABLE IF EXISTS `gallery`;
CREATE TABLE `gallery` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NULL,
  `image` VARCHAR(255) NULL,
  `video_url` VARCHAR(255) NULL,
  `category` VARCHAR(80) NULL,
  `alt_text` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `gallery` (`id`, `title`, `image`, `video_url`, `category`, `alt_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mahmutlar - Temel Kazısı', NULL, NULL, 'Temel Kazısı', 'Mahmutlar - Temel Kazısı', 0, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Kestel - Arsa Tesviye', NULL, NULL, 'Arsa Tesviye', 'Kestel - Arsa Tesviye', 1, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Oba - Kanal Açma', NULL, NULL, 'Altyapı', 'Oba - Kanal Açma', 2, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(4, 'Tosmur - Moloz Taşıma', NULL, NULL, 'Moloz Taşıma', 'Tosmur - Moloz Taşıma', 3, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(5, 'Kargıcak - Bahçe Düzenleme', NULL, NULL, 'Bahçe Düzenleme', 'Kargıcak - Bahçe Düzenleme', 4, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(6, 'Avsallar - Villa Hafriyatı', NULL, NULL, 'Hafriyat', 'Avsallar - Villa Hafriyatı', 5, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: blog_categories -----
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE `blog_categories` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `description` TEXT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_categories` (`id`, `title`, `slug`, `description`, `seo_title`, `seo_description`, `sort_order`, `is_active`) VALUES
(1, 'Hafriyat', 'hafriyat', 'Hafriyat kategorisindeki yazılar.', NULL, NULL, 0, 1),
(2, 'Kepçe Kiralama', 'kepce-kiralama', 'Kepçe Kiralama kategorisindeki yazılar.', NULL, NULL, 1, 1),
(3, 'Rehber', 'rehber', 'Rehber kategorisindeki yazılar.', NULL, NULL, 2, 1);

-- ----- Tablo: blog_posts -----
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE `blog_posts` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_id` INT NULL,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `excerpt` TEXT NULL,
  `content_markdown` TEXT NULL,
  `cover_image` VARCHAR(255) NULL,
  `cover_image_alt` VARCHAR(255) NULL,
  `cover_image_title` VARCHAR(255) NULL,
  `author_name` VARCHAR(255) NULL,
  `focus_keyword` VARCHAR(255) NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `canonical_url` VARCHAR(255) NULL,
  `og_title` VARCHAR(255) NULL,
  `og_description` TEXT NULL,
  `og_image` VARCHAR(255) NULL,
  `twitter_title` VARCHAR(255) NULL,
  `twitter_description` TEXT NULL,
  `twitter_image` VARCHAR(255) NULL,
  `robots_index` TINYINT NOT NULL DEFAULT 1,
  `robots_follow` TINYINT NOT NULL DEFAULT 1,
  `schema_type` VARCHAR(30) NOT NULL DEFAULT 'BlogPosting',
  `related_service_id` INT NULL,
  `related_posts_json` TEXT NULL,
  `faq_json` TEXT NULL,
  `seo_score` INT NOT NULL DEFAULT 0,
  `seo_suggestions_json` TEXT NULL,
  `reading_time` INT NOT NULL DEFAULT 1,
  `status` VARCHAR(20) NOT NULL DEFAULT 'draft',
  `published_at` DATETIME NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `excerpt`, `content_markdown`, `cover_image`, `cover_image_alt`, `cover_image_title`, `author_name`, `focus_keyword`, `seo_title`, `seo_description`, `canonical_url`, `og_title`, `og_description`, `og_image`, `twitter_title`, `twitter_description`, `twitter_image`, `robots_index`, `robots_follow`, `schema_type`, `related_service_id`, `related_posts_json`, `faq_json`, `seo_score`, `seo_suggestions_json`, `reading_time`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Alanya’da Kepçe Kiralama Hangi İşlerde Kullanılır?', 'alanyada-kepce-kiralama-hangi-islerde-kullanilir', '## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan a…', '## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan altyapı çalışmalarına kadar geniş bir kullanım alanı vardır.\n\n### Başlıca Kullanım Alanları\n\n- Temel kazısı ve hafriyat\n- Bahçe ve arsa düzenleme\n- Kanal ve altyapı açma\n- Moloz yükleme ve taşıma\n\n### Neden Kepçe Kiralamalı?\n\nİş makinesi satın almak yerine, ihtiyaç duyduğunuz süre boyunca operatörlü kepçe kiralamak çok daha ekonomiktir. Ersan Hafriyat olarak günlük, haftalık ve aylık kiralama seçenekleri sunuyoruz.', NULL, NULL, NULL, 'Ersan Hafriyat', NULL, 'Alanya’da Kepçe Kiralama Hangi İşlerde Kullanılır? | Ersan Hafriyat', '## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan altyap…', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'BlogPosting', NULL, NULL, NULL, 0, NULL, 1, 'published', '2026-07-02 15:34:08', '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 1, 'Hafriyat ve Moloz Taşıma Sürecinde Nelere Dikkat Edilmeli?', 'hafriyat-ve-moloz-tasima-surecinde-nelere-dikkat-edilmeli', '## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken ön…', '## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken önemli noktalar vardır.\n\n### Dikkat Edilmesi Gerekenler\n\n1. **İş güvenliği:** Saha güvenliği önceliklidir.\n2. **Ruhsat ve izinler:** Gerekli belgeler eksiksiz olmalıdır.\n3. **Doğru makine seçimi:** İşin ölçeğine uygun ekipman kullanılmalıdır.\n4. **Çevre duyarlılığı:** Molozlar uygun döküm sahalarına taşınmalıdır.\n\nErsan Hafriyat, tüm bu süreçleri profesyonelce yönetir.', NULL, NULL, NULL, 'Ersan Hafriyat', NULL, 'Hafriyat ve Moloz Taşıma Sürecinde Nelere Dikkat Edilmeli? | Ersan Hafriyat', '## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken önemli …', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'BlogPosting', NULL, NULL, NULL, 0, NULL, 1, 'published', '2026-06-29 15:34:08', '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 1, 'Mahmutlar’da Bahçe, Arsa ve Temel Kazısı İçin Profesyonel Çözüm', 'mahmutlarda-bahce-arsa-ve-temel-kazisi', '## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizme…', '## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizmet veriyoruz.\n\n### Hizmetlerimiz\n\n- Temel kazısı\n- Arsa tesviye ve dolgu\n- Bahçe düzenleme\n- Çevre temizliği\n\nModern makine parkurumuz ve uzman kadromuzla projelerinizi güvenle tamamlıyoruz. Ücretsiz keşif için bizimle iletişime geçin.', NULL, NULL, NULL, 'Ersan Hafriyat', NULL, 'Mahmutlar’da Bahçe, Arsa ve Temel Kazısı İçin Profesyonel Çözüm | Ersan Hafriyat', '## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizmet ver…', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'BlogPosting', NULL, NULL, NULL, 0, NULL, 1, 'published', '2026-06-26 15:34:08', '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: faqs -----
DROP TABLE IF EXISTS `faqs`;
CREATE TABLE `faqs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `question` VARCHAR(255) NOT NULL,
  `answer` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES
(1, 'Kepçe kiralama fiyatları nasıl belirlenir?', 'Kepçe kiralama fiyatları; işin süresi, makine tipi, çalışma bölgesi ve işin kapsamına göre belirlenir. Ücretsiz keşif sonrası net fiyat sunarız.', 0, 1),
(2, 'Hafriyat ve moloz taşıma hizmetiniz var mı?', 'Evet, Alanya ve çevresinde hafriyat ve moloz taşıma hizmeti sunuyoruz. Damperli kamyonlarımızla molozları uygun döküm sahalarına taşıyoruz.', 1, 1),
(3, 'Hizmet verdiğiniz bölgeler nerelerdir?', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez, Cikcilli, Çıplaklı, Payallar, Konaklı, Avsallar ve Gazipaşa bölgelerinde hizmet veriyoruz.', 2, 1),
(4, 'Çalışma saatleriniz nedir?', 'Pazartesi - Cumartesi 08:00 - 18:00 saatleri arasında hizmet veriyoruz. Acil işler için bize ulaşabilirsiniz.', 3, 1),
(5, 'Acil işler için hizmet sağlıyor musunuz?', 'Evet, acil hafriyat ve kepçe ihtiyaçlarınız için hızlı çözümler sunuyoruz. WhatsApp veya telefon ile bize ulaşabilirsiniz.', 4, 1);

-- ----- Tablo: testimonials -----
DROP TABLE IF EXISTS `testimonials`;
CREATE TABLE `testimonials` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `company` VARCHAR(255) NULL,
  `location` VARCHAR(255) NULL,
  `comment` TEXT NULL,
  `rating` INT NOT NULL DEFAULT 5,
  `image` VARCHAR(255) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `testimonials` (`id`, `name`, `company`, `location`, `comment`, `rating`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mehmet A.', NULL, 'Mahmutlar', 'Villa temeli için kazı işini çok hızlı ve temiz yaptılar. Kesinlikle tavsiye ederim.', 5, NULL, 0, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Ayşe K.', NULL, 'Kestel', 'Bahçe düzenleme ve arsa tesviyesinde profesyonel bir ekip. Teşekkürler.', 5, NULL, 1, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Hasan Y.', NULL, 'Oba', 'Moloz taşıma işini zamanında ve uygun fiyata hallettiler.', 5, NULL, 2, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: popups -----
DROP TABLE IF EXISTS `popups`;
CREATE TABLE `popups` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `image` VARCHAR(255) NULL,
  `button_text` VARCHAR(255) NULL,
  `button_url` VARCHAR(255) NULL,
  `button_type` VARCHAR(20) NOT NULL DEFAULT 'internal',
  `is_active` TINYINT NOT NULL DEFAULT 0,
  `delay_seconds` INT NOT NULL DEFAULT 3,
  `repeat_after_hours` INT NOT NULL DEFAULT 24,
  `target_pages` VARCHAR(40) NOT NULL DEFAULT 'all',
  `show_on_mobile` TINYINT NOT NULL DEFAULT 1,
  `overlay_opacity` VARCHAR(10) NOT NULL DEFAULT 0.6,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `popups` (`id`, `title`, `description`, `image`, `button_text`, `button_url`, `button_type`, `is_active`, `delay_seconds`, `repeat_after_hours`, `target_pages`, `show_on_mobile`, `overlay_opacity`, `created_at`, `updated_at`) VALUES
(1, 'Ücretsiz Keşif ve Teklif!', 'Hafriyat, kepçe kiralama ve moloz taşıma işleriniz için hemen WhatsApp’tan ücretsiz teklif alın.', NULL, 'WhatsApp’tan Teklif Al', 'Merhaba, ücretsiz keşif ve teklif almak istiyorum.', 'whatsapp', 0, 5, 24, 'home', 1, '0.6', '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: leads -----
DROP TABLE IF EXISTS `leads`;
CREATE TABLE `leads` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(255) NOT NULL,
  `phone` VARCHAR(40) NOT NULL,
  `email` VARCHAR(255) NULL,
  `service_type` VARCHAR(255) NULL,
  `region` VARCHAR(255) NULL,
  `message` TEXT NULL,
  `source` VARCHAR(40) NOT NULL DEFAULT 'website',
  `status` VARCHAR(20) NOT NULL DEFAULT 'new',
  `admin_note` TEXT NULL,
  `ip_hash` VARCHAR(64) NULL,
  `user_agent` VARCHAR(255) NULL,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: media -----
DROP TABLE IF EXISTS `media`;
CREATE TABLE `media` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `file_name` VARCHAR(255) NOT NULL,
  `file_path` VARCHAR(255) NOT NULL,
  `file_type` VARCHAR(60) NULL,
  `alt_text` VARCHAR(255) NULL,
  `title` VARCHAR(255) NULL,
  `uploaded_by` INT NULL,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: footer_settings -----
DROP TABLE IF EXISTS `footer_settings`;
CREATE TABLE `footer_settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `logo` VARCHAR(255) NULL,
  `description` TEXT NULL,
  `copyright_text` VARCHAR(255) NULL,
  `column_1_title` VARCHAR(255) NULL,
  `column_1_links_json` TEXT NULL,
  `column_2_title` VARCHAR(255) NULL,
  `column_2_links_json` TEXT NULL,
  `column_3_title` VARCHAR(255) NULL,
  `column_3_content` TEXT NULL,
  `web_design_credit_text` VARCHAR(255) NULL,
  `web_design_credit_url` VARCHAR(255) NULL,
  `background_color` VARCHAR(20) NOT NULL DEFAULT '#111111',
  `text_color` VARCHAR(20) NOT NULL DEFAULT '#CBD5E1',
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `footer_settings` (`id`, `logo`, `description`, `copyright_text`, `column_1_title`, `column_1_links_json`, `column_2_title`, `column_2_links_json`, `column_3_title`, `column_3_content`, `web_design_credit_text`, `web_design_credit_url`, `background_color`, `text_color`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, moloz taşıma ve çevre düzenleme hizmetleri sunuyoruz.', '© 2026 Ersan Hafriyat. Tüm hakları saklıdır.', 'Hizmetlerimiz', '[{"title":"Alanya Hafriyat Hizmeti","url":"\\/hizmetler\\/alanya-hafriyat-hizmeti"},{"title":"Kepçe Kiralama","url":"\\/hizmetler\\/kepce-kiralama"},{"title":"Temel Kazısı","url":"\\/hizmetler\\/temel-kazisi"},{"title":"Alt Yapı ve Kanal Açma","url":"\\/hizmetler\\/alt-yapi-kanal-acma"},{"title":"Arsa Tesviye","url":"\\/hizmetler\\/arsa-tesviye-dolgu"}]', 'Hızlı Linkler', '[{"title":"Ana Sayfa","url":"\\/"},{"title":"Hakkımızda","url":"\\/hakkimizda"},{"title":"Makine Parkuru","url":"\\/makine-parkuru"},{"title":"Projelerimiz","url":"\\/projeler"},{"title":"Galeri","url":"\\/galeri"},{"title":"Blog","url":"\\/blog"}]', 'Hizmet Bölgeleri', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez ve çevresi', NULL, NULL, '#111111', '#CBD5E1', '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: social_links -----
DROP TABLE IF EXISTS `social_links`;
CREATE TABLE `social_links` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `platform` VARCHAR(60) NOT NULL,
  `url` VARCHAR(255) NOT NULL,
  `icon` VARCHAR(60) NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `social_links` (`id`, `platform`, `url`, `icon`, `sort_order`, `is_active`) VALUES
(1, 'facebook', 'https://facebook.com', 'facebook', 0, 1),
(2, 'instagram', 'https://instagram.com', 'instagram', 1, 1),
(3, 'whatsapp', 'https://wa.me/905321234567', 'whatsapp', 2, 1);

-- ----- Tablo: redirects -----
DROP TABLE IF EXISTS `redirects`;
CREATE TABLE `redirects` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `old_url` VARCHAR(255) NOT NULL,
  `new_url` VARCHAR(255) NOT NULL,
  `status_code` INT NOT NULL DEFAULT 301,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: notification_settings -----
DROP TABLE IF EXISTS `notification_settings`;
CREATE TABLE `notification_settings` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `owner_name` VARCHAR(255) NULL,
  `owner_phone` VARCHAR(40) NULL,
  `owner_email` VARCHAR(255) NULL,
  `whatsapp_api_enabled` TINYINT NOT NULL DEFAULT 0,
  `whatsapp_provider` VARCHAR(40) NULL,
  `whatsapp_api_token` TEXT NULL,
  `whatsapp_phone_number_id` VARCHAR(255) NULL,
  `whatsapp_template_name` VARCHAR(255) NULL,
  `custom_webhook_url` VARCHAR(255) NULL,
  `sms_enabled` TINYINT NOT NULL DEFAULT 0,
  `sms_provider` VARCHAR(40) NULL,
  `sms_api_key` TEXT NULL,
  `email_enabled` TINYINT NOT NULL DEFAULT 0,
  `smtp_host` VARCHAR(255) NULL,
  `smtp_user` VARCHAR(255) NULL,
  `smtp_password` TEXT NULL,
  `smtp_port` VARCHAR(10) NULL,
  `telegram_enabled` TINYINT NOT NULL DEFAULT 0,
  `telegram_bot_token` TEXT NULL,
  `telegram_chat_id` VARCHAR(255) NULL,
  `notify_on_new_lead` TINYINT NOT NULL DEFAULT 1,
  `notify_on_contact_form` TINYINT NOT NULL DEFAULT 1,
  `notify_on_whatsapp_click` TINYINT NOT NULL DEFAULT 0,
  `notify_on_popup_click` TINYINT NOT NULL DEFAULT 0,
  `notify_on_admin_login` TINYINT NOT NULL DEFAULT 0,
  `notify_on_new_visitor` TINYINT NOT NULL DEFAULT 0,
  `visitor_notification_throttle_minutes` INT NOT NULL DEFAULT 30,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `notification_settings` (`id`, `owner_name`, `owner_phone`, `owner_email`, `whatsapp_api_enabled`, `whatsapp_provider`, `whatsapp_api_token`, `whatsapp_phone_number_id`, `whatsapp_template_name`, `custom_webhook_url`, `sms_enabled`, `sms_provider`, `sms_api_key`, `email_enabled`, `smtp_host`, `smtp_user`, `smtp_password`, `smtp_port`, `telegram_enabled`, `telegram_bot_token`, `telegram_chat_id`, `notify_on_new_lead`, `notify_on_contact_form`, `notify_on_whatsapp_click`, `notify_on_popup_click`, `notify_on_admin_login`, `notify_on_new_visitor`, `visitor_notification_throttle_minutes`, `created_at`, `updated_at`) VALUES
(1, 'Ersan Hafriyat', '905321234567', 'info@ersanhafriyat.com.tr', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, 0, 0, 0, 0, 30, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- ----- Tablo: notification_logs -----
DROP TABLE IF EXISTS `notification_logs`;
CREATE TABLE `notification_logs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event_type` VARCHAR(60) NULL,
  `channel` VARCHAR(40) NULL,
  `recipient` VARCHAR(255) NULL,
  `message` TEXT NULL,
  `status` VARCHAR(40) NULL,
  `provider_response` TEXT NULL,
  `related_id` INT NULL,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: site_events -----
DROP TABLE IF EXISTS `site_events`;
CREATE TABLE `site_events` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event_type` VARCHAR(60) NOT NULL,
  `page_url` VARCHAR(255) NULL,
  `source` VARCHAR(255) NULL,
  `ip_hash` VARCHAR(64) NULL,
  `user_agent` VARCHAR(255) NULL,
  `metadata_json` TEXT NULL,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: license_logs -----
DROP TABLE IF EXISTS `license_logs`;
CREATE TABLE `license_logs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `event_type` VARCHAR(40) NOT NULL,
  `status` VARCHAR(40) NULL,
  `message` TEXT NULL,
  `request_url` VARCHAR(255) NULL,
  `response_json` TEXT NULL,
  `created_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----- Tablo: service_regions -----
DROP TABLE IF EXISTS `service_regions`;
CREATE TABLE `service_regions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL UNIQUE,
  `city` VARCHAR(80) NULL,
  `district` VARCHAR(80) NULL,
  `neighborhood` VARCHAR(120) NULL,
  `description` TEXT NULL,
  `seo_title` VARCHAR(255) NULL,
  `seo_description` TEXT NULL,
  `sort_order` INT NOT NULL DEFAULT 0,
  `is_active` TINYINT NOT NULL DEFAULT 1,
  `created_at` DATETIME NULL,
  `updated_at` DATETIME NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `service_regions` (`id`, `title`, `slug`, `city`, `district`, `neighborhood`, `description`, `seo_title`, `seo_description`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mahmutlar', 'mahmutlar', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 0, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Kestel', 'kestel', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Kargıcak', 'kargicak', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 2, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(4, 'Oba', 'oba', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 3, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(5, 'Tosmur', 'tosmur', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 4, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(6, 'Alanya Merkez', 'alanya-merkez', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 5, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(7, 'Cikcilli', 'cikcilli', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 6, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(8, 'Çıplaklı', 'ciplakli', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 7, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(9, 'Payallar', 'payallar', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 8, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(10, 'Konaklı', 'konakli', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 9, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(11, 'Avsallar', 'avsallar', 'Antalya', 'Alanya', NULL, NULL, NULL, NULL, 10, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(12, 'Gazipaşa', 'gazipasa', 'Antalya', 'Gazipaşa', NULL, NULL, NULL, NULL, 11, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

SET FOREIGN_KEY_CHECKS=1;
