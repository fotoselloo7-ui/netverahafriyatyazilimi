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

    protected function insert(string $table, array $data): int
    {
        $cols = '`' . implode('`, `', array_keys($data)) . '`';
        $ph = implode(', ', array_fill(0, count($data), '?'));
        $stmt = $this->pdo->prepare("INSERT INTO `$table` ($cols) VALUES ($ph)");
        $stmt->execute(array_values($data));
        return (int) $this->pdo->lastInsertId();
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
            'name' => 'Netvera Yönetici',
            'email' => 'admin@netverahafriyat.local',
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
            ['site_name', 'Netvera Hafriyat', 'general', 'text'],
            ['site_tagline', 'Alanya Hafriyat • Kepçe Kiralama • Mini Kepçe', 'general', 'text'],
            ['phone', '+90 539 528 01 48', 'contact', 'text'],
            ['whatsapp_number', '905395280148', 'contact', 'text'],
            ['email', 'info@netvera.tr', 'contact', 'text'],
            ['address', 'Mahmutlar Mah. Alanya / ANTALYA', 'contact', 'text'],
            ['working_hours', 'Pzt - Cmt: 08:00 - 18:00', 'contact', 'text'],
            ['top_bar_text', 'Alanya ve çevresinde hafriyat, kepçe ve kazı hizmetleri', 'general', 'text'],
            ['map_embed', 'https://www.google.com/maps?q=Mahmutlar+Alanya+Antalya&output=embed', 'contact', 'textarea'],
            ['seo_title', 'Alanya Hafriyat | Kepçe, Kazı ve Moloz Hizmetleri | Netvera Hafriyat', 'seo', 'text'],
            ['seo_description', 'Alanya’da hafriyat, operatörlü kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye hizmetleri. İşiniz için hızlı teklif alın.', 'seo', 'textarea'],
            ['seo_keywords', 'alanya hafriyat, alanya kepçe kiralama, alanya mini kepçe, temel kazısı, moloz taşıma, arsa tesviye', 'seo', 'text'],
            ['og_image', 'genel/alanya-hafriyat-og-kapak.webp', 'seo', 'image'],
            ['footer_about', 'Netvera Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme ihtiyaçlarına yönelik çözümler sunar.', 'general', 'textarea'],
            ['logo', 'genel/netvera-hafriyat-logo.webp', 'general', 'image'],
            ['about_counter_experience', '', 'about', 'text'],
            ['about_counter_projects', '', 'about', 'text'],
            ['about_counter_staff', '', 'about', 'text'],
            ['about_counter_support', '', 'about', 'text'],
            ['floating_whatsapp_enabled', '1', 'general', 'toggle'],
            ['web_design_credit_text', 'Netvera Teknoloji Yazılım', 'footer', 'text'],
            ['web_design_credit_url', '', 'footer', 'text'],
            ['content_pack_version', '7', 'system', 'text'],
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
            ['Projelerimiz', '/projeler', 'internal'],
            ['Blog', '/blog', 'internal'],
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
            ['Ana Sayfa', '/'], ['Hakkımızda', '/hakkimizda'], ['Hizmetlerimiz', '/hizmetler'],
            ['Projelerimiz', '/projeler'], ['Blog', '/blog'], ['İletişim', '/iletisim'],
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
            ['Konum', 'internal', '/iletisim#konum', 'map-pin'],
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
            'excerpt' => 'Netvera Hafriyat; Mahmutlar’dan Alanya ve çevresine hafriyat, kepçe kiralama, kazı, taşıma ve tesviye hizmetleri sunar.',
            'content' => '<p>Netvera Hafriyat, Mahmutlar’dan Alanya ve çevresine hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme hizmetleri sunar.</p><p>Her işte önce çalışma alanının erişimi, zemin yapısı, kazı veya taşıma kapsamı ve ihtiyaç duyulan makine tipi değerlendirilir. Amaç; gereksiz iş kalemleri oluşturmadan sahaya uygun bir çalışma planı ve net teklif hazırlamaktır.</p><p>Talebinizi telefon veya WhatsApp üzerinden iletebilir; yapılacak işin konumu, yaklaşık alanı, erişim koşulları ve varsa fotoğrafları paylaşarak daha doğru bir ön değerlendirme alabilirsiniz.</p>',
            'hero_title' => 'Netvera Hafriyat Hakkında',
            'hero_subtitle' => 'Alanya’da hafriyat, kepçe ve kazı ihtiyaçları için saha odaklı çözüm',
            'hero_image' => 'sayfalar/ersan-hafriyat-hakkimizda-saha.webp',
            'cover_image' => 'sayfalar/ersan-hafriyat-hakkimizda-saha.webp',
            'og_image' => 'genel/alanya-hafriyat-og-kapak.webp',
            'hero_overlay_opacity' => '0.55',
            'seo_title' => 'Netvera Hafriyat Hakkında | Alanya Hafriyat ve Kepçe',
            'seo_description' => 'Netvera Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel kazısı, moloz taşıma ve arsa tesviye hizmetleri sunar.',
            'robots_index' => 1,
            'is_active' => 1,
            'created_at' => $this->now(),
            'updated_at' => $this->now(),
        ]);

        $legal = [
            ['Gizlilik Politikası', 'gizlilik-politikasi', '<p>Bu web sitesi üzerinden iletilen iletişim ve teklif bilgileri yalnızca talebinizi değerlendirmek, size dönüş yapmak ve hizmet sürecini yürütmek amacıyla kullanılır.</p><p>Formlarda paylaşılan kişisel veriler üçüncü kişilere pazarlama amacıyla satılmaz. Yasal zorunluluklar ve hizmetin yürütülmesi için gerekli teknik sağlayıcılar saklıdır.</p>'],
            ['KVKK Aydınlatma Metni', 'kvkk', '<p>6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında; iletişim ve teklif formlarında paylaştığınız ad, telefon, e-posta, bölge ve mesaj bilgileri talebinizin değerlendirilmesi ve sizinle iletişim kurulması amacıyla işlenebilir.</p><p>Verilerinizle ilgili talepleriniz için sitede yer alan iletişim kanallarını kullanabilirsiniz.</p>'],
            ['Çerez Politikası', 'cerez-politikasi', '<p>Web sitesi; temel işlevlerin çalışması, güvenlik, tercihlerin hatırlanması ve ölçümleme amaçlarıyla gerekli olduğunda çerez ve benzeri teknolojiler kullanabilir.</p><p>Kullanılan üçüncü taraf ölçüm veya reklam araçları değişirse bu metnin yönetim panelinden güncellenmesi gerekir.</p>'],
        ];
        foreach ($legal as [$title, $slug, $content]) {
            $this->insert('pages', [
                'title' => $title, 'slug' => $slug, 'content' => $content,
                'hero_title' => $title, 'hero_overlay_opacity' => '0.55',
                'seo_title' => $title . ' | Netvera Hafriyat', 'robots_index' => 0,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedHomeSections(): void
    {
        $sectionImages = [
            'hero' => 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            'machine_anim' => 'anasayfa/alanya-hafriyat-mini-kepce-saha.webp',
        ];
        $sections = [
            ['hero', 'Alanya Hafriyat ve Kepçe Hizmetleri',
             'Alanya ve çevresinde hafriyat, operatörlü kepçe ve mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye işleri için ihtiyaca uygun saha çözümü.',
             json_encode([
                'button_1_text' => 'WhatsApp’tan Teklif Al', 'button_1_url' => 'Merhaba, Alanya’da hafriyat/kepçe hizmeti için teklif almak istiyorum.', 'button_1_type' => 'whatsapp',
                'button_2_text' => 'Hizmetleri İncele', 'button_2_url' => '/hizmetler', 'button_2_type' => 'internal',
                'overlay_opacity' => '0.55', 'show_form' => '1', 'show_badges' => '1',
                'badges' => [
                    ['icon' => 'message-circle', 'title' => 'Hızlı İletişim', 'text' => 'İşinizi telefon veya WhatsApp ile anlatın.'],
                    ['icon' => 'truck', 'title' => 'Doğru Makine Planı', 'text' => 'Makine seçimi işin türü ve saha koşullarına göre yapılır.'],
                    ['icon' => 'map-pin', 'title' => 'Yerel Hizmet', 'text' => 'Mahmutlar, Alanya Merkez ve çevre bölgeler.'],
                    ['icon' => 'shield', 'title' => 'Planlı Uygulama', 'text' => 'Erişim, zemin ve çalışma kapsamı önceden değerlendirilir.'],
                    ['icon' => 'tag', 'title' => 'Şeffaf Teklif', 'text' => 'Süre, makine, nakliye ve saha koşullarına göre fiyatlandırma.'],
                ],
             ], JSON_UNESCAPED_UNICODE),
             ''],
            ['services', 'Alanya Hafriyat Hizmetleri', 'Kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme hizmetleri.', null, ''],
            ['equipment', 'İşinize Uygun Makine Seçimi', 'İşin türü, saha koşulları ve erişime göre uygun makine seçeneği planlanır; marka/model ve mevcut makine teklif öncesinde teyit edilir.', null, ''],
            ['process', 'Hizmet Sürecimiz', 'Talebinizden saha uygulamasına kadar net ve planlı ilerleyen süreç', json_encode([
                ['icon' => 'message-circle', 'title' => 'Talebi Paylaşın', 'text' => 'Konum, iş türü, yaklaşık alan ve varsa saha fotoğraflarını iletin.'],
                ['icon' => 'search', 'title' => 'Saha İhtiyacını Belirleyelim', 'text' => 'Erişim, zemin, kazı derinliği ve çıkan malzeme gibi temel koşullar değerlendirilir.'],
                ['icon' => 'clipboard', 'title' => 'Makine ve İş Planı', 'text' => 'İşe uygun makine, süre, nakliye ve ekip ihtiyacı planlanır.'],
                ['icon' => 'hard-hat', 'title' => 'Uygulama', 'text' => 'Belirlenen çalışma kapsamına göre saha uygulaması gerçekleştirilir.'],
                ['icon' => 'check-circle', 'title' => 'Kontrol ve Teslim', 'text' => 'Tamamlanan iş saha koşulları ve talep kapsamına göre kontrol edilir.'],
            ], JSON_UNESCAPED_UNICODE), ''],
            ['machine_anim', 'Sahada Doğru Plan, Verimli Çalışma',
             'Kazı, yükleme, taşıma ve tesviye işlerinde makine seçimi; alanın erişimi, zemin ve iş kapsamına göre planlanır.', null, ''],
            ['gallery', 'Sahadan Gerçek Görüntüler', 'Bu bölümde yalnızca Netvera Hafriyat’ın gerçek çalışma fotoğraf ve videoları yayınlanır.', null, ''],
            ['projects', 'Son Projeler', 'Alanya ve çevresindeki gerçek saha çalışmalarından proje örnekleri.', null, ''],
            ['regions', 'Alanya Hizmet Bölgelerimiz', 'Mahmutlar’dan Alanya Merkez ve çevre mahallelere uzanan hizmet alanlarımız.', null, ''],
            ['blog', 'Hafriyat Bilgi Merkezi', 'Kepçe seçimi, fiyat faktörleri, kazı ve saha hazırlığı hakkında karar vermeyi kolaylaştıran içerikler.', null, ''],
            ['faq', 'Hafriyat ve Kepçe Hakkında Sık Sorulanlar', 'Fiyat, makine seçimi, çalışma süreci ve hizmet bölgeleri hakkında kısa cevaplar.', null, ''],
            ['final_cta', 'Alanya’da Hafriyat veya Kepçe Hizmetine mi İhtiyacınız Var?', 'İşin konumunu ve kapsamını paylaşın; uygun makine ve çalışma planı için teklif isteyin.', null, ''],
        ];
        $i = 0;
        foreach ($sections as [$key, $title, $subtitle, $json, $image]) {
            $this->insert('home_sections', [
                'section_key' => $key, 'title' => $title, 'subtitle' => $subtitle,
                'content_json' => $json, 'image' => $sectionImages[$key] ?? $image, 'sort_order' => $i++,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedServices(): void
    {
        $services = [
            [
                'title' => 'Kepçe Kiralama',
                'slug' => 'kepce-kiralama',
                'icon' => 'truck',
                'short' => 'Alanya’da temel kazısı, yükleme, kanal, tesviye ve saha işleri için operatörlü kepçe hizmeti.',
                'hero' => 'Alanya Kepçe Kiralama',
                'content' => '<h2>Alanya’da kepçe kiralama hangi işler için kullanılır?</h2><p>Kepçe kiralama; temel ve kanal kazısı, arsa düzenleme, yükleme, tesviye, moloz ve hafriyat işleri gibi farklı saha ihtiyaçlarında kullanılır. Doğru makine seçimi işin büyüklüğü, zemin yapısı, çalışma alanına erişim ve çıkarılacak malzemenin miktarına göre yapılır.</p><h2>Operatörlü kepçe hizmetinde süreç nasıl işler?</h2><p>Teklif öncesinde işin konumu, yapılacak çalışma, yaklaşık alan veya kazı ölçüsü, makinenin sahaya giriş koşulları ve varsa fotoğraflar değerlendirilir. Saatlik veya günlük çalışma ihtiyacı da bu kapsam içinde netleştirilir.</p><h2>Kepçe kiralama fiyatını neler belirler?</h2><p>Fiyat; çalışma süresi, kullanılacak makine tipi, makinenin sahaya nakli, zemin koşulları, ataşman ihtiyacı, çıkan hafriyatın taşınıp taşınmayacağı ve kamyon gereksinimi gibi kalemlere göre değişir. Bu nedenle tek bir sabit fiyat yerine işin kapsamına göre teklif hazırlanır.</p>',
                'advantages' => ['İşin kapsamına göre makine planlama', 'Operatörlü çalışma', 'Kazı, yükleme ve tesviye ihtiyaçlarını birlikte değerlendirme', 'Telefon ve WhatsApp üzerinden hızlı ön değerlendirme', 'Saha koşullarına göre teklif'],
                'usage' => ['Temel ve yapı kazıları', 'Kanal ve altyapı kazıları', 'Arsa tesviye ve dolgu', 'Toprak ve moloz yükleme', 'Bahçe ve saha düzenleme'],
                'seo_title' => 'Alanya Kepçe Kiralama | Operatörlü Kepçe | Netvera Hafriyat',
                'seo_description' => 'Alanya’da operatörlü kepçe kiralama; temel ve kanal kazısı, yükleme, tesviye ve hafriyat işleri. İşinize uygun makine için Netvera Hafriyat’tan teklif alın.',
                'faqs' => [
                    ['Alanya’da kepçe kiralama fiyatı nasıl belirlenir?', 'Fiyat; çalışma süresi, makine tipi, saha erişimi, nakliye, zemin, ataşman ihtiyacı ve çıkan malzemenin taşınması gibi iş kalemlerine göre belirlenir.'],
                    ['Saatlik veya günlük kepçe çalışması mümkün mü?', 'Çalışma modeli işin kapsamına ve sahaya göre planlanır. Saatlik veya günlük uygunluk için işin konumunu ve yapılacak çalışmayı ileterek teklif isteyebilirsiniz.'],
                    ['Makinenin sahaya nakli nasıl planlanır?', 'Makine tipi, çalışma konumu ve saha erişimi netleştirildikten sonra uygun taşıma yöntemi teklif kapsamına dahil edilir.'],
                ],
            ],
            [
                'title' => 'Mini Kepçe Kiralama',
                'slug' => 'mini-kepce-kiralama',
                'icon' => 'excavator',
                'short' => 'Dar alan, bahçe, küçük temel ve kanal işleri için Alanya mini kepçe ve mini ekskavatör çözümleri.',
                'hero' => 'Alanya Mini Kepçe Kiralama',
                'content' => '<h2>Mini kepçe hangi işlerde tercih edilir?</h2><p>Mini kepçe; büyük iş makinelerinin manevra yapmakta zorlandığı dar bahçeler, bina çevreleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve hassas tesviye işleri için tercih edilir. En önemli avantajı sınırlı çalışma alanlarında kontrollü hareket edebilmesidir.</p><h2>Dar alanda makine seçimi nasıl yapılır?</h2><p>Kapı veya geçiş genişliği, saha içindeki dönüş alanı, kazı derinliği, zemin tipi ve çıkan malzemenin nasıl uzaklaştırılacağı birlikte değerlendirilir. Gerçek makine ölçüleri yalnız doğrulanmış ekipman bilgisi üzerinden paylaşılır.</p><h2>Mini kepçe fiyatını etkileyen faktörler</h2><p>Çalışma süresi, makinenin sahaya nakli, zemin koşulları, kazı derinliği, ataşman ihtiyacı ve moloz/hafriyat taşıması fiyatı etkileyebilir.</p>',
                'advantages' => ['Dar alanlarda çalışma planı', 'Bahçe ve bina çevresinde kontrollü kazı', 'Küçük temel ve kanal işleri', 'Erişim ölçülerine göre ön değerlendirme', 'Hassas tesviye ve düzenleme'],
                'usage' => ['Dar bahçe girişleri', 'Küçük temel kazıları', 'Kanal ve tesisat hatları', 'Peyzaj ve çevre düzenleme', 'Hassas tesviye işleri'],
                'seo_title' => 'Alanya Mini Kepçe Kiralama | Dar Alan Kazı | Netvera Hafriyat',
                'seo_description' => 'Alanya mini kepçe kiralama; dar bahçe girişleri, küçük temel ve kanal kazıları, peyzaj ve hassas saha işleri. İşiniz için uygun mini kepçe planı alın.',
                'faqs' => [
                    ['Mini kepçe dar bahçe girişlerinde kullanılabilir mi?', 'Uygunluk giriş genişliği, dönüş alanı ve kullanılacak gerçek makinenin ölçülerine bağlıdır. Saha ölçülerini ve fotoğrafları paylaşarak ön değerlendirme yapılabilir.'],
                    ['Mini kepçe ile temel kazısı yapılır mı?', 'Küçük ölçekli temel ve benzeri kazılarda kullanılabilir; uygunluk kazı derinliği, zemin ve iş hacmine göre belirlenir.'],
                    ['Mini kepçe fiyatı neye göre değişir?', 'Çalışma süresi, nakliye, zemin, erişim, kazı kapsamı ve varsa ataşman ihtiyacı fiyatı etkileyen başlıca unsurlardır.'],
                ],
            ],
            [
                'title' => 'Temel Kazısı',
                'slug' => 'temel-kazisi',
                'icon' => 'layers',
                'short' => 'Alanya’da villa, konut ve yapı projeleri için saha koşullarına uygun temel kazısı hizmeti.',
                'hero' => 'Alanya Temel Kazısı',
                'content' => '<h2>Temel kazısı öncesinde nelere bakılır?</h2><p>Temel kazısında proje ölçüleri kadar zeminin yapısı, makinenin sahaya erişimi, kazı derinliği, çıkan toprağın sahada kullanılıp kullanılmayacağı ve taşıma ihtiyacı önemlidir.</p><h2>Kazıdan çıkan malzeme nasıl yönetilir?</h2><p>Çıkan malzemenin bir kısmı dolgu veya tesviye için değerlendirilebilir; taşınması gereken toprak ve moloz için yükleme ve nakliye planı oluşturulur.</p><h2>Teklif için hangi bilgiler gerekir?</h2><p>Konum, proje veya yaklaşık kazı ölçüsü, saha giriş durumu, zeminle ilgili bilinen bilgiler ve fotoğraflar teklifin daha doğru hazırlanmasına yardımcı olur.</p>',
                'advantages' => ['Kazı ölçülerine göre planlama', 'Saha erişimi ve zemin değerlendirmesi', 'Hafriyat yükleme ve taşıma ihtiyacını birlikte planlama', 'Tesviye ve dolgu ihtiyacını aynı süreçte değerlendirme', 'İş kapsamına göre makine seçimi'],
                'usage' => ['Villa temel kazısı', 'Konut ve yapı temelleri', 'İstinat ve çevre kazıları', 'Temel çevresi düzenleme', 'Kazı sonrası dolgu ve tesviye'],
                'seo_title' => 'Alanya Temel Kazısı | Bina ve Villa Kazısı | Netvera Hafriyat',
                'seo_description' => 'Alanya’da bina ve villa temel kazısı; saha erişimi, zemin, kazı ölçüsü, hafriyat taşıma ve tesviye ihtiyacına göre planlı kazı hizmeti.',
                'faqs' => [
                    ['Temel kazısı fiyatı nasıl hesaplanır?', 'Kazı hacmi, zemin, makine tipi, çalışma süresi, saha erişimi ve çıkan malzemenin taşınma ihtiyacı temel fiyat faktörleridir.'],
                    ['Kazıdan çıkan toprak taşınabilir mi?', 'Taşıma ihtiyacı varsa kazı ile birlikte yükleme ve nakliye planlanabilir. Net kapsam sahadaki malzeme miktarına göre belirlenir.'],
                    ['Temel kazısı için keşif gerekir mi?', 'Ölçekli veya erişimi zor işlerde saha koşullarını görmek daha doğru makine ve süre planı yapılmasını sağlar.'],
                ],
            ],
            [
                'title' => 'Moloz ve Hafriyat Taşıma',
                'slug' => 'moloz-hafriyat-nakliye',
                'icon' => 'truck',
                'short' => 'Alanya’da kazıdan çıkan toprak, hafriyat ve molozun yükleme ve taşıma ihtiyacına yönelik saha planlaması.',
                'hero' => 'Alanya Moloz ve Hafriyat Taşıma',
                'content' => '<h2>Moloz ve hafriyat taşıma nasıl planlanır?</h2><p>Taşıma işinde malzemenin türü ve tahmini miktarı, yükleme alanı, sahaya araç giriş-çıkışı ve uygun boşaltma planı birlikte değerlendirilir. Kazı işiyle eş zamanlı planlama yapılması sahadaki beklemeyi azaltabilir.</p><h2>Yükleme hizmeti de dahil olabilir mi?</h2><p>İşin kapsamına göre moloz veya toprağın kepçe ile yüklenmesi ve taşıma süreci birlikte değerlendirilebilir. Teklif için yaklaşık miktar, konum ve malzeme türünün paylaşılması yararlıdır.</p><h2>Fiyatı etkileyen unsurlar</h2><p>Malzeme miktarı, yükleme ihtiyacı, taşıma mesafesi, saha erişimi, çalışma süresi ve ek makine gereksinimi fiyatı belirleyen ana kalemlerdir.</p>',
                'advantages' => ['Kazı ve taşıma işini birlikte planlama', 'Yükleme ihtiyacını kapsama dahil etme', 'Malzeme miktarına göre araç planı', 'Saha giriş-çıkış koşullarını değerlendirme', 'Konum ve iş kapsamına göre teklif'],
                'usage' => ['Kazı toprağı taşıma', 'İnşaat molozu yükleme ve taşıma', 'Arsa ve bahçe temizliği sonrası malzeme', 'Temel kazısı hafriyatı', 'Saha temizliği'],
                'seo_title' => 'Alanya Moloz Taşıma | Hafriyat Nakliye | Netvera Hafriyat',
                'seo_description' => 'Alanya’da moloz taşıma ve hafriyat nakliye; yükleme, kazı toprağı, saha erişimi ve taşıma ihtiyacına göre planlama. Netvera Hafriyat’tan teklif alın.',
                'faqs' => [
                    ['Alanya moloz taşıma fiyatı neye göre belirlenir?', 'Malzeme miktarı, yükleme ihtiyacı, taşıma mesafesi, saha erişimi ve gereken araç/makine süresi fiyatı etkiler.'],
                    ['Molozun yüklenmesi de yapılabilir mi?', 'İş kapsamına göre kepçe ile yükleme ve taşıma birlikte planlanabilir.'],
                    ['Kazı ve hafriyat taşıma aynı işte planlanabilir mi?', 'Evet, kazı sırasında çıkan malzemenin taşınması gerekiyorsa iki iş tek çalışma planında değerlendirilebilir.'],
                ],
            ],
            [
                'title' => 'Altyapı ve Kanal Kazısı',
                'slug' => 'alt-yapi-kanal-acma',
                'icon' => 'git-branch',
                'short' => 'Alanya’da altyapı, drenaj, tesisat ve benzeri hatlar için kanal kazısı ve saha hazırlığı.',
                'hero' => 'Alanya Kanal Kazısı ve Altyapı',
                'content' => '<h2>Kanal kazısı hangi işler için yapılır?</h2><p>Kanal kazısı; drenaj, su ve tesisat hatları, altyapı geçişleri ve benzeri saha ihtiyaçlarında uygulanır. Çalışmanın genişliği ve derinliği, mevcut hatlar, zemin yapısı ve makinenin alana erişimi planlamada önemlidir.</p><h2>Dar alanlarda kanal kazısı</h2><p>Bahçe, bina çevresi veya sınırlı geçişe sahip alanlarda daha küçük makine ihtiyacı doğabilir. Kullanılacak makine, gerçek geçiş ölçüsü ve kazı kapsamına göre seçilir.</p><h2>Çalışma öncesi nelere dikkat edilir?</h2><p>Mevcut altyapı hatları ve proje bilgileri mümkün olduğunca önceden belirlenmeli; kazı güzergâhı, malzemenin nereye alınacağı ve kazı sonrası dolgu ihtiyacı birlikte değerlendirilmelidir.</p>',
                'advantages' => ['Kazı güzergâhına göre planlama', 'Dar alan koşullarını değerlendirme', 'Kazı sonrası dolgu ihtiyacını planlama', 'Zemin ve derinliğe göre makine seçimi', 'Saha düzenine uygun çalışma'],
                'usage' => ['Drenaj kanalı', 'Su ve tesisat hattı kazısı', 'Altyapı geçişleri', 'Bahçe ve bina çevresi kanal işleri', 'Kazı sonrası dolgu'],
                'seo_title' => 'Alanya Kanal Kazısı ve Altyapı | Netvera Hafriyat',
                'seo_description' => 'Alanya’da kanal kazısı, drenaj ve altyapı çalışmaları; dar alan, zemin, derinlik ve dolgu ihtiyacına göre saha planlaması ve teklif.',
                'faqs' => [
                    ['Kanal kazısında kullanılacak makine nasıl seçilir?', 'Kanalın genişliği ve derinliği, saha erişimi ve zemin yapısı makine seçiminde belirleyicidir.'],
                    ['Dar alanda kanal kazısı yapılabilir mi?', 'Uygunluk geçiş ölçüsü ve çalışma alanına bağlıdır. Saha ölçüleri paylaşıldığında mini makine seçeneği değerlendirilebilir.'],
                    ['Kazı sonrası dolgu yapılabilir mi?', 'İş kapsamına göre kanal kazısı sonrasında dolgu ve saha düzenleme ihtiyacı aynı plan içinde değerlendirilebilir.'],
                ],
            ],
            [
                'title' => 'Arsa Tesviye ve Dolgu',
                'slug' => 'arsa-tesviye-dolgu',
                'icon' => 'mountain',
                'short' => 'Alanya’da arsa, bahçe ve yapı çevresinde kot düzenleme, tesviye, dolgu ve yüzey hazırlığı.',
                'hero' => 'Alanya Arsa Tesviye ve Dolgu',
                'content' => '<h2>Arsa tesviyesi nedir?</h2><p>Arsa tesviyesi; yüzeydeki seviye farklarının işin amacına göre düzenlenmesi, gerekli alanların kazılması veya doldurulması ve sahada kontrollü bir eğim/kot oluşturulması işlemidir.</p><h2>Dolgu işinde hangi bilgiler önemlidir?</h2><p>Kullanılacak dolgu malzemesi, dolgu kalınlığı, alanın mevcut kotu, drenaj ihtiyacı ve sıkıştırma gereksinimi işin kapsamını etkiler.</p><h2>Fiyatı ne belirler?</h2><p>Alan büyüklüğü, taşınacak veya getirilecek malzeme miktarı, makine süresi, zemin ve erişim koşulları tesviye/dolgu fiyatında temel unsurlardır.</p>',
                'advantages' => ['Kot ve yüzey ihtiyacına göre çalışma', 'Kazı ve dolgu kalemlerini birlikte değerlendirme', 'Arsa ve bahçe düzenleme desteği', 'Malzeme hareketine göre makine planı', 'Saha erişimine göre teklif'],
                'usage' => ['Arsa düzeltme', 'Yapı öncesi saha hazırlığı', 'Bahçe tesviyesi', 'Toprak dolgu', 'Kot ve eğim düzenleme'],
                'seo_title' => 'Alanya Arsa Tesviye ve Dolgu | Netvera Hafriyat',
                'seo_description' => 'Alanya’da arsa tesviye, zemin düzenleme ve dolgu işleri. Alan, kot, malzeme miktarı, zemin ve makine ihtiyacına göre planlı saha çalışması.',
                'faqs' => [
                    ['Arsa tesviye fiyatı nasıl belirlenir?', 'Alan büyüklüğü, kot farkı, taşınacak veya getirilecek malzeme, makine süresi ve saha erişimi fiyatı etkiler.'],
                    ['Tesviye ile dolgu aynı işte yapılabilir mi?', 'Saha ihtiyacına göre kazı, dolgu ve yüzey düzenleme aynı çalışma planında ele alınabilir.'],
                    ['Bahçe tesviyesi için büyük kepçe şart mı?', 'Hayır. Makine seçimi alanın büyüklüğü ve erişim koşullarına göre yapılır; dar alanlarda daha küçük ekipman gerekebilir.'],
                ],
            ],
            [
                'title' => 'Arsa Temizleme ve Bahçe Düzenleme',
                'slug' => 'cevre-bahce-duzenleme',
                'icon' => 'trees',
                'short' => 'Alanya’da arsa ve bahçelerde saha temizliği, toprak düzenleme, tesviye ve kazı ihtiyaçları.',
                'hero' => 'Alanya Arsa Temizleme ve Bahçe Düzenleme',
                'content' => '<h2>Arsa ve bahçe temizliği hangi işleri kapsar?</h2><p>Saha temizliği; zemindeki birikintilerin kaldırılması, gerekli alanlarda kazı yapılması, toprağın düzenlenmesi, tesviye ve çıkan malzemenin yüklenip taşınması gibi farklı iş kalemlerini içerebilir.</p><h2>Bahçe alanlarında neden makine seçimi önemlidir?</h2><p>Bahçe kapısı, duvarlar, ağaçlar ve mevcut yapılar çalışma alanını sınırlayabilir. Bu nedenle makine boyutu ve hareket alanı önceden değerlendirilmelidir.</p><h2>Temizlik sonrası saha düzenlenebilir mi?</h2><p>İhtiyaca göre yüzey düzeltme, tesviye veya dolgu çalışmaları temizlik sonrasında aynı plan içinde ele alınabilir.</p>',
                'advantages' => ['Saha temizliği ve düzenlemeyi birlikte planlama', 'Dar girişleri değerlendirme', 'Yükleme ve taşıma ihtiyacını kapsama dahil etme', 'Tesviye ve dolgu seçeneği', 'Arazi durumuna göre makine planı'],
                'usage' => ['Arsa temizleme', 'Bahçe toprak düzenleme', 'Ağaç kökü ve alan temizliği', 'Yüzey tesviyesi', 'Yapı çevresi saha hazırlığı'],
                'seo_title' => 'Alanya Arsa Temizleme ve Bahçe Düzenleme | Netvera Hafriyat',
                'seo_description' => 'Alanya’da arsa temizleme, bahçe düzenleme, toprak tesviye, yükleme ve saha hazırlığı. Alanın erişim ve zemin koşullarına göre teklif alın.',
                'faqs' => [
                    ['Arsa temizleme işinde moloz taşıma da yapılabilir mi?', 'İş kapsamına göre çıkan malzemenin yüklenmesi ve taşınması aynı plan içinde değerlendirilebilir.'],
                    ['Dar bahçelerde hangi makine kullanılır?', 'Makine seçimi kapı/geçiş genişliği, dönüş alanı ve yapılacak işin hacmine göre belirlenir.'],
                    ['Temizlik sonrası tesviye yapılabilir mi?', 'Evet, ihtiyaç varsa yüzey düzeltme, tesviye ve dolgu kalemleri çalışma planına eklenebilir.'],
                ],
            ],
            [
                'title' => 'Drenaj ve Özel Kazı İşleri',
                'slug' => 'drenaj-ozel-kazi',
                'icon' => 'droplet',
                'short' => 'Alanya’da drenaj hattı, özel ölçülü kazı ve saha koşullarına göre planlanan kazı çalışmaları.',
                'hero' => 'Alanya Drenaj ve Özel Kazı İşleri',
                'content' => '<h2>Drenaj kazısı ne zaman gerekir?</h2><p>Drenaj kanalı veya hattı için yapılacak kazılarda güzergâh, eğim, derinlik, mevcut zemin ve saha erişimi birlikte değerlendirilir. Teknik proje gerektiren işlerde uygulama ilgili proje ve ölçülere göre yapılmalıdır.</p><h2>Özel kazı ne demektir?</h2><p>Standart geniş saha kazılarından farklı olarak dar geçiş, belirli ölçü veya hassas çalışma gerektiren işler özel kazı kapsamında değerlendirilebilir.</p><h2>Dolgu ve kapatma nasıl planlanır?</h2><p>Hat çalışması sonrasında dolgu, yüzey düzenleme veya tesviye ihtiyacı varsa bu kalemler kazı planıyla birlikte değerlendirilir.</p>',
                'advantages' => ['Güzergâh ve ölçüye göre kazı planı', 'Dar veya hassas alanları değerlendirme', 'Zemin ve erişime göre makine seçimi', 'Kazı sonrası dolgu ihtiyacını planlama', 'İş kapsamına göre teklif'],
                'usage' => ['Drenaj kanalları', 'Özel ölçülü kazılar', 'Bahçe ve yapı çevresi hatları', 'Dar alan çalışmaları', 'Kazı sonrası dolgu'],
                'seo_title' => 'Alanya Drenaj ve Özel Kazı İşleri | Netvera Hafriyat',
                'seo_description' => 'Alanya’da drenaj kanalı ve özel kazı işleri; güzergâh, derinlik, zemin ve saha erişimine göre makine ve çalışma planı.',
                'faqs' => [
                    ['Drenaj kazısı için hangi bilgiler gerekir?', 'Hat güzergâhı, yaklaşık uzunluk ve derinlik, saha erişimi ve varsa proje/ölçü bilgileri ön değerlendirme için önemlidir.'],
                    ['Dar alanda özel kazı yapılabilir mi?', 'Uygunluk geçiş ölçülerine ve gerçek makine seçeneklerine bağlıdır; saha bilgileri paylaşıldığında değerlendirilir.'],
                    ['Kazı sonrası dolgu planlanabilir mi?', 'İş kapsamına göre dolgu ve yüzey düzenleme çalışmaları kazı sürecine eklenebilir.'],
                ],
            ],
            [
                'title' => 'Havuz Kazısı',
                'slug' => 'havuz-kazisi',
                'icon' => 'droplet',
                'short' => 'Alanya’da villa ve bahçe projelerinde havuz alanı açma, kazı, yükleme ve saha hazırlığı.',
                'hero' => 'Alanya Havuz Kazısı',
                'content' => '<h2>Havuz kazısı nasıl planlanır?</h2><p>Havuz kazısında proje ölçüsü, kazı derinliği, makine erişimi, zemin yapısı ve çıkan toprağın nasıl yönetileceği birlikte değerlendirilir. Bahçe duvarı, giriş genişliği ve yapı çevresindeki hareket alanı makine seçimini doğrudan etkileyebilir.</p><h2>Kazı toprağı ne olur?</h2><p>Çıkan malzemenin sahada kullanılacak kısmı ile taşınacak kısmı ayrılarak yükleme ve nakliye ihtiyacı planlanabilir.</p><h2>Teklif için ne gerekir?</h2><p>Konum, havuz projesi veya yaklaşık ölçüler, saha giriş bilgisi ve fotoğraflar ön değerlendirmeyi hızlandırır.</p>',
                'advantages' => ['Proje ölçüsüne göre kazı planı', 'Dar bahçe erişimini değerlendirme', 'Kazı ve hafriyat taşımasını birlikte planlama', 'Zemin koşullarına göre makine seçimi', 'Kazı sonrası saha düzeni'],
                'usage' => ['Villa havuzu kazısı', 'Bahçe havuzu alan açma', 'Havuz çevresi saha hazırlığı', 'Kazı toprağı yükleme', 'Kazı sonrası tesviye'],
                'seo_title' => 'Alanya Havuz Kazısı | Villa ve Bahçe Havuzu | Netvera Hafriyat',
                'seo_description' => 'Alanya’da havuz kazısı; proje ölçüsü, bahçe erişimi, zemin, kazı derinliği ve hafriyat taşıma ihtiyacına göre planlı çalışma.',
                'faqs' => [
                    ['Havuz kazısı için mini kepçe kullanılabilir mi?', 'Uygunluk havuz ölçüsü, kazı derinliği, zemin ve bahçe erişimine bağlıdır. Dar alanlarda mini kepçe seçeneği değerlendirilebilir.'],
                    ['Havuz kazısından çıkan toprak taşınır mı?', 'İş kapsamına göre çıkan malzemenin yüklenmesi ve taşınması ayrıca planlanabilir.'],
                    ['Teklif için proje çizimi gerekli mi?', 'Proje veya ölçü bilgisi teklifin doğruluğunu artırır; yoksa yaklaşık ölçü ve saha fotoğraflarıyla ön değerlendirme yapılabilir.'],
                ],
            ],
            [
                'title' => 'Yol Açma ve Saha Hazırlığı',
                'slug' => 'yol-acma-saha-hazirlama',
                'icon' => 'mountain',
                'short' => 'Alanya’da arsa içi ulaşım, şantiye girişi, yüzey açma, kot düzenleme ve yol altyapısı hazırlığı.',
                'hero' => 'Alanya Yol Açma ve Saha Hazırlığı',
                'content' => '<h2>Yol açma çalışması hangi aşamalardan oluşur?</h2><p>Arsa veya şantiye içi yol hazırlığında güzergâh, mevcut eğim, zemin yapısı, genişlik ve kullanılacak malzeme belirlenir. Gerekli alanlarda yüzey kazısı, tesviye ve dolgu yapılabilir.</p><h2>Şantiye girişi nasıl hazırlanır?</h2><p>Makine ve kamyon geçişine uygun bir çalışma alanı oluşturmak için giriş genişliği, dönüş noktaları ve zemin taşıma durumu değerlendirilir.</p><h2>Serme ve sıkıştırma gerekir mi?</h2><p>Yol veya saha kullanım amacına göre stabilize veya benzeri dolgu malzemelerinin serilmesi ve sıkıştırılması ayrı bir iş kalemi olarak planlanabilir.</p>',
                'advantages' => ['Güzergâh ve kot planlama', 'Yüzey kazısı ve tesviye', 'Dolgu ihtiyacını birlikte değerlendirme', 'Kamyon ve makine erişimine göre saha düzeni', 'Serme-sıkıştırma ile entegre planlama'],
                'usage' => ['Arsa içi yol açma', 'Şantiye girişi hazırlama', 'Arazi geçiş yolu', 'Yol tabanı hazırlığı', 'Saha kot düzenleme'],
                'seo_title' => 'Alanya Yol Açma ve Saha Hazırlığı | Netvera Hafriyat',
                'seo_description' => 'Alanya’da yol açma, şantiye girişi, yüzey kazısı, tesviye ve saha hazırlığı. Güzergâh ve zemin koşullarına göre çalışma planı ve teklif.',
                'faqs' => [
                    ['Arsa içi yol açma fiyatı neye göre belirlenir?', 'Yol uzunluğu ve genişliği, zemin, eğim, kazı-dolgu miktarı, malzeme ve makine süresi fiyatı etkiler.'],
                    ['Yol açma işinde dolgu da yapılabilir mi?', 'İhtiyaca göre dolgu malzemesi serimi ve yüzey düzenleme aynı çalışma planında ele alınabilir.'],
                    ['Şantiye girişi için hangi bilgiler gerekir?', 'Giriş konumu, genişlik, yaklaşık güzergâh, eğim ve saha fotoğrafları ön değerlendirme için faydalıdır.'],
                ],
            ],
            [
                'title' => 'Toprak Serme ve Sıkıştırma',
                'slug' => 'toprak-serme-sikistirma',
                'icon' => 'layers',
                'short' => 'Alanya’da dolgu malzemesi, toprak veya stabilize serme, tesviye ve sıkıştırma hazırlığı.',
                'hero' => 'Alanya Toprak Serme ve Sıkıştırma',
                'content' => '<h2>Serme ve sıkıştırma hangi işlerde gerekir?</h2><p>Yol tabanı, bahçe, arsa, şantiye ve yapı çevresinde dolgu malzemesinin kontrollü biçimde yayılması ve yüzeyin kullanım amacına göre hazırlanması gerekebilir.</p><h2>Malzeme ve katman kalınlığı neden önemlidir?</h2><p>Kullanılacak malzeme türü, serim kalınlığı, alanın kotu ve drenaj ihtiyacı işin yöntemini belirler. Teknik gereklilik bulunan projelerde uygulama proje şartlarına göre yapılmalıdır.</p><h2>Hafriyat işiyle birlikte yapılabilir mi?</h2><p>Kazı sonrası dolgu, serme ve yüzey düzeltme aynı saha planında değerlendirilebilir; böylece makine hareketi daha verimli planlanır.</p>',
                'advantages' => ['Dolgu ve serme planı', 'Kot ve yüzey düzenleme', 'Kazı sonrası tamamlayıcı çalışma', 'Malzeme hareketine göre makine seçimi', 'Saha kullanım amacına göre hazırlık'],
                'usage' => ['Stabilize serme', 'Toprak dolgu', 'Yol tabanı hazırlığı', 'Bahçe ve arsa düzenleme', 'Kazı sonrası yüzey hazırlığı'],
                'seo_title' => 'Alanya Toprak Serme ve Sıkıştırma | Netvera Hafriyat',
                'seo_description' => 'Alanya’da toprak, dolgu ve stabilize serme; tesviye ve sıkıştırma hazırlığı. Alan, kot, malzeme ve saha koşullarına göre planlı çalışma.',
                'faqs' => [
                    ['Serme ve sıkıştırma fiyatı nasıl belirlenir?', 'Alan büyüklüğü, malzeme türü ve miktarı, serim kalınlığı, makine süresi ve saha erişimi fiyatı etkiler.'],
                    ['Kazı sonrası dolgu yapılabilir mi?', 'Evet, iş kapsamına göre kazı sonrası dolgu, serme ve yüzey düzenleme aynı plan içinde yürütülebilir.'],
                    ['Malzeme temini teklifin içinde olabilir mi?', 'Malzeme ihtiyacı ve temin koşulları işin konumuna göre ayrıca değerlendirilir.'],
                ],
            ],
            [
                'title' => 'Yıkım Sonrası Saha Temizliği',
                'slug' => 'yikim-sonrasi-saha-temizligi',
                'icon' => 'truck',
                'short' => 'Alanya’da yıkım veya tadilat sonrası moloz yükleme, alan temizleme, taşıma ve saha düzenleme.',
                'hero' => 'Alanya Yıkım Sonrası Saha Temizliği',
                'content' => '<h2>Yıkım sonrası saha temizliği neleri kapsar?</h2><p>Yıkım veya tadilat sonrasında oluşan molozun toplanması, kepçe ile yüklenmesi, taşıma planı ve sahada kalan zeminin düzenlenmesi ayrı iş kalemleri olarak değerlendirilebilir.</p><h2>Dar alanlarda temizlik nasıl yapılır?</h2><p>Bina çevresi, site içi veya bahçe gibi alanlarda makine seçimi giriş genişliği ve hareket alanına göre yapılır. Gerektiğinde daha küçük ekipman planlanabilir.</p><h2>Taşıma nasıl planlanır?</h2><p>Malzemenin türü ve miktarı, kamyon erişimi ve taşıma mesafesi dikkate alınarak yükleme ve nakliye kapsamı oluşturulur.</p>',
                'advantages' => ['Moloz yükleme ve taşıma planı', 'Dar alan erişimini değerlendirme', 'Saha temizliği ve tesviyeyi birlikte planlama', 'Malzeme miktarına göre araç ihtiyacı', 'İş sonrası alan düzenleme'],
                'usage' => ['Yıkım sonrası moloz', 'Tadilat sonrası saha temizliği', 'İnşaat atığı yükleme', 'Alan temizleme', 'Temizlik sonrası tesviye'],
                'seo_title' => 'Alanya Yıkım Sonrası Saha Temizliği | Netvera Hafriyat',
                'seo_description' => 'Alanya’da yıkım ve tadilat sonrası moloz yükleme, taşıma, saha temizliği ve tesviye. Alan ve malzeme miktarına göre teklif alın.',
                'faqs' => [
                    ['Yıkım sonrası moloz yükleme yapılabilir mi?', 'İş kapsamına göre molozun kepçe ile yüklenmesi ve taşıma planı birlikte değerlendirilebilir.'],
                    ['Dar site veya bahçe alanında çalışma mümkün mü?', 'Uygunluk giriş genişliği ve hareket alanına bağlıdır; saha fotoğraflarıyla ön değerlendirme yapılabilir.'],
                    ['Temizlik sonrası tesviye yapılabilir mi?', 'Evet, moloz kaldırıldıktan sonra ihtiyaç varsa yüzey düzenleme ve tesviye ayrıca planlanabilir.'],
                ],
            ],

            [
                'title' => 'Lastikli Kepçe Kiralama',
                'slug' => 'lastikli-kepce-kiralama',
                'icon' => 'excavator',
                'short' => 'Alanya’da şehir içi, yol, altyapı, yükleme ve saha işleri için hareket kabiliyeti yüksek lastikli kepçe hizmeti.',
                'hero' => 'Alanya Lastikli Kepçe Kiralama',
                'content' => '<h2>Lastikli kepçe hangi işlerde tercih edilir?</h2><p>Lastikli kepçeler; sert zeminli saha geçişleri, yol ve altyapı çalışmaları, yükleme, kanal ve şehir içi uygulamalarda hareket kabiliyeti sayesinde avantaj sağlar. Makine seçimi iş hacmi, zemin ve erişime göre yapılır.</p><h2>Normal tonajlı makine neden avantajlıdır?</h2><p>Çok ağır sınıf makinelerin gerekli olmadığı işlerde orta sınıf lastikli kepçeler saha içinde daha pratik hareket edebilir ve çalışma planını gereksiz kapasiteye göre büyütmez.</p><h2>Teklifte hangi bilgiler değerlendirilir?</h2><p>Konum, çalışma süresi, kazı veya yükleme kapsamı, zemin, makine erişimi ve varsa ataşman ihtiyacı teklifin temelini oluşturur.</p>',
                'advantages' => ['Şehir içi ve sert zeminde hareket kabiliyeti', 'Kazı ve yükleme işleri', 'Yol ve altyapı uygulamaları', 'Saha koşullarına göre makine seçimi', 'Operatörlü çalışma planı'],
                'usage' => ['Yol ve altyapı işleri', 'Kanal kazısı', 'Toprak ve moloz yükleme', 'Saha düzenleme', 'Şehir içi kazı çalışmaları'],
                'seo_title' => 'Alanya Lastikli Kepçe Kiralama | Netvera Hafriyat',
                'seo_description' => 'Alanya’da lastikli kepçe kiralama; yol, altyapı, kanal, yükleme ve saha düzenleme işleri için orta sınıf operatörlü makine çözümleri.',
                'faqs' => [
                    ['Lastikli kepçe hangi işlerde daha uygundur?', 'Yol, altyapı, sert zeminli saha, yükleme ve sık yer değişimi gereken işlerde lastikli makine seçeneği değerlendirilebilir.'],
                    ['Lastikli kepçe fiyatı nasıl belirlenir?', 'Makine sınıfı, çalışma süresi, saha konumu, zemin, ataşman ve nakliye ihtiyacı fiyatı belirler.'],
                    ['Çok ağır tonajlı makine mi kullanılıyor?', 'Makine sınıfı işin ihtiyacına göre seçilir; gereksiz ağır makine yerine uygun kapasitede çözüm planlanır.'],
                ],
            ],
            [
                'title' => 'Kazıcı Yükleyici Kiralama',
                'slug' => 'kazici-yukleyici-kiralama',
                'icon' => 'excavator',
                'short' => 'Alanya’da kazı, yükleme, kanal, saha temizliği ve dolgu işleri için çok amaçlı kazıcı yükleyici hizmeti.',
                'hero' => 'Alanya Kazıcı Yükleyici Kiralama',
                'content' => '<h2>Kazıcı yükleyici hangi işler için kullanılır?</h2><p>Kazıcı yükleyici; ön yükleyici kovası ve arka kazıcı kolu sayesinde küçük ve orta ölçekli saha işlerinde çok yönlü kullanılabilir. Kanal, yükleme, saha temizliği, dolgu ve çevre düzenleme işlerinde değerlendirilebilir.</p><h2>Hangi sahalarda avantaj sağlar?</h2><p>Birden fazla iş kaleminin aynı sahada yapılacağı uygulamalarda kazı ve yükleme fonksiyonlarının tek makinede bulunması çalışma akışını kolaylaştırabilir.</p><h2>Teklif nasıl hazırlanır?</h2><p>Yapılacak işlerin sırası, zemin, erişim, çalışma süresi ve malzeme hareketi değerlendirilerek uygun çalışma planı hazırlanır.</p>',
                'advantages' => ['Kazı ve yüklemeyi tek makinede birleştirme', 'Kanal ve saha temizliği', 'Dolgu ve malzeme hareketi', 'Orta ölçekli saha işleri', 'Operatörlü hizmet planı'],
                'usage' => ['Kanal kazısı', 'Toprak yükleme', 'Saha temizliği', 'Dolgu ve tesviye', 'İnşaat çevresi düzenleme'],
                'seo_title' => 'Alanya Kazıcı Yükleyici Kiralama | Netvera Hafriyat',
                'seo_description' => 'Alanya’da kazıcı yükleyici kiralama; kazı, yükleme, kanal, dolgu ve saha temizliği işleri için operatörlü çok amaçlı iş makinesi.',
                'faqs' => [
                    ['Kazıcı yükleyici ile hem kazı hem yükleme yapılabilir mi?', 'Evet, makinenin ön ve arka çalışma ekipmanları iş kapsamına göre iki farklı iş kaleminde kullanılabilir.'],
                    ['Hangi ölçekte işler için uygundur?', 'Küçük ve orta ölçekli saha işlerinde, erişim ve zemin koşulları uygunsa verimli bir seçenek olabilir.'],
                    ['Ataşman ihtiyacı nasıl belirlenir?', 'İş türü ve zemin koşullarına göre kullanılacak ekipman teklif öncesinde netleştirilir.'],
                ],
            ],
            [
                'title' => 'Forklift Kiralama',
                'slug' => 'forklift-kiralama',
                'icon' => 'forklift',
                'short' => 'Alanya’da paletli yük, yapı malzemesi ve saha içi indirme-bindirme ihtiyaçları için forklift desteği.',
                'hero' => 'Alanya Forklift Kiralama',
                'content' => '<h2>Forklift hangi işler için kullanılır?</h2><p>Forklift; paletli yapı malzemelerinin, paketli yüklerin ve saha içi taşınması gereken malzemelerin indirme-bindirme süreçlerinde kullanılır. Uygun makine seçimi yük ağırlığı, kaldırma yüksekliği ve zemin koşullarına bağlıdır.</p><h2>Saha koşulları neden önemlidir?</h2><p>Düz ve taşıyıcı zemin, giriş yüksekliği, manevra alanı ve yükün konumu forklift çalışma planını etkiler. Açık saha veya kapalı alan ihtiyacı teklif aşamasında netleştirilir.</p><h2>Teklif için hangi bilgiler gerekir?</h2><p>Yükün türü, yaklaşık ağırlığı, kaldırma yüksekliği, çalışma süresi, konum ve saha fotoğrafları doğru makine planına yardımcı olur.</p>',
                'advantages' => ['Paletli yük taşıma', 'İndirme-bindirme desteği', 'Saha içi malzeme hareketi', 'Yük ve yüksekliğe göre makine seçimi', 'Kısa veya planlı çalışma seçenekleri'],
                'usage' => ['Yapı malzemesi indirme', 'Palet taşıma', 'Depo ve saha içi lojistik', 'Kamyondan malzeme indirme', 'Şantiye malzeme yerleştirme'],
                'seo_title' => 'Alanya Forklift Kiralama | Saha ve Yük Taşıma | Netvera Hafriyat',
                'seo_description' => 'Alanya forklift kiralama; paletli yük, yapı malzemesi, kamyon indirme-bindirme ve saha içi taşıma ihtiyaçları için teklif alın.',
                'faqs' => [
                    ['Forklift fiyatı neye göre belirlenir?', 'Çalışma süresi, yük ağırlığı, kaldırma yüksekliği, saha konumu ve makinenin nakliye ihtiyacı fiyatı etkiler.'],
                    ['Açık şantiyede forklift kullanılabilir mi?', 'Zemin ve makine tipi uygun olduğunda açık saha çalışması planlanabilir.'],
                    ['Kamyondan malzeme indirme yapılabilir mi?', 'Yük ağırlığı ve saha erişimi uygun olduğunda indirme-bindirme işi planlanabilir.'],
                ],
            ],
            [
                'title' => 'Traktör ile Arazi ve Nakliye Desteği',
                'slug' => 'traktor-arazi-nakliye',
                'icon' => 'tractor',
                'short' => 'Alanya’da bahçe, arazi ve saha işlerinde yerli üretim traktörle malzeme taşıma ve yardımcı çalışma desteği.',
                'hero' => 'Alanya Traktör ile Arazi ve Nakliye Desteği',
                'content' => '<h2>Traktör hangi saha işlerinde kullanılır?</h2><p>Traktör; bahçe, tarla ve arazi içinde hafif malzeme taşıma, römork desteği ve saha lojistiği gibi işlerde kullanılabilir. Ekipman seçimi yapılacak işe ve arazi koşullarına göre belirlenir.</p><h2>Hafriyat işiyle birlikte kullanılabilir mi?</h2><p>Kepçe veya mini kepçe ile yapılan çalışmalarda saha içi yardımcı taşıma ihtiyacı varsa traktör ve römork desteği çalışma planına dahil edilebilir.</p><h2>Makine bilgisi nasıl teyit edilir?</h2><p>Yerli üretim traktör seçeneğinin model, güç ve ekipman bilgileri iş öncesinde mevcut makineye göre teyit edilir.</p>',
                'advantages' => ['Arazi içi yardımcı taşıma', 'Römork ile malzeme hareketi', 'Bahçe ve saha çalışmaları', 'Hafriyat ekibine lojistik destek', 'İşe göre ekipman planlama'],
                'usage' => ['Bahçe ve arazi işleri', 'Römorklu malzeme taşıma', 'Toprak ve hafif malzeme hareketi', 'Saha lojistiği', 'Kepçe çalışmalarına yardımcı taşıma'],
                'seo_title' => 'Alanya Traktör ve Arazi Nakliye Desteği | Netvera Hafriyat',
                'seo_description' => 'Alanya’da traktör ile arazi, bahçe ve saha içi nakliye desteği; römorklu malzeme taşıma ve yardımcı çalışma seçenekleri.',
                'faqs' => [
                    ['Traktörle hangi malzemeler taşınabilir?', 'Taşınabilecek malzeme miktarı ve türü römork, arazi ve güvenli çalışma koşullarına göre belirlenir.'],
                    ['Kepçe işiyle birlikte traktör desteği alınabilir mi?', 'İşin kapsamı uygunsa saha içi taşıma desteği aynı çalışma planına dahil edilebilir.'],
                    ['Hangi traktör modeli kullanılıyor?', 'Model ve güç sınıfı teklif öncesinde mevcut yerli üretim makineye göre teyit edilir.'],
                ],
            ],
        ];

        $visuals = [
            'kepce-kiralama' => [
                'card' => 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'mini-kepce-kiralama' => [
                'card' => 'hizmetler/alanya-mini-kepce-kiralama.webp',
                'hero' => 'https://images.pexels.com/photos/14846286/pexels-photo-14846286.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'temel-kazisi' => [
                'card' => 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'moloz-hafriyat-nakliye' => [
                'card' => 'hizmetler/alanya-moloz-hafriyat-tasima.webp',
                'hero' => 'https://images.pexels.com/photos/29506754/pexels-photo-29506754.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'alt-yapi-kanal-acma' => ['card' => 'hizmetler/alanya-kanal-kazisi.webp', 'hero' => 'hizmetler/alanya-kanal-kazisi.webp'],
            'arsa-tesviye-dolgu' => [
                'card' => 'hizmetler/alanya-arsa-tesviye-dolgu.webp',
                'hero' => 'https://images.pexels.com/photos/12164798/pexels-photo-12164798.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'cevre-bahce-duzenleme' => ['card' => 'galeri/alanya-dar-alan-mini-kepce-tesviye.webp', 'hero' => 'hizmetler/alanya-arsa-temizleme.webp'],
            'drenaj-ozel-kazi' => ['card' => 'hizmetler/alanya-kanal-kazisi.webp', 'hero' => 'hizmetler/alanya-kanal-kazisi.webp'],
            'havuz-kazisi' => [
                'card' => 'https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'yol-acma-saha-hazirlama' => [
                'card' => 'https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'toprak-serme-sikistirma' => [
                'card' => 'https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'yikim-sonrasi-saha-temizligi' => [
                'card' => 'https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],

            'lastikli-kepce-kiralama' => [
                'card' => 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'kazici-yukleyici-kiralama' => [
                'card' => 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'forklift-kiralama' => [
                'card' => 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
            'traktor-arazi-nakliye' => [
                'card' => 'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero' => 'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
            ],
        ];

        $process = [
            ['title' => 'Talep & Bilgi', 'text' => 'Konum, iş türü, ölçü ve varsa fotoğraflar alınır.'],
            ['title' => 'Saha Değerlendirmesi', 'text' => 'Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir.'],
            ['title' => 'Teklif & Plan', 'text' => 'İş kapsamı, çalışma modeli ve teklif netleştirilir.'],
            ['title' => 'Uygulama & Kontrol', 'text' => 'Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir.'],
        ];

        foreach ($services as $i => $s) {
            $visual = $visuals[$s['slug']] ?? [];
            $serviceId = $this->insert('services', [
                'title' => $s['title'],
                'slug' => $s['slug'],
                'icon' => $s['icon'],
                'card_image' => $visual['card'] ?? null,
                'cover_image' => $visual['hero'] ?? ($visual['card'] ?? null),
                'hero_image' => $visual['hero'] ?? ($visual['card'] ?? null),
                'og_image' => $visual['card'] ?? null,
                'short_description' => $s['short'],
                'content' => $s['content'],
                'hero_title' => $s['hero'],
                'hero_subtitle' => $s['short'],
                'advantages_json' => json_encode($s['advantages'], JSON_UNESCAPED_UNICODE),
                'usage_areas_json' => json_encode($s['usage'], JSON_UNESCAPED_UNICODE),
                'process_json' => json_encode($process, JSON_UNESCAPED_UNICODE),
                'seo_title' => $s['seo_title'],
                'seo_description' => $s['seo_description'],
                'sort_order' => $i,
                'is_featured' => in_array($s['slug'], [
                    'kepce-kiralama',
                    'mini-kepce-kiralama',
                    'temel-kazisi',
                    'moloz-hafriyat-nakliye',
                    'lastikli-kepce-kiralama',
                    'forklift-kiralama',
                ], true) ? 1 : 0,
                'is_active' => 1,
                'created_at' => $this->now(),
                'updated_at' => $this->now(),
            ]);

            foreach ($s['faqs'] as $faqOrder => [$question, $answer]) {
                $this->insert('service_faqs', [
                    'service_id' => $serviceId,
                    'question' => $question,
                    'answer' => $answer,
                    'sort_order' => $faqOrder,
                    'is_active' => 1,
                ]);
            }
        }
    }

    protected function seedEquipment(): void
    {
        $items = [
            [
                'title' => 'Zoomlion ZE35GU Mini Ekskavatör',
                'slug' => 'zoomlion-ze35gu-mini-ekskavator',
                'brand_model' => 'Zoomlion ZE35GU',
                'usage_area' => 'Dar alan kazısı, kanal, bahçe ve saha düzenleme',
                'attachments' => '',
                'short_description' => 'Mini ekskavatör • Dar alan çalışmaları • Kanal ve tesviye işleri',
                'content' => '<p>Netvera Hafriyat saha arşivindeki gerçek makine görsellerinde görülen Zoomlion ZE35GU mini ekskavatör; dar alan, kanal, bahçe ve saha düzenleme çalışmalarında kullanılmaktadır. Teknik kapasite ve ataşman bilgileri iş öncesinde mevcut konfigürasyona göre teyit edilir.</p>',
                'image' => 'makine/zoomlion-ze35gu-mini-ekskavator-alanya.webp',
            ],
            [
                'title' => 'Mitsubishi Canter Hafriyat Kamyonu',
                'slug' => 'mitsubishi-canter-hafriyat-kamyonu',
                'brand_model' => 'Mitsubishi Canter',
                'usage_area' => 'Toprak, moloz ve hafriyat taşıma',
                'attachments' => '',
                'short_description' => 'Hafriyat taşıma • Moloz taşıma • Saha lojistiği',
                'content' => '<p>Mitsubishi Canter kamyon; hafriyat toprağı, moloz ve saha lojistiği ihtiyaçlarında çalışma planına göre değerlendirilir. Taşıma kapasitesi ve sefer planı işin kapsamına göre netleştirilir.</p>',
                'image' => 'makine/mitsubishi-canter-hafriyat-kamyonu-alanya.webp',
            ],
            [
                'title' => 'Orta Sınıf Lastikli Ekskavatör',
                'slug' => 'orta-sinif-lastikli-ekskavator',
                'brand_model' => 'Lastikli Ekskavatör',
                'usage_area' => 'Yol, altyapı, kanal, yükleme ve şehir içi saha işleri',
                'attachments' => 'Kova • İşe göre ataşman',
                'short_description' => 'Lastikli ekskavatör • Şehir içi hareket kabiliyeti • Kazı ve yükleme',
                'content' => '<p>Çok ağır tonaj gerektirmeyen yol, altyapı, kanal ve yükleme işlerinde orta sınıf lastikli ekskavatör seçeneği değerlendirilir. Model ve teknik kapasite, iş öncesinde mevcut makineye göre teyit edilir.</p>',
                'image' => 'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
            ],
            [
                'title' => 'Kazıcı Yükleyici (Beko Loder)',
                'slug' => 'kazici-yukleyici-beko-loder',
                'brand_model' => 'Kazıcı Yükleyici',
                'usage_area' => 'Kazı, yükleme, kanal, dolgu ve saha temizliği',
                'attachments' => 'Ön yükleyici kova • Arka kazıcı',
                'short_description' => 'Kazı ve yükleme • Kanal işleri • Çok amaçlı saha kullanımı',
                'content' => '<p>Kazıcı yükleyici; kazı ve yükleme fonksiyonlarının aynı makinede gerektiği küçük ve orta ölçekli saha çalışmalarında kullanılır. Marka, model ve ataşman bilgisi iş öncesinde mevcut makineye göre teyit edilir.</p>',
                'image' => 'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
            ],
            [
                'title' => 'Tümosan Traktör',
                'slug' => 'tumosan-traktor',
                'brand_model' => 'Tümosan',
                'usage_area' => 'Bahçe, arazi, römorklu taşıma ve saha lojistiği',
                'attachments' => 'Römork • İşe göre yardımcı ekipman',
                'short_description' => 'Yerli üretim traktör • Arazi desteği • Römorklu taşıma',
                'content' => '<p>Yerli üretim Tümosan traktör; bahçe, arazi ve saha içi yardımcı taşıma işlerinde çalışma planına göre kullanılabilir. Model, güç ve ekipman bilgisi teklif öncesinde mevcut makineye göre teyit edilir.</p>',
                'image' => 'https://www.tumosan.com.tr/uploads/2023/08/2013-yerli-105-beygir-traktor-uretimi_op.webp',
            ],
            [
                'title' => 'Dizel Forklift',
                'slug' => 'dizel-forklift',
                'brand_model' => 'Dizel Forklift',
                'usage_area' => 'Paletli yük, yapı malzemesi ve saha içi indirme-bindirme',
                'attachments' => 'Standart çatal',
                'short_description' => 'Paletli yük taşıma • İndirme-bindirme • Saha lojistiği',
                'content' => '<p>Dizel forklift; yapı malzemesi, palet ve saha içi yüklerin taşınması ile kamyon indirme-bindirme işlerinde değerlendirilir. Kaldırma kapasitesi ve yükseklik bilgisi iş öncesinde mevcut makineye göre teyit edilir.</p>',
                'image' => 'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
            ],
        ];
        foreach ($items as $i => $m) {
            $this->insert('equipment', $m + [
                'gallery_json' => null,
                'sort_order' => $i,
                'is_active' => 1,
                'created_at' => $this->now(),
                'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedProjects(): void
    {
        $projects = [
            ['Mini Kepçe ile Kanal Kazısı','alanya-mini-kepce-kanal-kazisi','Alanya','Mini Kepçe / Kanal Kazısı','Dar alanda mini kepçe ile kanal açma ve saha düzenleme çalışması.','projeler/alanya-mini-kepce-kanal-kazisi.webp'],
            ['Dar Alanda Tesviye ve Saha Düzenleme','alanya-dar-alan-tesviye','Alanya','Arsa Tesviye','Yapı çevresinde mini kepçe ile toprak tesviyesi ve çalışma alanı düzenleme.','projeler/alanya-dar-alan-tesviye.webp'],
            ['Moloz ve Hafriyat Taşıma','alanya-moloz-hafriyat-tasima','Alanya','Moloz ve Hafriyat Taşıma','Saha çalışması sonrası moloz ve hafriyatın yüklenmesi ve taşınması.','hizmetler/alanya-moloz-hafriyat-tasima.webp'],
            ['Arsa Kazısı ve Tesviye','alanya-arsa-kazisi-tesviye','Alanya','Kazı ve Tesviye','Açık arazide kazı, yüzey düzeltme ve saha hazırlığı.','hizmetler/alanya-arsa-tesviye-dolgu.webp'],
            ['Bahçe ve Arsa Temizleme','alanya-bahce-arsa-temizleme','Alanya','Arsa Temizleme','Bahçe ve yapı çevresinde kök, toprak ve alan temizliği.','projeler/alanya-bahce-arsa-temizleme.jpg'],
            ['Yıkım Sonrası Saha Temizliği','alanya-yikim-sonrasi-saha-temizligi','Alanya','Yıkım Sonrası Temizlik','Yıkım ve tadilat sonrası moloz toplama ve saha temizliği.','projeler/alanya-yikim-sonrasi-saha-temizligi.jpg'],
            ['Sera Alanında Mini Kepçe Temizliği','alanya-sera-mini-kepce-temizligi','Alanya','Saha Temizliği','Sera içinde bitki ve kök temizliği, kazı ve malzeme yükleme çalışması.','projeler/alanya-sera-saha-temizligi.jpg'],
        ];
        foreach ($projects as [$title,$slug,$region,$serviceType,$short,$cover]) {
            $this->insert('projects', [
                'title' => $title,
                'slug' => $slug,
                'region' => $region,
                'service_type' => $serviceType,
                'short_description' => $short,
                'content' => '<p>' . $short . ' Görseller Netvera Hafriyat saha arşivinden seçilmiştir. Çalışma yöntemi; alan erişimi, zemin ve iş kapsamına göre planlanır.</p>',
                'cover_image' => $cover,
                'before_image' => null,
                'after_image' => null,
                'gallery_json' => null,
                'project_date' => 'Saha arşivi',
                'seo_title' => $title . ' | Alanya Hafriyat | Netvera Hafriyat',
                'seo_description' => $short . ' Alanya hafriyat ve mini kepçe saha çalışması.',
                'is_active' => 1,
                'created_at' => $this->now(),
                'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedBlog(): void
    {
        $categories = [
            ['Kepçe Kiralama', 'kepce-kiralama', 'Alanya’da kepçe ve mini kepçe seçimi, kiralama süreci ve fiyat faktörleri.', 'Alanya Kepçe Kiralama Rehberi | Netvera Hafriyat', 'Kepçe ve mini kepçe kiralama öncesi makine seçimi, saha erişimi, çalışma süresi ve fiyat faktörlerini öğrenin.'],
            ['Hafriyat ve Kazı', 'hafriyat-kazi', 'Temel, kanal, moloz, tesviye ve hafriyat işlerinin planlama rehberleri.', 'Alanya Hafriyat ve Kazı Rehberi | Netvera Hafriyat', 'Alanya’da hafriyat, temel kazısı, kanal, moloz taşıma ve arsa tesviye işleri için karar rehberleri.'],
            ['Saha Rehberi', 'saha-rehberi', 'İş başlamadan önce erişim, zemin, ölçü ve saha hazırlığı hakkında pratik bilgiler.', 'Hafriyat Saha Rehberi | Netvera Hafriyat', 'Kazı ve hafriyat işi öncesinde saha erişimi, zemin, makine seçimi ve teklif için gerekli bilgileri öğrenin.'],
        ];
        $categoryIds = [];
        foreach ($categories as $i => [$title, $slug, $desc, $seoTitle, $seoDesc]) {
            $categoryIds[$slug] = $this->insert('blog_categories', [
                'title' => $title, 'slug' => $slug, 'description' => $desc,
                'seo_title' => $seoTitle, 'seo_description' => $seoDesc,
                'sort_order' => $i, 'is_active' => 1,
            ]);
        }

        $posts = [
            [
                'category' => 'kepce-kiralama',
                'title' => 'Alanya’da Kepçe Kiralama Fiyatları Nasıl Hesaplanır?',
                'slug' => 'alanyada-kepce-kiralama-fiyatlari-nasil-hesaplanir',
                'focus' => 'alanya kepçe kiralama fiyatları',
                'service_slug' => 'kepce-kiralama',
                'excerpt' => 'Alanya’da kepçe kiralama fiyatını çalışma süresi, makine tipi, nakliye, zemin, saha erişimi ve hafriyat taşıma ihtiyacı birlikte belirler.',
                'seo_title' => 'Alanya Kepçe Kiralama Fiyatları Nasıl Hesaplanır? | Netvera Hafriyat',
                'seo_description' => 'Alanya kepçe kiralama fiyatını etkileyen makine, süre, nakliye, zemin, ataşman, saha erişimi ve hafriyat taşıma kalemlerini öğrenin.',
                'content' => "## Alanya’da kepçe kiralama fiyatını ne belirler?\n\nKepçe kiralama için tek bir doğru fiyat yoktur. Aynı şehirde iki işin maliyeti; çalışma süresi, kullanılacak makine, zeminin durumu ve nakliye ihtiyacı nedeniyle farklı olabilir. Bu yüzden doğru yaklaşım, önce işin kapsamını netleştirip sonra teklif oluşturmaktır.\n\n### 1. Çalışma süresi\n\nKazı, yükleme veya tesviye işinin tahmini süresi toplam maliyetin ana kalemlerinden biridir. Kısa bir yükleme işi ile gün boyu sürecek temel kazısı aynı şekilde fiyatlanmaz.\n\n### 2. Makine tipi\n\nDar alan için mini kepçe gerekirken daha geniş ve yüksek hacimli işler farklı kapasitede makine gerektirebilir. Gereğinden büyük makine seçmek de, yetersiz makineyle çalışmak da verimsiz olabilir.\n\n### 3. Makinenin sahaya nakli\n\nMakinenin çalışma alanına nasıl ulaştırılacağı, mesafe ve taşıma ihtiyacı teklifte dikkate alınır.\n\n### 4. Zemin ve ataşman ihtiyacı\n\nSert zemin, taşlı alan veya kırıcı gerektiren işler standart kazıdan farklı planlanır.\n\n### 5. Çıkan hafriyatın taşınması\n\nKazıdan çıkan toprak veya moloz sahada kalmayacaksa yükleme ve taşıma ayrıca planlanır.\n\n### 6. Saha erişimi\n\nDar kapı, düşük geçiş, eğimli arazi veya sınırlı dönüş alanı makine seçimini doğrudan etkileyebilir.\n\n## Daha doğru teklif için ne göndermelisiniz?\n\nKonum, yapılacak işin kısa tarifi, yaklaşık ölçü veya alan, giriş genişliği ve birkaç saha fotoğrafı ilk değerlendirmeyi hızlandırır. Böylece yalnız \"saatlik fiyat\" yerine gerçek işinize göre daha anlamlı bir teklif hazırlanabilir.",
                'faq' => [
                    ['Kepçe kiralama için sabit saatlik fiyat var mı?', 'Fiyat; makine, süre, nakliye, saha ve iş kapsamına göre değişebildiği için tek bir sabit rakam her iş için doğru olmaz.'],
                    ['Fotoğraf göndererek ön teklif alınabilir mi?', 'Konum, ölçü ve saha fotoğrafları ön değerlendirmeyi kolaylaştırır; bazı işlerde kesin plan için yerinde inceleme gerekebilir.'],
                ],
            ],
            [
                'category' => 'kepce-kiralama',
                'title' => 'Mini Kepçe mi Büyük Kepçe mi? Alanya’daki İşiniz İçin Hangisi Uygun?',
                'slug' => 'mini-kepce-mi-buyuk-kepce-mi-alanya',
                'focus' => 'alanya mini kepçe',
                'service_slug' => 'mini-kepce-kiralama',
                'excerpt' => 'Dar bahçe, küçük kanal ve hassas kazılarda mini kepçe; daha yüksek hacimli ve geniş sahalarda farklı makine seçenekleri değerlendirilebilir.',
                'seo_title' => 'Mini Kepçe mi Büyük Kepçe mi? Alanya İçin Makine Seçimi',
                'seo_description' => 'Alanya’da mini kepçe ile daha büyük kepçe arasında seçim yaparken giriş genişliği, kazı hacmi, zemin ve çalışma alanında nelere bakılır?',
                'content' => "## Mini kepçe ne zaman daha mantıklıdır?\n\nMini kepçe; dar bahçe girişleri, bina çevreleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve kontrollü çalışma gereken alanlarda avantaj sağlayabilir. Ancak \"mini\" olması her iş için yeterli olduğu anlamına gelmez.\n\n### Giriş ve dönüş alanı\n\nMakinenin sahaya girebilmesi için yalnız kapı genişliği değil, içeride dönüş yapabileceği alan da önemlidir. Gerçek makine ölçüsü doğrulanmadan kesin uygunluk söylenmemelidir.\n\n### Kazı derinliği ve hacmi\n\nKüçük bir kanal ile yüksek hacimli temel kazısının makine ihtiyacı aynı değildir. Kazı derinliği, genişliği ve çıkarılacak malzeme miktarı seçimi etkiler.\n\n### Zemin yapısı\n\nYumuşak toprak, sıkışmış dolgu, taşlı zemin veya kırıcı ihtiyacı farklı ekipman gerektirebilir.\n\n### Çıkan malzemenin taşınması\n\nMini kepçeyle kazı yapılırken çıkan toprağın kamyona yüklenmesi veya sahada başka bir noktaya alınması gerekiyorsa bu akış da baştan planlanmalıdır.\n\n## Hangi bilgileri paylaşmalısınız?\n\nİşin konumu, kapı/geçiş ölçüsü, yaklaşık kazı ölçüsü, zeminle ilgili bilinenler ve fotoğraflar doğru makineyi seçmek için iyi bir başlangıçtır.",
                'faq' => [
                    ['Mini kepçe bahçe kapısından geçer mi?', 'Bu, kapının gerçek genişliğine ve kullanılacak makinenin doğrulanmış ölçülerine bağlıdır. Ölçü ve fotoğraf paylaşılması gerekir.'],
                    ['Mini kepçe temel kazısında kullanılabilir mi?', 'Küçük ölçekli işlerde kullanılabilir; uygunluk kazı hacmi, derinlik, zemin ve süreye göre değerlendirilir.'],
                ],
            ],
            [
                'category' => 'hafriyat-kazi',
                'title' => 'Temel Kazısı Öncesi Nelere Bakılır?',
                'slug' => 'temel-kazisi-oncesi-nelere-bakilir',
                'focus' => 'alanya temel kazısı',
                'service_slug' => 'temel-kazisi',
                'excerpt' => 'Temel kazısından önce proje ölçüsü kadar saha erişimi, zemin, kazı derinliği, çıkan malzeme ve taşıma planı da netleştirilmelidir.',
                'seo_title' => 'Alanya Temel Kazısı Öncesi Nelere Bakılır? | Netvera Hafriyat',
                'seo_description' => 'Temel kazısı öncesinde kazı ölçüsü, zemin, saha erişimi, makine seçimi, hafriyat taşıma ve dolgu planında kontrol edilmesi gerekenler.',
                'content' => "## Temel kazısında ilk soru yalnız \"kaç metre kazılacak?\" değildir\n\nSağlıklı bir temel kazısı planı; proje ölçüsü, zemin, makine erişimi ve çıkan malzemenin yönetimini birlikte ele alır. İş başlamadan önce bu başlıkların netleştirilmesi gereksiz beklemeyi ve yanlış makine seçimini azaltır.\n\n### Proje ve kazı ölçüleri\n\nKazının sınırları, derinliği ve çalışma payı mümkün olduğunca net olmalıdır. Uygulama teknik projeye bağlıysa saha çalışması ilgili ölçülere göre yürütülmelidir.\n\n### Makinenin sahaya erişimi\n\nKapı, yol genişliği, eğim, dönüş alanı ve çevredeki mevcut yapılar makinenin seçimini etkiler.\n\n### Zemin yapısı\n\nToprak, dolgu, taşlı veya sert zemin çalışma süresini ve ataşman ihtiyacını değiştirebilir.\n\n### Çıkan malzeme ne olacak?\n\nKazı toprağı sahada dolgu için kullanılacak mı, stoklanacak mı, yoksa taşınacak mı? Bu karar yükleme ve kamyon planını doğrudan etkiler.\n\n### Kazı sonrası tesviye ve dolgu\n\nTemel çevresi veya saha içinde daha sonra dolgu ve seviye düzenlemesi gerekecekse iş sırası en baştan buna göre planlanabilir.\n\n## Teklif isterken paylaşılabilecek bilgiler\n\nKonum, proje/ölçü bilgisi, saha fotoğrafları, giriş durumu ve çıkan malzemeyle ilgili beklenti doğru ön değerlendirme için en yararlı bilgilerdir.",
                'faq' => [
                    ['Temel kazısı için hangi makine gerekir?', 'Makine seçimi kazı hacmi, derinlik, zemin ve saha erişimine göre yapılır.'],
                    ['Kazı toprağı taşınmak zorunda mı?', 'Hayır. Proje ve saha uygunsa bir kısmı dolgu veya tesviye için değerlendirilebilir; taşınacak kısım ayrıca planlanır.'],
                ],
            ],
        ];

        $blogVisuals = [
            'alanyada-kepce-kiralama-fiyatlari-nasil-hesaplanir' => [
                'image' => 'https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp',
                'alt' => 'Alanya kepçe kiralama ve hafriyat saha çalışması',
            ],
            'mini-kepce-mi-buyuk-kepce-mi-alanya' => [
                'image' => 'hizmetler/alanya-mini-kepce-kiralama.webp',
                'alt' => 'Alanya mini kepçe ile dar alan saha çalışması',
            ],
            'temel-kazisi-oncesi-nelere-bakilir' => [
                'image' => 'https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp',
                'alt' => 'Temel kazısı yapılan yapı şantiyesinde ekskavatör',
            ],
        ];

        foreach ($posts as $idx => $post) {
            $wordCount = str_word_count(strip_tags($post['content']));
            $visual = $blogVisuals[$post['slug']] ?? ['image' => null, 'alt' => $post['title']];
            $this->insert('blog_posts', [
                'category_id' => $categoryIds[$post['category']] ?? null,
                'title' => $post['title'], 'slug' => $post['slug'],
                'excerpt' => $post['excerpt'],
                'content_markdown' => $post['content'],
                'cover_image' => $visual['image'],
                'cover_image_alt' => $visual['alt'],
                'cover_image_title' => $post['title'],
                'og_image' => $visual['image'],
                'twitter_image' => $visual['image'],
                'author_name' => 'Netvera Hafriyat',
                'focus_keyword' => $post['focus'],
                'seo_title' => $post['seo_title'],
                'seo_description' => $post['seo_description'],
                'og_title' => $post['seo_title'],
                'og_description' => $post['seo_description'],
                'twitter_title' => $post['seo_title'],
                'twitter_description' => $post['seo_description'],
                'robots_index' => 1, 'robots_follow' => 1,
                'schema_type' => 'BlogPosting',
                'related_service_id' => (int) ($this->pdo->query("SELECT id FROM services WHERE slug = " . $this->pdo->quote($post['service_slug']) . " LIMIT 1")->fetchColumn() ?: 0),
                'faq_json' => json_encode(array_map(fn ($f) => ['question' => $f[0], 'answer' => $f[1]], $post['faq']), JSON_UNESCAPED_UNICODE),
                'reading_time' => max(2, (int) ceil($wordCount / 200)),
                'status' => 'published',
                'published_at' => date('Y-m-d H:i:s', strtotime("-" . ($idx * 4) . " days")),
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedFaqs(): void
    {
        $faqs = [
            ['Alanya’da kepçe kiralama fiyatları nasıl belirlenir?', 'Fiyat; çalışma süresi, kullanılacak makine, saha erişimi, nakliye, zemin, ataşman ihtiyacı ve çıkan hafriyatın taşınıp taşınmayacağı gibi iş kalemlerine göre belirlenir.'],
            ['Mini kepçe hangi işler için uygundur?', 'Mini kepçe; dar bahçe girişleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve büyük makinelerin erişemediği alanlarda değerlendirilebilir. Uygunluk gerçek geçiş ölçüsüne göre belirlenir.'],
            ['Hafriyat ve moloz taşıma birlikte yapılabilir mi?', 'İşin kapsamına göre kazı, yükleme ve taşıma aynı çalışma planında değerlendirilebilir. Malzeme miktarı ve saha giriş-çıkış koşulları teklif aşamasında dikkate alınır.'],
            ['Hangi bölgelere hizmet veriyorsunuz?', 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Alanya Merkez, Cikcilli, Çıplaklı, Payallar, Konaklı, Avsallar ve planlamaya uygun çevre bölgeler için talep oluşturabilirsiniz.'],
            ['Teklif almak için hangi bilgileri paylaşmalıyım?', 'İşin konumu, yapılacak çalışma, yaklaşık ölçü veya alan, saha giriş durumu ve varsa fotoğraflar ön değerlendirmeyi hızlandırır.'],
            ['Saatlik veya günlük çalışma yapılabilir mi?', 'Çalışma modeli işin türü, makine ihtiyacı ve saha koşullarına göre belirlenir. Uygunluk ve fiyat için iş detaylarını paylaşabilirsiniz.'],
        ];
        foreach ($faqs as $i => [$q, $a]) {
            $this->insert('faqs', ['question' => $q, 'answer' => $a, 'sort_order' => $i, 'is_active' => 1]);
        }
    }

    protected function seedGallery(): void
    {
        // Ana sayfada ilk 8 görsel gösterildiği için en hafif WebP dosyaları önce sıralanır.
        $items = [
            ['Zoomlion Mini Ekskavatör','galeri/alanya-zoomlion-mini-ekskavator.webp','Makine Parkuru','Alanya Zoomlion ZE35GU mini ekskavatör saha görünümü'],
            ['Kanal Hafriyatı Mini Kepçe','galeri/alanya-kanal-hafriyat-mini-kepce.webp','Kanal Kazısı','Alanya mini kepçe kanal ve hafriyat çalışması'],
            ['Dar Alanda Mini Kepçe Tesviye','galeri/alanya-dar-alan-mini-kepce-tesviye.webp','Mini Kepçe','Alanya dar alanda mini kepçe ile tesviye çalışması'],
            ['Hafriyat Kamyonu Saha Çalışması','galeri/alanya-hafriyat-kamyonu-saha.webp','Hafriyat Taşıma','Alanya hafriyat kamyonu saha çalışması'],
            ['Dolgu ve Kamyon Çalışması','galeri/alanya-hafriyat-dolgu-kamyon.webp','Dolgu ve Tesviye','Alanya dolgu ve hafriyat kamyon çalışması'],
            ['Moloz ve Hafriyat Taşıma','hizmetler/alanya-moloz-hafriyat-tasima.webp','Moloz Taşıma','Alanya moloz ve hafriyat taşıma çalışması'],
            ['Mini Kepçe ile Kanal Kazısı','projeler/alanya-mini-kepce-kanal-kazisi.webp','Kanal Kazısı','Alanya mini kepçe ile kanal kazısı çalışması'],
            ['Arsa Tesviye ve Dolgu','hizmetler/alanya-arsa-tesviye-dolgu.webp','Arsa Tesviye','Alanya arsa tesviye ve dolgu saha çalışması'],
            ['Malzeme Yükleme ve Saha Lojistiği','galeri/alanya-malzeme-yukleme-saha-lojistigi.jpg','Saha Lojistiği','Alanya saha lojistiği ve malzeme yükleme çalışması'],
            ['Hafriyat Toprağı Taşıma','galeri/alanya-hafriyat-toprak-tasima.jpg','Hafriyat Taşıma','Alanya hafriyat toprağı taşıma kamyonu'],
            ['Bahçe ve Arsa Temizleme','galeri/alanya-bahce-arsa-temizleme.jpg','Arsa Temizleme','Alanya mini kepçe bahçe ve arsa temizleme'],
            ['Sera Alanında Kök ve Bitki Temizliği','galeri/alanya-sera-alani-temizleme-1.jpg','Saha Temizliği','Alanya sera alanında mini kepçe ile kök temizliği'],
            ['Yıkım Sonrası Saha Temizliği','galeri/alanya-yikim-moloz-temizleme.jpg','Yıkım Sonrası Temizlik','Alanya yıkım sonrası mini kepçe ile moloz temizleme'],
            ['Arsa Kazısı ve Tesviye','galeri/alanya-arsa-kazisi-tesviye.jpg','Arsa Tesviye','Alanya arsa kazısı ve tesviye çalışması'],
            ['Sera İçinde Mini Kepçe Çalışması','galeri/alanya-sera-mini-kepce-calismasi.jpg','Saha Temizliği','Alanya sera içinde mini kepçe saha çalışması'],
            ['Sera Hafriyat Yükleme','galeri/alanya-sera-hafriyat-tasima.jpg','Hafriyat Taşıma','Alanya sera alanı hafriyat yükleme ve taşıma'],
        ];
        foreach ($items as $i => [$title,$image,$category,$alt]) {
            $this->insert('gallery', [
                'title' => $title,
                'image' => $image,
                'video_url' => null,
                'category' => $category,
                'alt_text' => $alt,
                'sort_order' => $i,
                'is_active' => 1,
                'created_at' => $this->now(),
                'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedPopup(): void
    {
        $this->insert('popups', [
            'title' => 'Ücretsiz Keşif ve Teklif!',
            'description' => 'Hafriyat, kepçe kiralama ve moloz taşıma işleriniz için hemen WhatsApp’tan ücretsiz teklif alın.',
            'image' => 'popup/alanya-hafriyat-teklif-saha.webp',
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
            'description' => 'Netvera Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye ihtiyaçlarına yönelik saha çözümleri sunar.',
            'copyright_text' => '© ' . date('Y') . ' Netvera Hafriyat. Tüm hakları saklıdır.',
            'column_1_title' => 'Hizmetlerimiz',
            'column_1_links_json' => json_encode([
                ['title' => 'Kepçe Kiralama', 'url' => '/hizmetler/kepce-kiralama'],
                ['title' => 'Mini Kepçe Kiralama', 'url' => '/hizmetler/mini-kepce-kiralama'],
                ['title' => 'Temel Kazısı', 'url' => '/hizmetler/temel-kazisi'],
                ['title' => 'Moloz Taşıma', 'url' => '/hizmetler/moloz-hafriyat-nakliye'],
                ['title' => 'Kanal Kazısı', 'url' => '/hizmetler/alt-yapi-kanal-acma'],
            ], JSON_UNESCAPED_UNICODE),
            'column_2_title' => 'Hızlı Linkler',
            'column_2_links_json' => json_encode([
                ['title' => 'Ana Sayfa', 'url' => '/'],
                ['title' => 'Hakkımızda', 'url' => '/hakkimizda'],
                ['title' => 'Hizmetlerimiz', 'url' => '/hizmetler'],
                ['title' => 'Projelerimiz', 'url' => '/projeler'],
                ['title' => 'Blog', 'url' => '/blog'],
                ['title' => 'İletişim', 'url' => '/iletisim'],
            ], JSON_UNESCAPED_UNICODE),
            'column_3_title' => 'Hizmet Bölgeleri',
            'column_3_content' => 'Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Cikcilli, Çıplaklı, Alanya Merkez, Konaklı, Payallar ve Avsallar',
            'background_color' => '#111111',
            'text_color' => '#CBD5E1',
            'created_at' => $this->now(), 'updated_at' => $this->now(),
        ]);
    }

    protected function seedSocial(): void
    {
        $links = [
            ['whatsapp', '#', 'whatsapp', 0, 1],
            ['instagram', '', 'instagram', 1, 0],
            ['facebook', '', 'facebook', 2, 0],
            ['youtube', '', 'youtube', 3, 0],
        ];
        foreach ($links as [$platform, $url, $icon, $sort, $active]) {
            $this->insert('social_links', [
                'platform' => $platform,
                'url' => $url === '' ? '#' : $url,
                'icon' => $icon,
                'sort_order' => $sort,
                'is_active' => $active,
            ]);
        }
    }

    protected function seedNotifications(): void
    {
        $this->insert('notification_settings', [
            'owner_name' => 'Netvera Hafriyat',
            'owner_phone' => '905321234567',
            'owner_email' => 'info@netvera.tr',
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
        // Sahte veya örnek müşteri yorumu yayınlanmaz.
        // Yalnızca gerçek müşteriden izinli yorumlar admin panelden eklenir.
    }

    public function upgradeLegacyDemoContent(): void
    {
        // Eski demo seed paketini gerçek yayına uygun içerik paketiyle değiştirir.
        // Yalnız Migrator tarafından bilinen legacy imza tespit edildiğinde çağrılır.
        $preserve = [];
        // Yerelde/admin panelinde girilmiş gerçek işletme ve iletişim verilerini koru.
        // SEO metinlerini yenilerken kullanıcının telefon, harita veya logo ayarını ezme.
        foreach ([
            'site_name', 'phone', 'whatsapp_number', 'email', 'address', 'working_hours',
            'map_embed', 'logo', 'og_image', 'web_design_credit_text', 'web_design_credit_url'
        ] as $key) {
            $stmt = $this->pdo->prepare('SELECT setting_value FROM settings WHERE setting_key = ? LIMIT 1');
            $stmt->execute([$key]);
            $preserve[$key] = (string) ($stmt->fetchColumn() ?: '');
        }

        $tables = [
            'service_faqs', 'services', 'blog_posts', 'blog_categories', 'faqs',
            'service_regions', 'equipment', 'projects', 'gallery', 'testimonials',
            'home_sections', 'pages', 'menus', 'footer_settings',
        ];
        foreach ($tables as $table) {
            $this->pdo->exec('DELETE FROM ' . $table);
        }
        $this->pdo->exec('DELETE FROM settings');

        $this->seedSettings();
        foreach ($preserve as $key => $value) {
            if ($value === '') { continue; }
            $stmt = $this->pdo->prepare('UPDATE settings SET setting_value = ?, updated_at = ? WHERE setting_key = ?');
            $stmt->execute([$value, $this->now(), $key]);
        }

        $this->seedMenus();
        $this->seedPages();
        $this->seedHomeSections();
        $this->seedServices();
        $this->seedEquipment();
        $this->seedProjects();
        $this->seedBlog();
        $this->seedFaqs();
        $this->seedGallery();
        $this->seedFooter();
        $this->seedTestimonials();
        $this->seedServiceRegions();
    }

    public function applyBrandPackV7(): void
    {
        $now = $this->now();

        // Marka adı ve seçilen logo mevcut kurulumlara uygulanır.
        $settingUpdates = [
            'site_name' => 'Netvera Hafriyat',
            'logo' => 'genel/netvera-hafriyat-logo.webp',
            'footer_about' => 'Netvera Hafriyat; hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme ihtiyaçlarına yönelik profesyonel web sitesi demo içeriği sunar.',
        ];
        foreach ($settingUpdates as $key => $value) {
            $stmt = $this->pdo->prepare('UPDATE settings SET setting_value=?, updated_at=? WHERE setting_key=?');
            $stmt->execute([$value, $now, $key]);
        }

        // Eski marka e-posta adresi yalnız eski varsayılan hâlâ duruyorsa yenilenir.
        $this->pdo->exec("UPDATE settings SET setting_value='info@netvera.tr', updated_at=" . $this->pdo->quote($now) . " WHERE setting_key='email' AND setting_value LIKE '%ersanhafriyat%'");
        $this->pdo->exec("UPDATE notification_settings SET owner_email='info@netvera.tr' WHERE owner_email LIKE '%ersanhafriyat%'");
        $this->pdo->exec("UPDATE notification_settings SET owner_name='Netvera Hafriyat' WHERE owner_name='Ersan Hafriyat'");
        $this->pdo->exec("UPDATE users SET name='Netvera Yönetici' WHERE name='Ersan Yönetici'");

        // Görünür içerikte kalan eski marka adını topluca Netvera Hafriyat'a çevir.
        $replaceTargets = [
            'settings' => ['setting_value'],
            'pages' => ['title','excerpt','content','hero_title','hero_subtitle','seo_title','seo_description'],
            'home_sections' => ['title','subtitle','content_json'],
            'services' => ['title','short_description','content','hero_title','hero_subtitle','seo_title','seo_description'],
            'projects' => ['title','short_description','content','seo_title','seo_description'],
            'blog_categories' => ['title','description','seo_title','seo_description'],
            'blog_posts' => ['title','excerpt','content_markdown','author_name','seo_title','seo_description','og_title','og_description','twitter_title','twitter_description'],
            'faqs' => ['question','answer'],
            'footer_settings' => ['description','copyright_text','column_1_title','column_1_links_json','column_2_title','column_2_links_json','column_3_title','column_3_content'],
            'service_regions' => ['description','seo_title','seo_description'],
            'popups' => ['title','description','button_text','button_url'],
        ];
        foreach ($replaceTargets as $table => $columns) {
            foreach ($columns as $column) {
                try {
                    $this->pdo->exec("UPDATE `$table` SET `$column`=REPLACE(`$column`, 'Ersan Hafriyat', 'Netvera Hafriyat') WHERE `$column` LIKE '%Ersan Hafriyat%'");
                } catch (\Throwable $e) {
                    // Eski kurulumda alan yoksa diğer alanların güncellenmesini engelleme.
                }
            }
        }

        // Footer sosyal ikonları: sahte genel profil linklerini kapat, WhatsApp'ı global numaraya bağla.
        try {
            $this->pdo->exec("UPDATE social_links SET url='#' WHERE LOWER(platform)='whatsapp' AND (url='' OR url LIKE '%905321234567%')");
            $this->pdo->exec("UPDATE social_links SET is_active=0 WHERE LOWER(platform) IN ('facebook','instagram') AND (url='https://facebook.com' OR url='https://instagram.com' OR url='#' OR url='')");
            $count = (int) ($this->pdo->query("SELECT COUNT(*) FROM social_links")->fetchColumn() ?: 0);
            if ($count === 0) {
                $this->seedSocial();
            }
        } catch (\Throwable $e) {
        }

        // Her hizmet kartı kendi işine uygun görseli taşır.
        $serviceVisuals = [
            'kepce-kiralama' => ['https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'mini-kepce-kiralama' => ['hizmetler/alanya-mini-kepce-kiralama.webp','https://images.pexels.com/photos/14846286/pexels-photo-14846286.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'temel-kazisi' => ['https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'moloz-hafriyat-nakliye' => ['hizmetler/alanya-moloz-hafriyat-tasima.webp','https://images.pexels.com/photos/29506754/pexels-photo-29506754.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'alt-yapi-kanal-acma' => ['hizmetler/alanya-kanal-kazisi.webp','hizmetler/alanya-kanal-kazisi.webp'],
            'arsa-tesviye-dolgu' => ['hizmetler/alanya-arsa-tesviye-dolgu.webp','https://images.pexels.com/photos/12164798/pexels-photo-12164798.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'cevre-bahce-duzenleme' => ['galeri/alanya-dar-alan-mini-kepce-tesviye.webp','hizmetler/alanya-arsa-temizleme.webp'],
            'drenaj-ozel-kazi' => ['hizmetler/alanya-kanal-kazisi.webp','hizmetler/alanya-kanal-kazisi.webp'],
            'havuz-kazisi' => ['https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'yol-acma-saha-hazirlama' => ['https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'toprak-serme-sikistirma' => ['https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'yikim-sonrasi-saha-temizligi' => ['https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'lastikli-kepce-kiralama' => ['https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'kazici-yukleyici-kiralama' => ['https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'forklift-kiralama' => ['https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'traktor-arazi-nakliye' => ['https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
        ];
        $serviceImageStmt = $this->pdo->prepare('UPDATE services SET card_image=?, hero_image=?, cover_image=?, og_image=?, updated_at=? WHERE slug=?');
        foreach ($serviceVisuals as $slug => [$card,$hero]) {
            $serviceImageStmt->execute([$card,$hero,$hero,$card,$now,$slug]);
        }

        // Her makalenin kendine ait kapak/OG/Twitter görseli vardır.
        $blogVisuals = [
            'alanyada-kepce-kiralama-fiyatlari-nasil-hesaplanir' => ['https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp','Alanya kepçe kiralama ve hafriyat saha çalışması'],
            'mini-kepce-mi-buyuk-kepce-mi-alanya' => ['hizmetler/alanya-mini-kepce-kiralama.webp','Alanya mini kepçe ile dar alan saha çalışması'],
            'temel-kazisi-oncesi-nelere-bakilir' => ['https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp','Temel kazısı yapılan yapı şantiyesinde ekskavatör'],
        ];
        $blogImageStmt = $this->pdo->prepare('UPDATE blog_posts SET cover_image=?, cover_image_alt=?, cover_image_title=title, og_image=?, twitter_image=?, author_name=?, updated_at=? WHERE slug=?');
        foreach ($blogVisuals as $slug => [$image,$alt]) {
            $blogImageStmt->execute([$image,$alt,$image,$image,'Netvera Hafriyat',$now,$slug]);
        }

        // Footer'ın marka açıklamasını ve telifini yeni marka ile eşitle.
        try {
            $this->pdo->exec("UPDATE footer_settings SET description='Netvera Hafriyat; hafriyat ve iş makinesi hizmetlerini modern, güçlü ve profesyonel bir kurumsal yapı ile sunmak için hazırlanmıştır.', copyright_text='© " . date('Y') . " Netvera Hafriyat. Tüm hakları saklıdır.'");
        } catch (\Throwable $e) {
        }

        $exists = $this->pdo->prepare("SELECT id FROM settings WHERE setting_key='content_pack_version' LIMIT 1");
        $exists->execute();
        if ($exists->fetchColumn()) {
            $st = $this->pdo->prepare("UPDATE settings SET setting_value='7', updated_at=? WHERE setting_key='content_pack_version'");
            $st->execute([$now]);
        } else {
            $this->insert('settings', [
                'setting_key'=>'content_pack_version','setting_value'=>'7','setting_group'=>'system','input_type'=>'text',
                'created_at'=>$now,'updated_at'=>$now,
            ]);
        }
    }

    public function applyCatalogPackV6(): void
    {
        $process = [
            ['title' => 'Talep & Bilgi', 'text' => 'Konum, iş türü, ölçü ve varsa fotoğraflar alınır.'],
            ['title' => 'Saha Değerlendirmesi', 'text' => 'Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir.'],
            ['title' => 'Teklif & Plan', 'text' => 'İş kapsamı, çalışma modeli ve teklif netleştirilir.'],
            ['title' => 'Uygulama & Kontrol', 'text' => 'Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir.'],
        ];

        $services = [
            [
                'title'=>'Lastikli Kepçe Kiralama','slug'=>'lastikli-kepce-kiralama','icon'=>'excavator',
                'short'=>'Alanya’da şehir içi, yol, altyapı, yükleme ve saha işleri için hareket kabiliyeti yüksek lastikli kepçe hizmeti.',
                'hero'=>'Alanya Lastikli Kepçe Kiralama',
                'content'=>'<h2>Lastikli kepçe hangi işlerde tercih edilir?</h2><p>Lastikli kepçeler; yol, altyapı, yükleme, kanal ve şehir içi saha işlerinde hareket kabiliyeti sayesinde avantaj sağlar. Makine sınıfı iş hacmi, zemin ve erişime göre seçilir.</p><h2>Fiyatı neler belirler?</h2><p>Çalışma süresi, makine sınıfı, konum, zemin, ataşman ve nakliye ihtiyacı teklifin temel kalemleridir.</p>',
                'advantages'=>['Şehir içi hareket kabiliyeti','Kazı ve yükleme','Yol ve altyapı işleri','Saha koşullarına göre makine seçimi','Operatörlü çalışma'],
                'usage'=>['Yol ve altyapı işleri','Kanal kazısı','Toprak ve moloz yükleme','Saha düzenleme','Şehir içi kazı'],
                'seo_title'=>'Alanya Lastikli Kepçe Kiralama | Netvera Hafriyat',
                'seo_description'=>'Alanya’da lastikli kepçe kiralama; yol, altyapı, kanal, yükleme ve saha düzenleme işleri için operatörlü makine çözümleri.',
                'card'=>'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero_img'=>'https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
                'faqs'=>[
                    ['Lastikli kepçe hangi işlerde uygundur?','Yol, altyapı, yükleme ve sık yer değişimi gereken saha işlerinde değerlendirilebilir.'],
                    ['Fiyat nasıl belirlenir?','Makine sınıfı, çalışma süresi, konum, zemin, ataşman ve nakliye ihtiyacına göre belirlenir.'],
                ],
            ],
            [
                'title'=>'Kazıcı Yükleyici Kiralama','slug'=>'kazici-yukleyici-kiralama','icon'=>'excavator',
                'short'=>'Alanya’da kazı, yükleme, kanal, saha temizliği ve dolgu işleri için çok amaçlı kazıcı yükleyici hizmeti.',
                'hero'=>'Alanya Kazıcı Yükleyici Kiralama',
                'content'=>'<h2>Kazıcı yükleyici hangi işler için kullanılır?</h2><p>Ön yükleyici kovası ve arka kazıcı kolu sayesinde kazı, yükleme, kanal, dolgu ve saha temizliği gibi birden fazla iş kaleminde değerlendirilebilir.</p><h2>Hangi sahalarda avantaj sağlar?</h2><p>Küçük ve orta ölçekli, birden fazla işin aynı sahada yürütüldüğü uygulamalarda çok yönlü çalışma sağlar.</p>',
                'advantages'=>['Kazı ve yüklemeyi birleştirme','Kanal işleri','Dolgu ve malzeme hareketi','Saha temizliği','Operatörlü hizmet'],
                'usage'=>['Kanal kazısı','Toprak yükleme','Saha temizliği','Dolgu ve tesviye','İnşaat çevresi düzenleme'],
                'seo_title'=>'Alanya Kazıcı Yükleyici Kiralama | Netvera Hafriyat',
                'seo_description'=>'Alanya’da kazıcı yükleyici kiralama; kazı, yükleme, kanal, dolgu ve saha temizliği işleri için çok amaçlı iş makinesi.',
                'card'=>'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero_img'=>'https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
                'faqs'=>[
                    ['Kazıcı yükleyici ile hem kazı hem yükleme yapılabilir mi?','Evet, iş kapsamına göre iki fonksiyon aynı çalışma planında kullanılabilir.'],
                    ['Hangi ölçekte işler için uygundur?','Küçük ve orta ölçekli saha işlerinde erişim ve zemin uygunsa verimli bir seçenektir.'],
                ],
            ],
            [
                'title'=>'Forklift Kiralama','slug'=>'forklift-kiralama','icon'=>'forklift',
                'short'=>'Alanya’da paletli yük, yapı malzemesi ve saha içi indirme-bindirme ihtiyaçları için forklift desteği.',
                'hero'=>'Alanya Forklift Kiralama',
                'content'=>'<h2>Forklift hangi işler için kullanılır?</h2><p>Forklift; paletli yapı malzemeleri, paketli yükler ve saha içi indirme-bindirme işlerinde kullanılır. Yük ağırlığı, kaldırma yüksekliği ve zemin koşulları makine seçimini belirler.</p><h2>Teklif için hangi bilgiler gerekir?</h2><p>Yük türü, yaklaşık ağırlık, kaldırma yüksekliği, çalışma süresi ve saha fotoğrafları doğru planlamaya yardımcı olur.</p>',
                'advantages'=>['Paletli yük taşıma','İndirme-bindirme','Saha içi malzeme hareketi','Yük ve yüksekliğe göre makine seçimi','Planlı çalışma'],
                'usage'=>['Yapı malzemesi indirme','Palet taşıma','Depo ve saha lojistiği','Kamyon boşaltma','Şantiye malzeme yerleştirme'],
                'seo_title'=>'Alanya Forklift Kiralama | Netvera Hafriyat',
                'seo_description'=>'Alanya forklift kiralama; paletli yük, yapı malzemesi, kamyon indirme-bindirme ve saha içi taşıma ihtiyaçları için teklif alın.',
                'card'=>'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero_img'=>'https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
                'faqs'=>[
                    ['Forklift fiyatı neye göre belirlenir?','Çalışma süresi, yük ağırlığı, kaldırma yüksekliği, saha konumu ve nakliye ihtiyacı fiyatı etkiler.'],
                    ['Kamyondan malzeme indirme yapılabilir mi?','Yük ve saha koşulları uygunsa indirme-bindirme işi planlanabilir.'],
                ],
            ],
            [
                'title'=>'Traktör ile Arazi ve Nakliye Desteği','slug'=>'traktor-arazi-nakliye','icon'=>'tractor',
                'short'=>'Alanya’da bahçe, arazi ve saha işlerinde yerli üretim traktörle malzeme taşıma ve yardımcı çalışma desteği.',
                'hero'=>'Alanya Traktör ile Arazi ve Nakliye Desteği',
                'content'=>'<h2>Traktör hangi saha işlerinde kullanılır?</h2><p>Traktör; bahçe, arazi ve saha içi yardımcı taşıma, römork desteği ve hafif malzeme hareketi gibi işlerde kullanılabilir.</p><h2>Makine bilgisi nasıl teyit edilir?</h2><p>Yerli üretim traktör seçeneğinin model, güç ve ekipman bilgileri iş öncesinde mevcut makineye göre teyit edilir.</p>',
                'advantages'=>['Arazi içi taşıma','Römork desteği','Bahçe ve saha çalışmaları','Hafriyat ekibine lojistik destek','İşe göre ekipman'],
                'usage'=>['Bahçe ve arazi işleri','Römorklu taşıma','Toprak ve hafif malzeme hareketi','Saha lojistiği','Kepçe işlerine yardımcı taşıma'],
                'seo_title'=>'Alanya Traktör ve Arazi Nakliye Desteği | Netvera Hafriyat',
                'seo_description'=>'Alanya’da traktör ile arazi, bahçe ve saha içi nakliye desteği; römorklu malzeme taşıma ve yardımcı çalışma seçenekleri.',
                'card'=>'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp',
                'hero_img'=>'https://images.pexels.com/photos/8938489/pexels-photo-8938489.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp',
                'faqs'=>[
                    ['Traktörle hangi işler yapılabilir?','Arazi içi yardımcı taşıma, römorklu malzeme hareketi ve saha lojistiği işlerinde kullanılabilir.'],
                    ['Hangi traktör modeli kullanılıyor?','Model ve güç sınıfı teklif öncesinde mevcut yerli üretim makineye göre teyit edilir.'],
                ],
            ],
        ];

        $findService = $this->pdo->prepare('SELECT id FROM services WHERE slug=? LIMIT 1');
        foreach ($services as $i => $s) {
            $findService->execute([$s['slug']]);
            $serviceId = (int) ($findService->fetchColumn() ?: 0);
            if ($serviceId === 0) {
                $serviceId = $this->insert('services', [
                    'title'=>$s['title'],'slug'=>$s['slug'],'icon'=>$s['icon'],
                    'card_image'=>$s['card'],'cover_image'=>$s['hero_img'],'hero_image'=>$s['hero_img'],'og_image'=>$s['card'],
                    'short_description'=>$s['short'],'content'=>$s['content'],
                    'hero_title'=>$s['hero'],'hero_subtitle'=>$s['short'],
                    'advantages_json'=>json_encode($s['advantages'], JSON_UNESCAPED_UNICODE),
                    'usage_areas_json'=>json_encode($s['usage'], JSON_UNESCAPED_UNICODE),
                    'process_json'=>json_encode($process, JSON_UNESCAPED_UNICODE),
                    'seo_title'=>$s['seo_title'],'seo_description'=>$s['seo_description'],
                    'sort_order'=>12+$i,'is_featured'=>0,'is_active'=>1,
                    'created_at'=>$this->now(),'updated_at'=>$this->now(),
                ]);
                foreach ($s['faqs'] as $faqOrder => [$question,$answer]) {
                    $this->insert('service_faqs', [
                        'service_id'=>$serviceId,'question'=>$question,'answer'=>$answer,
                        'sort_order'=>$faqOrder,'is_active'=>1,
                    ]);
                }
            }
        }

        $this->pdo->exec("UPDATE services SET is_featured=CASE WHEN slug IN (
            'kepce-kiralama','mini-kepce-kiralama','temel-kazisi',
            'moloz-hafriyat-nakliye','lastikli-kepce-kiralama','forklift-kiralama'
        ) THEN 1 ELSE 0 END");

        $equipment = [
            ['Orta Sınıf Lastikli Ekskavatör','orta-sinif-lastikli-ekskavator','Lastikli Ekskavatör','Yol, altyapı, kanal, yükleme ve şehir içi saha işleri','Kova • İşe göre ataşman','Lastikli ekskavatör • Şehir içi hareket kabiliyeti • Kazı ve yükleme','<p>Çok ağır tonaj gerektirmeyen yol, altyapı, kanal ve yükleme işlerinde orta sınıf lastikli ekskavatör seçeneği değerlendirilir. Model ve kapasite iş öncesinde teyit edilir.</p>','https://images.pexels.com/photos/37704019/pexels-photo-37704019.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp'],
            ['Kazıcı Yükleyici (Beko Loder)','kazici-yukleyici-beko-loder','Kazıcı Yükleyici','Kazı, yükleme, kanal, dolgu ve saha temizliği','Ön yükleyici kova • Arka kazıcı','Kazı ve yükleme • Kanal işleri • Çok amaçlı saha kullanımı','<p>Kazıcı yükleyici; kazı ve yükleme fonksiyonlarının aynı makinede gerektiği küçük ve orta ölçekli saha çalışmalarında kullanılır. Marka ve model teklif öncesinde teyit edilir.</p>','https://images.pexels.com/photos/29411122/pexels-photo-29411122.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp'],
            ['Tümosan Traktör','tumosan-traktor','Tümosan','Bahçe, arazi, römorklu taşıma ve saha lojistiği','Römork • İşe göre yardımcı ekipman','Yerli üretim traktör • Arazi desteği • Römorklu taşıma','<p>Yerli üretim Tümosan traktör; bahçe, arazi ve saha içi yardımcı taşıma işlerinde kullanılabilir. Model ve güç bilgisi teklif öncesinde mevcut makineye göre teyit edilir.</p>','https://www.tumosan.com.tr/uploads/2023/08/2013-yerli-105-beygir-traktor-uretimi_op.webp'],
            ['Dizel Forklift','dizel-forklift','Dizel Forklift','Paletli yük, yapı malzemesi ve saha içi indirme-bindirme','Standart çatal','Paletli yük taşıma • İndirme-bindirme • Saha lojistiği','<p>Dizel forklift; yapı malzemesi, palet ve saha içi yüklerin taşınması ile kamyon indirme-bindirme işlerinde değerlendirilir. Kapasite iş öncesinde teyit edilir.</p>','https://images.pexels.com/photos/12069525/pexels-photo-12069525.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp'],
        ];
        $findEquipment = $this->pdo->prepare('SELECT id FROM equipment WHERE slug=? LIMIT 1');
        $baseSort = (int) ($this->pdo->query('SELECT COALESCE(MAX(sort_order),0) FROM equipment')->fetchColumn() ?: 0) + 1;
        foreach ($equipment as $i => [$title,$slug,$brand,$usage,$attachments,$short,$content,$image]) {
            $findEquipment->execute([$slug]);
            if (!$findEquipment->fetchColumn()) {
                $this->insert('equipment', [
                    'title'=>$title,'slug'=>$slug,'brand_model'=>$brand,'usage_area'=>$usage,
                    'attachments'=>$attachments,'short_description'=>$short,'content'=>$content,
                    'image'=>$image,'gallery_json'=>null,'sort_order'=>$baseSort+$i,'is_active'=>1,
                    'created_at'=>$this->now(),'updated_at'=>$this->now(),
                ]);
            }
        }

        $this->pdo->exec("UPDATE home_sections SET subtitle='İşin türü, saha koşulları ve erişime göre uygun makine seçeneği planlanır; marka/model ve mevcut makine teklif öncesinde teyit edilir.' WHERE section_key='equipment'");

        $now=$this->now();
        $exists=$this->pdo->prepare("SELECT id FROM settings WHERE setting_key='content_pack_version' LIMIT 1");
        $exists->execute();
        if($exists->fetchColumn()){
            $st=$this->pdo->prepare("UPDATE settings SET setting_value='6', updated_at=? WHERE setting_key='content_pack_version'");
            $st->execute([$now]);
        }else{
            $this->insert('settings',['setting_key'=>'content_pack_version','setting_value'=>'6','setting_group'=>'system','input_type'=>'text','created_at'=>$now,'updated_at'=>$now]);
        }
    }

    public function applyVisualPackV5(): void
    {
        $serviceVisuals = [
            'kepce-kiralama' => ['https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'mini-kepce-kiralama' => ['hizmetler/alanya-mini-kepce-kiralama.webp','https://images.pexels.com/photos/14846286/pexels-photo-14846286.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'temel-kazisi' => ['https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'moloz-hafriyat-nakliye' => ['hizmetler/alanya-moloz-hafriyat-tasima.webp','https://images.pexels.com/photos/29506754/pexels-photo-29506754.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'alt-yapi-kanal-acma' => ['hizmetler/alanya-kanal-kazisi.webp','hizmetler/alanya-kanal-kazisi.webp'],
            'arsa-tesviye-dolgu' => ['hizmetler/alanya-arsa-tesviye-dolgu.webp','https://images.pexels.com/photos/12164798/pexels-photo-12164798.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'cevre-bahce-duzenleme' => ['galeri/alanya-dar-alan-mini-kepce-tesviye.webp','hizmetler/alanya-arsa-temizleme.webp'],
            'drenaj-ozel-kazi' => ['hizmetler/alanya-kanal-kazisi.webp','hizmetler/alanya-kanal-kazisi.webp'],
            'havuz-kazisi' => ['https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/38733243/pexels-photo-38733243.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'yol-acma-saha-hazirlama' => ['https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/18812422/pexels-photo-18812422.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'toprak-serme-sikistirma' => ['https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/4390530/pexels-photo-4390530.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
            'yikim-sonrasi-saha-temizligi' => ['https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=900&h=560&fit=crop&fm=webp','https://images.pexels.com/photos/29565466/pexels-photo-29565466.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp'],
        ];
        $stmt = $this->pdo->prepare('UPDATE services SET card_image=?, cover_image=?, hero_image=?, og_image=?, updated_at=? WHERE slug=?');
        foreach ($serviceVisuals as $slug => [$card,$hero]) {
            $stmt->execute([$card,$hero,$hero,$card,$this->now(),$slug]);
        }

        $this->pdo->exec("UPDATE home_sections SET image='https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1600&h=900&fit=crop&fm=webp' WHERE section_key='hero'");
        $this->pdo->exec("UPDATE pages SET hero_image='sayfalar/ersan-hafriyat-hakkimizda-saha.webp', cover_image='sayfalar/ersan-hafriyat-hakkimizda-saha.webp', og_image='genel/alanya-hafriyat-og-kapak.webp' WHERE slug='hakkimizda'");
        $this->pdo->exec("UPDATE popups SET image='popup/alanya-hafriyat-teklif-saha.webp'");

        $blogVisuals = [
            'alanyada-kepce-kiralama-fiyatlari-nasil-hesaplanir' => ['https://images.pexels.com/photos/38948572/pexels-photo-38948572.jpeg?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp','Alanya kepçe kiralama ve hafriyat saha çalışması'],
            'mini-kepce-mi-buyuk-kepce-mi-alanya' => ['hizmetler/alanya-mini-kepce-kiralama.webp','Alanya mini kepçe ile dar alan saha çalışması'],
            'temel-kazisi-oncesi-nelere-bakilir' => ['https://images.pexels.com/photos/18214889/pexels-photo-18214889.png?auto=compress&cs=tinysrgb&w=1200&h=675&fit=crop&fm=webp','Temel kazısı yapılan yapı şantiyesinde ekskavatör'],
        ];
        $bst = $this->pdo->prepare('UPDATE blog_posts SET cover_image=?, cover_image_alt=?, cover_image_title=title, og_image=?, twitter_image=?, updated_at=? WHERE slug=?');
        foreach ($blogVisuals as $slug => [$img,$alt]) {
            $bst->execute([$img,$alt,$img,$img,$this->now(),$slug]);
        }

        $updateSetting = $this->pdo->prepare("UPDATE settings SET setting_value=?, updated_at=? WHERE setting_key=? AND (setting_value IS NULL OR setting_value='')");
        $updateSetting->execute(['genel/netvera-hafriyat-logo.webp',$this->now(),'logo']);
        $updateSetting->execute(['genel/alanya-hafriyat-og-kapak.webp',$this->now(),'og_image']);

        if ((int) $this->pdo->query('SELECT COUNT(*) FROM equipment')->fetchColumn() === 0) { $this->seedEquipment(); }
        if ((int) $this->pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn() === 0) { $this->seedProjects(); }
        if ((int) $this->pdo->query('SELECT COUNT(*) FROM gallery')->fetchColumn() === 0) { $this->seedGallery(); }

        $now = $this->now();
        $exists = $this->pdo->prepare("SELECT id FROM settings WHERE setting_key='content_pack_version' LIMIT 1");
        $exists->execute();
        if ($exists->fetchColumn()) {
            $st = $this->pdo->prepare("UPDATE settings SET setting_value='5', updated_at=? WHERE setting_key='content_pack_version'");
            $st->execute([$now]);
        } else {
            $this->insert('settings', ['setting_key'=>'content_pack_version','setting_value'=>'5','setting_group'=>'system','input_type'=>'text','created_at'=>$now,'updated_at'=>$now]);
        }
    }

    protected function seedServiceRegions(): void
    {
        $regions = [
            ['Mahmutlar', 'Antalya', 'Alanya'],
            ['Kestel', 'Antalya', 'Alanya'],
            ['Kargıcak', 'Antalya', 'Alanya'],
            ['Oba', 'Antalya', 'Alanya'],
            ['Tosmur', 'Antalya', 'Alanya'],
            ['Alanya Merkez', 'Antalya', 'Alanya'],
            ['Cikcilli', 'Antalya', 'Alanya'],
            ['Çıplaklı', 'Antalya', 'Alanya'],
            ['Payallar', 'Antalya', 'Alanya'],
            ['Konaklı', 'Antalya', 'Alanya'],
            ['Avsallar', 'Antalya', 'Alanya'],
            ['Gazipaşa', 'Antalya', 'Gazipaşa'],
        ];
        foreach ($regions as $i => [$title, $city, $district]) {
            $desc = $title . ' ve çevresinde hafriyat, kepçe, mini kepçe, kazı, taşıma ve tesviye talepleri işin konumu ve kapsamına göre planlanır.';
            $this->insert('service_regions', [
                'title' => $title, 'slug' => slugify($title),
                'city' => $city, 'district' => $district,
                'description' => $desc,
                'seo_title' => $title . ' Hafriyat ve Kepçe Hizmetleri | Netvera Hafriyat',
                'seo_description' => $title . ' bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Netvera Hafriyat ile iletişime geçin.',
                'sort_order' => $i, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }
}
