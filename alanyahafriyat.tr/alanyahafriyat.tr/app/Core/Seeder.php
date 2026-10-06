<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Seeder
{
    protected PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    protected function now(): string
    {
        return date('Y-m-d H:i:s');
    }

    protected function insert(string $table, array $data): void
    {
        $cols = '`' . implode('`, `', array_keys($data)) . '`';
        $ph = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO `$table` ($cols) VALUES ($ph)");
        $stmt->execute(array_values($data));
    }

    public function run(): void
    {
        $this->seedUsers();
        $this->seedSettings();
        $this->seedTheme();
        $this->seedMenus();
        $this->seedPages();
        $this->seedHomeSections();
        $this->seedServices();
        $this->seedEquipment();
        $this->seedProjects();
        $this->seedBlog();
        $this->seedFaqs();
        $this->seedGallery();
        $this->seedPopup();
        $this->seedFooter();
        $this->seedSocial();
        $this->seedNotifications();
        $this->seedTestimonials();
        $this->seedServiceRegions();
    }

    protected function seedUsers(): void
    {
        $this->insert('users', [
            'name' => 'Ersan Yönetici',
            'email' => 'admin@ersanhafriyat.local',
            'password_hash' => password_hash('ChangeMe8020!', PASSWORD_BCRYPT),
            'role' => 'admin',
            'status' => 'active',
            'created_at' => $this->now(),
            'updated_at' => $this->now(),
        ]);
    }

    protected function seedSettings(): void
    {
        $settings = [
            ['site_name', 'Ersan Hafriyat', 'general', 'text'],
            ['site_tagline', 'Alanya & Mahmutlar Profesyonel Hafriyat ve Kepçe Hizmetleri', 'general', 'text'],
            ['phone', '+90 532 123 45 67', 'contact', 'text'],
            ['whatsapp_number', '905321234567', 'contact', 'text'],
            ['email', 'info@ersanhafriyat.com.tr', 'contact', 'text'],
            ['address', 'Mahmutlar Mah. Alanya / ANTALYA', 'contact', 'text'],
            ['working_hours', 'Pzt - Cmt: 08:00 - 18:00', 'contact', 'text'],
            ['top_bar_text', 'Alanya, Mahmutlar ve Çevresi Hizmetinizde!', 'general', 'text'],
            ['map_embed', 'https://www.google.com/maps?q=Mahmutlar+Alanya+Antalya&output=embed', 'contact', 'textarea'],
            ['seo_title', 'Ersan Hafriyat | Alanya & Mahmutlar Hafriyat ve Kepçe Kiralama', 'seo', 'text'],
            ['seo_description', 'Alanya ve Mahmutlar’da temel kazısı, moloz taşıma, kepçe kiralama, altyapı ve bahçe düzenleme hizmetleri. Hızlı, güvenli ve ekonomik hafriyat çözümleri.', 'seo', 'textarea'],
            ['seo_keywords', 'alanya hafriyat, mahmutlar kepçe kiralama, temel kazısı, moloz taşıma', 'seo', 'text'],
            ['og_image', '', 'seo', 'image'],
            ['footer_about', 'Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, moloz taşıma ve çevre düzenleme hizmetleri sunuyoruz.', 'general', 'textarea'],
            ['logo', '', 'general', 'image'],
            ['about_counter_experience', '10+', 'about', 'text'],
            ['about_counter_projects', '1000+', 'about', 'text'],
            ['about_counter_staff', '15+', 'about', 'text'],
            ['about_counter_support', '7/24', 'about', 'text'],
            ['floating_whatsapp_enabled', '0', 'general', 'toggle'],
            ['web_design_credit_text', 'Netvera Teknoloji Yazılım', 'footer', 'text'],
            ['web_design_credit_url', '', 'footer', 'text'],
        ];
        foreach ($settings as [$k, $v, $g, $t]) {
            $this->insert('settings', [
                'setting_key' => $k, 'setting_value' => $v, 'setting_group' => $g,
                'input_type' => $t, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedTheme(): void
    {
        // Hafriyat Sarısı (ana palet) — kontrast garantili
        $this->insert('theme_settings', [
            'primary_color' => '#F5A400',
            'primary_hover_color' => '#D98A00',
            'primary_text_color' => '#111827',
            'secondary_color' => '#111827',
            'secondary_text_color' => '#FFFFFF',
            'dark_color' => '#080B0F',
            'accent_color' => '#FFB703',
            'background_color' => '#F7F4EF',
            'surface_color' => '#FFFFFF',
            'text_color' => '#111827',
            'muted_text_color' => '#64748B',
            'border_color' => '#E5E7EB',
            'button_primary_bg' => '#F5A400',
            'button_primary_text' => '#111827',
            'button_dark_bg' => '#080B0F',
            'button_dark_text' => '#FFFFFF',
            'whatsapp_color' => '#25D366',
            'border_radius' => '10px',
            'card_radius' => '14px',
            'shadow_strength' => '0.10',
            'created_at' => $this->now(),
            'updated_at' => $this->now(),
        ]);
    }

    protected function seedMenus(): void
    {
        $header = [
            ['Ana Sayfa', '/', 'internal'],
            ['Hakkımızda', '/hakkimizda', 'internal'],
            ['Hizmetlerimiz', '/hizmetler', 'internal'],
            ['Makine Parkuru', '/makine-parkuru', 'internal'],
            ['Projelerimiz', '/projeler', 'internal'],
            ['Galeri', '/galeri', 'internal'],
            ['Blog', '/blog', 'internal'],
            ['SSS', '/sss', 'internal'],
            ['İletişim', '/iletisim', 'internal'],
        ];
        $i = 0;
        foreach ($header as [$title, $url, $type]) {
            $this->insert('menus', [
                'menu_location' => 'header', 'title' => $title, 'url' => $url,
                'menu_type' => $type, 'target' => '_self', 'sort_order' => $i++,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }

        $footerLinks = [
            ['Ana Sayfa', '/'], ['Hakkımızda', '/hakkimizda'], ['Makine Parkuru', '/makine-parkuru'],
            ['Projelerimiz', '/projeler'], ['Galeri', '/galeri'], ['Blog', '/blog'],
        ];
        $i = 0;
        foreach ($footerLinks as [$title, $url]) {
            $this->insert('menus', [
                'menu_location' => 'footer', 'title' => $title, 'url' => $url,
                'menu_type' => 'internal', 'target' => '_self', 'sort_order' => $i++,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }

        // Mobil alt aksiyon barı
        $mobile = [
            ['Ara', 'phone', '', 'phone'],
            ['WhatsApp', 'whatsapp', 'Merhaba, teklif almak istiyorum.', 'whatsapp'],
            ['Konum', 'external', '/iletisim', 'map-pin'],
            ['Teklif Al', 'internal', '/iletisim', 'send'],
        ];
        $i = 0;
        foreach ($mobile as [$title, $type, $url, $icon]) {
            $this->insert('menus', [
                'menu_location' => 'mobile_bar', 'title' => $title, 'url' => $url,
                'menu_type' => $type, 'icon' => $icon, 'target' => '_self', 'sort_order' => $i++,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedPages(): void
    {
        $this->insert('pages', [
            'title' => 'Hakkımızda',
            'slug' => 'hakkimizda',
            'excerpt' => 'Ersan Hafriyat olarak Alanya ve Mahmutlar’da profesyonel hafriyat çözümleri sunuyoruz.',
            'content' => "<p>Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, temel kazısı, moloz taşıma, altyapı ve çevre düzenleme hizmetleri sunuyoruz. Modern makine parkurumuz ve deneyimli ekibimizle projelerinizi güvenle gerçekleştiriyoruz.</p><p>İş güvenliği ve müşteri memnuniyetini ön planda tutarak, her ölçekteki işinizde hızlı, kaliteli ve ekonomik çözümler üretiyoruz.</p>",
            'hero_title' => 'Hakkımızda',
            'hero_subtitle' => 'Alanya ve Mahmutlar’da güvenilir hafriyat çözüm ortağınız',
            'hero_overlay_opacity' => '0.55',
            'seo_title' => 'Hakkımızda | Ersan Hafriyat',
            'seo_description' => 'Ersan Hafriyat; Alanya ve Mahmutlar’da deneyimli ekip ve modern makine parkuru ile hafriyat, kepçe kiralama ve çevre düzenleme hizmetleri sunar.',
            'robots_index' => 1,
            'is_active' => 1,
            'created_at' => $this->now(),
            'updated_at' => $this->now(),
        ]);

        $legal = [
            ['Gizlilik Politikası', 'gizlilik-politikasi', '<p>Kişisel verilerinizin güvenliği bizim için önemlidir. Bu sayfa içeriği yönetim panelinden düzenlenebilir.</p>'],
            ['KVKK Aydınlatma Metni', 'kvkk', '<p>6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında aydınlatma metni. İçerik yönetim panelinden düzenlenebilir.</p>'],
            ['Çerez Politikası', 'cerez-politikasi', '<p>Web sitemizde deneyiminizi iyileştirmek için çerezler kullanılmaktadır. İçerik yönetim panelinden düzenlenebilir.</p>'],
        ];
        foreach ($legal as [$title, $slug, $content]) {
            $this->insert('pages', [
                'title' => $title, 'slug' => $slug, 'content' => $content,
                'hero_title' => $title, 'hero_overlay_opacity' => '0.55',
                'seo_title' => $title . ' | Ersan Hafriyat', 'robots_index' => 1,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedHomeSections(): void
    {
        $sections = [
            ['hero', 'Alanya ve Mahmutlar’da Profesyonel Hafriyat & Kepçe Hizmetleri',
             'Temel kazısı, moloz taşıma, bahçe düzenleme, kanal açma ve kepçe kiralama hizmetlerimizle projelerinizi güvenli, hızlı ve ekonomik şekilde tamamlıyoruz.',
             json_encode([
                'button_1_text' => 'WhatsApp’tan Teklif Al', 'button_1_url' => 'Merhaba, hafriyat/kepçe hizmeti için teklif almak istiyorum.', 'button_1_type' => 'whatsapp',
                'button_2_text' => 'Hizmetleri İncele', 'button_2_url' => '/hizmetler', 'button_2_type' => 'internal',
                'overlay_opacity' => '0.55', 'show_form' => '1', 'show_badges' => '1',
                'badges' => [
                    ['icon' => 'zap', 'title' => 'Hızlı Dönüş', 'text' => 'Talebinize anında çözüm sunuyoruz.'],
                    ['icon' => 'users', 'title' => 'Deneyimli Ekip', 'text' => 'Alanında uzman ve tecrübeli kadro.'],
                    ['icon' => 'truck', 'title' => 'Modern Makine', 'text' => 'Güçlü ve bakımlı makine parkuru.'],
                    ['icon' => 'shield', 'title' => 'Özenli Çalışma', 'text' => 'İş güvenliği ve kaliteli önceliğimiz.'],
                    ['icon' => 'tag', 'title' => 'Uygun Fiyat', 'text' => 'Kaliteli hizmeti uygun fiyatlarla.'],
                ],
             ], JSON_UNESCAPED_UNICODE),
             ''],
            ['services', 'Hizmetlerimiz', 'Alanya ve Mahmutlar genelinde sunduğumuz profesyonel hafriyat hizmetleri', null, ''],
            ['equipment', 'Makine Parkurumuz', 'Güçlü, bakımlı ve modern iş makinelerimizle tüm hafriyat işlerinizi güvenle üstleniyoruz.', null, ''],
            ['process', 'Çalışma Sürecimiz', 'Talepten teslime kadar şeffaf ve planlı bir süreç', json_encode([
                ['icon' => 'message-circle', 'title' => 'Talep Alınır', 'text' => 'İhtiyacınızı WhatsApp veya telefon ile bize iletirsiniz.'],
                ['icon' => 'search', 'title' => 'Keşif & Planlama', 'text' => 'Uzman ekibimiz keşif yapar ve planlama oluşturur.'],
                ['icon' => 'clipboard', 'title' => 'Makine Planı', 'text' => 'Uygun makine ve ekip planlaması yapılır.'],
                ['icon' => 'hard-hat', 'title' => 'Saha Uygulama', 'text' => 'İş güvenliği ile hızlı ve düzenli şekilde uygulanır.'],
                ['icon' => 'check-circle', 'title' => 'Teslim & Kontrol', 'text' => 'İş teslim edilir, kontrol edilir ve onayınız alınır.'],
            ], JSON_UNESCAPED_UNICODE), ''],
            ['machine_anim', 'Sahada Güç, İşte Verim',
             'Kepçe, kamyon ve deneyimli ekibimizle hafriyat işleriniz planlı, hızlı ve güvenli şekilde ilerler.', null, ''],
            ['gallery', 'Çalışmalarımızdan Kareler', 'Sahadaki işlerimizden bazı görüntüler', null, ''],
            ['regions', 'Çalışma Bölgelerimiz', 'Hizmet verdiğimiz bölgeler', null, ''],
            ['blog', 'Son Yazılarımız', 'Hafriyat ve kepçe kiralama hakkında faydalı içerikler', null, ''],
            ['faq', 'Sık Sorulan Sorular', 'Merak edilenler', null, ''],
            ['final_cta', 'Hafriyat, Kepçe Kiralama ve Daha Fazlası İçin Yanınızdayız!', 'Hemen bize ulaşın, ücretsiz keşif ve en uygun fiyat teklifini alın.', null, ''],
        ];
        $i = 0;
        foreach ($sections as [$key, $title, $subtitle, $json, $image]) {
            $this->insert('home_sections', [
                'section_key' => $key, 'title' => $title, 'subtitle' => $subtitle,
                'content_json' => $json, 'image' => $image, 'sort_order' => $i++,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedServices(): void
    {
        $services = [
            ['Alanya Hafriyat Hizmeti', 'alanya-hafriyat-hizmeti', 'excavator', 'Alanya genelinde hafriyat işlerini profesyonelce gerçekleştiriyoruz.'],
            ['Kepçe Kiralama', 'kepce-kiralama', 'truck', 'Günlük, haftalık veya aylık kepçe kiralama hizmetleri ile yanınızdayız.'],
            ['Mini Kepçe Kiralama', 'mini-kepce-kiralama', 'truck', 'Dar alanlarda yüksek manevra kabiliyetli mini kepçe kiralama.'],
            ['Temel Kazısı', 'temel-kazisi', 'layers', 'Bina, villa ve yapı projeleri için hızlı ve güvenli temel kazısı.'],
            ['Moloz ve Hafriyat Nakliye', 'moloz-hafriyat-nakliye', 'truck', 'Moloz ve hafriyat taşıma işlerinde hızlı ve düzenli nakliye.'],
            ['Alt Yapı ve Kanal Açma', 'alt-yapi-kanal-acma', 'git-branch', 'Altyapı, kanal ve drenaj açma işlerinde profesyonel çözümler.'],
            ['Çevre ve Bahçe Düzenleme', 'cevre-bahce-duzenleme', 'trees', 'Bahçe temizliği, düzenleme ve çevre düzenleme işleri.'],
            ['Arsa Tesviye ve Dolgu', 'arsa-tesviye-dolgu', 'mountain', 'Arsa tesviye, dolgu ve düzenleme işlerinde hassas çözümler.'],
            ['Drenaj ve Özel Kazı İşleri', 'drenaj-ozel-kazi', 'droplet', 'Drenaj ve özel kazı işlerinde deneyimli ekip ve doğru ekipman.'],
        ];
        $i = 0;
        foreach ($services as [$title, $slug, $icon, $desc]) {
            $advantages = ['Deneyimli ve uzman ekip', 'Modern ve bakımlı makine parkuru', 'Zamanında ve güvenli çalışma', 'Uygun fiyat politikası', 'Yerinde ücretsiz keşif'];
            $usage = ['Konut ve villa projeleri', 'Ticari yapılar', 'Arsa ve bahçe alanları', 'Altyapı çalışmaları'];
            $process = [
                ['title' => 'Talep & Keşif', 'text' => 'İhtiyacınızı değerlendirir, yerinde keşif yaparız.'],
                ['title' => 'Planlama', 'text' => 'Uygun makine ve ekip planlaması yaparız.'],
                ['title' => 'Uygulama', 'text' => 'İş güvenliği kurallarıyla hızlıca uygularız.'],
                ['title' => 'Teslim', 'text' => 'İşi teslim eder, memnuniyetinizi alırız.'],
            ];
            $this->insert('services', [
                'title' => $title, 'slug' => $slug, 'icon' => $icon,
                'short_description' => $desc,
                'content' => "<p>$title hizmetimiz kapsamında Alanya, Mahmutlar ve çevre bölgelerde profesyonel çözümler sunuyoruz. Deneyimli ekibimiz ve modern makine parkurumuzla işlerinizi hızlı, güvenli ve ekonomik şekilde tamamlıyoruz.</p><p>Detaylı bilgi ve ücretsiz keşif için bize WhatsApp veya telefon üzerinden ulaşabilirsiniz.</p>",
                'hero_title' => $title,
                'hero_subtitle' => $desc,
                'advantages_json' => json_encode($advantages, JSON_UNESCAPED_UNICODE),
                'usage_areas_json' => json_encode($usage, JSON_UNESCAPED_UNICODE),
                'process_json' => json_encode($process, JSON_UNESCAPED_UNICODE),
                'seo_title' => $title . ' | Ersan Hafriyat',
                'seo_description' => str_excerpt($desc, 155),
                'sort_order' => $i, 'is_featured' => $i < 6 ? 1 : 0, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
            $i++;
        }
    }

    protected function seedEquipment(): void
    {
        $items = [
            ['Hidromek 102B', 'hidromek-102b', 'Kazıcı Yükleyici', 'Ağırlık: 20 Ton • Kova Kapasitesi: 1.1 m³ • Güçlü ve Yakıt Tasarruflu'],
            ['JCB 3CX', 'jcb-3cx', 'Beko Loder', 'Yükleyici & Kazıcı • Çok Amaçlı Kullanım • Yüksek Performans'],
            ['Mini Ekskavatör', 'mini-ekskavator', 'Mini Kepçe', 'Ağırlık: 3.5 Ton • Dar Alanlarda Yüksek Manevra • Hassas Çalışma'],
            ['Kamyon / Damper', 'kamyon-damper', 'Nakliye', '6x4 Damper Kamyon • Moloz ve Hafriyat Taşıma • Yüksek Taşıma Kapasitesi'],
        ];
        $i = 0;
        foreach ($items as [$title, $slug, $usage, $desc]) {
            $this->insert('equipment', [
                'title' => $title, 'slug' => $slug, 'brand_model' => $title,
                'usage_area' => $usage, 'attachments' => 'Kova, kırıcı, ripper',
                'short_description' => $desc,
                'content' => "<p>$title makinemiz, hafriyat ve kazı işlerinizde yüksek performans sunar. Bakımlı ve operatörlü olarak hizmet vermektedir.</p>",
                'sort_order' => $i++, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedProjects(): void
    {
        $projects = [
            ['Mahmutlar Temel Kazısı', 'mahmutlar-temel-kazisi', 'Mahmutlar', 'Temel Kazısı'],
            ['Kestel Arsa Tesviye', 'kestel-arsa-tesviye', 'Kestel', 'Arsa Tesviye'],
            ['Oba Kanal Açma', 'oba-kanal-acma', 'Oba', 'Altyapı ve Kanal Açma'],
            ['Tosmur Moloz Taşıma', 'tosmur-moloz-tasima', 'Tosmur', 'Moloz Taşıma'],
            ['Kargıcak Bahçe Düzenleme', 'kargicak-bahce-duzenleme', 'Kargıcak', 'Bahçe Düzenleme'],
            ['Avsallar Villa Hafriyatı', 'avsallar-villa-hafriyati', 'Avsallar', 'Hafriyat'],
        ];
        $i = 0;
        foreach ($projects as [$title, $slug, $region, $type]) {
            $this->insert('projects', [
                'title' => $title, 'slug' => $slug, 'region' => $region, 'service_type' => $type,
                'short_description' => "$region bölgesinde gerçekleştirdiğimiz $type çalışması.",
                'content' => "<p>$region bölgesinde tamamladığımız $type projesi. İş güvenliği kurallarına uygun, hızlı ve titiz bir çalışmayla teslim edilmiştir.</p>",
                'project_date' => '2024',
                'seo_title' => $title . ' | Ersan Hafriyat',
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
            $i++;
        }
    }

    protected function seedBlog(): void
    {
        $catId = null;
        $categories = [
            ['Hafriyat', 'hafriyat'],
            ['Kepçe Kiralama', 'kepce-kiralama'],
            ['Rehber', 'rehber'],
        ];
        $i = 0;
        foreach ($categories as [$title, $slug]) {
            $this->insert('blog_categories', [
                'title' => $title, 'slug' => $slug,
                'description' => "$title kategorisindeki yazılar.",
                'sort_order' => $i++, 'is_active' => 1,
            ]);
        }
        $firstCat = (int) $this->pdo->query('SELECT id FROM blog_categories ORDER BY id ASC LIMIT 1')->fetchColumn();

        $posts = [
            ['Alanya’da Kepçe Kiralama Hangi İşlerde Kullanılır?', 'alanyada-kepce-kiralama-hangi-islerde-kullanilir',
             "## Alanya’da Kepçe Kiralama\n\nKepçe kiralama, Alanya ve çevresinde birçok farklı işte kullanılır. Temel kazısından bahçe düzenlemeye, moloz taşımadan altyapı çalışmalarına kadar geniş bir kullanım alanı vardır.\n\n### Başlıca Kullanım Alanları\n\n- Temel kazısı ve hafriyat\n- Bahçe ve arsa düzenleme\n- Kanal ve altyapı açma\n- Moloz yükleme ve taşıma\n\n### Neden Kepçe Kiralamalı?\n\nİş makinesi satın almak yerine, ihtiyaç duyduğunuz süre boyunca operatörlü kepçe kiralamak çok daha ekonomiktir. Ersan Hafriyat olarak günlük, haftalık ve aylık kiralama seçenekleri sunuyoruz."],
            ['Hafriyat ve Moloz Taşıma Sürecinde Nelere Dikkat Edilmeli?', 'hafriyat-ve-moloz-tasima-surecinde-nelere-dikkat-edilmeli',
             "## Hafriyat ve Moloz Taşıma\n\nHafriyat işleri, doğru planlama ve iş güvenliği gerektiren süreçlerdir. Moloz taşıma sırasında dikkat edilmesi gereken önemli noktalar vardır.\n\n### Dikkat Edilmesi Gerekenler\n\n1. **İş güvenliği:** Saha güvenliği önceliklidir.\n2. **Ruhsat ve izinler:** Gerekli belgeler eksiksiz olmalıdır.\n3. **Doğru makine seçimi:** İşin ölçeğine uygun ekipman kullanılmalıdır.\n4. **Çevre duyarlılığı:** Molozlar uygun döküm sahalarına taşınmalıdır.\n\nErsan Hafriyat, tüm bu süreçleri profesyonelce yönetir."],
            ['Mahmutlar’da Bahçe, Arsa ve Temel Kazısı İçin Profesyonel Çözüm', 'mahmutlarda-bahce-arsa-ve-temel-kazisi',
             "## Mahmutlar’da Profesyonel Kazı Çözümleri\n\nMahmutlar ve çevresinde bahçe düzenleme, arsa tesviye ve temel kazısı işlerinde deneyimli ekibimizle hizmet veriyoruz.\n\n### Hizmetlerimiz\n\n- Temel kazısı\n- Arsa tesviye ve dolgu\n- Bahçe düzenleme\n- Çevre temizliği\n\nModern makine parkurumuz ve uzman kadromuzla projelerinizi güvenle tamamlıyoruz. Ücretsiz keşif için bizimle iletişime geçin."],
        ];
        foreach ($posts as $idx => [$title, $slug, $md]) {
            $wordCount = str_word_count(strip_tags($md));
            $this->insert('blog_posts', [
                'category_id' => $firstCat,
                'title' => $title, 'slug' => $slug,
                'excerpt' => str_excerpt($md, 150),
                'content_markdown' => $md,
                'author_name' => 'Ersan Hafriyat',
                'seo_title' => $title . ' | Ersan Hafriyat',
                'seo_description' => str_excerpt($md, 155),
                'robots_index' => 1, 'robots_follow' => 1,
                'schema_type' => 'BlogPosting',
                'reading_time' => max(1, (int) ceil($wordCount / 200)),
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime("-" . ($idx * 3) . " days")),
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedFaqs(): void
    {
        $faqs = [
            ['Kepçe kiralama fiyatları nasıl belirlenir?', 'Kepçe kiralama fiyatları; işin süresi, makine tipi, çalışma bölgesi ve işin kapsamına göre belirlenir. Ücretsiz keşif sonrası net fiyat sunarız.'],
            ['Hafriyat ve moloz taşıma hizmetiniz var mı?', 'Evet, Alanya ve çevresinde hafriyat ve moloz taşıma hizmeti sunuyoruz. Damperli kamyonlarımızla molozları uygun döküm sahalarına taşıyoruz.'],
            ['Hizmet verdiğiniz bölgeler nerelerdir?', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez, Cikcilli, Çıplaklı, Payallar, Konaklı, Avsallar ve Gazipaşa bölgelerinde hizmet veriyoruz.'],
            ['Çalışma saatleriniz nedir?', 'Pazartesi - Cumartesi 08:00 - 18:00 saatleri arasında hizmet veriyoruz. Acil işler için bize ulaşabilirsiniz.'],
            ['Acil işler için hizmet sağlıyor musunuz?', 'Evet, acil hafriyat ve kepçe ihtiyaçlarınız için hızlı çözümler sunuyoruz. WhatsApp veya telefon ile bize ulaşabilirsiniz.'],
        ];
        $i = 0;
        foreach ($faqs as [$q, $a]) {
            $this->insert('faqs', ['question' => $q, 'answer' => $a, 'sort_order' => $i++, 'is_active' => 1]);
        }
    }

    protected function seedGallery(): void
    {
        $items = [
            ['Mahmutlar - Temel Kazısı', 'Temel Kazısı'],
            ['Kestel - Arsa Tesviye', 'Arsa Tesviye'],
            ['Oba - Kanal Açma', 'Altyapı'],
            ['Tosmur - Moloz Taşıma', 'Moloz Taşıma'],
            ['Kargıcak - Bahçe Düzenleme', 'Bahçe Düzenleme'],
            ['Avsallar - Villa Hafriyatı', 'Hafriyat'],
        ];
        $i = 0;
        foreach ($items as [$title, $cat]) {
            $this->insert('gallery', [
                'title' => $title, 'category' => $cat, 'alt_text' => $title,
                'sort_order' => $i++, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedPopup(): void
    {
        $this->insert('popups', [
            'title' => 'Ücretsiz Keşif ve Teklif!',
            'description' => 'Hafriyat, kepçe kiralama ve moloz taşıma işleriniz için hemen WhatsApp’tan ücretsiz teklif alın.',
            'button_text' => 'WhatsApp’tan Teklif Al',
            'button_url' => 'Merhaba, ücretsiz keşif ve teklif almak istiyorum.',
            'button_type' => 'whatsapp',
            'is_active' => 0,
            'delay_seconds' => 5,
            'repeat_after_hours' => 24,
            'target_pages' => 'home',
            'show_on_mobile' => 1,
            'overlay_opacity' => '0.6',
            'created_at' => $this->now(), 'updated_at' => $this->now(),
        ]);
    }

    protected function seedFooter(): void
    {
        $this->insert('footer_settings', [
            'description' => 'Alanya ve Mahmutlar başta olmak üzere çevre bölgelerde hafriyat, kepçe kiralama, moloz taşıma ve çevre düzenleme hizmetleri sunuyoruz.',
            'copyright_text' => '© ' . date('Y') . ' Ersan Hafriyat. Tüm hakları saklıdır.',
            'column_1_title' => 'Hizmetlerimiz',
            'column_1_links_json' => json_encode([
                ['title' => 'Alanya Hafriyat Hizmeti', 'url' => '/hizmetler/alanya-hafriyat-hizmeti'],
                ['title' => 'Kepçe Kiralama', 'url' => '/hizmetler/kepce-kiralama'],
                ['title' => 'Temel Kazısı', 'url' => '/hizmetler/temel-kazisi'],
                ['title' => 'Alt Yapı ve Kanal Açma', 'url' => '/hizmetler/alt-yapi-kanal-acma'],
                ['title' => 'Arsa Tesviye', 'url' => '/hizmetler/arsa-tesviye-dolgu'],
            ], JSON_UNESCAPED_UNICODE),
            'column_2_title' => 'Hızlı Linkler',
            'column_2_links_json' => json_encode([
                ['title' => 'Ana Sayfa', 'url' => '/'],
                ['title' => 'Hakkımızda', 'url' => '/hakkimizda'],
                ['title' => 'Makine Parkuru', 'url' => '/makine-parkuru'],
                ['title' => 'Projelerimiz', 'url' => '/projeler'],
                ['title' => 'Galeri', 'url' => '/galeri'],
                ['title' => 'Blog', 'url' => '/blog'],
            ], JSON_UNESCAPED_UNICODE),
            'column_3_title' => 'Hizmet Bölgeleri',
            'column_3_content' => 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez ve çevresi',
            'background_color' => '#111111',
            'text_color' => '#CBD5E1',
            'created_at' => $this->now(), 'updated_at' => $this->now(),
        ]);
    }

    protected function seedSocial(): void
    {
        $links = [
            ['facebook', 'https://facebook.com', 'facebook'],
            ['instagram', 'https://instagram.com', 'instagram'],
            ['whatsapp', 'https://wa.me/905321234567', 'whatsapp'],
        ];
        $i = 0;
        foreach ($links as [$platform, $url, $icon]) {
            $this->insert('social_links', [
                'platform' => $platform, 'url' => $url, 'icon' => $icon,
                'sort_order' => $i++, 'is_active' => 1,
            ]);
        }
    }

    protected function seedNotifications(): void
    {
        $this->insert('notification_settings', [
            'owner_name' => 'Ersan Hafriyat',
            'owner_phone' => '905321234567',
            'owner_email' => 'info@ersanhafriyat.com.tr',
            'whatsapp_api_enabled' => 0,
            'sms_enabled' => 0,
            'email_enabled' => 0,
            'telegram_enabled' => 0,
            'notify_on_new_lead' => 1,
            'notify_on_contact_form' => 1,
            'notify_on_whatsapp_click' => 0,
            'notify_on_popup_click' => 0,
            'notify_on_admin_login' => 0,
            'notify_on_new_visitor' => 0,
            'visitor_notification_throttle_minutes' => 30,
            'created_at' => $this->now(), 'updated_at' => $this->now(),
        ]);
    }

    protected function seedTestimonials(): void
    {
        $items = [
            ['Mehmet A.', 'Mahmutlar', 'Villa temeli için kazı işini çok hızlı ve temiz yaptılar. Kesinlikle tavsiye ederim.', 5],
            ['Ayşe K.', 'Kestel', 'Bahçe düzenleme ve arsa tesviyesinde profesyonel bir ekip. Teşekkürler.', 5],
            ['Hasan Y.', 'Oba', 'Moloz taşıma işini zamanında ve uygun fiyata hallettiler.', 5],
        ];
        $i = 0;
        foreach ($items as [$name, $loc, $comment, $rating]) {
            $this->insert('testimonials', [
                'name' => $name, 'location' => $loc, 'comment' => $comment,
                'rating' => $rating, 'sort_order' => $i++, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedServiceRegions(): void
    {
        // Varsayılan bölgeler (admin panelden tamamen değiştirilebilir)
        $regions = [
            ['Mahmutlar', 'Antalya', 'Alanya'], ['Kestel', 'Antalya', 'Alanya'],
            ['Kargıcak', 'Antalya', 'Alanya'], ['Oba', 'Antalya', 'Alanya'],
            ['Tosmur', 'Antalya', 'Alanya'], ['Alanya Merkez', 'Antalya', 'Alanya'],
            ['Cikcilli', 'Antalya', 'Alanya'], ['Çıplaklı', 'Antalya', 'Alanya'],
            ['Payallar', 'Antalya', 'Alanya'], ['Konaklı', 'Antalya', 'Alanya'],
            ['Avsallar', 'Antalya', 'Alanya'], ['Gazipaşa', 'Antalya', 'Gazipaşa'],
        ];
        $i = 0;
        foreach ($regions as [$title, $city, $district]) {
            $this->insert('service_regions', [
                'title' => $title, 'slug' => slugify($title),
                'city' => $city, 'district' => $district,
                'sort_order' => $i++, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }
}
