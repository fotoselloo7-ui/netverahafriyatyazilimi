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
            ['site_tagline', 'Alanya Hafriyat • Kepçe Kiralama • Mini Kepçe', 'general', 'text'],
            ['phone', '+90 539 528 01 48', 'contact', 'text'],
            ['whatsapp_number', '905395280148', 'contact', 'text'],
            ['email', 'info@ersanhafriyat.com.tr', 'contact', 'text'],
            ['address', 'Mahmutlar Mah. Alanya / ANTALYA', 'contact', 'text'],
            ['working_hours', 'Pzt - Cmt: 08:00 - 18:00', 'contact', 'text'],
            ['top_bar_text', 'Alanya ve çevresinde hafriyat, kepçe ve kazı hizmetleri', 'general', 'text'],
            ['map_embed', 'https://www.google.com/maps?q=Mahmutlar+Alanya+Antalya&output=embed', 'contact', 'textarea'],
            ['seo_title', 'Alanya Hafriyat | Kepçe, Kazı ve Moloz Hizmetleri | Ersan Hafriyat', 'seo', 'text'],
            ['seo_description', 'Alanya’da hafriyat, operatörlü kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye hizmetleri. İşiniz için hızlı teklif alın.', 'seo', 'textarea'],
            ['seo_keywords', 'alanya hafriyat, alanya kepçe kiralama, alanya mini kepçe, temel kazısı, moloz taşıma, arsa tesviye', 'seo', 'text'],
            ['og_image', '', 'seo', 'image'],
            ['footer_about', 'Ersan Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme ihtiyaçlarına yönelik çözümler sunar.', 'general', 'textarea'],
            ['logo', '', 'general', 'image'],
            ['about_counter_experience', '', 'about', 'text'],
            ['about_counter_projects', '', 'about', 'text'],
            ['about_counter_staff', '', 'about', 'text'],
            ['about_counter_support', '', 'about', 'text'],
            ['floating_whatsapp_enabled', '1', 'general', 'toggle'],
            ['web_design_credit_text', 'Netvera Teknoloji Yazılım', 'footer', 'text'],
            ['web_design_credit_url', '', 'footer', 'text'],
            ['content_pack_version', '2', 'system', 'text'],
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
            'excerpt' => 'Ersan Hafriyat; Mahmutlar’dan Alanya ve çevresine hafriyat, kepçe kiralama, kazı, taşıma ve tesviye hizmetleri sunar.',
            'content' => '<p>Ersan Hafriyat, Mahmutlar’dan Alanya ve çevresine hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma, arsa tesviye ve saha düzenleme hizmetleri sunar.</p><p>Her işte önce çalışma alanının erişimi, zemin yapısı, kazı veya taşıma kapsamı ve ihtiyaç duyulan makine tipi değerlendirilir. Amaç; gereksiz iş kalemleri oluşturmadan sahaya uygun bir çalışma planı ve net teklif hazırlamaktır.</p><p>Talebinizi telefon veya WhatsApp üzerinden iletebilir; yapılacak işin konumu, yaklaşık alanı, erişim koşulları ve varsa fotoğrafları paylaşarak daha doğru bir ön değerlendirme alabilirsiniz.</p>',
            'hero_title' => 'Ersan Hafriyat Hakkında',
            'hero_subtitle' => 'Alanya’da hafriyat, kepçe ve kazı ihtiyaçları için saha odaklı çözüm',
            'hero_overlay_opacity' => '0.55',
            'seo_title' => 'Ersan Hafriyat Hakkında | Alanya Hafriyat ve Kepçe',
            'seo_description' => 'Ersan Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel kazısı, moloz taşıma ve arsa tesviye hizmetleri sunar.',
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
                'seo_title' => $title . ' | Ersan Hafriyat', 'robots_index' => 0,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedHomeSections(): void
    {
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
            ['equipment', 'İşinize Uygun Makine Seçimi', 'Makine parkuru bölümünde yalnızca işletmenin doğrulanmış gerçek makineleri yayınlanır.', null, ''],
            ['process', 'Hizmet Sürecimiz', 'Talebinizden saha uygulamasına kadar net ve planlı ilerleyen süreç', json_encode([
                ['icon' => 'message-circle', 'title' => 'Talebi Paylaşın', 'text' => 'Konum, iş türü, yaklaşık alan ve varsa saha fotoğraflarını iletin.'],
                ['icon' => 'search', 'title' => 'Saha İhtiyacını Belirleyelim', 'text' => 'Erişim, zemin, kazı derinliği ve çıkan malzeme gibi temel koşullar değerlendirilir.'],
                ['icon' => 'clipboard', 'title' => 'Makine ve İş Planı', 'text' => 'İşe uygun makine, süre, nakliye ve ekip ihtiyacı planlanır.'],
                ['icon' => 'hard-hat', 'title' => 'Uygulama', 'text' => 'Belirlenen çalışma kapsamına göre saha uygulaması gerçekleştirilir.'],
                ['icon' => 'check-circle', 'title' => 'Kontrol ve Teslim', 'text' => 'Tamamlanan iş saha koşulları ve talep kapsamına göre kontrol edilir.'],
            ], JSON_UNESCAPED_UNICODE), ''],
            ['machine_anim', 'Sahada Doğru Plan, Verimli Çalışma',
             'Kazı, yükleme, taşıma ve tesviye işlerinde makine seçimi; alanın erişimi, zemin ve iş kapsamına göre planlanır.', null, ''],
            ['gallery', 'Sahadan Gerçek Görüntüler', 'Bu bölümde yalnızca Ersan Hafriyat’ın gerçek çalışma fotoğraf ve videoları yayınlanır.', null, ''],
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
                'content_json' => $json, 'image' => $image, 'sort_order' => $i++,
                'is_active' => 1, 'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }

    protected function seedServices(): void
    {
        $services = [
            [
                'title' => 'Kepçe Kiralama', 'slug' => 'kepce-kiralama', 'icon' => 'truck',
                'short' => 'Alanya’da temel kazısı, yükleme, kanal, tesviye ve saha işleri için operatörlü kepçe hizmeti.',
                'hero' => 'Alanya Kepçe Kiralama',
                'content' => '<h2>Alanya’da kepçe kiralama hangi işler için kullanılır?</h2><p>Kepçe kiralama; temel ve kanal kazısı, arsa düzenleme, yükleme, tesviye, moloz ve hafriyat işleri gibi farklı saha ihtiyaçlarında kullanılır. Doğru makine seçimi işin büyüklüğü, zemin yapısı, çalışma alanına erişim ve çıkarılacak malzemenin miktarına göre yapılır.</p><h2>Operatörlü kepçe hizmetinde süreç nasıl işler?</h2><p>Teklif öncesinde işin konumu, yapılacak çalışma, yaklaşık alan veya kazı ölçüsü, makinenin sahaya giriş koşulları ve varsa fotoğraflar değerlendirilir. Böylece gereksiz kapasite veya yetersiz makine seçimi yerine işe uygun bir plan oluşturulur.</p><h2>Kepçe kiralama fiyatını neler belirler?</h2><p>Fiyat; çalışma süresi, kullanılacak makine tipi, makinenin sahaya nakli, zemin koşulları, kırıcı veya farklı ataşman ihtiyacı, çıkan hafriyatın taşınıp taşınmayacağı ve kamyon gereksinimi gibi kalemlere göre değişir. Bu nedenle tek bir sabit fiyat yerine işin kapsamına göre teklif hazırlanır.</p><h2>Alanya’da hizmet bölgeleri</h2><p>Mahmutlar, Kestel, Kargıcak, Oba, Tosmur, Cikcilli, Çıplaklı, Alanya Merkez, Konaklı, Payallar, Avsallar ve hizmet planına uygun çevre bölgeler için talep oluşturabilirsiniz.</p>',
                'advantages' => ['İşin kapsamına göre makine planlama', 'Operatörlü çalışma seçeneği', 'Kazı, yükleme ve tesviye ihtiyaçlarını birlikte değerlendirme', 'Telefon ve WhatsApp üzerinden hızlı ön değerlendirme', 'Saha koşullarına göre teklif'],
                'usage' => ['Temel ve yapı kazıları', 'Kanal ve altyapı kazıları', 'Arsa tesviye ve dolgu', 'Toprak ve moloz yükleme', 'Bahçe ve saha düzenleme'],
                'seo_title' => 'Alanya Kepçe Kiralama | Operatörlü Kepçe | Ersan Hafriyat',
                'seo_description' => 'Alanya’da operatörlü kepçe kiralama; temel ve kanal kazısı, yükleme, tesviye ve hafriyat işleri. İşinize uygun makine için Ersan Hafriyat’tan teklif alın.',
                'faqs' => [
                    ['Alanya’da kepçe kiralama fiyatı nasıl belirlenir?', 'Fiyat; çalışma süresi, makine tipi, saha erişimi, nakliye, zemin, ataşman ihtiyacı ve çıkan malzemenin taşınması gibi iş kalemlerine göre belirlenir.'],
                    ['Saatlik veya günlük kepçe çalışması mümkün mü?', 'Çalışma modeli işin kapsamına ve sahaya göre planlanır. Saatlik veya günlük uygunluk için işin konumunu ve yapılacak çalışmayı ileterek teklif isteyebilirsiniz.'],
                    ['Kepçe operatörlü mü çalışıyor?', 'Hizmet planı operatörlü çalışma ihtiyacına göre hazırlanır. Teklif aşamasında makine ve operatör gereksinimi birlikte netleştirilir.'],
                ],
            ],
            [
                'title' => 'Mini Kepçe Kiralama', 'slug' => 'mini-kepce-kiralama', 'icon' => 'truck',
                'short' => 'Dar alan, bahçe, küçük temel ve kanal işleri için Alanya mini kepçe ve mini ekskavatör çözümleri.',
                'hero' => 'Alanya Mini Kepçe Kiralama',
                'content' => '<h2>Mini kepçe hangi işlerde tercih edilir?</h2><p>Mini kepçe; büyük iş makinelerinin manevra yapmakta zorlandığı dar bahçeler, bina çevreleri, küçük temel ve kanal kazıları, peyzaj hazırlığı ve hassas tesviye işleri için tercih edilir. En önemli avantajı daha sınırlı çalışma alanlarında kontrollü hareket edebilmesidir.</p><h2>Dar alanda makine seçimi nasıl yapılır?</h2><p>Mini kepçe talebinde yalnız işin büyüklüğü değil; kapı veya geçiş genişliği, saha içindeki dönüş alanı, kazı derinliği, zemin tipi ve çıkan malzemenin nasıl uzaklaştırılacağı da önemlidir. Bu bilgiler makine seçiminin temelini oluşturur.</p><h2>Mini kepçe fiyatını etkileyen faktörler</h2><p>Çalışma süresi, makinenin sahaya nakli, zemin koşulları, kazı derinliği, ataşman ihtiyacı ve moloz/hafriyat taşıması fiyatı etkileyebilir. Gerçek makine ölçüleri ve teknik sınırlar yalnızca doğrulanmış ekipman bilgisi üzerinden paylaşılır.</p>',
                'advantages' => ['Dar alanlarda çalışma planı', 'Bahçe ve bina çevresinde kontrollü kazı', 'Küçük temel ve kanal işleri', 'Erişim ölçülerine göre ön değerlendirme', 'Kazı ve tesviye ihtiyaçlarını birlikte planlama'],
                'usage' => ['Dar bahçe girişleri', 'Küçük temel kazıları', 'Kanal ve tesisat hatları', 'Peyzaj ve çevre düzenleme', 'Hassas tesviye işleri'],
                'seo_title' => 'Alanya Mini Kepçe Kiralama | Dar Alan Kazı | Ersan Hafriyat',
                'seo_description' => 'Alanya mini kepçe kiralama; dar bahçe girişleri, küçük temel ve kanal kazıları, peyzaj ve hassas saha işleri. İşiniz için uygun mini kepçe planı alın.',
                'faqs' => [
                    ['Mini kepçe dar bahçe girişlerinde kullanılabilir mi?', 'Uygunluk giriş genişliği, dönüş alanı ve kullanılacak gerçek makinenin ölçülerine bağlıdır. Saha ölçülerini ve fotoğrafları paylaşarak ön değerlendirme yapılabilir.'],
                    ['Mini kepçe ile temel kazısı yapılır mı?', 'Küçük ölçekli temel ve benzeri kazılarda kullanılabilir; uygunluk kazı derinliği, zemin ve iş hacmine göre belirlenir.'],
                    ['Mini kepçe fiyatı neye göre değişir?', 'Çalışma süresi, nakliye, zemin, erişim, kazı kapsamı ve varsa kırıcı/ataşman ihtiyacı fiyatı etkileyen başlıca unsurlardır.'],
                ],
            ],
            [
                'title' => 'Temel Kazısı', 'slug' => 'temel-kazisi', 'icon' => 'layers',
                'short' => 'Alanya’da villa, konut ve yapı projeleri için saha koşullarına uygun temel kazısı hizmeti.',
                'hero' => 'Alanya Temel Kazısı',
                'content' => '<h2>Temel kazısı öncesinde nelere bakılır?</h2><p>Temel kazısında proje ölçüleri kadar zeminin yapısı, makinenin sahaya erişimi, kazı derinliği, çıkan toprağın sahada kullanılıp kullanılmayacağı ve taşıma ihtiyacı önemlidir. Çalışma bu bilgiler netleştirildikten sonra planlanır.</p><h2>Kazıdan çıkan malzeme nasıl yönetilir?</h2><p>Çıkan malzemenin bir kısmı dolgu veya tesviye için değerlendirilebilir; taşınması gereken toprak ve moloz için ise yükleme ve nakliye planı oluşturulur. Böylece kazı ile saha düzeni birbirinden kopuk iki iş yerine tek süreçte ele alınabilir.</p><h2>Teklif için hangi bilgiler gerekir?</h2><p>Konum, proje veya yaklaşık kazı ölçüsü, saha giriş durumu, zeminle ilgili bilinen bilgiler ve fotoğraflar teklifin daha doğru hazırlanmasına yardımcı olur.</p>',
                'advantages' => ['Kazı ölçülerine göre planlama', 'Saha erişimi ve zemin değerlendirmesi', 'Hafriyat yükleme ve taşıma ihtiyacını birlikte planlama', 'Tesviye ve dolgu ihtiyacını aynı süreçte değerlendirme', 'İş kapsamına göre makine seçimi'],
                'usage' => ['Villa temel kazısı', 'Konut ve yapı temelleri', 'İstinat ve çevre kazıları', 'Temel çevresi düzenleme', 'Kazı sonrası dolgu ve tesviye'],
                'seo_title' => 'Alanya Temel Kazısı | Bina ve Villa Kazısı | Ersan Hafriyat',
                'seo_description' => 'Alanya’da bina ve villa temel kazısı; saha erişimi, zemin, kazı ölçüsü, hafriyat taşıma ve tesviye ihtiyacına göre planlı kazı hizmeti.',
                'faqs' => [
                    ['Temel kazısı fiyatı nasıl hesaplanır?', 'Kazı hacmi, zemin, makine tipi, çalışma süresi, saha erişimi ve çıkan malzemenin taşınma ihtiyacı temel fiyat faktörleridir.'],
                    ['Kazıdan çıkan toprak taşınabilir mi?', 'Taşıma ihtiyacı varsa kazı ile birlikte yükleme ve nakliye planlanabilir. Net kapsam sahadaki malzeme miktarına göre belirlenir.'],
                    ['Temel kazısı için keşif gerekir mi?', 'Ölçekli veya erişimi zor işlerde saha koşullarını görmek daha doğru makine ve süre planı yapılmasını sağlar.'],
                ],
            ],
            [
                'title' => 'Moloz ve Hafriyat Taşıma', 'slug' => 'moloz-hafriyat-nakliye', 'icon' => 'truck',
                'short' => 'Alanya’da kazıdan çıkan toprak, hafriyat ve molozun yükleme ve taşıma ihtiyacına yönelik saha planlaması.',
                'hero' => 'Alanya Moloz ve Hafriyat Taşıma',
                'content' => '<h2>Moloz ve hafriyat taşıma nasıl planlanır?</h2><p>Taşıma işinde yalnız kamyon sayısı değil; malzemenin türü ve tahmini miktarı, yükleme alanı, sahaya araç giriş-çıkışı ve uygun boşaltma planı birlikte değerlendirilir. Kazı işiyle eş zamanlı planlama yapılması sahadaki beklemeyi azaltabilir.</p><h2>Yükleme hizmeti de dahil olabilir mi?</h2><p>İşin kapsamına göre moloz veya toprağın kepçe ile yüklenmesi ve taşıma süreci birlikte değerlendirilebilir. Teklif için yaklaşık miktar, konum ve malzeme türünün paylaşılması yararlıdır.</p><h2>Fiyatı etkileyen unsurlar</h2><p>Malzeme miktarı, yükleme ihtiyacı, taşıma mesafesi, saha erişimi, çalışma süresi ve ek makine gereksinimi fiyatı belirleyen ana kalemlerdir.</p>',
                'advantages' => ['Kazı ve taşıma işini birlikte planlama', 'Yükleme ihtiyacını kapsama dahil edebilme', 'Malzeme miktarına göre araç planı', 'Saha giriş-çıkış koşullarını değerlendirme', 'Konum ve iş kapsamına göre teklif'],
                'usage' => ['Kazı toprağı taşıma', 'İnşaat molozu yükleme ve taşıma', 'Arsa ve bahçe temizliği sonrası malzeme', 'Temel kazısı hafriyatı', 'Saha temizliği'],
                'seo_title' => 'Alanya Moloz Taşıma | Hafriyat Nakliye | Ersan Hafriyat',
                'seo_description' => 'Alanya’da moloz taşıma ve hafriyat nakliye; yükleme, kazı toprağı, saha erişimi ve taşıma ihtiyacına göre planlama. Ersan Hafriyat’tan teklif alın.',
                'faqs' => [
                    ['Alanya moloz taşıma fiyatı neye göre belirlenir?', 'Malzeme miktarı, yükleme ihtiyacı, taşıma mesafesi, saha erişimi ve gereken araç/makine süresi fiyatı etkiler.'],
                    ['Molozun yüklenmesi de yapılabilir mi?', 'İş kapsamına göre kepçe ile yükleme ve taşıma birlikte planlanabilir.'],
                    ['Kazı ve hafriyat taşıma aynı işte planlanabilir mi?', 'Evet, kazı sırasında çıkan malzemenin taşınması gerekiyorsa iki iş tek çalışma planında değerlendirilebilir.'],
                ],
            ],
            [
                'title' => 'Altyapı ve Kanal Kazısı', 'slug' => 'alt-yapi-kanal-acma', 'icon' => 'git-branch',
                'short' => 'Alanya’da altyapı, drenaj, tesisat ve benzeri hatlar için kanal kazısı ve saha hazırlığı.',
                'hero' => 'Alanya Kanal Kazısı ve Altyapı',
                'content' => '<h2>Kanal kazısı hangi işler için yapılır?</h2><p>Kanal kazısı; drenaj, su ve tesisat hatları, altyapı geçişleri ve benzeri saha ihtiyaçlarında uygulanır. Çalışmanın genişliği ve derinliği, mevcut hatlar, zemin yapısı ve makinenin alana erişimi planlamada önemlidir.</p><h2>Dar alanlarda kanal kazısı</h2><p>Bahçe, bina çevresi veya sınırlı geçişe sahip alanlarda daha küçük makine ihtiyacı doğabilir. Kullanılacak makine, gerçek geçiş ölçüsü ve kazı kapsamına göre seçilir.</p><h2>Çalışma öncesi nelere dikkat edilir?</h2><p>Mevcut altyapı hatları ve proje bilgileri mümkün olduğunca önceden belirlenmeli; kazı güzergâhı, malzemenin nereye alınacağı ve kazı sonrası dolgu ihtiyacı birlikte değerlendirilmelidir.</p>',
                'advantages' => ['Kazı güzergâhına göre planlama', 'Dar alan koşullarını değerlendirme', 'Kazı sonrası dolgu ihtiyacını planlama', 'Zemin ve derinliğe göre makine seçimi', 'Saha düzenine uygun çalışma'],
                'usage' => ['Drenaj kanalı', 'Su ve tesisat hattı kazısı', 'Altyapı geçişleri', 'Bahçe ve bina çevresi kanal işleri', 'Kazı sonrası dolgu'],
                'seo_title' => 'Alanya Kanal Kazısı ve Altyapı | Ersan Hafriyat',
                'seo_description' => 'Alanya’da kanal kazısı, drenaj ve altyapı çalışmaları; dar alan, zemin, derinlik ve dolgu ihtiyacına göre saha planlaması ve teklif.',
                'faqs' => [
                    ['Kanal kazısında kullanılacak makine nasıl seçilir?', 'Kanalın genişliği ve derinliği, saha erişimi ve zemin yapısı makine seçiminde belirleyicidir.'],
                    ['Dar alanda kanal kazısı yapılabilir mi?', 'Uygunluk geçiş ölçüsü ve çalışma alanına bağlıdır. Saha ölçüleri paylaşıldığında mini makine seçeneği değerlendirilebilir.'],
                    ['Kazı sonrası dolgu yapılabilir mi?', 'İş kapsamına göre kanal kazısı sonrasında dolgu ve saha düzenleme ihtiyacı aynı plan içinde değerlendirilebilir.'],
                ],
            ],
            [
                'title' => 'Arsa Tesviye ve Dolgu', 'slug' => 'arsa-tesviye-dolgu', 'icon' => 'mountain',
                'short' => 'Alanya’da arsa, bahçe ve yapı çevresinde kot düzenleme, tesviye, dolgu ve yüzey hazırlığı.',
                'hero' => 'Alanya Arsa Tesviye ve Dolgu',
                'content' => '<h2>Arsa tesviyesi nedir?</h2><p>Arsa tesviyesi; yüzeydeki seviye farklarının işin amacına göre düzenlenmesi, gerekli alanların kazılması veya doldurulması ve sahada kontrollü bir eğim/kot oluşturulması işlemidir. Yapı öncesi hazırlık, bahçe düzenleme ve kullanım alanı açma gibi farklı amaçlarla yapılabilir.</p><h2>Dolgu işinde hangi bilgiler önemlidir?</h2><p>Kullanılacak dolgu malzemesi, dolgu kalınlığı, alanın mevcut kotu, drenaj ihtiyacı ve sıkıştırma gereksinimi işin kapsamını etkiler. Saha koşullarına göre uygun makine ve çalışma sırası belirlenir.</p><h2>Fiyatı ne belirler?</h2><p>Alan büyüklüğü, taşınacak veya getirilecek malzeme miktarı, makine süresi, zemin ve erişim koşulları tesviye/dolgu fiyatında temel unsurlardır.</p>',
                'advantages' => ['Kot ve yüzey ihtiyacına göre çalışma', 'Kazı ve dolgu kalemlerini birlikte değerlendirme', 'Arsa ve bahçe düzenleme desteği', 'Malzeme hareketine göre makine planı', 'Saha erişimine göre teklif'],
                'usage' => ['Arsa düzeltme', 'Yapı öncesi saha hazırlığı', 'Bahçe tesviyesi', 'Toprak dolgu', 'Kot ve eğim düzenleme'],
                'seo_title' => 'Alanya Arsa Tesviye ve Dolgu | Ersan Hafriyat',
                'seo_description' => 'Alanya’da arsa tesviye, zemin düzenleme ve dolgu işleri. Alan, kot, malzeme miktarı, zemin ve makine ihtiyacına göre planlı saha çalışması.',
                'faqs' => [
                    ['Arsa tesviye fiyatı nasıl belirlenir?', 'Alan büyüklüğü, kot farkı, taşınacak veya getirilecek malzeme, makine süresi ve saha erişimi fiyatı etkiler.'],
                    ['Tesviye ile dolgu aynı işte yapılabilir mi?', 'Saha ihtiyacına göre kazı, dolgu ve yüzey düzenleme aynı çalışma planında ele alınabilir.'],
                    ['Bahçe tesviyesi için büyük kepçe şart mı?', 'Hayır. Makine seçimi alanın büyüklüğü ve erişim koşullarına göre yapılır; dar alanlarda daha küçük ekipman gerekebilir.'],
                ],
            ],
            [
                'title' => 'Arsa Temizleme ve Bahçe Düzenleme', 'slug' => 'cevre-bahce-duzenleme', 'icon' => 'trees',
                'short' => 'Alanya’da arsa ve bahçelerde saha temizliği, toprak düzenleme, tesviye ve kazı ihtiyaçları.',
                'hero' => 'Alanya Arsa Temizleme ve Bahçe Düzenleme',
                'content' => '<h2>Arsa ve bahçe temizliği hangi işleri kapsar?</h2><p>Saha temizliği; zemindeki birikintilerin kaldırılması, gerekli alanlarda kazı yapılması, toprağın düzenlenmesi, tesviye ve çıkan malzemenin yüklenip taşınması gibi farklı iş kalemlerini içerebilir. İş kapsamı arazinin mevcut durumuna göre belirlenir.</p><h2>Bahçe alanlarında neden makine seçimi önemlidir?</h2><p>Bahçe kapısı, duvarlar, ağaçlar ve mevcut yapılar çalışma alanını sınırlayabilir. Bu nedenle makine boyutu ve hareket alanı önceden değerlendirilmelidir.</p><h2>Temizlik sonrası saha düzenlenebilir mi?</h2><p>İhtiyaca göre yüzey düzeltme, tesviye veya dolgu çalışmaları temizlik sonrasında aynı plan içinde ele alınabilir.</p>',
                'advantages' => ['Saha temizliği ve düzenlemeyi birlikte planlama', 'Dar girişleri değerlendirme', 'Yükleme ve taşıma ihtiyacını kapsama dahil etme', 'Tesviye ve dolgu seçeneği', 'Arazi durumuna göre makine planı'],
                'usage' => ['Arsa temizleme', 'Bahçe toprak düzenleme', 'Yüzey tesviyesi', 'Malzeme yükleme ve taşıma', 'Yapı çevresi saha hazırlığı'],
                'seo_title' => 'Alanya Arsa Temizleme ve Bahçe Düzenleme | Ersan Hafriyat',
                'seo_description' => 'Alanya’da arsa temizleme, bahçe düzenleme, toprak tesviye, yükleme ve saha hazırlığı. Alanın erişim ve zemin koşullarına göre teklif alın.',
                'faqs' => [
                    ['Arsa temizleme işinde moloz taşıma da yapılabilir mi?', 'İş kapsamına göre çıkan malzemenin yüklenmesi ve taşınması aynı plan içinde değerlendirilebilir.'],
                    ['Dar bahçelerde hangi makine kullanılır?', 'Makine seçimi kapı/geçiş genişliği, dönüş alanı ve yapılacak işin hacmine göre belirlenir.'],
                    ['Temizlik sonrası tesviye yapılabilir mi?', 'Evet, ihtiyaç varsa yüzey düzeltme, tesviye ve dolgu kalemleri çalışma planına eklenebilir.'],
                ],
            ],
            [
                'title' => 'Drenaj ve Özel Kazı İşleri', 'slug' => 'drenaj-ozel-kazi', 'icon' => 'droplet',
                'short' => 'Alanya’da drenaj hattı, özel ölçülü kazı ve saha koşullarına göre planlanan kazı çalışmaları.',
                'hero' => 'Alanya Drenaj ve Özel Kazı İşleri',
                'content' => '<h2>Drenaj kazısı ne zaman gerekir?</h2><p>Drenaj kanalı veya hattı için yapılacak kazılarda güzergâh, eğim, derinlik, mevcut zemin ve saha erişimi birlikte değerlendirilir. Kazının amacı suyun kontrollü şekilde yönlendirilmesine uygun bir hat oluşturmaktır; teknik proje gerektiren işlerde uygulama ilgili proje ve ölçülere göre yapılmalıdır.</p><h2>Özel kazı ne demektir?</h2><p>Standart geniş saha kazılarından farklı olarak dar geçiş, belirli ölçü veya hassas çalışma gerektiren işler özel kazı kapsamında değerlendirilebilir. Kullanılacak makine ve ataşman gerçek saha koşullarına göre seçilir.</p>',
                'advantages' => ['Güzergâh ve ölçüye göre kazı planı', 'Dar veya hassas alanları değerlendirme', 'Zemin ve erişime göre makine seçimi', 'Kazı sonrası dolgu ihtiyacını planlama', 'İş kapsamına göre teklif'],
                'usage' => ['Drenaj kanalları', 'Özel ölçülü kazılar', 'Bahçe ve yapı çevresi hatları', 'Dar alan çalışmaları', 'Kazı sonrası dolgu'],
                'seo_title' => 'Alanya Drenaj ve Özel Kazı İşleri | Ersan Hafriyat',
                'seo_description' => 'Alanya’da drenaj kanalı ve özel kazı işleri; güzergâh, derinlik, zemin ve saha erişimine göre makine ve çalışma planı.',
                'faqs' => [
                    ['Drenaj kazısı için hangi bilgiler gerekir?', 'Hat güzergâhı, yaklaşık uzunluk ve derinlik, saha erişimi ve varsa proje/ölçü bilgileri ön değerlendirme için önemlidir.'],
                    ['Dar alanda özel kazı yapılabilir mi?', 'Uygunluk geçiş ölçülerine ve gerçek makine seçeneklerine bağlıdır; saha bilgileri paylaşıldığında değerlendirilir.'],
                    ['Kazı sonrası dolgu planlanabilir mi?', 'İş kapsamına göre dolgu ve yüzey düzenleme çalışmaları kazı sürecine eklenebilir.'],
                ],
            ],
        ];

        $process = [
            ['title' => 'Talep & Bilgi', 'text' => 'Konum, iş türü, ölçü ve varsa fotoğraflar alınır.'],
            ['title' => 'Saha Değerlendirmesi', 'text' => 'Erişim, zemin, makine ve taşıma ihtiyacı değerlendirilir.'],
            ['title' => 'Teklif & Plan', 'text' => 'İş kapsamı, çalışma modeli ve teklif netleştirilir.'],
            ['title' => 'Uygulama & Kontrol', 'text' => 'Planlanan iş uygulanır ve tamamlanan çalışma kontrol edilir.'],
        ];

        foreach ($services as $i => $s) {
            $serviceId = $this->insert('services', [
                'title' => $s['title'], 'slug' => $s['slug'], 'icon' => $s['icon'],
                'short_description' => $s['short'],
                'content' => $s['content'],
                'hero_title' => $s['hero'],
                'hero_subtitle' => $s['short'],
                'advantages_json' => json_encode($s['advantages'], JSON_UNESCAPED_UNICODE),
                'usage_areas_json' => json_encode($s['usage'], JSON_UNESCAPED_UNICODE),
                'process_json' => json_encode($process, JSON_UNESCAPED_UNICODE),
                'seo_title' => $s['seo_title'],
                'seo_description' => $s['seo_description'],
                'sort_order' => $i, 'is_featured' => $i < 6 ? 1 : 0, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
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
        // Makine parkurunda yalnızca işletmenin doğrulanmış gerçek makine/model bilgileri yayınlanır.
        // Varsayılan sahte marka, tonaj veya teknik özellik seed edilmez.
    }

    protected function seedProjects(): void
    {
        // Gerçek saha kanıtı olmayan örnek proje yayınlanmaz.
        // Projeler admin panelden gerçek tarih, bölge, görsel ve iş kapsamıyla eklenir.
    }

    protected function seedBlog(): void
    {
        $categories = [
            ['Kepçe Kiralama', 'kepce-kiralama', 'Alanya’da kepçe ve mini kepçe seçimi, kiralama süreci ve fiyat faktörleri.', 'Alanya Kepçe Kiralama Rehberi | Ersan Hafriyat', 'Kepçe ve mini kepçe kiralama öncesi makine seçimi, saha erişimi, çalışma süresi ve fiyat faktörlerini öğrenin.'],
            ['Hafriyat ve Kazı', 'hafriyat-kazi', 'Temel, kanal, moloz, tesviye ve hafriyat işlerinin planlama rehberleri.', 'Alanya Hafriyat ve Kazı Rehberi | Ersan Hafriyat', 'Alanya’da hafriyat, temel kazısı, kanal, moloz taşıma ve arsa tesviye işleri için karar rehberleri.'],
            ['Saha Rehberi', 'saha-rehberi', 'İş başlamadan önce erişim, zemin, ölçü ve saha hazırlığı hakkında pratik bilgiler.', 'Hafriyat Saha Rehberi | Ersan Hafriyat', 'Kazı ve hafriyat işi öncesinde saha erişimi, zemin, makine seçimi ve teklif için gerekli bilgileri öğrenin.'],
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
                'seo_title' => 'Alanya Kepçe Kiralama Fiyatları Nasıl Hesaplanır? | Ersan Hafriyat',
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
                'seo_title' => 'Alanya Temel Kazısı Öncesi Nelere Bakılır? | Ersan Hafriyat',
                'seo_description' => 'Temel kazısı öncesinde kazı ölçüsü, zemin, saha erişimi, makine seçimi, hafriyat taşıma ve dolgu planında kontrol edilmesi gerekenler.',
                'content' => "## Temel kazısında ilk soru yalnız \"kaç metre kazılacak?\" değildir\n\nSağlıklı bir temel kazısı planı; proje ölçüsü, zemin, makine erişimi ve çıkan malzemenin yönetimini birlikte ele alır. İş başlamadan önce bu başlıkların netleştirilmesi gereksiz beklemeyi ve yanlış makine seçimini azaltır.\n\n### Proje ve kazı ölçüleri\n\nKazının sınırları, derinliği ve çalışma payı mümkün olduğunca net olmalıdır. Uygulama teknik projeye bağlıysa saha çalışması ilgili ölçülere göre yürütülmelidir.\n\n### Makinenin sahaya erişimi\n\nKapı, yol genişliği, eğim, dönüş alanı ve çevredeki mevcut yapılar makinenin seçimini etkiler.\n\n### Zemin yapısı\n\nToprak, dolgu, taşlı veya sert zemin çalışma süresini ve ataşman ihtiyacını değiştirebilir.\n\n### Çıkan malzeme ne olacak?\n\nKazı toprağı sahada dolgu için kullanılacak mı, stoklanacak mı, yoksa taşınacak mı? Bu karar yükleme ve kamyon planını doğrudan etkiler.\n\n### Kazı sonrası tesviye ve dolgu\n\nTemel çevresi veya saha içinde daha sonra dolgu ve seviye düzenlemesi gerekecekse iş sırası en baştan buna göre planlanabilir.\n\n## Teklif isterken paylaşılabilecek bilgiler\n\nKonum, proje/ölçü bilgisi, saha fotoğrafları, giriş durumu ve çıkan malzemeyle ilgili beklenti doğru ön değerlendirme için en yararlı bilgilerdir.",
                'faq' => [
                    ['Temel kazısı için hangi makine gerekir?', 'Makine seçimi kazı hacmi, derinlik, zemin ve saha erişimine göre yapılır.'],
                    ['Kazı toprağı taşınmak zorunda mı?', 'Hayır. Proje ve saha uygunsa bir kısmı dolgu veya tesviye için değerlendirilebilir; taşınacak kısım ayrıca planlanır.'],
                ],
            ],
        ];

        foreach ($posts as $idx => $post) {
            $wordCount = str_word_count(strip_tags($post['content']));
            $this->insert('blog_posts', [
                'category_id' => $categoryIds[$post['category']] ?? null,
                'title' => $post['title'], 'slug' => $post['slug'],
                'excerpt' => $post['excerpt'],
                'content_markdown' => $post['content'],
                'author_name' => 'Ersan Hafriyat',
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
        // Galeri yalnızca gerçek saha fotoğraf ve videolarıyla doldurulur.
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
            'description' => 'Ersan Hafriyat; Alanya ve çevresinde hafriyat, kepçe kiralama, mini kepçe, temel ve kanal kazısı, moloz taşıma ve arsa tesviye ihtiyaçlarına yönelik saha çözümleri sunar.',
            'copyright_text' => '© ' . date('Y') . ' Ersan Hafriyat. Tüm hakları saklıdır.',
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
                'seo_title' => $title . ' Hafriyat ve Kepçe Hizmetleri | Ersan Hafriyat',
                'seo_description' => $title . ' bölgesinde hafriyat, kepçe kiralama, temel ve kanal kazısı, moloz taşıma ve tesviye talepleri için Ersan Hafriyat ile iletişime geçin.',
                'sort_order' => $i, 'is_active' => 1,
                'created_at' => $this->now(), 'updated_at' => $this->now(),
            ]);
        }
    }
}
