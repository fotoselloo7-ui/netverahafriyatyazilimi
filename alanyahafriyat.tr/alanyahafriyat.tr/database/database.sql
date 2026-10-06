-- =====================================================================
--  Ersan Hafriyat CMS — Tek Dosya Kurulum (MySQL / MariaDB)
--  Üretim: 2026-10-06 16:39
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
(1, 'Netvera Yönetici', 'admin@netverahafriyat.local', '$2y$10$TukhxuJClp2Xj/lRGrCJJOXsNEjq.4VC5Jc2OitVmaMWHyJxaKECe', 'admin', 'active', NULL, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'site_name', 'Netvera Hafriyat', 'general', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'site_tagline', 'Alanya Hafriyat • Kepçe Kiralama • Mini Kepçe', 'general', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'phone', '+90 539 528 01 48', 'contact', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'whatsapp_number', '905395280148', 'contact', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'email', 'info@netvera.tr', 'contact', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'address', 'Mahmutlar Mah. Alanya / ANTALYA', 'contact', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'working_hours', 'Pzt - Cmt: 08:00 - 18:00', 'contact', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(8, 'top_bar_text', 'Alanya ve çevresinde hafriyat, kepçe ve kazı hizmetleri', 'general', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(9, 'map_embed', 'https://www.google.com/maps?q=Mahmutlar+Alanya+Antalya&output=embed', 'contact', 'textarea', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(10, 'seo_title', 'Alanya Hafriyat | Kepçe, Kazı ve Moloz Hizmetleri | Netvera Hafriyat', 'seo', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(11, 'seo_description', 'Alanya’da hafriyat, operatörlü kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye hizmetleri. İşiniz için hızlı teklif alın.', 'seo', 'textarea', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(12, 'seo_keywords', 'alanya hafriyat, alanya kepçe kiralama, alanya mini kepçe, temel kazısı, moloz taşıma, arsa tesviye', 'seo', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(13, 'og_image', 'genel/alanya-hafriyat-og-kapak.webp', 'seo', 'image', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(14, 'footer_about', 'Netvera Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme ihtiyaçlarına yönelik çözümler sunar.', 'general', 'textarea', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(15, 'logo', 'genel/netvera-hafriyat-logo.webp', 'general', 'image', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(16, 'about_counter_experience', '', 'about', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(17, 'about_counter_projects', '', 'about', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(18, 'about_counter_staff', '', 'about', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(19, 'about_counter_support', '', 'about', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(20, 'floating_whatsapp_enabled', '1', 'general', 'toggle', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(21, 'web_design_credit_text', 'Netvera Teknoloji Yazılım', 'footer', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(22, 'web_design_credit_url', '', 'footer', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(23, 'content_pack_version', '7', 'system', 'text', '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, '#F5A400', '#D98A00', '#111827', '#111827', '#FFFFFF', '#080B0F', '#FFB703', '#F7F4EF', '#FFFFFF', '#111827', '#64748B', '#E5E7EB', '#F5A400', '#111827', '#080B0F', '#FFFFFF', '#25D366', '10px', '14px', '0.10', '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'header', 'Ana Sayfa', '/', NULL, 'internal', NULL, '_self', 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'header', 'Hakkımızda', '/hakkimizda', NULL, 'internal', NULL, '_self', 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'header', 'Hizmetlerimiz', '/hizmetler', NULL, 'internal', NULL, '_self', 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'header', 'Projelerimiz', '/projeler', NULL, 'internal', NULL, '_self', 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'header', 'Blog', '/blog', NULL, 'internal', NULL, '_self', 4, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'header', 'İletişim', '/iletisim', NULL, 'internal', NULL, '_self', 5, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'footer', 'Ana Sayfa', '/', NULL, 'internal', NULL, '_self', 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(8, 'footer', 'Hakkımızda', '/hakkimizda', NULL, 'internal', NULL, '_self', 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(9, 'footer', 'Hizmetlerimiz', '/hizmetler', NULL, 'internal', NULL, '_self', 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(10, 'footer', 'Projelerimiz', '/projeler', NULL, 'internal', NULL, '_self', 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(11, 'footer', 'Blog', '/blog', NULL, 'internal', NULL, '_self', 4, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(12, 'footer', 'İletişim', '/iletisim', NULL, 'internal', NULL, '_self', 5, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(13, 'mobile_bar', 'Ara', '', NULL, 'phone', 'phone', '_self', 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(14, 'mobile_bar', 'WhatsApp', 'Merhaba, teklif almak istiyorum.', NULL, 'whatsapp', 'whatsapp', '_self', 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(15, 'mobile_bar', 'Konum', '/iletisim#konum', NULL, 'internal', 'map-pin', '_self', 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(16, 'mobile_bar', 'Teklif Al', '/iletisim', NULL, 'internal', 'send', '_self', 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Hakkımızda', 'hakkimizda', 'Netvera Hafriyat; Mahmutlar’dan Alanya ve çevresine hafriyat, kepçe kiralama, kazı, taşıma ve tesviye hizmetleri sunar.', '<p>Netvera Hafriyat, Mahmutlar’dan Alanya ve çevresine hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme hizmetleri sunar.</p><p>Her işte önce çalışma alanının erişimi, zemin yapısı, kazı veya taşıma kapsamı ve ihtiyaç duyulan makine tipi değerlendirilir. Amaç; gereksiz iş kalemleri oluşturmadan sahaya uygun bir çalışma planı ve net teklif hazırlamaktır.</p><p>Talebinizi telefon veya WhatsApp üzerinden iletebilir; yapılacak işin konumu, yaklaşık alanı, erişim koşulları ve varsa fotoğrafları paylaşarak daha doğru bir ön değerlendirme alabilirsiniz.</p>', 'Netvera Hafriyat Hakkında', 'Alanya’da hafriyat, kepçe ve kazı ihtiyaçları için saha odaklı çözüm', 'sayfalar/ersan-hafriyat-hakkimizda-saha.webp', '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', 'sayfalar/ersan-hafriyat-hakkimizda-saha.webp', 'Netvera Hafriyat Hakkında | Alanya Hafriyat ve Kepçe', 'Netvera Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel kazısı, moloz taşıma ve arsa tesviye hizmetleri sunar.', NULL, 'genel/alanya-hafriyat-og-kapak.webp', 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'Gizlilik Politikası', 'gizlilik-politikasi', NULL, '<p>Bu web sitesi üzerinden iletilen iletişim ve teklif bilgileri yalnızca talebinizi değerlendirmek, size dönüş yapmak ve hizmet sürecini yürütmek amacıyla kullanılır.</p><p>Formlarda paylaşılan kişisel veriler üçüncü kişilere pazarlama amacıyla satılmaz. Yasal zorunluluklar ve hizmetin yürütülmesi için gerekli teknik sağlayıcılar saklıdır.</p>', 'Gizlilik Politikası', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Gizlilik Politikası | Netvera Hafriyat', NULL, NULL, NULL, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'KVKK Aydınlatma Metni', 'kvkk', NULL, '<p>6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında; iletişim ve teklif formlarında paylaştığınız ad, telefon, e-posta, bölge ve mesaj bilgileri talebinizin değerlendirilmesi ve sizinle iletişim kurulması amacıyla işlenebilir.</p><p>Verilerinizle ilgili talepleriniz için sitede yer alan iletişim kanallarını kullanabilirsiniz.</p>', 'KVKK Aydınlatma Metni', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'KVKK Aydınlatma Metni | Netvera Hafriyat', NULL, NULL, NULL, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'Çerez Politikası', 'cerez-politikasi', NULL, '<p>Web sitesi; temel işlevlerin çalışması, güvenlik, tercihlerin hatırlanması ve ölçümleme amaçlarıyla gerekli olduğunda çerez ve benzeri teknolojiler kullanabilir.</p><p>Kullanılan üçüncü taraf ölçüm veya reklam araçları değişirse bu metnin yönetim panelinden güncellenmesi gerekir.</p>', 'Çerez Politikası', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Çerez Politikası | Netvera Hafriyat', NULL, NULL, NULL, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'hero', 'Alanya Hafriyat ve Kepçe Hizmetleri', 'Alanya ve çevresinde hafriyat, operatörlü kepçe ve mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye işleri için ihtiyaca uygun saha çözümü.', '{"button_1_text":"WhatsApp’tan Teklif Al","button_1_url":"Merhaba, Alanya’da hafriyat\\/kepçe hizmeti için teklif almak istiyorum.","button_1_type":"whatsapp","button_2_text":"Hizmetleri İncele","button_2_url":"\\/hizmetler","button_2_type":"internal","overlay_opacity":"0.55","show_form":"1","show_badges":"1","badges":[{"icon":"message-circle","title":"Hızlı İletişim","text":"İşinizi telefon veya WhatsApp ile anlatın."},{"icon":"truck","title":"Doğru Makine Planı","text":"Makine seçimi işin türü ve saha koşullarına göre yapılır."},{"icon":"map-pin","title":"Yerel Hizmet","text":"Mahmutlar, Alanya Merkez ve çevre bölgeler."},{"icon":"shield","title":"Planlı Uygulama","text":"Erişim, zemin ve çalışma kapsamı önceden değerlendirilir."},{"icon":"tag","title":"Şeffaf Teklif","text":"Süre, makine, nakliye ve saha koşullarına göre fiyatlandırma."}]}', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', NULL, NULL, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'services', 'Alanya Hafriyat Hizmetleri', 'Kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme hizmetleri.', NULL, '', NULL, NULL, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'equipment', 'İşinize Uygun Makine Seçimi', 'İşin türü, saha koşulları ve erişime göre uygun makine seçeneği planlanır; marka/model ve mevcut makine teklif öncesinde teyit edilir.', NULL, '', NULL, NULL, 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'process', 'Hizmet Sürecimiz', 'Talebinizden saha uygulamasına kadar net ve planlı ilerleyen süreç', '[{"icon":"message-circle","title":"Talebi Paylaşın","text":"Konum, iş türü, yaklaşık alan ve varsa saha fotoğraflarını iletin."},{"icon":"search","title":"Saha İhtiyacını Belirleyelim","text":"Erişim, zemin, kazı derinliği ve çıkan malzeme gibi temel koşullar değerlendirilir."},{"icon":"clipboard","title":"Makine ve İş Planı","text":"İşe uygun makine, süre, nakliye ve ekip ihtiyacı planlanır."},{"icon":"hard-hat","title":"Uygulama","text":"Belirlenen çalışma kapsamına göre saha uygulaması gerçekleştirilir."},{"icon":"check-circle","title":"Kontrol ve Teslim","text":"Tamamlanan iş saha koşulları ve talep kapsamına göre kontrol edilir."}]', '', NULL, NULL, 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'machine_anim', 'Sahada Doğru Plan, Verimli Çalışma', 'Kazı, yükleme, taşıma ve tesviye işlerinde makine seçimi; alanın erişimi, zemin ve iş kapsamına göre planlanır.', NULL, 'anasayfa/alanya-hafriyat-mini-kepce-saha.webp', NULL, NULL, 4, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'gallery', 'Sahadan Gerçek Görüntüler', 'Bu bölümde yalnızca Netvera Hafriyat’ın gerçek çalışma fotoğraf ve videoları yayınlanır.', NULL, '', NULL, NULL, 5, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'projects', 'Son Projeler', 'Alanya ve çevresindeki gerçek saha çalışmalarından proje örnekleri.', NULL, '', NULL, NULL, 6, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(8, 'regions', 'Alanya Hizmet Bölgelerimiz', 'Mahmutlar’dan Alanya Merkez ve çevre mahallelere uzanan hizmet alanlarımız.', NULL, '', NULL, NULL, 7, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(9, 'blog', 'Hafriyat Bilgi Merkezi', 'Kepçe seçimi, fiyat faktörleri, kazı ve saha hazırlığı hakkında karar vermeyi kolaylaştıran içerikler.', NULL, '', NULL, NULL, 8, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(10, 'faq', 'Hafriyat ve Kepçe Hakkında Sık Sorulanlar', 'Fiyat, makine seçimi, çalışma süreci ve hizmet bölgeleri hakkında kısa cevaplar.', NULL, '', NULL, NULL, 9, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(11, 'final_cta', 'Alanya’da Hafriyat veya Kepçe Hizmetine mi İhtiyacınız Var?', 'İşin konumunu ve kapsamını paylaşın; uygun makine ve çalışma planı için teklif isteyin.', NULL, '', NULL, NULL, 10, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Kepçe Kiralama', 'kepce-kiralama', 'Alanya’da temel kazısı, yükleme, kanal, tesviye ve saha işleri için operatörlü kepçe hizmeti.', '<h2>Alanya’da kepçe kiralama hangi işler için kullanılır?</h2><p>Kepçe kiralama; temel ve kanal kazısı, arsa düzenleme, yükleme, tesviye, moloz ve hafriyat işleri gibi farklı saha ihtiyaçlarında kullanılır. Doğru makine seçimi işin büyüklüğü, zemin yapısı, çalışma alanına erişim ve çıkarılacak malzemenin miktarına göre yapılır.</p><h2>Operatörlü kepçe hizmetinde süreç nasıl işler?</h2><p>Teklif öncesinde işin konumu, yapılacak çalışma, yaklaşık alan veya kazı ölçüsü, makinenin sahaya giriş koşulları ve varsa fotoğraflar değerlendirilir. Saatlik veya günlük çalışma ihtiyacı da bu kapsam içinde netleştirilir.</p><h2>Kepçe kiralama fiyatını neler belirler?</h2><p>Fiyat; çalışma süresi, kullanılacak makine tipi, makinenin sahaya nakli, zemin koşulları, ataşman ihtiyacı, çıkan hafriyatın taşınıp taşınmayacağı ve kamyon gereksinimi gibi kalemlere göre değişir. Bu nedenle tek bir sabit fiyat yerine işin kapsamına göre teklif hazırlanır.</p>', 'truck', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Kepçe Kiralama', 'Alanya’da temel kazısı, yükleme, kanal, tesviye ve saha işleri için operatörlü kepçe hizmeti.', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["İşin kapsamına göre makine planlama","Operatörlü çalışma","Kazı, yükleme ve tesviye ihtiyaçlarını birlikte değerlendirme","Telefon ve WhatsApp üzerinden hızlı ön değerlendirme","Saha koşullarına göre teklif"]', '["Temel ve yapı kazıları","Kanal ve altyapı kazıları","Arsa tesviye ve dolgu","Toprak ve moloz yükleme","Bahçe ve saha düzenleme"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Kepçe Kiralama | Operatörlü Kepçe | Netvera Hafriyat', 'Alanya’da operatörlü kepçe kiralama; temel ve kanal kazısı, yükleme, tesviye ve hafriyat işleri. İşinize uygun makine için Netvera Hafriyat’tan teklif alın.', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 0, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'Mini Kepçe Kiralama', 'mini-kepce-kiralama', 'Dar alan, bahçe, küçük temel ve kanal işleri için Alanya mini kepçe ve mini ekskavatör çözümleri.', '<h2>Mini kepçe hangi işlerde tercih edilir?</h2><p>Mini kepçe; büyük iş makinelerinin manevra yapmakta zorlandığı dar bahçeler, bina çevreleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve hassas tesviye işleri için tercih edilir. En önemli avantajı sınırlı çalışma alanlarında kontrollü hareket edebilmesidir.</p><h2>Dar alanda makine seçimi nasıl yapılır?</h2><p>Kapı veya geçiş genişliği, saha içindeki dönüş alanı, kazı derinliği, zemin tipi ve çıkan malzemenin nasıl uzaklaştırılacağı birlikte değerlendirilir. Gerçek makine ölçüleri yalnız doğrulanmış ekipman bilgisi üzerinden paylaşılır.</p><h2>Mini kepçe fiyatını etkileyen faktörler</h2><p>Çalışma süresi, makinenin sahaya nakli, zemin koşulları, kazı derinliği, ataşman ihtiyacı ve moloz/hafriyat taşıması fiyatı etkileyebilir.</p>', 'excavator', 'hizmetler/alanya-mini-kepce-kiralama.webp', 'https://images.pexels.com/photos/14846286/pexels-photo-14846286.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Mini Kepçe Kiralama', 'Dar alan, bahçe, küçük temel ve kanal işleri için Alanya mini kepçe ve mini ekskavatör çözümleri.', 'https://images.pexels.com/photos/14846286/pexels-photo-14846286.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Dar alanlarda çalışma planı","Bahçe ve bina çevresinde kontrollü kazı","Küçük temel ve kanal işleri","Erişim ölçülerine göre ön değerlendirme","Hassas tesviye ve düzenleme"]', '["Dar bahçe girişleri","Küçük temel kazıları","Kanal ve tesisat hatları","Peyzaj ve çevre düzenleme","Hassas tesviye işleri"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Mini Kepçe Kiralama | Dar Alan Kazı | Netvera Hafriyat', 'Alanya mini kepçe kiralama; dar bahçe girişleri, küçük temel ve kanal kazıları, peyzaj ve hassas saha işleri. İşiniz için uygun mini kepçe planı alın.', 'hizmetler/alanya-mini-kepce-kiralama.webp', 1, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'Temel Kazısı', 'temel-kazisi', 'Alanya’da villa, konut ve yapı projeleri için saha koşullarına uygun temel kazısı hizmeti.', '<h2>Temel kazısı öncesinde nelere bakılır?</h2><p>Temel kazısında proje ölçüleri kadar zeminin yapısı, makinenin sahaya erişimi, kazı derinliği, çıkan toprağın sahada kullanılıp kullanılmayacağı ve taşıma ihtiyacı önemlidir.</p><h2>Kazıdan çıkan malzeme nasıl yönetilir?</h2><p>Çıkan malzemenin bir kısmı dolgu veya tesviye için değerlendirilebilir; taşınması gereken toprak ve moloz için yükleme ve nakliye planı oluşturulur.</p><h2>Teklif için hangi bilgiler gerekir?</h2><p>Konum, proje veya yaklaşık kazı ölçüsü, saha giriş durumu, zeminle ilgili bilinen bilgiler ve fotoğraflar teklifin daha doğru hazırlanmasına yardımcı olur.</p>', 'layers', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Temel Kazısı', 'Alanya’da villa, konut ve yapı projeleri için saha koşullarına uygun temel kazısı hizmeti.', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Kazı ölçülerine göre planlama","Saha erişimi ve zemin değerlendirmesi","Hafriyat yükleme ve taşıma ihtiyacını birlikte planlama","Tesviye ve dolgu ihtiyacını aynı süreçte değerlendirme","İş kapsamına göre makine seçimi"]', '["Villa temel kazısı","Konut ve yapı temelleri","İstinat ve çevre kazıları","Temel çevresi düzenleme","Kazı sonrası dolgu ve tesviye"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Temel Kazısı | Bina ve Villa Kazısı | Netvera Hafriyat', 'Alanya’da bina ve villa temel kazısı; saha erişimi, zemin, kazı ölçüsü, hafriyat taşıma ve tesviye ihtiyacına göre planlı kazı hizmeti.', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 2, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'Moloz ve Hafriyat Taşıma', 'moloz-hafriyat-nakliye', 'Alanya’da kazıdan çıkan toprak, hafriyat ve molozun yükleme ve taşıma ihtiyacına yönelik saha planlaması.', '<h2>Moloz ve hafriyat taşıma nasıl planlanır?</h2><p>Taşıma işinde malzemenin türü ve tahmini miktarı, yükleme alanı, sahaya araç giriş-çıkışı ve uygun boşaltma planı birlikte değerlendirilir. Kazı işiyle eş zamanlı planlama yapılması sahadaki beklemeyi azaltabilir.</p><h2>Yükleme hizmeti de dahil olabilir mi?</h2><p>İşin kapsamına göre moloz veya toprağın kepçe ile yüklenmesi ve taşıma süreci birlikte değerlendirilebilir. Teklif için yaklaşık miktar, konum ve malzeme türünün paylaşılması yararlıdır.</p><h2>Fiyatı etkileyen unsurlar</h2><p>Malzeme miktarı, yükleme ihtiyacı, taşıma mesafesi, saha erişimi, çalışma süresi ve ek makine gereksinimi fiyatı belirleyen ana kalemlerdir.</p>', 'truck', 'hizmetler/alanya-moloz-hafriyat-tasima.webp', 'https://images.pexels.com/photos/29506754/pexels-photo-29506754.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Moloz ve Hafriyat Taşıma', 'Alanya’da kazıdan çıkan toprak, hafriyat ve molozun yükleme ve taşıma ihtiyacına yönelik saha planlaması.', 'https://images.pexels.com/photos/29506754/pexels-photo-29506754.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Kazı ve taşıma işini birlikte planlama","Yükleme ihtiyacını kapsama dahil etme","Malzeme miktarına göre araç planı","Saha giriş-çıkış koşullarını değerlendirme","Konum ve iş kapsamına göre teklif"]', '["Kazı toprağı taşıma","İnşaat molozu yükleme ve taşıma","Arsa ve bahçe temizliği sonrası malzeme","Temel kazısı hafriyatı","Saha temizliği"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Moloz Taşıma | Hafriyat Nakliye | Netvera Hafriyat', 'Alanya’da moloz taşıma ve hafriyat nakliye; yükleme, kazı toprağı, saha erişimi ve taşıma ihtiyacına göre planlama. Netvera Hafriyat’tan teklif alın.', 'hizmetler/alanya-moloz-hafriyat-tasima.webp', 3, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'Altyapı ve Kanal Kazısı', 'alt-yapi-kanal-acma', 'Alanya’da altyapı, drenaj, tesisat ve benzeri hatlar için kanal kazısı ve saha hazırlığı.', '<h2>Kanal kazısı hangi işler için yapılır?</h2><p>Kanal kazısı; drenaj, su ve tesisat hatları, altyapı geçişleri ve benzeri saha ihtiyaçlarında uygulanır. Çalışmanın genişliği ve derinliği, mevcut hatlar, zemin yapısı ve makinenin alana erişimi planlamada önemlidir.</p><h2>Dar alanlarda kanal kazısı</h2><p>Bahçe, bina çevresi veya sınırlı geçişe sahip alanlarda daha küçük makine ihtiyacı doğabilir. Kullanılacak makine, gerçek geçiş ölçüsü ve kazı kapsamına göre seçilir.</p><h2>Çalışma öncesi nelere dikkat edilir?</h2><p>Mevcut altyapı hatları ve proje bilgileri mümkün olduğunca önceden belirlenmeli; kazı güzergâhı, malzemenin nereye alınacağı ve kazı sonrası dolgu ihtiyacı birlikte değerlendirilmelidir.</p>', 'git-branch', 'hizmetler/alanya-kanal-kazisi.webp', 'hizmetler/alanya-kanal-kazisi.webp', 'Alanya Kanal Kazısı ve Altyapı', 'Alanya’da altyapı, drenaj, tesisat ve benzeri hatlar için kanal kazısı ve saha hazırlığı.', 'hizmetler/alanya-kanal-kazisi.webp', '["Kazı güzergâhına göre planlama","Dar alan koşullarını değerlendirme","Kazı sonrası dolgu ihtiyacını planlama","Zemin ve derinliğe göre makine seçimi","Saha düzenine uygun çalışma"]', '["Drenaj kanalı","Su ve tesisat hattı kazısı","Altyapı geçişleri","Bahçe ve bina çevresi kanal işleri","Kazı sonrası dolgu"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Kanal Kazısı ve Altyapı | Netvera Hafriyat', 'Alanya’da kanal kazısı, drenaj ve altyapı çalışmaları; dar alan, zemin, derinlik ve dolgu ihtiyacına göre saha planlaması ve teklif.', 'hizmetler/alanya-kanal-kazisi.webp', 4, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'Arsa Tesviye ve Dolgu', 'arsa-tesviye-dolgu', 'Alanya’da arsa, bahçe ve yapı çevresinde kot düzenleme, tesviye, dolgu ve yüzey hazırlığı.', '<h2>Arsa tesviyesi nedir?</h2><p>Arsa tesviyesi; yüzeydeki seviye farklarının işin amacına göre düzenlenmesi, gerekli alanların kazılması veya doldurulması ve sahada kontrollü bir eğim/kot oluşturulması işlemidir.</p><h2>Dolgu işinde hangi bilgiler önemlidir?</h2><p>Kullanılacak dolgu malzemesi, dolgu kalınlığı, alanın mevcut kotu, drenaj ihtiyacı ve sıkıştırma gereksinimi işin kapsamını etkiler.</p><h2>Fiyatı ne belirler?</h2><p>Alan büyüklüğü, taşınacak veya getirilecek malzeme miktarı, makine süresi, zemin ve erişim koşulları tesviye/dolgu fiyatında temel unsurlardır.</p>', 'mountain', 'hizmetler/alanya-arsa-tesviye-dolgu.webp', 'https://images.pexels.com/photos/12164798/pexels-photo-12164798.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Arsa Tesviye ve Dolgu', 'Alanya’da arsa, bahçe ve yapı çevresinde kot düzenleme, tesviye, dolgu ve yüzey hazırlığı.', 'https://images.pexels.com/photos/12164798/pexels-photo-12164798.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Kot ve yüzey ihtiyacına göre çalışma","Kazı ve dolgu kalemlerini birlikte değerlendirme","Arsa ve bahçe düzenleme desteği","Malzeme hareketine göre makine planı","Saha erişimine göre teklif"]', '["Arsa düzeltme","Yapı öncesi saha hazırlığı","Bahçe tesviyesi","Toprak dolgu","Kot ve eğim düzenleme"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Arsa Tesviye ve Dolgu | Netvera Hafriyat', 'Alanya’da arsa tesviye, zemin düzenleme ve dolgu işleri. Alan, kot, malzeme miktarı, zemin ve makine ihtiyacına göre planlı saha çalışması.', 'hizmetler/alanya-arsa-tesviye-dolgu.webp', 5, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'Arsa Temizleme ve Bahçe Düzenleme', 'cevre-bahce-duzenleme', 'Alanya’da arsa ve bahçelerde saha temizliği, toprak düzenleme, tesviye ve kazı ihtiyaçları.', '<h2>Arsa ve bahçe temizliği hangi işleri kapsar?</h2><p>Saha temizliği; zemindeki birikintilerin kaldırılması, gerekli alanlarda kazı yapılması, toprağın düzenlenmesi, tesviye ve çıkan malzemenin yüklenip taşınması gibi farklı iş kalemlerini içerebilir.</p><h2>Bahçe alanlarında neden makine seçimi önemlidir?</h2><p>Bahçe kapısı, duvarlar, ağaçlar ve mevcut yapılar çalışma alanını sınırlayabilir. Bu nedenle makine boyutu ve hareket alanı önceden değerlendirilmelidir.</p><h2>Temizlik sonrası saha düzenlenebilir mi?</h2><p>İhtiyaca göre yüzey düzeltme, tesviye veya dolgu çalışmaları temizlik sonrasında aynı plan içinde ele alınabilir.</p>', 'trees', 'galeri/alanya-dar-alan-mini-kepce-tesviye.webp', 'hizmetler/alanya-arsa-temizleme.webp', 'Alanya Arsa Temizleme ve Bahçe Düzenleme', 'Alanya’da arsa ve bahçelerde saha temizliği, toprak düzenleme, tesviye ve kazı ihtiyaçları.', 'hizmetler/alanya-arsa-temizleme.webp', '["Saha temizliği ve düzenlemeyi birlikte planlama","Dar girişleri değerlendirme","Yükleme ve taşıma ihtiyacını kapsama dahil etme","Tesviye ve dolgu seçeneği","Arazi durumuna göre makine planı"]', '["Arsa temizleme","Bahçe toprak düzenleme","Ağaç kökü ve alan temizliği","Yüzey tesviyesi","Yapı çevresi saha hazırlığı"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Arsa Temizleme ve Bahçe Düzenleme | Netvera Hafriyat', 'Alanya’da arsa temizleme, bahçe düzenleme, toprak tesviye, yükleme ve saha hazırlığı. Alanın erişim ve zemin koşullarına göre teklif alın.', 'galeri/alanya-dar-alan-mini-kepce-tesviye.webp', 6, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(8, 'Drenaj ve Özel Kazı İşleri', 'drenaj-ozel-kazi', 'Alanya’da drenaj hattı, özel ölçülü kazı ve saha koşullarına göre planlanan kazı çalışmaları.', '<h2>Drenaj kazısı ne zaman gerekir?</h2><p>Drenaj kanalı veya hattı için yapılacak kazılarda güzergâh, eğim, derinlik, mevcut zemin ve saha erişimi birlikte değerlendirilir. Teknik proje gerektiren işlerde uygulama ilgili proje ve ölçülere göre yapılmalıdır.</p><h2>Özel kazı ne demektir?</h2><p>Standart geniş saha kazılarından farklı olarak dar geçiş, belirli ölçü veya hassas çalışma gerektiren işler özel kazı kapsamında değerlendirilebilir.</p><h2>Dolgu ve kapatma nasıl planlanır?</h2><p>Hat çalışması sonrasında dolgu, yüzey düzenleme veya tesviye ihtiyacı varsa bu kalemler kazı planıyla birlikte değerlendirilir.</p>', 'droplet', 'hizmetler/alanya-kanal-kazisi.webp', 'hizmetler/alanya-kanal-kazisi.webp', 'Alanya Drenaj ve Özel Kazı İşleri', 'Alanya’da drenaj hattı, özel ölçülü kazı ve saha koşullarına göre planlanan kazı çalışmaları.', 'hizmetler/alanya-kanal-kazisi.webp', '["Güzergâh ve ölçüye göre kazı planı","Dar veya hassas alanları değerlendirme","Zemin ve erişime göre makine seçimi","Kazı sonrası dolgu ihtiyacını planlama","İş kapsamına göre teklif"]', '["Drenaj kanalları","Özel ölçülü kazılar","Bahçe ve yapı çevresi hatları","Dar alan çalışmaları","Kazı sonrası dolgu"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Drenaj ve Özel Kazı İşleri | Netvera Hafriyat', 'Alanya’da drenaj kanalı ve özel kazı işleri; güzergâh, derinlik, zemin ve saha erişimine göre makine ve çalışma planı.', 'hizmetler/alanya-kanal-kazisi.webp', 7, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(9, 'Havuz Kazısı', 'havuz-kazisi', 'Alanya’da villa ve bahçe projelerinde havuz alanı açma, kazı, yükleme ve saha hazırlığı.', '<h2>Havuz kazısı nasıl planlanır?</h2><p>Havuz kazısında proje ölçüsü, kazı derinliği, makine erişimi, zemin yapısı ve çıkan toprağın nasıl yönetileceği birlikte değerlendirilir. Bahçe duvarı, giriş genişliği ve yapı çevresindeki hareket alanı makine seçimini doğrudan etkileyebilir.</p><h2>Kazı toprağı ne olur?</h2><p>Çıkan malzemenin sahada kullanılacak kısmı ile taşınacak kısmı ayrılarak yükleme ve nakliye ihtiyacı planlanabilir.</p><h2>Teklif için ne gerekir?</h2><p>Konum, havuz projesi veya yaklaşık ölçüler, saha giriş bilgisi ve fotoğraflar ön değerlendirmeyi hızlandırır.</p>', 'droplet', 'https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Havuz Kazısı', 'Alanya’da villa ve bahçe projelerinde havuz alanı açma, kazı, yükleme ve saha hazırlığı.', 'https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Proje ölçüsüne göre kazı planı","Dar bahçe erişimini değerlendirme","Kazı ve hafriyat taşımasını birlikte planlama","Zemin koşullarına göre makine seçimi","Kazı sonrası saha düzeni"]', '["Villa havuzu kazısı","Bahçe havuzu alan açma","Havuz çevresi saha hazırlığı","Kazı toprağı yükleme","Kazı sonrası tesviye"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Havuz Kazısı | Villa ve Bahçe Havuzu | Netvera Hafriyat', 'Alanya’da havuz kazısı; proje ölçüsü, bahçe erişimi, zemin, kazı derinliği ve hafriyat taşıma ihtiyacına göre planlı çalışma.', 'https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 8, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(10, 'Yol Açma ve Saha Hazırlığı', 'yol-acma-saha-hazirlama', 'Alanya’da arsa içi ulaşım, şantiye girişi, yüzey açma, kot düzenleme ve yol altyapısı hazırlığı.', '<h2>Yol açma çalışması hangi aşamalardan oluşur?</h2><p>Arsa veya şantiye içi yol hazırlığında güzergâh, mevcut eğim, zemin yapısı, genişlik ve kullanılacak malzeme belirlenir. Gerekli alanlarda yüzey kazısı, tesviye ve dolgu yapılabilir.</p><h2>Şantiye girişi nasıl hazırlanır?</h2><p>Makine ve kamyon geçişine uygun bir çalışma alanı oluşturmak için giriş genişliği, dönüş noktaları ve zemin taşıma durumu değerlendirilir.</p><h2>Serme ve sıkıştırma gerekir mi?</h2><p>Yol veya saha kullanım amacına göre stabilize veya benzeri dolgu malzemelerinin serilmesi ve sıkıştırılması ayrı bir iş kalemi olarak planlanabilir.</p>', 'mountain', 'https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Yol Açma ve Saha Hazırlığı', 'Alanya’da arsa içi ulaşım, şantiye girişi, yüzey açma, kot düzenleme ve yol altyapısı hazırlığı.', 'https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Güzergâh ve kot planlama","Yüzey kazısı ve tesviye","Dolgu ihtiyacını birlikte değerlendirme","Kamyon ve makine erişimine göre saha düzeni","Serme-sıkıştırma ile entegre planlama"]', '["Arsa içi yol açma","Şantiye girişi hazırlama","Arazi geçiş yolu","Yol tabanı hazırlığı","Saha kot düzenleme"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Yol Açma ve Saha Hazırlığı | Netvera Hafriyat', 'Alanya’da yol açma, şantiye girişi, yüzey kazısı, tesviye ve saha hazırlığı. Güzergâh ve zemin koşullarına göre çalışma planı ve teklif.', 'https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 9, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(11, 'Toprak Serme ve Sıkıştırma', 'toprak-serme-sikistirma', 'Alanya’da dolgu malzemesi, toprak veya stabilize serme, tesviye ve sıkıştırma hazırlığı.', '<h2>Serme ve sıkıştırma hangi işlerde gerekir?</h2><p>Yol tabanı, bahçe, arsa, şantiye ve yapı çevresinde dolgu malzemesinin kontrollü biçimde yayılması ve yüzeyin kullanım amacına göre hazırlanması gerekebilir.</p><h2>Malzeme ve katman kalınlığı neden önemlidir?</h2><p>Kullanılacak malzeme türü, serim kalınlığı, alanın kotu ve drenaj ihtiyacı işin yöntemini belirler. Teknik gereklilik bulunan projelerde uygulama proje şartlarına göre yapılmalıdır.</p><h2>Hafriyat işiyle birlikte yapılabilir mi?</h2><p>Kazı sonrası dolgu, serme ve yüzey düzeltme aynı saha planında değerlendirilebilir; böylece makine hareketi daha verimli planlanır.</p>', 'layers', 'https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Toprak Serme ve Sıkıştırma', 'Alanya’da dolgu malzemesi, toprak veya stabilize serme, tesviye ve sıkıştırma hazırlığı.', 'https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Dolgu ve serme planı","Kot ve yüzey düzenleme","Kazı sonrası tamamlayıcı çalışma","Malzeme hareketine göre makine seçimi","Saha kullanım amacına göre hazırlık"]', '["Stabilize serme","Toprak dolgu","Yol tabanı hazırlığı","Bahçe ve arsa düzenleme","Kazı sonrası yüzey hazırlığı"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Toprak Serme ve Sıkıştırma | Netvera Hafriyat', 'Alanya’da toprak, dolgu ve stabilize serme; tesviye ve sıkıştırma hazırlığı. Alan, kot, malzeme ve saha koşullarına göre planlı çalışma.', 'https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 10, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(12, 'Yıkım Sonrası Saha Temizliği', 'yikim-sonrasi-saha-temizligi', 'Alanya’da yıkım veya tadilat sonrası moloz yükleme, alan temizleme, taşıma ve saha düzenleme.', '<h2>Yıkım sonrası saha temizliği neleri kapsar?</h2><p>Yıkım veya tadilat sonrasında oluşan molozun toplanması, kepçe ile yüklenmesi, taşıma planı ve sahada kalan zeminin düzenlenmesi ayrı iş kalemleri olarak değerlendirilebilir.</p><h2>Dar alanlarda temizlik nasıl yapılır?</h2><p>Bina çevresi, site içi veya bahçe gibi alanlarda makine seçimi giriş genişliği ve hareket alanına göre yapılır. Gerektiğinde daha küçük ekipman planlanabilir.</p><h2>Taşıma nasıl planlanır?</h2><p>Malzemenin türü ve miktarı, kamyon erişimi ve taşıma mesafesi dikkate alınarak yükleme ve nakliye kapsamı oluşturulur.</p>', 'truck', 'https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Yıkım Sonrası Saha Temizliği', 'Alanya’da yıkım veya tadilat sonrası moloz yükleme, alan temizleme, taşıma ve saha düzenleme.', 'https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Moloz yükleme ve taşıma planı","Dar alan erişimini değerlendirme","Saha temizliği ve tesviyeyi birlikte planlama","Malzeme miktarına göre araç ihtiyacı","İş sonrası alan düzenleme"]', '["Yıkım sonrası moloz","Tadilat sonrası saha temizliği","İnşaat atığı yükleme","Alan temizleme","Temizlik sonrası tesviye"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Yıkım Sonrası Saha Temizliği | Netvera Hafriyat', 'Alanya’da yıkım ve tadilat sonrası moloz yükleme, taşıma, saha temizliği ve tesviye. Alan ve malzeme miktarına göre teklif alın.', 'https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 11, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(13, 'Lastikli Kepçe Kiralama', 'lastikli-kepce-kiralama', 'Alanya’da şehir içi, yol, altyapı, yükleme ve saha işleri için hareket kabiliyeti yüksek lastikli kepçe hizmeti.', '<h2>Lastikli kepçe hangi işlerde tercih edilir?</h2><p>Lastikli kepçeler; sert zeminli saha geçişleri, yol ve altyapı çalışmaları, yükleme, kanal ve şehir içi uygulamalarda hareket kabiliyeti sayesinde avantaj sağlar. Makine seçimi iş hacmi, zemin ve erişime göre yapılır.</p><h2>Normal tonajlı makine neden avantajlıdır?</h2><p>Çok ağır sınıf makinelerin gerekli olmadığı işlerde orta sınıf lastikli kepçeler saha içinde daha pratik hareket edebilir ve çalışma planını gereksiz kapasiteye göre büyütmez.</p><h2>Teklifte hangi bilgiler değerlendirilir?</h2><p>Konum, çalışma süresi, kazı veya yükleme kapsamı, zemin, makine erişimi ve varsa ataşman ihtiyacı teklifin temelini oluşturur.</p>', 'excavator', 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Lastikli Kepçe Kiralama', 'Alanya’da şehir içi, yol, altyapı, yükleme ve saha işleri için hareket kabiliyeti yüksek lastikli kepçe hizmeti.', 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Şehir içi ve sert zeminde hareket kabiliyeti","Kazı ve yükleme işleri","Yol ve altyapı uygulamaları","Saha koşullarına göre makine seçimi","Operatörlü çalışma planı"]', '["Yol ve altyapı işleri","Kanal kazısı","Toprak ve moloz yükleme","Saha düzenleme","Şehir içi kazı çalışmaları"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Lastikli Kepçe Kiralama | Netvera Hafriyat', 'Alanya’da lastikli kepçe kiralama; yol, altyapı, kanal, yükleme ve saha düzenleme işleri için orta sınıf operatörlü makine çözümleri.', 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 12, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(14, 'Kazıcı Yükleyici Kiralama', 'kazici-yukleyici-kiralama', 'Alanya’da kazı, yükleme, kanal, saha temizliği ve dolgu işleri için çok amaçlı kazıcı yükleyici hizmeti.', '<h2>Kazıcı yükleyici hangi işler için kullanılır?</h2><p>Kazıcı yükleyici; ön yükleyici kovası ve arka kazıcı kolu sayesinde küçük ve orta ölçekli saha işlerinde çok yönlü kullanılabilir. Kanal, yükleme, saha temizliği, dolgu ve çevre düzenleme işlerinde değerlendirilebilir.</p><h2>Hangi sahalarda avantaj sağlar?</h2><p>Birden fazla iş kaleminin aynı sahada yapılacağı uygulamalarda kazı ve yükleme fonksiyonlarının tek makinede bulunması çalışma akışını kolaylaştırabilir.</p><h2>Teklif nasıl hazırlanır?</h2><p>Yapılacak işlerin sırası, zemin, erişim, çalışma süresi ve malzeme hareketi değerlendirilerek uygun çalışma planı hazırlanır.</p>', 'excavator', 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Kazıcı Yükleyici Kiralama', 'Alanya’da kazı, yükleme, kanal, saha temizliği ve dolgu işleri için çok amaçlı kazıcı yükleyici hizmeti.', 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Kazı ve yüklemeyi tek makinede birleştirme","Kanal ve saha temizliği","Dolgu ve malzeme hareketi","Orta ölçekli saha işleri","Operatörlü hizmet planı"]', '["Kanal kazısı","Toprak yükleme","Saha temizliği","Dolgu ve tesviye","İnşaat çevresi düzenleme"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Kazıcı Yükleyici Kiralama | Netvera Hafriyat', 'Alanya’da kazıcı yükleyici kiralama; kazı, yükleme, kanal, dolgu ve saha temizliği işleri için operatörlü çok amaçlı iş makinesi.', 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 13, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(15, 'Forklift Kiralama', 'forklift-kiralama', 'Alanya’da paletli yük, yapı malzemesi ve saha içi indirme-bindirme ihtiyaçları için forklift desteği.', '<h2>Forklift hangi işler için kullanılır?</h2><p>Forklift; paletli yapı malzemelerinin, paketli yüklerin ve saha içi taşınması gereken malzemelerin indirme-bindirme süreçlerinde kullanılır. Uygun makine seçimi yük ağırlığı, kaldırma yüksekliği ve zemin koşullarına bağlıdır.</p><h2>Saha koşulları neden önemlidir?</h2><p>Düz ve taşıyıcı zemin, giriş yüksekliği, manevra alanı ve yükün konumu forklift çalışma planını etkiler. Açık saha veya kapalı alan ihtiyacı teklif aşamasında netleştirilir.</p><h2>Teklif için hangi bilgiler gerekir?</h2><p>Yükün türü, yaklaşık ağırlığı, kaldırma yüksekliği, çalışma süresi, konum ve saha fotoğrafları doğru makine planına yardımcı olur.</p>', 'forklift', 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Forklift Kiralama', 'Alanya’da paletli yük, yapı malzemesi ve saha içi indirme-bindirme ihtiyaçları için forklift desteği.', 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Paletli yük taşıma","İndirme-bindirme desteği","Saha içi malzeme hareketi","Yük ve yüksekliğe göre makine seçimi","Kısa veya planlı çalışma seçenekleri"]', '["Yapı malzemesi indirme","Palet taşıma","Depo ve saha içi lojistik","Kamyondan malzeme indirme","Şantiye malzeme yerleştirme"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Forklift Kiralama | Saha ve Yük Taşıma | Netvera Hafriyat', 'Alanya forklift kiralama; paletli yük, yapı malzemesi, kamyon indirme-bindirme ve saha içi taşıma ihtiyaçları için teklif alın.', 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 14, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(16, 'Traktör ile Arazi ve Nakliye Desteği', 'traktor-arazi-nakliye', 'Alanya’da bahçe, arazi ve saha işlerinde yerli üretim traktörle malzeme taşıma ve yardımcı çalışma desteği.', '<h2>Traktör hangi saha işlerinde kullanılır?</h2><p>Traktör; bahçe, tarla ve arazi içinde hafif malzeme taşıma, römork desteği ve saha lojistiği gibi işlerde kullanılabilir. Ekipman seçimi yapılacak işe ve arazi koşullarına göre belirlenir.</p><h2>Hafriyat işiyle birlikte kullanılabilir mi?</h2><p>Kepçe veya mini kepçe ile yapılan çalışmalarda saha içi yardımcı taşıma ihtiyacı varsa traktör ve römork desteği çalışma planına dahil edilebilir.</p><h2>Makine bilgisi nasıl teyit edilir?</h2><p>Yerli üretim traktör seçeneğinin model, güç ve ekipman bilgileri iş öncesinde mevcut makineye göre teyit edilir.</p>', 'tractor', 'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', 'Alanya Traktör ile Arazi ve Nakliye Desteği', 'Alanya’da bahçe, arazi ve saha işlerinde yerli üretim traktörle malzeme taşıma ve yardımcı çalışma desteği.', 'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp', '["Arazi içi yardımcı taşıma","Römork ile malzeme hareketi","Bahçe ve saha çalışmaları","Hafriyat ekibine lojistik destek","İşe göre ekipman planlama"]', '["Bahçe ve arazi işleri","Römorklu malzeme taşıma","Toprak ve hafif malzeme hareketi","Saha lojistiği","Kepçe çalışmalarına yardımcı taşıma"]', '[{"title":"Talep & Bilgi","text":"Konum, iş türü, ölçü ve varsa fotoğraflar alınır."},{"title":"Saha Değerlendirmesi","text":"Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir."},{"title":"Teklif & Plan","text":"İş kapsamı, çalışma modeli ve teklif netleştirilir."},{"title":"Uygulama & Kontrol","text":"Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir."}]', 'Alanya Traktör ve Arazi Nakliye Desteği | Netvera Hafriyat', 'Alanya’da traktör ile arazi, bahçe ve saha içi nakliye desteği; römorklu malzeme taşıma ve yardımcı çalışma seçenekleri.', 'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', 15, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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

INSERT INTO `service_faqs` (`id`, `service_id`, `question`, `answer`, `sort_order`, `is_active`) VALUES
(1, 1, 'Alanya’da kepçe kiralama fiyatı nasıl belirlenir?', 'Fiyat; çalışma süresi, makine tipi, saha erişimi, nakliye, zemin, ataşman ihtiyacı ve çıkan malzemenin taşınması gibi iş kalemlerine göre belirlenir.', 0, 1),
(2, 1, 'Saatlik veya günlük kepçe çalışması mümkün mü?', 'Çalışma modeli işin kapsamına ve sahaya göre planlanır. Saatlik veya günlük uygunluk için işin konumunu ve yapılacak çalışmayı ileterek teklif isteyebilirsiniz.', 1, 1),
(3, 1, 'Makinenin sahaya nakli nasıl planlanır?', 'Makine tipi, çalışma konumu ve saha erişimi netleştirildikten sonra uygun taşıma yöntemi teklif kapsamına dahil edilir.', 2, 1),
(4, 2, 'Mini kepçe dar bahçe girişlerinde kullanılabilir mi?', 'Uygunluk giriş genişliği, dönüş alanı ve kullanılacak gerçek makinenin ölçülerine bağlıdır. Saha ölçülerini ve fotoğrafları paylaşarak ön değerlendirme yapılabilir.', 0, 1),
(5, 2, 'Mini kepçe ile temel kazısı yapılır mı?', 'Küçük ölçekli temel ve benzeri kazılarda kullanılabilir; uygunluk kazı derinliği, zemin ve iş hacmine göre belirlenir.', 1, 1),
(6, 2, 'Mini kepçe fiyatı neye göre değişir?', 'Çalışma süresi, nakliye, zemin, erişim, kazı kapsamı ve varsa ataşman ihtiyacı fiyatı etkileyen başlıca unsurlardır.', 2, 1),
(7, 3, 'Temel kazısı fiyatı nasıl hesaplanır?', 'Kazı hacmi, zemin, makine tipi, çalışma süresi, saha erişimi ve çıkan malzemenin taşınma ihtiyacı temel fiyat faktörleridir.', 0, 1),
(8, 3, 'Kazıdan çıkan toprak taşınabilir mi?', 'Taşıma ihtiyacı varsa kazı ile birlikte yükleme ve nakliye planlanabilir. Net kapsam sahadaki malzeme miktarına göre belirlenir.', 1, 1),
(9, 3, 'Temel kazısı için keşif gerekir mi?', 'Ölçekli veya erişimi zor işlerde saha koşullarını görmek daha doğru makine ve süre planı yapılmasını sağlar.', 2, 1),
(10, 4, 'Alanya moloz taşıma fiyatı neye göre belirlenir?', 'Malzeme miktarı, yükleme ihtiyacı, taşıma mesafesi, saha erişimi ve gereken araç/makine süresi fiyatı etkiler.', 0, 1),
(11, 4, 'Molozun yüklenmesi de yapılabilir mi?', 'İş kapsamına göre kepçe ile yükleme ve taşıma birlikte planlanabilir.', 1, 1),
(12, 4, 'Kazı ve hafriyat taşıma aynı işte planlanabilir mi?', 'Evet, kazı sırasında çıkan malzemenin taşınması gerekiyorsa iki iş tek çalışma planında değerlendirilebilir.', 2, 1),
(13, 5, 'Kanal kazısında kullanılacak makine nasıl seçilir?', 'Kanalın genişliği ve derinliği, saha erişimi ve zemin yapısı makine seçiminde belirleyicidir.', 0, 1),
(14, 5, 'Dar alanda kanal kazısı yapılabilir mi?', 'Uygunluk geçiş ölçüsü ve çalışma alanına bağlıdır. Saha ölçüleri paylaşıldığında mini makine seçeneği değerlendirilebilir.', 1, 1),
(15, 5, 'Kazı sonrası dolgu yapılabilir mi?', 'İş kapsamına göre kanal kazısı sonrasında dolgu ve saha düzenleme ihtiyacı aynı plan içinde değerlendirilebilir.', 2, 1),
(16, 6, 'Arsa tesviye fiyatı nasıl belirlenir?', 'Alan büyüklüğü, kot farkı, taşınacak veya getirilecek malzeme, makine süresi ve saha erişimi fiyatı etkiler.', 0, 1),
(17, 6, 'Tesviye ile dolgu aynı işte yapılabilir mi?', 'Saha ihtiyacına göre kazı, dolgu ve yüzey düzenleme aynı çalışma planında ele alınabilir.', 1, 1),
(18, 6, 'Bahçe tesviyesi için büyük kepçe şart mı?', 'Hayır. Makine seçimi alanın büyüklüğü ve erişim koşullarına göre yapılır; dar alanlarda daha küçük ekipman gerekebilir.', 2, 1),
(19, 7, 'Arsa temizleme işinde moloz taşıma da yapılabilir mi?', 'İş kapsamına göre çıkan malzemenin yüklenmesi ve taşınması aynı plan içinde değerlendirilebilir.', 0, 1),
(20, 7, 'Dar bahçelerde hangi makine kullanılır?', 'Makine seçimi kapı/geçiş genişliği, dönüş alanı ve yapılacak işin hacmine göre belirlenir.', 1, 1),
(21, 7, 'Temizlik sonrası tesviye yapılabilir mi?', 'Evet, ihtiyaç varsa yüzey düzeltme, tesviye ve dolgu kalemleri çalışma planına eklenebilir.', 2, 1),
(22, 8, 'Drenaj kazısı için hangi bilgiler gerekir?', 'Hat güzergâhı, yaklaşık uzunluk ve derinlik, saha erişimi ve varsa proje/ölçü bilgileri ön değerlendirme için önemlidir.', 0, 1),
(23, 8, 'Dar alanda özel kazı yapılabilir mi?', 'Uygunluk geçiş ölçülerine ve gerçek makine seçeneklerine bağlıdır; saha bilgileri paylaşıldığında değerlendirilir.', 1, 1),
(24, 8, 'Kazı sonrası dolgu planlanabilir mi?', 'İş kapsamına göre dolgu ve yüzey düzenleme çalışmaları kazı sürecine eklenebilir.', 2, 1),
(25, 9, 'Havuz kazısı için mini kepçe kullanılabilir mi?', 'Uygunluk havuz ölçüsü, kazı derinliği, zemin ve bahçe erişimine bağlıdır. Dar alanlarda mini kepçe seçeneği değerlendirilebilir.', 0, 1),
(26, 9, 'Havuz kazısından çıkan toprak taşınır mı?', 'İş kapsamına göre çıkan malzemenin yüklenmesi ve taşınması ayrıca planlanabilir.', 1, 1),
(27, 9, 'Teklif için proje çizimi gerekli mi?', 'Proje veya ölçü bilgisi teklifin doğruluğunu artırır; yoksa yaklaşık ölçü ve saha fotoğraflarıyla ön değerlendirme yapılabilir.', 2, 1),
(28, 10, 'Arsa içi yol açma fiyatı neye göre belirlenir?', 'Yol uzunluğu ve genişliği, zemin, eğim, kazı-dolgu miktarı, malzeme ve makine süresi fiyatı etkiler.', 0, 1),
(29, 10, 'Yol açma işinde dolgu da yapılabilir mi?', 'İhtiyaca göre dolgu malzemesi serimi ve yüzey düzenleme aynı çalışma planında ele alınabilir.', 1, 1),
(30, 10, 'Şantiye girişi için hangi bilgiler gerekir?', 'Giriş konumu, genişlik, yaklaşık güzergâh, eğim ve saha fotoğrafları ön değerlendirme için faydalıdır.', 2, 1),
(31, 11, 'Serme ve sıkıştırma fiyatı nasıl belirlenir?', 'Alan büyüklüğü, malzeme türü ve miktarı, serim kalınlığı, makine süresi ve saha erişimi fiyatı etkiler.', 0, 1),
(32, 11, 'Kazı sonrası dolgu yapılabilir mi?', 'Evet, iş kapsamına göre kazı sonrası dolgu, serme ve yüzey düzenleme aynı plan içinde yürütülebilir.', 1, 1),
(33, 11, 'Malzeme temini teklifin içinde olabilir mi?', 'Malzeme ihtiyacı ve temin koşulları işin konumuna göre ayrıca değerlendirilir.', 2, 1),
(34, 12, 'Yıkım sonrası moloz yükleme yapılabilir mi?', 'İş kapsamına göre molozun kepçe ile yüklenmesi ve taşıma planı birlikte değerlendirilebilir.', 0, 1),
(35, 12, 'Dar site veya bahçe alanında çalışma mümkün mü?', 'Uygunluk giriş genişliği ve hareket alanına bağlıdır; saha fotoğraflarıyla ön değerlendirme yapılabilir.', 1, 1),
(36, 12, 'Temizlik sonrası tesviye yapılabilir mi?', 'Evet, moloz kaldırıldıktan sonra ihtiyaç varsa yüzey düzenleme ve tesviye ayrıca planlanabilir.', 2, 1),
(37, 13, 'Lastikli kepçe hangi işlerde daha uygundur?', 'Yol, altyapı, sert zeminli saha, yükleme ve sık yer değişimi gereken işlerde lastikli makine seçeneği değerlendirilebilir.', 0, 1),
(38, 13, 'Lastikli kepçe fiyatı nasıl belirlenir?', 'Makine sınıfı, çalışma süresi, saha konumu, zemin, ataşman ve nakliye ihtiyacı fiyatı belirler.', 1, 1),
(39, 13, 'Çok ağır tonajlı makine mi kullanılıyor?', 'Makine sınıfı işin ihtiyacına göre seçilir; gereksiz ağır makine yerine uygun kapasitede çözüm planlanır.', 2, 1),
(40, 14, 'Kazıcı yükleyici ile hem kazı hem yükleme yapılabilir mi?', 'Evet, makinenin ön ve arka çalışma ekipmanları iş kapsamına göre iki farklı iş kaleminde kullanılabilir.', 0, 1),
(41, 14, 'Hangi ölçekte işler için uygundur?', 'Küçük ve orta ölçekli saha işlerinde, erişim ve zemin koşulları uygunsa verimli bir seçenek olabilir.', 1, 1),
(42, 14, 'Ataşman ihtiyacı nasıl belirlenir?', 'İş türü ve zemin koşullarına göre kullanılacak ekipman teklif öncesinde netleştirilir.', 2, 1),
(43, 15, 'Forklift fiyatı neye göre belirlenir?', 'Çalışma süresi, yük ağırlığı, kaldırma yüksekliği, saha konumu ve makinenin nakliye ihtiyacı fiyatı etkiler.', 0, 1),
(44, 15, 'Açık şantiyede forklift kullanılabilir mi?', 'Zemin ve makine tipi uygun olduğunda açık saha çalışması planlanabilir.', 1, 1),
(45, 15, 'Kamyondan malzeme indirme yapılabilir mi?', 'Yük ağırlığı ve saha erişimi uygun olduğunda indirme-bindirme işi planlanabilir.', 2, 1),
(46, 16, 'Traktörle hangi malzemeler taşınabilir?', 'Taşınabilecek malzeme miktarı ve türü römork, arazi ve güvenli çalışma koşullarına göre belirlenir.', 0, 1),
(47, 16, 'Kepçe işiyle birlikte traktör desteği alınabilir mi?', 'İşin kapsamı uygunsa saha içi taşıma desteği aynı çalışma planına dahil edilebilir.', 1, 1),
(48, 16, 'Hangi traktör modeli kullanılıyor?', 'Model ve güç sınıfı teklif öncesinde mevcut yerli üretim makineye göre teyit edilir.', 2, 1);

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
(1, 'Zoomlion ZE35GU Mini Ekskavatör', 'zoomlion-ze35gu-mini-ekskavator', 'Zoomlion ZE35GU', 'Dar alan kazısı, kanal, bahçe ve saha düzenleme', '', 'Mini ekskavatör • Dar alan çalışmaları • Kanal ve tesviye işleri', '<p>Netvera Hafriyat saha arşivindeki gerçek makine görsellerinde görülen Zoomlion ZE35GU mini ekskavatör; dar alan, kanal, bahçe ve saha düzenleme çalışmalarında kullanılmaktadır. Teknik kapasite ve ataşman bilgileri iş öncesinde mevcut konfigürasyona göre teyit edilir.</p>', 'makine/zoomlion-ze35gu-mini-ekskavator-alanya.webp', NULL, 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'Mitsubishi Canter Hafriyat Kamyonu', 'mitsubishi-canter-hafriyat-kamyonu', 'Mitsubishi Canter', 'Toprak, moloz ve hafriyat taşıma', '', 'Hafriyat taşıma • Moloz taşıma • Saha lojistiği', '<p>Mitsubishi Canter kamyon; hafriyat toprağı, moloz ve saha lojistiği ihtiyaçlarında çalışma planına göre değerlendirilir. Taşıma kapasitesi ve sefer planı işin kapsamına göre netleştirilir.</p>', 'makine/mitsubishi-canter-hafriyat-kamyonu-alanya.webp', NULL, 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'Orta Sınıf Lastikli Ekskavatör', 'orta-sinif-lastikli-ekskavator', 'Lastikli Ekskavatör', 'Yol, altyapı, kanal, yükleme ve şehir içi saha işleri', 'Kova • İşe göre ataşman', 'Lastikli ekskavatör • Şehir içi hareket kabiliyeti • Kazı ve yükleme', '<p>Çok ağır tonaj gerektirmeyen yol, altyapı, kanal ve yükleme işlerinde orta sınıf lastikli ekskavatör seçeneği değerlendirilir. Model ve teknik kapasite, iş öncesinde mevcut makineye göre teyit edilir.</p>', 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', NULL, 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'Kazıcı Yükleyici (Beko Loder)', 'kazici-yukleyici-beko-loder', 'Kazıcı Yükleyici', 'Kazı, yükleme, kanal, dolgu ve saha temizliği', 'Ön yükleyici kova • Arka kazıcı', 'Kazı ve yükleme • Kanal işleri • Çok amaçlı saha kullanımı', '<p>Kazıcı yükleyici; kazı ve yükleme fonksiyonlarının aynı makinede gerektiği küçük ve orta ölçekli saha çalışmalarında kullanılır. Marka, model ve ataşman bilgisi iş öncesinde mevcut makineye göre teyit edilir.</p>', 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', NULL, 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'Tümosan Traktör', 'tumosan-traktor', 'Tümosan', 'Bahçe, arazi, römorklu taşıma ve saha lojistiği', 'Römork • İşe göre yardımcı ekipman', 'Yerli üretim traktör • Arazi desteği • Römorklu taşıma', '<p>Yerli üretim Tümosan traktör; bahçe, arazi ve saha içi yardımcı taşıma işlerinde çalışma planına göre kullanılabilir. Model, güç ve ekipman bilgisi teklif öncesinde mevcut makineye göre teyit edilir.</p>', 'https://www.tumosan.com.tr/uploads/2023/08/2013-yerli-105-beygir-traktor-uretimi_op.webp', NULL, 4, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'Dizel Forklift', 'dizel-forklift', 'Dizel Forklift', 'Paletli yük, yapı malzemesi ve saha içi indirme-bindirme', 'Standart çatal', 'Paletli yük taşıma • İndirme-bindirme • Saha lojistiği', '<p>Dizel forklift; yapı malzemesi, palet ve saha içi yüklerin taşınması ile kamyon indirme-bindirme işlerinde değerlendirilir. Kaldırma kapasitesi ve yükseklik bilgisi iş öncesinde mevcut makineye göre teyit edilir.</p>', 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp', NULL, 5, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Mini Kepçe ile Kanal Kazısı', 'alanya-mini-kepce-kanal-kazisi', 'Alanya', 'Mini Kepçe / Kanal Kazısı', 'Dar alanda mini kepçe ile kanal açma ve saha düzenleme çalışması.', '<p>Dar alanda mini kepçe ile kanal açma ve saha düzenleme çalışması. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'projeler/alanya-mini-kepce-kanal-kazisi.webp', NULL, NULL, NULL, 'Saha arşivi', 'Mini Kepçe ile Kanal Kazısı | Alanya Hafriyat | Netvera Hafriyat', 'Dar alanda mini kepçe ile kanal açma ve saha düzenleme çalışması. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'Dar Alanda Tesviye ve Saha Düzenleme', 'alanya-dar-alan-tesviye', 'Alanya', 'Arsa Tesviye', 'Yapı çevresinde mini kepçe ile toprak tesviyesi ve çalışma alanı düzenleme.', '<p>Yapı çevresinde mini kepçe ile toprak tesviyesi ve çalışma alanı düzenleme. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'projeler/alanya-dar-alan-tesviye.webp', NULL, NULL, NULL, 'Saha arşivi', 'Dar Alanda Tesviye ve Saha Düzenleme | Alanya Hafriyat | Netvera Hafriyat', 'Yapı çevresinde mini kepçe ile toprak tesviyesi ve çalışma alanı düzenleme. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'Moloz ve Hafriyat Taşıma', 'alanya-moloz-hafriyat-tasima', 'Alanya', 'Moloz ve Hafriyat Taşıma', 'Saha çalışması sonrası moloz ve hafriyatın yüklenmesi ve taşınması.', '<p>Saha çalışması sonrası moloz ve hafriyatın yüklenmesi ve taşınması. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'hizmetler/alanya-moloz-hafriyat-tasima.webp', NULL, NULL, NULL, 'Saha arşivi', 'Moloz ve Hafriyat Taşıma | Alanya Hafriyat | Netvera Hafriyat', 'Saha çalışması sonrası moloz ve hafriyatın yüklenmesi ve taşınması. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'Arsa Kazısı ve Tesviye', 'alanya-arsa-kazisi-tesviye', 'Alanya', 'Kazı ve Tesviye', 'Açık arazide kazı, yüzey düzeltme ve saha hazırlığı.', '<p>Açık arazide kazı, yüzey düzeltme ve saha hazırlığı. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'hizmetler/alanya-arsa-tesviye-dolgu.webp', NULL, NULL, NULL, 'Saha arşivi', 'Arsa Kazısı ve Tesviye | Alanya Hafriyat | Netvera Hafriyat', 'Açık arazide kazı, yüzey düzeltme ve saha hazırlığı. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'Bahçe ve Arsa Temizleme', 'alanya-bahce-arsa-temizleme', 'Alanya', 'Arsa Temizleme', 'Bahçe ve yapı çevresinde kök, toprak ve alan temizliği.', '<p>Bahçe ve yapı çevresinde kök, toprak ve alan temizliği. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'projeler/alanya-bahce-arsa-temizleme.jpg', NULL, NULL, NULL, 'Saha arşivi', 'Bahçe ve Arsa Temizleme | Alanya Hafriyat | Netvera Hafriyat', 'Bahçe ve yapı çevresinde kök, toprak ve alan temizliği. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'Yıkım Sonrası Saha Temizliği', 'alanya-yikim-sonrasi-saha-temizligi', 'Alanya', 'Yıkım Sonrası Temizlik', 'Yıkım ve tadilat sonrası moloz toplama ve saha temizliği.', '<p>Yıkım ve tadilat sonrası moloz toplama ve saha temizliği. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'projeler/alanya-yikim-sonrasi-saha-temizligi.jpg', NULL, NULL, NULL, 'Saha arşivi', 'Yıkım Sonrası Saha Temizliği | Alanya Hafriyat | Netvera Hafriyat', 'Yıkım ve tadilat sonrası moloz toplama ve saha temizliği. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'Sera Alanında Mini Kepçe Temizliği', 'alanya-sera-mini-kepce-temizligi', 'Alanya', 'Saha Temizliği', 'Sera içinde bitki ve kök temizliği, kazı ve malzeme yükleme çalışması.', '<p>Sera içinde bitki ve kök temizliği, kazı ve malzeme yükleme çalışması. Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>', 'projeler/alanya-sera-saha-temizligi.jpg', NULL, NULL, NULL, 'Saha arşivi', 'Sera Alanında Mini Kepçe Temizliği | Alanya Hafriyat | Netvera Hafriyat', 'Sera içinde bitki ve kök temizliği, kazı ve malzeme yükleme çalışması. Alanya hafriyat ve mini kepçe saha çalışması.', 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Zoomlion Mini Ekskavatör', 'galeri/alanya-zoomlion-mini-ekskavator.webp', NULL, 'Makine Parkuru', 'Alanya Zoomlion ZE35GU mini ekskavatör saha görünümü', 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'Kanal Hafriyatı Mini Kepçe', 'galeri/alanya-kanal-hafriyat-mini-kepce.webp', NULL, 'Kanal Kazısı', 'Alanya mini kepçe kanal ve hafriyat çalışması', 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'Dar Alanda Mini Kepçe Tesviye', 'galeri/alanya-dar-alan-mini-kepce-tesviye.webp', NULL, 'Mini Kepçe', 'Alanya dar alanda mini kepçe ile tesviye çalışması', 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'Hafriyat Kamyonu Saha Çalışması', 'galeri/alanya-hafriyat-kamyonu-saha.webp', NULL, 'Hafriyat Taşıma', 'Alanya hafriyat kamyonu saha çalışması', 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'Dolgu ve Kamyon Çalışması', 'galeri/alanya-hafriyat-dolgu-kamyon.webp', NULL, 'Dolgu ve Tesviye', 'Alanya dolgu ve hafriyat kamyon çalışması', 4, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'Moloz ve Hafriyat Taşıma', 'hizmetler/alanya-moloz-hafriyat-tasima.webp', NULL, 'Moloz Taşıma', 'Alanya moloz ve hafriyat taşıma çalışması', 5, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'Mini Kepçe ile Kanal Kazısı', 'projeler/alanya-mini-kepce-kanal-kazisi.webp', NULL, 'Kanal Kazısı', 'Alanya mini kepçe ile kanal kazısı çalışması', 6, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(8, 'Arsa Tesviye ve Dolgu', 'hizmetler/alanya-arsa-tesviye-dolgu.webp', NULL, 'Arsa Tesviye', 'Alanya arsa tesviye ve dolgu saha çalışması', 7, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(9, 'Malzeme Yükleme ve Saha Lojistiği', 'galeri/alanya-malzeme-yukleme-saha-lojistigi.jpg', NULL, 'Saha Lojistiği', 'Alanya saha lojistiği ve malzeme yükleme çalışması', 8, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(10, 'Hafriyat Toprağı Taşıma', 'galeri/alanya-hafriyat-toprak-tasima.jpg', NULL, 'Hafriyat Taşıma', 'Alanya hafriyat toprağı taşıma kamyonu', 9, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(11, 'Bahçe ve Arsa Temizleme', 'galeri/alanya-bahce-arsa-temizleme.jpg', NULL, 'Arsa Temizleme', 'Alanya mini kepçe bahçe ve arsa temizleme', 10, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(12, 'Sera Alanında Kök ve Bitki Temizliği', 'galeri/alanya-sera-alani-temizleme-1.jpg', NULL, 'Saha Temizliği', 'Alanya sera alanında mini kepçe ile kök temizliği', 11, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(13, 'Yıkım Sonrası Saha Temizliği', 'galeri/alanya-yikim-moloz-temizleme.jpg', NULL, 'Yıkım Sonrası Temizlik', 'Alanya yıkım sonrası mini kepçe ile moloz temizleme', 12, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(14, 'Arsa Kazısı ve Tesviye', 'galeri/alanya-arsa-kazisi-tesviye.jpg', NULL, 'Arsa Tesviye', 'Alanya arsa kazısı ve tesviye çalışması', 13, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(15, 'Sera İçinde Mini Kepçe Çalışması', 'galeri/alanya-sera-mini-kepce-calismasi.jpg', NULL, 'Saha Temizliği', 'Alanya sera içinde mini kepçe saha çalışması', 14, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(16, 'Sera Hafriyat Yükleme', 'galeri/alanya-sera-hafriyat-tasima.jpg', NULL, 'Hafriyat Taşıma', 'Alanya sera alanı hafriyat yükleme ve taşıma', 15, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Kepçe Kiralama', 'kepce-kiralama', 'Alanya’da kepçe ve mini kepçe seçimi, kiralama süreci ve fiyat faktörleri.', 'Alanya Kepçe Kiralama Rehberi | Netvera Hafriyat', 'Kepçe ve mini kepçe kiralama öncesi makine seçimi, saha erişimi, çalışma süresi ve fiyat faktörlerini öğrenin.', 0, 1),
(2, 'Hafriyat ve Kazı', 'hafriyat-kazi', 'Temel, kanal, moloz, tesviye ve hafriyat işlerinin planlama rehberleri.', 'Alanya Hafriyat ve Kazı Rehberi | Netvera Hafriyat', 'Alanya’da hafriyat, temel kazısı, kanal, moloz taşıma ve arsa tesviye işleri için karar rehberleri.', 1, 1),
(3, 'Saha Rehberi', 'saha-rehberi', 'İş başlamadan önce erişim, zemin, ölçü ve saha hazırlığı hakkında pratik bilgiler.', 'Hafriyat Saha Rehberi | Netvera Hafriyat', 'Kazı ve hafriyat işi öncesinde saha erişimi, zemin, makine seçimi ve teklif için gerekli bilgileri öğrenin.', 2, 1);

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
(1, 1, 'Alanya’da Kepçe Kiralama Fiyatları Nasıl Hesaplanır?', 'alanyada-kepce-kiralama-fiyatlari-nasil-hesaplanir', 'Alanya’da kepçe kiralama fiyatını çalışma süresi, makine tipi, nakliye, zemin, saha erişimi ve hafriyat taşıma ihtiyacı birlikte belirler.', '## Alanya’da kepçe kiralama fiyatını ne belirler?\n\nKepçe kiralama için tek bir doğru fiyat yoktur. Aynı şehirde iki işin maliyeti; çalışma süresi, kullanılacak makine, zeminin durumu ve nakliye ihtiyacı nedeniyle farklı olabilir. Bu yüzden doğru yaklaşım, önce işin kapsamını netleştirip sonra teklif oluşturmaktır.\n\n### 1. Çalışma süresi\n\nKazı, yükleme veya tesviye işinin tahmini süresi toplam maliyetin ana kalemlerinden biridir. Kısa bir yükleme işi ile gün boyu sürecek temel kazısı aynı şekilde fiyatlanmaz.\n\n### 2. Makine tipi\n\nDar alan için mini kepçe gerekirken daha geniş ve yüksek hacimli işler farklı kapasitede makine gerektirebilir. Gereğinden büyük makine seçmek de, yetersiz makineyle çalışmak da verimsiz olabilir.\n\n### 3. Makinenin sahaya nakli\n\nMakinenin çalışma alanına nasıl ulaştırılacağı, mesafe ve taşıma ihtiyacı teklifte dikkate alınır.\n\n### 4. Zemin ve ataşman ihtiyacı\n\nSert zemin, taşlı alan veya kırıcı gerektiren işler standart kazıdan farklı planlanır.\n\n### 5. Çıkan hafriyatın taşınması\n\nKazıdan çıkan toprak veya moloz sahada kalmayacaksa yükleme ve taşıma ayrıca planlanır.\n\n### 6. Saha erişimi\n\nDar kapı, düşük geçiş, eğimli arazi veya sınırlı dönüş alanı makine seçimini doğrudan etkileyebilir.\n\n## Daha doğru teklif için ne göndermelisiniz?\n\nKonum, yapılacak işin kısa tarifi, yaklaşık ölçü veya alan, giriş genişliği ve birkaç saha fotoğrafı ilk değerlendirmeyi hızlandırır. Böylece yalnız "saatlik fiyat" yerine gerçek işinize göre daha anlamlı bir teklif hazırlanabilir.', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp', 'Alanya kepçe kiralama ve hafriyat saha çalışması', 'Alanya’da Kepçe Kiralama Fiyatları Nasıl Hesaplanır?', 'Netvera Hafriyat', 'alanya kepçe kiralama fiyatları', 'Alanya Kepçe Kiralama Fiyatları Nasıl Hesaplanır? | Netvera Hafriyat', 'Alanya kepçe kiralama fiyatını etkileyen makine, süre, nakliye, zemin, ataşman, saha erişimi ve hafriyat taşıma kalemlerini öğrenin.', NULL, 'Alanya Kepçe Kiralama Fiyatları Nasıl Hesaplanır? | Netvera Hafriyat', 'Alanya kepçe kiralama fiyatını etkileyen makine, süre, nakliye, zemin, ataşman, saha erişimi ve hafriyat taşıma kalemlerini öğrenin.', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp', 'Alanya Kepçe Kiralama Fiyatları Nasıl Hesaplanır? | Netvera Hafriyat', 'Alanya kepçe kiralama fiyatını etkileyen makine, süre, nakliye, zemin, ataşman, saha erişimi ve hafriyat taşıma kalemlerini öğrenin.', 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp', 1, 1, 'BlogPosting', 1, NULL, '[{"question":"Kepçe kiralama için sabit saatlik fiyat var mı?","answer":"Fiyat; makine, süre, nakliye, saha ve iş kapsamına göre değişebildiği için tek bir sabit rakam her iş için doğru olmaz."},{"question":"Fotoğraf göndererek ön teklif alınabilir mi?","answer":"Konum, ölçü ve saha fotoğrafları ön değerlendirmeyi kolaylaştırır; bazı işlerde kesin plan için yerinde inceleme gerekebilir."}]', 0, NULL, 2, 'published', '2026-10-06 16:39:13', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 1, 'Mini Kepçe mi Büyük Kepçe mi? Alanya’daki İşiniz İçin Hangisi Uygun?', 'mini-kepce-mi-buyuk-kepce-mi-alanya', 'Dar bahçe, küçük kanal ve hassas kazılarda mini kepçe; daha yüksek hacimli ve geniş sahalarda farklı makine seçenekleri değerlendirilebilir.', '## Mini kepçe ne zaman daha mantıklıdır?\n\nMini kepçe; dar bahçe girişleri, bina çevreleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve kontrollü çalışma gereken alanlarda avantaj sağlayabilir. Ancak "mini" olması her iş için yeterli olduğu anlamına gelmez.\n\n### Giriş ve dönüş alanı\n\nMakinenin sahaya girebilmesi için yalnız kapı genişliği değil, içeride dönüş yapabileceği alan da önemlidir. Gerçek makine ölçüsü doğrulanmadan kesin uygunluk söylenmemelidir.\n\n### Kazı derinliği ve hacmi\n\nKüçük bir kanal ile yüksek hacimli temel kazısının makine ihtiyacı aynı değildir. Kazı derinliği, genişliği ve çıkarılacak malzeme miktarı seçimi etkiler.\n\n### Zemin yapısı\n\nYumuşak toprak, sıkışmış dolgu, taşlı zemin veya kırıcı ihtiyacı farklı ekipman gerektirebilir.\n\n### Çıkan malzemenin taşınması\n\nMini kepçeyle kazı yapılırken çıkan toprağın kamyona yüklenmesi veya sahada başka bir noktaya alınması gerekiyorsa bu akış da baştan planlanmalıdır.\n\n## Hangi bilgileri paylaşmalısınız?\n\nİşin konumu, kapı/geçiş ölçüsü, yaklaşık kazı ölçüsü, zeminle ilgili bilinenler ve fotoğraflar doğru makineyi seçmek için iyi bir başlangıçtır.', 'hizmetler/alanya-mini-kepce-kiralama.webp', 'Alanya mini kepçe ile dar alan saha çalışması', 'Mini Kepçe mi Büyük Kepçe mi? Alanya’daki İşiniz İçin Hangisi Uygun?', 'Netvera Hafriyat', 'alanya mini kepçe', 'Mini Kepçe mi Büyük Kepçe mi? Alanya İçin Makine Seçimi', 'Alanya’da mini kepçe ile daha büyük kepçe arasında seçim yaparken giriş genişliği, kazı hacmi, zemin ve çalışma alanında nelere bakılır?', NULL, 'Mini Kepçe mi Büyük Kepçe mi? Alanya İçin Makine Seçimi', 'Alanya’da mini kepçe ile daha büyük kepçe arasında seçim yaparken giriş genişliği, kazı hacmi, zemin ve çalışma alanında nelere bakılır?', 'hizmetler/alanya-mini-kepce-kiralama.webp', 'Mini Kepçe mi Büyük Kepçe mi? Alanya İçin Makine Seçimi', 'Alanya’da mini kepçe ile daha büyük kepçe arasında seçim yaparken giriş genişliği, kazı hacmi, zemin ve çalışma alanında nelere bakılır?', 'hizmetler/alanya-mini-kepce-kiralama.webp', 1, 1, 'BlogPosting', 2, NULL, '[{"question":"Mini kepçe bahçe kapısından geçer mi?","answer":"Bu, kapının gerçek genişliğine ve kullanılacak makinenin doğrulanmış ölçülerine bağlıdır. Ölçü ve fotoğraf paylaşılması gerekir."},{"question":"Mini kepçe temel kazısında kullanılabilir mi?","answer":"Küçük ölçekli işlerde kullanılabilir; uygunluk kazı hacmi, derinlik, zemin ve süreye göre değerlendirilir."}]', 0, NULL, 2, 'published', '2026-10-02 16:39:13', '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 2, 'Temel Kazısı Öncesi Nelere Bakılır?', 'temel-kazisi-oncesi-nelere-bakilir', 'Temel kazısından önce proje ölçüsü kadar saha erişimi, zemin, kazı derinliği, çıkan malzeme ve taşıma planı da netleştirilmelidir.', '## Temel kazısında ilk soru yalnız "kaç metre kazılacak?" değildir\n\nSağlıklı bir temel kazısı planı; proje ölçüsü, zemin, makine erişimi ve çıkan malzemenin yönetimini birlikte ele alır. İş başlamadan önce bu başlıkların netleştirilmesi gereksiz beklemeyi ve yanlış makine seçimini azaltır.\n\n### Proje ve kazı ölçüleri\n\nKazının sınırları, derinliği ve çalışma payı mümkün olduğunca net olmalıdır. Uygulama teknik projeye bağlıysa saha çalışması ilgili ölçülere göre yürütülmelidir.\n\n### Makinenin sahaya erişimi\n\nKapı, yol genişliği, eğim, dönüş alanı ve çevredeki mevcut yapılar makinenin seçimini etkiler.\n\n### Zemin yapısı\n\nToprak, dolgu, taşlı veya sert zemin çalışma süresini ve ataşman ihtiyacını değiştirebilir.\n\n### Çıkan malzeme ne olacak?\n\nKazı toprağı sahada dolgu için kullanılacak mı, stoklanacak mı, yoksa taşınacak mı? Bu karar yükleme ve kamyon planını doğrudan etkiler.\n\n### Kazı sonrası tesviye ve dolgu\n\nTemel çevresi veya saha içinde daha sonra dolgu ve seviye düzenlemesi gerekecekse iş sırası en baştan buna göre planlanabilir.\n\n## Teklif isterken paylaşılabilecek bilgiler\n\nKonum, proje/ölçü bilgisi, saha fotoğrafları, giriş durumu ve çıkan malzemeyle ilgili beklenti doğru ön değerlendirme için en yararlı bilgilerdir.', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp', 'Temel kazısı yapılan yapı şantiyesinde ekskavatör', 'Temel Kazısı Öncesi Nelere Bakılır?', 'Netvera Hafriyat', 'alanya temel kazısı', 'Alanya Temel Kazısı Öncesi Nelere Bakılır? | Netvera Hafriyat', 'Temel kazısı öncesinde kazı ölçüsü, zemin, saha erişimi, makine seçimi, hafriyat taşıma ve dolgu planında kontrol edilmesi gerekenler.', NULL, 'Alanya Temel Kazısı Öncesi Nelere Bakılır? | Netvera Hafriyat', 'Temel kazısı öncesinde kazı ölçüsü, zemin, saha erişimi, makine seçimi, hafriyat taşıma ve dolgu planında kontrol edilmesi gerekenler.', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp', 'Alanya Temel Kazısı Öncesi Nelere Bakılır? | Netvera Hafriyat', 'Temel kazısı öncesinde kazı ölçüsü, zemin, saha erişimi, makine seçimi, hafriyat taşıma ve dolgu planında kontrol edilmesi gerekenler.', 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp', 1, 1, 'BlogPosting', 3, NULL, '[{"question":"Temel kazısı için hangi makine gerekir?","answer":"Makine seçimi kazı hacmi, derinlik, zemin ve saha erişimine göre yapılır."},{"question":"Kazı toprağı taşınmak zorunda mı?","answer":"Hayır. Proje ve saha uygunsa bir kısmı dolgu veya tesviye için değerlendirilebilir; taşınacak kısım ayrıca planlanır."}]', 0, NULL, 2, 'published', '2026-09-28 16:39:13', '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Alanya’da kepçe kiralama fiyatları nasıl belirlenir?', 'Fiyat; çalışma süresi, kullanılacak makine, saha erişimi, nakliye, zemin, ataşman ihtiyacı ve çıkan hafriyatın taşınıp taşınmayacağı gibi iş kalemlerine göre belirlenir.', 0, 1),
(2, 'Mini kepçe hangi işler için uygundur?', 'Mini kepçe; dar bahçe girişleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve büyük makinelerin erişemediği alanlarda değerlendirilebilir. Uygunluk gerçek geçiş ölçüsüne göre belirlenir.', 1, 1),
(3, 'Hafriyat ve moloz taşıma birlikte yapılabilir mi?', 'İşin kapsamına göre kazı, yükleme ve taşıma aynı çalışma planında değerlendirilebilir. Malzeme miktarı ve saha giriş-çıkış koşulları teklif aşamasında dikkate alınır.', 2, 1),
(4, 'Hangi bölgelere hizmet veriyorsunuz?', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez, Cikcilli, Çıplaklı, Payallar, Konaklı, Avsallar ve planlamaya uygun çevre bölgeler için talep oluşturabilirsiniz.', 3, 1),
(5, 'Teklif almak için hangi bilgileri paylaşmalıyım?', 'İşin konumu, yapılacak çalışma, yaklaşık ölçü veya alan, saha giriş durumu ve varsa fotoğraflar ön değerlendirmeyi hızlandırır.', 4, 1),
(6, 'Saatlik veya günlük çalışma yapılabilir mi?', 'Çalışma modeli işin türü, makine ihtiyacı ve saha koşullarına göre belirlenir. Uygunluk ve fiyat için iş detaylarını paylaşabilirsiniz.', 5, 1);

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
(1, 'Ücretsiz Keşif ve Teklif!', 'Hafriyat, kepçe kiralama ve moloz taşıma işleriniz için hemen WhatsApp’tan ücretsiz teklif alın.', 'popup/alanya-hafriyat-teklif-saha.webp', 'WhatsApp’tan Teklif Al', 'Merhaba, ücretsiz keşif ve teklif almak istiyorum.', 'whatsapp', 0, 5, 24, 'home', 1, '0.6', '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, NULL, 'Netvera Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye ihtiyaçlarına yönelik saha çözümleri sunar.', '© 2026 Netvera Hafriyat. Tüm hakları saklıdır.', 'Hizmetlerimiz', '[{"title":"Kepçe Kiralama","url":"\\/hizmetler\\/kepce-kiralama"},{"title":"Mini Kepçe Kiralama","url":"\\/hizmetler\\/mini-kepce-kiralama"},{"title":"Temel Kazısı","url":"\\/hizmetler\\/temel-kazisi"},{"title":"Moloz Taşıma","url":"\\/hizmetler\\/moloz-hafriyat-nakliye"},{"title":"Kanal Kazısı","url":"\\/hizmetler\\/alt-yapi-kanal-acma"}]', 'Hızlı Linkler', '[{"title":"Ana Sayfa","url":"\\/"},{"title":"Hakkımızda","url":"\\/hakkimizda"},{"title":"Hizmetlerimiz","url":"\\/hizmetler"},{"title":"Projelerimiz","url":"\\/projeler"},{"title":"Blog","url":"\\/blog"},{"title":"İletişim","url":"\\/iletisim"}]', 'Hizmet Bölgeleri', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Cikcilli, Çıplaklı, Alanya Merkez, Konaklı, Payallar ve Avsallar', NULL, NULL, '#111111', '#CBD5E1', '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'whatsapp', '#', 'whatsapp', 0, 1),
(2, 'instagram', '#', 'instagram', 1, 0),
(3, 'facebook', '#', 'facebook', 2, 0),
(4, 'youtube', '#', 'youtube', 3, 0);

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
(1, 'Netvera Hafriyat', '905321234567', 'info@netvera.tr', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, 0, 0, 0, 0, 30, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

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
(1, 'Mahmutlar', 'mahmutlar', 'Antalya', 'Alanya', NULL, 'Mahmutlar ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Mahmutlar Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Mahmutlar bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 0, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(2, 'Kestel', 'kestel', 'Antalya', 'Alanya', NULL, 'Kestel ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Kestel Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Kestel bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 1, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(3, 'Kargıcak', 'kargicak', 'Antalya', 'Alanya', NULL, 'Kargıcak ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Kargıcak Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Kargıcak bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 2, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(4, 'Oba', 'oba', 'Antalya', 'Alanya', NULL, 'Oba ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Oba Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Oba bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 3, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(5, 'Tosmur', 'tosmur', 'Antalya', 'Alanya', NULL, 'Tosmur ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Tosmur Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Tosmur bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 4, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(6, 'Alanya Merkez', 'alanya-merkez', 'Antalya', 'Alanya', NULL, 'Alanya Merkez ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Alanya Merkez Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Alanya Merkez bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 5, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(7, 'Cikcilli', 'cikcilli', 'Antalya', 'Alanya', NULL, 'Cikcilli ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Cikcilli Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Cikcilli bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 6, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(8, 'Çıplaklı', 'ciplakli', 'Antalya', 'Alanya', NULL, 'Çıplaklı ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Çıplaklı Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Çıplaklı bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 7, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(9, 'Payallar', 'payallar', 'Antalya', 'Alanya', NULL, 'Payallar ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Payallar Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Payallar bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 8, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(10, 'Konaklı', 'konakli', 'Antalya', 'Alanya', NULL, 'Konaklı ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Konaklı Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Konaklı bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 9, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(11, 'Avsallar', 'avsallar', 'Antalya', 'Alanya', NULL, 'Avsallar ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Avsallar Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Avsallar bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 10, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13'),
(12, 'Gazipaşa', 'gazipasa', 'Antalya', 'Gazipaşa', NULL, 'Gazipaşa ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.', 'Gazipaşa Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat', 'Gazipaşa bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.', 11, 1, '2026-10-06 16:39:13', '2026-10-06 16:39:13');

SET FOREIGN_KEY_CHECKS=1;
