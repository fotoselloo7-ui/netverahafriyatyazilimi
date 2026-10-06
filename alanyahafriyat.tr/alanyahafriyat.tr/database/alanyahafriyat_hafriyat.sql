-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 28 Ağu 2026, 14:21:13
-- Sunucu sürümü: 10.11.14-MariaDB-cll-lve
-- PHP Sürümü: 8.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `alanyahafriyat_hafriyat`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_categories`
--

CREATE TABLE `blog_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `blog_categories`
--

INSERT INTO `blog_categories` (`id`, `title`, `slug`, `description`, `seo_title`, `seo_description`, `sort_order`, `is_active`) VALUES
(1, 'Hafriyat', 'hafriyat', 'Hafriyat kategorisindeki yazılar.', NULL, NULL, 0, 1),
(2, 'Kepçe Kiralama', 'kepce-kiralama', 'Kepçe Kiralama kategorisindeki yazılar.', NULL, NULL, 1, 1),
(3, 'Rehber', 'rehber', 'Rehber kategorisindeki yazılar.', NULL, NULL, 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content_markdown` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `cover_image_alt` varchar(255) DEFAULT NULL,
  `cover_image_title` varchar(255) DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `focus_keyword` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_title` varchar(255) DEFAULT NULL,
  `og_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `twitter_title` varchar(255) DEFAULT NULL,
  `twitter_description` text DEFAULT NULL,
  `twitter_image` varchar(255) DEFAULT NULL,
  `robots_index` tinyint(4) NOT NULL DEFAULT 1,
  `robots_follow` tinyint(4) NOT NULL DEFAULT 1,
  `schema_type` varchar(30) NOT NULL DEFAULT 'BlogPosting',
  `related_service_id` int(11) DEFAULT NULL,
  `related_posts_json` text DEFAULT NULL,
  `faq_json` text DEFAULT NULL,
  `seo_score` int(11) NOT NULL DEFAULT 0,
  `seo_suggestions_json` text DEFAULT NULL,
  `reading_time` int(11) NOT NULL DEFAULT 1,
  `status` varchar(20) NOT NULL DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `category_id`, `title`, `slug`, `excerpt`, `content_markdown`, `cover_image`, `cover_image_alt`, `cover_image_title`, `author_name`, `focus_keyword`, `seo_title`, `seo_description`, `canonical_url`, `og_title`, `og_description`, `og_image`, `twitter_title`, `twitter_description`, `twitter_image`, `robots_index`, `robots_follow`, `schema_type`, `related_service_id`, `related_posts_json`, `faq_json`, `seo_score`, `seo_suggestions_json`, `reading_time`, `status`, `published_at`, `created_at`, `updated_at`) VALUES
(1, 1, 'Alanya’da Kepçe Kiralama Hangi İşlerde Kullanılır?', 'alanyada-kepce-kiralama-hangi-islerde-kullanilir', '## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan a…', '## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan altyapı çalışmalarına kadar geniş bir kullanım alanı vardır.\n\n### Başlıca Kullanım Alanları\n\n- Temel kazısı ve hafriyat\n- Bahçe ve arsa düzenleme\n- Kanal ve altyapı açma\n- Moloz yükleme ve taşıma\n\n### Neden Kepçe Kiralamalı?\n\nİş makinesi satın almak yerine, ihtiyaç duyduğunuz süre boyunca operatörlü kepçe kiralamak çok daha ekonomiktir. Ersan Hafriyat olarak günlük, haftalık ve aylık kiralama seçenekleri sunuyoruz.', NULL, NULL, NULL, 'Ersan Hafriyat', NULL, 'Alanya’da Kepçe Kiralama Hangi İşlerde Kullanılır? | Ersan Hafriyat', '## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan altyap…', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'BlogPosting', NULL, NULL, NULL, 0, NULL, 1, 'published', '2026-07-02 15:34:08', '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 1, 'Hafriyat ve Moloz Taşıma Sürecinde Nelere Dikkat Edilmeli?', 'hafriyat-ve-moloz-tasima-surecinde-nelere-dikkat-edilmeli', '## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken ön…', '## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken önemli noktalar vardır.\n\n### Dikkat Edilmesi Gerekenler\n\n1. **İş güvenliği:** Saha güvenliği önceliklidir.\n2. **Ruhsat ve izinler:** Gerekli belgeler eksiksiz olmalıdır.\n3. **Doğru makine seçimi:** İşin ölçeğine uygun ekipman kullanılmalıdır.\n4. **Çevre duyarlılığı:** Molozlar uygun döküm sahalarına taşınmalıdır.\n\nErsan Hafriyat, tüm bu süreçleri profesyonelce yönetir.', NULL, NULL, NULL, 'Ersan Hafriyat', NULL, 'Hafriyat ve Moloz Taşıma Sürecinde Nelere Dikkat Edilmeli? | Ersan Hafriyat', '## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken önemli …', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'BlogPosting', NULL, NULL, NULL, 0, NULL, 1, 'published', '2026-06-29 15:34:08', '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 1, 'Mahmutlar’da Bahçe, Arsa ve Temel Kazısı İçin Profesyonel Çözüm', 'mahmutlarda-bahce-arsa-ve-temel-kazisi', '## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizme…', '## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizmet veriyoruz.\n\n### Hizmetlerimiz\n\n- Temel kazısı\n- Arsa tesviye ve dolgu\n- Bahçe düzenleme\n- Çevre temizliği\n\nModern makine parkurumuz ve uzman kadromuzla projelerinizi güvenle tamamlıyoruz. Ücretsiz keşif için bizimle iletişime geçin.', NULL, NULL, NULL, 'Ersan Hafriyat', NULL, 'Mahmutlar’da Bahçe, Arsa ve Temel Kazısı İçin Profesyonel Çözüm | Ersan Hafriyat', '## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizmet ver…', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 'BlogPosting', NULL, NULL, NULL, 0, NULL, 1, 'published', '2026-06-26 15:34:08', '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `equipment`
--

CREATE TABLE `equipment` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `brand_model` varchar(255) DEFAULT NULL,
  `usage_area` varchar(255) DEFAULT NULL,
  `attachments` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `gallery_json` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `equipment`
--

INSERT INTO `equipment` (`id`, `title`, `slug`, `brand_model`, `usage_area`, `attachments`, `short_description`, `content`, `image`, `gallery_json`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hidromek 102B', 'hidromek-102b', 'Hidromek 102B', 'Kazıcı Yükleyici', 'Kova, kırıcı, ripper', 'Ağırlık: 20 Ton • Kova Kapasitesi: 1.1 m³ • Güçlü ve Yakıt Tasarruflu', '<p>Hidromek 102B makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'JCB 3CX', 'jcb-3cx', 'JCB 3CX', 'Beko Loder', 'Kova, kırıcı, ripper', 'Yükleyici & Kazıcı • Çok Amaçlı Kullanım • Yüksek Performans', '<p>JCB 3CX makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'Mini Ekskavatör', 'mini-ekskavator', 'Mini Ekskavatör', 'Mini Kepçe', 'Kova, kırıcı, ripper', 'Ağırlık: 3.5 Ton • Dar Alanlarda Yüksek Manevra • Hassas Çalışma', '<p>Mini Ekskavatör makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'Kamyon / Damper', 'kamyon-damper', 'Kamyon / Damper', 'Nakliye', 'Kova, kırıcı, ripper', '6x4 Damper Kamyon • Moloz ve Hafriyat Taşıma • Yüksek Taşıma Kapasitesi', '<p>Kamyon / Damper makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>', NULL, NULL, 3, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `sort_order`, `is_active`) VALUES
(1, 'Kepçe kiralama fiyatları nasıl belirlenir?', 'Kepçe kiralama fiyatları; işin süresi, makine tipi, çalışma bölgesi ve işin kapsamına göre belirlenir. Ücretsiz keşif sonrası net fiyat sunarız.', 0, 1),
(2, 'Hafriyat ve moloz taşıma hizmetiniz var mı?', 'Evet, Alanya ve çevresinde hafriyat ve moloz taşıma hizmeti sunuyoruz. Damperli kamyonlarımızla molozları uygun döküm sahalarına taşıyoruz.', 1, 1),
(3, 'Hizmet verdiğiniz bölgeler nerelerdir?', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez, Cikcilli, Çıplaklı, Payallar, Konaklı, Avsallar ve Gazipaşa bölgelerinde hizmet veriyoruz.', 2, 1),
(4, 'Çalışma saatleriniz nedir?', 'Pazartesi - Cumartesi 08:00 - 18:00 saatleri arasında hizmet veriyoruz. Acil işler için bize ulaşabilirsiniz.', 3, 1),
(5, 'Acil işler için hizmet sağlıyor musunuz?', 'Evet, acil hafriyat ve kepçe ihtiyaçlarınız için hızlı çözümler sunuyoruz. WhatsApp veya telefon ile bize ulaşabilirsiniz.', 4, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `footer_settings`
--

CREATE TABLE `footer_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `copyright_text` varchar(255) DEFAULT NULL,
  `column_1_title` varchar(255) DEFAULT NULL,
  `column_1_links_json` text DEFAULT NULL,
  `column_2_title` varchar(255) DEFAULT NULL,
  `column_2_links_json` text DEFAULT NULL,
  `column_3_title` varchar(255) DEFAULT NULL,
  `column_3_content` text DEFAULT NULL,
  `web_design_credit_text` varchar(255) DEFAULT NULL,
  `web_design_credit_url` varchar(255) DEFAULT NULL,
  `background_color` varchar(20) NOT NULL DEFAULT '#111111',
  `text_color` varchar(20) NOT NULL DEFAULT '#CBD5E1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `footer_settings`
--

INSERT INTO `footer_settings` (`id`, `logo`, `description`, `copyright_text`, `column_1_title`, `column_1_links_json`, `column_2_title`, `column_2_links_json`, `column_3_title`, `column_3_content`, `web_design_credit_text`, `web_design_credit_url`, `background_color`, `text_color`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, moloz taşıma ve çevre düzenleme hizmetleri sunuyoruz.', '© 2026 Ersan Hafriyat. Tüm hakları saklıdır.', 'Hizmetlerimiz', '[{\"title\":\"Alanya Hafriyat Hizmeti\",\"url\":\"\\/hizmetler\\/alanya-hafriyat-hizmeti\"},{\"title\":\"Kepçe Kiralama\",\"url\":\"\\/hizmetler\\/kepce-kiralama\"},{\"title\":\"Temel Kazısı\",\"url\":\"\\/hizmetler\\/temel-kazisi\"},{\"title\":\"Alt Yapı ve Kanal Açma\",\"url\":\"\\/hizmetler\\/alt-yapi-kanal-acma\"},{\"title\":\"Arsa Tesviye\",\"url\":\"\\/hizmetler\\/arsa-tesviye-dolgu\"}]', 'Hızlı Linkler', '[{\"title\":\"Ana Sayfa\",\"url\":\"\\/\"},{\"title\":\"Hakkımızda\",\"url\":\"\\/hakkimizda\"},{\"title\":\"Makine Parkuru\",\"url\":\"\\/makine-parkuru\"},{\"title\":\"Projelerimiz\",\"url\":\"\\/projeler\"},{\"title\":\"Galeri\",\"url\":\"\\/galeri\"},{\"title\":\"Blog\",\"url\":\"\\/blog\"}]', 'Hizmet Bölgeleri', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez ve çevresi', NULL, NULL, '#111111', '#CBD5E1', '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `gallery`
--

CREATE TABLE `gallery` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `video_url` varchar(255) DEFAULT NULL,
  `category` varchar(80) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `gallery`
--

INSERT INTO `gallery` (`id`, `title`, `image`, `video_url`, `category`, `alt_text`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mahmutlar - Temel Kazısı', NULL, NULL, 'Temel Kazısı', 'Mahmutlar - Temel Kazısı', 0, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Kestel - Arsa Tesviye', NULL, NULL, 'Arsa Tesviye', 'Kestel - Arsa Tesviye', 1, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Oba - Kanal Açma', NULL, NULL, 'Altyapı', 'Oba - Kanal Açma', 2, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(4, 'Tosmur - Moloz Taşıma', NULL, NULL, 'Moloz Taşıma', 'Tosmur - Moloz Taşıma', 3, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(5, 'Kargıcak - Bahçe Düzenleme', NULL, NULL, 'Bahçe Düzenleme', 'Kargıcak - Bahçe Düzenleme', 4, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(6, 'Avsallar - Villa Hafriyatı', NULL, NULL, 'Hafriyat', 'Avsallar - Villa Hafriyatı', 5, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `home_sections`
--

CREATE TABLE `home_sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_key` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `content_json` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `cta_text` varchar(255) DEFAULT NULL,
  `cta_url` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `home_sections`
--

INSERT INTO `home_sections` (`id`, `section_key`, `title`, `subtitle`, `content_json`, `image`, `cta_text`, `cta_url`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'hero', 'Alanya ve Mahmutlar’da Profesyonel Hafriyat & Kepçe Hizmetleri', 'Temel kazısı, moloz taşıma, bahçe düzenleme, kanal açma ve kepçe kiralama hizmetlerimizle projelerinizi güvenli, hızlı ve ekonomik şekilde tamamlıyoruz.', '{\"button_1_text\":\"WhatsApp’tan Teklif Al\",\"button_1_url\":\"Merhaba, hafriyat\\/kepçe hizmeti için teklif almak istiyorum.\",\"button_1_type\":\"whatsapp\",\"button_2_text\":\"Hizmetleri İncele\",\"button_2_url\":\"\\/hizmetler\",\"button_2_type\":\"internal\",\"overlay_opacity\":\"0.55\",\"show_form\":\"1\",\"show_badges\":\"1\",\"badges\":[{\"icon\":\"zap\",\"title\":\"Hızlı Dönüş\",\"text\":\"Talebinize anında çözüm sunuyoruz.\"},{\"icon\":\"users\",\"title\":\"Deneyimli Ekip\",\"text\":\"Alanında uzman ve tecrübeli kadro.\"},{\"icon\":\"truck\",\"title\":\"Modern Makine\",\"text\":\"Güçlü ve bakımlı makine parkuru.\"},{\"icon\":\"shield\",\"title\":\"Özenli Çalışma\",\"text\":\"İş güvenliği ve kaliteli önceliğimiz.\"},{\"icon\":\"tag\",\"title\":\"Uygun Fiyat\",\"text\":\"Kaliteli hizmeti uygun fiyatlarla.\"}]}', '', NULL, NULL, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'services', 'Hizmetlerimiz', 'Alanya ve Mahmutlar genelinde sunduğumuz profesyonel hafriyat hizmetleri', NULL, '', NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'equipment', 'Makine Parkurumuz', 'Güçlü, bakımlı ve modern iş makinelerimizle tüm hafriyat işlerinizi güvenle üstleniyoruz.', NULL, '', NULL, NULL, 2, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'process', 'Çalışma Sürecimiz', 'Talepten teslime kadar şeffaf ve planlı bir süreç', '[{\"icon\":\"message-circle\",\"title\":\"Talep Alınır\",\"text\":\"İhtiyacınızı WhatsApp veya telefon ile bize iletirsiniz.\"},{\"icon\":\"search\",\"title\":\"Keşif & Planlama\",\"text\":\"Uzman ekibimiz keşif yapar ve planlama oluşturur.\"},{\"icon\":\"clipboard\",\"title\":\"Makine Planı\",\"text\":\"Uygun makine ve ekip planlaması yapılır.\"},{\"icon\":\"hard-hat\",\"title\":\"Saha Uygulama\",\"text\":\"İş güvenliği ile hızlı ve düzenli şekilde uygulanır.\"},{\"icon\":\"check-circle\",\"title\":\"Teslim & Kontrol\",\"text\":\"İş teslim edilir, kontrol edilir ve onayınız alınır.\"}]', '', NULL, NULL, 3, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(5, 'machine_anim', 'Sahada Güç, İşte Verim', 'Kepçe, kamyon ve deneyimli ekibimizle hafriyat işleriniz planlı, hızlı ve güvenli şekilde ilerler.', NULL, '', NULL, NULL, 4, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(6, 'gallery', 'Çalışmalarımızdan Kareler', 'Sahadaki işlerimizden bazı görüntüler', NULL, '', NULL, NULL, 5, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(7, 'regions', 'Çalışma Bölgelerimiz', 'Hizmet verdiğimiz bölgeler', NULL, '', NULL, NULL, 6, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(8, 'blog', 'Son Yazılarımız', 'Hafriyat ve kepçe kiralama hakkında faydalı içerikler', NULL, '', NULL, NULL, 7, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(9, 'faq', 'Sık Sorulan Sorular', 'Merak edilenler', NULL, '', NULL, NULL, 8, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(10, 'final_cta', 'Hafriyat, Kepçe Kiralama ve Daha Fazlası İçin Yanınızdayız!', 'Hemen bize ulaşın, ücretsiz keşif ve en uygun fiyat teklifini alın.', NULL, '', NULL, NULL, 9, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `leads`
--

CREATE TABLE `leads` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(40) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `source` varchar(40) NOT NULL DEFAULT 'website',
  `status` varchar(20) NOT NULL DEFAULT 'new',
  `admin_note` text DEFAULT NULL,
  `ip_hash` varchar(64) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `license_logs`
--

CREATE TABLE `license_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(40) NOT NULL,
  `status` varchar(40) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `request_url` varchar(255) DEFAULT NULL,
  `response_json` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `media`
--

CREATE TABLE `media` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_type` varchar(60) DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `menus`
--

CREATE TABLE `menus` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `menu_location` varchar(40) NOT NULL DEFAULT 'header',
  `title` varchar(255) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `page_id` int(11) DEFAULT NULL,
  `menu_type` varchar(30) NOT NULL DEFAULT 'internal',
  `icon` varchar(60) DEFAULT NULL,
  `target` varchar(20) NOT NULL DEFAULT '_self',
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `menus`
--

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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification_logs`
--

CREATE TABLE `notification_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(60) DEFAULT NULL,
  `channel` varchar(40) DEFAULT NULL,
  `recipient` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` varchar(40) DEFAULT NULL,
  `provider_response` text DEFAULT NULL,
  `related_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notification_settings`
--

CREATE TABLE `notification_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `owner_name` varchar(255) DEFAULT NULL,
  `owner_phone` varchar(40) DEFAULT NULL,
  `owner_email` varchar(255) DEFAULT NULL,
  `whatsapp_api_enabled` tinyint(4) NOT NULL DEFAULT 0,
  `whatsapp_provider` varchar(40) DEFAULT NULL,
  `whatsapp_api_token` text DEFAULT NULL,
  `whatsapp_phone_number_id` varchar(255) DEFAULT NULL,
  `whatsapp_template_name` varchar(255) DEFAULT NULL,
  `custom_webhook_url` varchar(255) DEFAULT NULL,
  `sms_enabled` tinyint(4) NOT NULL DEFAULT 0,
  `sms_provider` varchar(40) DEFAULT NULL,
  `sms_api_key` text DEFAULT NULL,
  `email_enabled` tinyint(4) NOT NULL DEFAULT 0,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_user` varchar(255) DEFAULT NULL,
  `smtp_password` text DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT NULL,
  `telegram_enabled` tinyint(4) NOT NULL DEFAULT 0,
  `telegram_bot_token` text DEFAULT NULL,
  `telegram_chat_id` varchar(255) DEFAULT NULL,
  `notify_on_new_lead` tinyint(4) NOT NULL DEFAULT 1,
  `notify_on_contact_form` tinyint(4) NOT NULL DEFAULT 1,
  `notify_on_whatsapp_click` tinyint(4) NOT NULL DEFAULT 0,
  `notify_on_popup_click` tinyint(4) NOT NULL DEFAULT 0,
  `notify_on_admin_login` tinyint(4) NOT NULL DEFAULT 0,
  `notify_on_new_visitor` tinyint(4) NOT NULL DEFAULT 0,
  `visitor_notification_throttle_minutes` int(11) NOT NULL DEFAULT 30,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `notification_settings`
--

INSERT INTO `notification_settings` (`id`, `owner_name`, `owner_phone`, `owner_email`, `whatsapp_api_enabled`, `whatsapp_provider`, `whatsapp_api_token`, `whatsapp_phone_number_id`, `whatsapp_template_name`, `custom_webhook_url`, `sms_enabled`, `sms_provider`, `sms_api_key`, `email_enabled`, `smtp_host`, `smtp_user`, `smtp_password`, `smtp_port`, `telegram_enabled`, `telegram_bot_token`, `telegram_chat_id`, `notify_on_new_lead`, `notify_on_contact_form`, `notify_on_whatsapp_click`, `notify_on_popup_click`, `notify_on_admin_login`, `notify_on_new_visitor`, `visitor_notification_throttle_minutes`, `created_at`, `updated_at`) VALUES
(1, 'Ersan Hafriyat', '905321234567', 'info@ersanhafriyat.com.tr', 0, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 1, 1, 0, 0, 0, 0, 30, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `hero_overlay_opacity` varchar(10) NOT NULL DEFAULT '0.55',
  `hero_button_1_text` varchar(255) DEFAULT NULL,
  `hero_button_1_url` varchar(255) DEFAULT NULL,
  `hero_button_1_type` varchar(20) NOT NULL DEFAULT 'internal',
  `hero_button_2_text` varchar(255) DEFAULT NULL,
  `hero_button_2_url` varchar(255) DEFAULT NULL,
  `hero_button_2_type` varchar(20) NOT NULL DEFAULT 'internal',
  `cover_image` varchar(255) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `canonical_url` varchar(255) DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `robots_index` tinyint(4) NOT NULL DEFAULT 1,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `excerpt`, `content`, `hero_title`, `hero_subtitle`, `hero_image`, `hero_overlay_opacity`, `hero_button_1_text`, `hero_button_1_url`, `hero_button_1_type`, `hero_button_2_text`, `hero_button_2_url`, `hero_button_2_type`, `cover_image`, `seo_title`, `seo_description`, `canonical_url`, `og_image`, `robots_index`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Hakkımızda', 'hakkimizda', 'Ersan Hafriyat olarak Alanya ve Mahmutlar’da profesyonel hafriyat çözümleri sunuyoruz.', '<p>Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, temel kazısı, moloz taşıma, altyapı ve çevre düzenleme hizmetleri sunuyoruz. Modern makine parkurumuz ve deneyimli ekibimizle projelerinizi güvenle gerçekleştiriyoruz.</p><p>İş güvenliği ve müşteri memnuniyetini ön planda tutarak, her ölçekteki işinizde hızlı, kaliteli ve ekonomik çözümler üretiyoruz.</p>', 'Hakkımızda', 'Alanya ve Mahmutlar’da güvenilir hafriyat çözüm ortağınız', NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Hakkımızda | Ersan Hafriyat', 'Ersan Hafriyat; Alanya ve Mahmutlar’da deneyimli ekip ve modern makine parkuru ile hafriyat, kepçe kiralama ve çevre düzenleme hizmetleri sunar.', NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'Gizlilik Politikası', 'gizlilik-politikasi', NULL, '<p>Kişisel verilerinizin güvenliği bizim için önemlidir. Bu sayfa içeriği yönetim panelinden düzenlenebilir.</p>', 'Gizlilik Politikası', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Gizlilik Politikası | Ersan Hafriyat', NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'KVKK Aydınlatma Metni', 'kvkk', NULL, '<p>6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında aydınlatma metni. İçerik yönetim panelinden düzenlenebilir.</p>', 'KVKK Aydınlatma Metni', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'KVKK Aydınlatma Metni | Ersan Hafriyat', NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'Çerez Politikası', 'cerez-politikasi', NULL, '<p>Web sitemizde deneyiminizi iyileştirmek için çerezler kullanılmaktadır. İçerik yönetim panelinden düzenlenebilir.</p>', 'Çerez Politikası', NULL, NULL, '0.55', NULL, NULL, 'internal', NULL, NULL, 'internal', NULL, 'Çerez Politikası | Ersan Hafriyat', NULL, NULL, NULL, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `popups`
--

CREATE TABLE `popups` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_url` varchar(255) DEFAULT NULL,
  `button_type` varchar(20) NOT NULL DEFAULT 'internal',
  `is_active` tinyint(4) NOT NULL DEFAULT 0,
  `delay_seconds` int(11) NOT NULL DEFAULT 3,
  `repeat_after_hours` int(11) NOT NULL DEFAULT 24,
  `target_pages` varchar(40) NOT NULL DEFAULT 'all',
  `show_on_mobile` tinyint(4) NOT NULL DEFAULT 1,
  `overlay_opacity` varchar(10) NOT NULL DEFAULT '0.6',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `popups`
--

INSERT INTO `popups` (`id`, `title`, `description`, `image`, `button_text`, `button_url`, `button_type`, `is_active`, `delay_seconds`, `repeat_after_hours`, `target_pages`, `show_on_mobile`, `overlay_opacity`, `created_at`, `updated_at`) VALUES
(1, 'Ücretsiz Keşif ve Teklif!', 'Hafriyat, kepçe kiralama ve moloz taşıma işleriniz için hemen WhatsApp’tan ücretsiz teklif alın.', NULL, 'WhatsApp’tan Teklif Al', 'Merhaba, ücretsiz keşif ve teklif almak istiyorum.', 'whatsapp', 0, 5, 24, 'home', 1, '0.6', '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `region` varchar(255) DEFAULT NULL,
  `service_type` varchar(255) DEFAULT NULL,
  `short_description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `before_image` varchar(255) DEFAULT NULL,
  `after_image` varchar(255) DEFAULT NULL,
  `gallery_json` text DEFAULT NULL,
  `project_date` varchar(30) DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `projects`
--

INSERT INTO `projects` (`id`, `title`, `slug`, `region`, `service_type`, `short_description`, `content`, `cover_image`, `before_image`, `after_image`, `gallery_json`, `project_date`, `seo_title`, `seo_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mahmutlar Temel Kazısı', 'mahmutlar-temel-kazisi', 'Mahmutlar', 'Temel Kazısı', 'Mahmutlar bölgesinde gerçekleştirdiğimiz Temel Kazısı çalışması.', '<p>Mahmutlar bölgesinde tamamladığımız Temel Kazısı projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Mahmutlar Temel Kazısı | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Kestel Arsa Tesviye', 'kestel-arsa-tesviye', 'Kestel', 'Arsa Tesviye', 'Kestel bölgesinde gerçekleştirdiğimiz Arsa Tesviye çalışması.', '<p>Kestel bölgesinde tamamladığımız Arsa Tesviye projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Kestel Arsa Tesviye | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Oba Kanal Açma', 'oba-kanal-acma', 'Oba', 'Altyapı ve Kanal Açma', 'Oba bölgesinde gerçekleştirdiğimiz Altyapı ve Kanal Açma çalışması.', '<p>Oba bölgesinde tamamladığımız Altyapı ve Kanal Açma projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Oba Kanal Açma | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(4, 'Tosmur Moloz Taşıma', 'tosmur-moloz-tasima', 'Tosmur', 'Moloz Taşıma', 'Tosmur bölgesinde gerçekleştirdiğimiz Moloz Taşıma çalışması.', '<p>Tosmur bölgesinde tamamladığımız Moloz Taşıma projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Tosmur Moloz Taşıma | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(5, 'Kargıcak Bahçe Düzenleme', 'kargicak-bahce-duzenleme', 'Kargıcak', 'Bahçe Düzenleme', 'Kargıcak bölgesinde gerçekleştirdiğimiz Bahçe Düzenleme çalışması.', '<p>Kargıcak bölgesinde tamamladığımız Bahçe Düzenleme projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Kargıcak Bahçe Düzenleme | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(6, 'Avsallar Villa Hafriyatı', 'avsallar-villa-hafriyati', 'Avsallar', 'Hafriyat', 'Avsallar bölgesinde gerçekleştirdiğimiz Hafriyat çalışması.', '<p>Avsallar bölgesinde tamamladığımız Hafriyat projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>', NULL, NULL, NULL, NULL, '2024', 'Avsallar Villa Hafriyatı | Ersan Hafriyat', NULL, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `redirects`
--

CREATE TABLE `redirects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `old_url` varchar(255) NOT NULL,
  `new_url` varchar(255) NOT NULL,
  `status_code` int(11) NOT NULL DEFAULT 301,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `services`
--

CREATE TABLE `services` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `short_description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `icon` varchar(60) DEFAULT NULL,
  `card_image` varchar(255) DEFAULT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `hero_title` varchar(255) DEFAULT NULL,
  `hero_subtitle` varchar(255) DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `advantages_json` text DEFAULT NULL,
  `usage_areas_json` text DEFAULT NULL,
  `process_json` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `og_image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_featured` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `services`
--

INSERT INTO `services` (`id`, `title`, `slug`, `short_description`, `content`, `icon`, `card_image`, `cover_image`, `hero_title`, `hero_subtitle`, `hero_image`, `advantages_json`, `usage_areas_json`, `process_json`, `seo_title`, `seo_description`, `og_image`, `sort_order`, `is_featured`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Alanya Hafriyat Hizmeti', 'alanya-hafriyat-hizmeti', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.', '<p>Alanya Hafriyat Hizmeti hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'excavator', NULL, NULL, 'Alanya Hafriyat Hizmeti', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Alanya Hafriyat Hizmeti | Ersan Hafriyat', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.', NULL, 0, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(2, 'Kepçe Kiralama', 'kepce-kiralama', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.', '<p>Kepçe Kiralama hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'truck', NULL, NULL, 'Kepçe Kiralama', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Kepçe Kiralama | Ersan Hafriyat', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.', NULL, 1, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(3, 'Mini Kepçe Kiralama', 'mini-kepce-kiralama', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.', '<p>Mini Kepçe Kiralama hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'truck', NULL, NULL, 'Mini Kepçe Kiralama', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Mini Kepçe Kiralama | Ersan Hafriyat', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.', NULL, 2, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(4, 'Temel Kazısı', 'temel-kazisi', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.', '<p>Temel Kazısı hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'layers', NULL, NULL, 'Temel Kazısı', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Temel Kazısı | Ersan Hafriyat', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.', NULL, 3, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(5, 'Moloz ve Hafriyat Nakliye', 'moloz-hafriyat-nakliye', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.', '<p>Moloz ve Hafriyat Nakliye hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'truck', NULL, NULL, 'Moloz ve Hafriyat Nakliye', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Moloz ve Hafriyat Nakliye | Ersan Hafriyat', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.', NULL, 4, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(6, 'Alt Yapı ve Kanal Açma', 'alt-yapi-kanal-acma', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.', '<p>Alt Yapı ve Kanal Açma hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'git-branch', NULL, NULL, 'Alt Yapı ve Kanal Açma', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Alt Yapı ve Kanal Açma | Ersan Hafriyat', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.', NULL, 5, 1, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(7, 'Çevre ve Bahçe Düzenleme', 'cevre-bahce-duzenleme', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.', '<p>Çevre ve Bahçe Düzenleme hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'trees', NULL, NULL, 'Çevre ve Bahçe Düzenleme', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Çevre ve Bahçe Düzenleme | Ersan Hafriyat', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.', NULL, 6, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(8, 'Arsa Tesviye ve Dolgu', 'arsa-tesviye-dolgu', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.', '<p>Arsa Tesviye ve Dolgu hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'mountain', NULL, NULL, 'Arsa Tesviye ve Dolgu', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Arsa Tesviye ve Dolgu | Ersan Hafriyat', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.', NULL, 7, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07'),
(9, 'Drenaj ve Özel Kazı İşleri', 'drenaj-ozel-kazi', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.', '<p>Drenaj ve Özel Kazı İşleri hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>', 'droplet', NULL, NULL, 'Drenaj ve Özel Kazı İşleri', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.', NULL, '[\"Deneyimli ve uzman ekip\",\"Modern ve bakımlı makine parkuru\",\"Zamanında ve güvenli çalışma\",\"Uygun fiyat politikası\",\"Yerinde ücretsiz keşif\"]', '[\"Konut ve villa projeleri\",\"Ticari yapılar\",\"Arsa ve bahçe alanları\",\"Altyapı çalışmaları\"]', '[{\"title\":\"Talep & Keşif\",\"text\":\"İhtiyacınızı değerlendirir, yerinde keşif yaparız.\"},{\"title\":\"Planlama\",\"text\":\"Uygun makine ve ekip planlaması yaparız.\"},{\"title\":\"Uygulama\",\"text\":\"İş güvenliği kurallarıyla hızlıca uygularız.\"},{\"title\":\"Teslim\",\"text\":\"İşi teslim eder, memnuniyetinizi alırız.\"}]', 'Drenaj ve Özel Kazı İşleri | Ersan Hafriyat', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.', NULL, 8, 0, 1, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `service_faqs`
--

CREATE TABLE `service_faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `service_id` int(11) NOT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `service_regions`
--

CREATE TABLE `service_regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `city` varchar(80) DEFAULT NULL,
  `district` varchar(80) DEFAULT NULL,
  `neighborhood` varchar(120) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_description` text DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `service_regions`
--

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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `settings`
--

CREATE TABLE `settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `setting_key` varchar(255) NOT NULL,
  `setting_value` text DEFAULT NULL,
  `setting_group` varchar(60) NOT NULL DEFAULT 'general',
  `input_type` varchar(30) NOT NULL DEFAULT 'text',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `settings`
--

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

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `site_events`
--

CREATE TABLE `site_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_type` varchar(60) NOT NULL,
  `page_url` varchar(255) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `ip_hash` varchar(64) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `metadata_json` text DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `social_links`
--

CREATE TABLE `social_links` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `platform` varchar(60) NOT NULL,
  `url` varchar(255) NOT NULL,
  `icon` varchar(60) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `social_links`
--

INSERT INTO `social_links` (`id`, `platform`, `url`, `icon`, `sort_order`, `is_active`) VALUES
(1, 'facebook', 'https://facebook.com', 'facebook', 0, 1),
(2, 'instagram', 'https://instagram.com', 'instagram', 1, 1),
(3, 'whatsapp', 'https://wa.me/905321234567', 'whatsapp', 2, 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `testimonials`
--

CREATE TABLE `testimonials` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `company` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `rating` int(11) NOT NULL DEFAULT 5,
  `image` varchar(255) DEFAULT NULL,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `testimonials`
--

INSERT INTO `testimonials` (`id`, `name`, `company`, `location`, `comment`, `rating`, `image`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mehmet A.', NULL, 'Mahmutlar', 'Villa temeli için kazı işini çok hızlı ve temiz yaptılar. Kesinlikle tavsiye ederim.', 5, NULL, 0, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(2, 'Ayşe K.', NULL, 'Kestel', 'Bahçe düzenleme ve arsa tesviyesinde profesyonel bir ekip. Teşekkürler.', 5, NULL, 1, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08'),
(3, 'Hasan Y.', NULL, 'Oba', 'Moloz taşıma işini zamanında ve uygun fiyata hallettiler.', 5, NULL, 2, 1, '2026-07-02 15:34:08', '2026-07-02 15:34:08');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `theme_settings`
--

CREATE TABLE `theme_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `primary_color` varchar(20) NOT NULL DEFAULT '#F5A400',
  `primary_hover_color` varchar(20) NOT NULL DEFAULT '#D98A00',
  `primary_text_color` varchar(20) NOT NULL DEFAULT '#111827',
  `secondary_color` varchar(20) NOT NULL DEFAULT '#111827',
  `secondary_text_color` varchar(20) NOT NULL DEFAULT '#FFFFFF',
  `dark_color` varchar(20) NOT NULL DEFAULT '#080B0F',
  `accent_color` varchar(20) NOT NULL DEFAULT '#FFB703',
  `background_color` varchar(20) NOT NULL DEFAULT '#F7F4EF',
  `surface_color` varchar(20) NOT NULL DEFAULT '#FFFFFF',
  `text_color` varchar(20) NOT NULL DEFAULT '#111827',
  `muted_text_color` varchar(20) NOT NULL DEFAULT '#64748B',
  `border_color` varchar(20) NOT NULL DEFAULT '#E5E7EB',
  `button_primary_bg` varchar(20) NOT NULL DEFAULT '#F5A400',
  `button_primary_text` varchar(20) NOT NULL DEFAULT '#111827',
  `button_dark_bg` varchar(20) NOT NULL DEFAULT '#080B0F',
  `button_dark_text` varchar(20) NOT NULL DEFAULT '#FFFFFF',
  `whatsapp_color` varchar(20) NOT NULL DEFAULT '#25D366',
  `border_radius` varchar(20) NOT NULL DEFAULT '10px',
  `card_radius` varchar(20) NOT NULL DEFAULT '14px',
  `shadow_strength` varchar(20) NOT NULL DEFAULT '0.10',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `theme_settings`
--

INSERT INTO `theme_settings` (`id`, `primary_color`, `primary_hover_color`, `primary_text_color`, `secondary_color`, `secondary_text_color`, `dark_color`, `accent_color`, `background_color`, `surface_color`, `text_color`, `muted_text_color`, `border_color`, `button_primary_bg`, `button_primary_text`, `button_dark_bg`, `button_dark_text`, `whatsapp_color`, `border_radius`, `card_radius`, `shadow_strength`, `created_at`, `updated_at`) VALUES
(1, '#F5A400', '#D98A00', '#111827', '#111827', '#FFFFFF', '#080B0F', '#FFB703', '#F7F4EF', '#FFFFFF', '#111827', '#64748B', '#E5E7EB', '#F5A400', '#111827', '#080B0F', '#FFFFFF', '#25D366', '10px', '14px', '0.10', '2026-07-02 15:34:07', '2026-07-02 15:34:07');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` varchar(30) NOT NULL DEFAULT 'admin',
  `status` varchar(20) NOT NULL DEFAULT 'active',
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `status`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Ersan Yönetici', 'admin@ersanhafriyat.local', '$2y$10$MKC.WLBq5DAvtJP37RNySee3EPx8caf5/K251hZF9GTujTFq6O3yq', 'admin', 'active', NULL, '2026-07-02 15:34:07', '2026-07-02 15:34:07');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `blog_categories`
--
ALTER TABLE `blog_categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `footer_settings`
--
ALTER TABLE `footer_settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `home_sections`
--
ALTER TABLE `home_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section_key` (`section_key`);

--
-- Tablo için indeksler `leads`
--
ALTER TABLE `leads`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `license_logs`
--
ALTER TABLE `license_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `menus`
--
ALTER TABLE `menus`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notification_logs`
--
ALTER TABLE `notification_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `notification_settings`
--
ALTER TABLE `notification_settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `popups`
--
ALTER TABLE `popups`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `redirects`
--
ALTER TABLE `redirects`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `service_faqs`
--
ALTER TABLE `service_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `service_regions`
--
ALTER TABLE `service_regions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Tablo için indeksler `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `setting_key` (`setting_key`);

--
-- Tablo için indeksler `site_events`
--
ALTER TABLE `site_events`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `social_links`
--
ALTER TABLE `social_links`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `testimonials`
--
ALTER TABLE `testimonials`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `theme_settings`
--
ALTER TABLE `theme_settings`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `blog_categories`
--
ALTER TABLE `blog_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `equipment`
--
ALTER TABLE `equipment`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `footer_settings`
--
ALTER TABLE `footer_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `gallery`
--
ALTER TABLE `gallery`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `home_sections`
--
ALTER TABLE `home_sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `leads`
--
ALTER TABLE `leads`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `license_logs`
--
ALTER TABLE `license_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `media`
--
ALTER TABLE `media`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `menus`
--
ALTER TABLE `menus`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Tablo için AUTO_INCREMENT değeri `notification_logs`
--
ALTER TABLE `notification_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `notification_settings`
--
ALTER TABLE `notification_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Tablo için AUTO_INCREMENT değeri `popups`
--
ALTER TABLE `popups`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Tablo için AUTO_INCREMENT değeri `redirects`
--
ALTER TABLE `redirects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `services`
--
ALTER TABLE `services`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Tablo için AUTO_INCREMENT değeri `service_faqs`
--
ALTER TABLE `service_faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `service_regions`
--
ALTER TABLE `service_regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Tablo için AUTO_INCREMENT değeri `settings`
--
ALTER TABLE `settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Tablo için AUTO_INCREMENT değeri `site_events`
--
ALTER TABLE `site_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `social_links`
--
ALTER TABLE `social_links`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `testimonials`
--
ALTER TABLE `testimonials`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Tablo için AUTO_INCREMENT değeri `theme_settings`
--
ALTER TABLE `theme_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
