<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Migrator
{
    protected PDO $pdo;
    protected Schema $schema;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->schema = new Schema($pdo);
    }

    public static function tableNames(): array
    {
        return [
            'users', 'settings', 'theme_settings', 'menus', 'pages', 'home_sections',
            'services', 'service_faqs', 'equipment', 'projects', 'gallery',
            'blog_categories', 'blog_posts', 'faqs', 'testimonials', 'popups', 'leads',
            'media', 'footer_settings', 'social_links', 'redirects',
            'notification_settings', 'notification_logs', 'site_events', 'license_logs',
            'service_regions',
        ];
    }

    public function fresh(): void
    {
        $this->schema->dropAll(array_reverse(static::tableNames()));
        $this->run();
    }

    /**
     * Kurulu sistemlerde sonradan eklenen tabloları oluşturur (idempotent,
     * CREATE TABLE IF NOT EXISTS ile). Her boot'ta güvenle çağrılabilir.
     */
    public function upgrade(): void
    {
        $this->schema->create('license_logs', function (Blueprint $t) {
            $t->id();
            $t->string('event_type', 40);
            $t->string('status', 40)->nullable();
            $t->text('message')->nullable();
            $t->string('request_url')->nullable();
            $t->text('response_json')->nullable();
            $t->datetime('created_at')->nullable();
        });

        // Çalışma bölgeleri gerçek CMS modülü
        $this->schema->create('service_regions', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('city', 80)->nullable();
            $t->string('district', 80)->nullable();
            $t->string('neighborhood', 120)->nullable();
            $t->text('description')->nullable();
            $t->string('seo_title')->nullable();
            $t->text('seo_description')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        // Sonradan eklenen kolonlar (idempotent)
        $this->schema->addColumnIfMissing('license_logs', 'request_url', 'VARCHAR(255)');
        $blogCols = [
            'cover_image_alt' => 'VARCHAR(255)', 'cover_image_title' => 'VARCHAR(255)',
            'author_name' => 'VARCHAR(255)', 'focus_keyword' => 'VARCHAR(255)',
            'og_title' => 'VARCHAR(255)', 'og_description' => 'TEXT',
            'twitter_title' => 'VARCHAR(255)', 'twitter_description' => 'TEXT',
            'twitter_image' => 'VARCHAR(255)', 'robots_index' => 'TINYINT',
            'robots_follow' => 'TINYINT', 'schema_type' => 'VARCHAR(30)',
            'related_service_id' => 'INT', 'related_posts_json' => 'TEXT',
            'faq_json' => 'TEXT', 'seo_score' => 'INT', 'seo_suggestions_json' => 'TEXT',
        ];
        foreach ($blogCols as $col => $type) {
            $this->schema->addColumnIfMissing('blog_posts', $col, $type);
        }
        $this->schema->addColumnIfMissing('blog_categories', 'seo_title', 'VARCHAR(255)');
        $this->schema->addColumnIfMissing('blog_categories', 'seo_description', 'TEXT');
        $this->schema->addColumnIfMissing('testimonials', 'company', 'VARCHAR(255)');
        $this->schema->addColumnIfMissing('testimonials', 'image', 'VARCHAR(255)');
        $this->schema->addColumnIfMissing('testimonials', 'sort_order', 'INT', '0');
        $this->schema->addColumnIfMissing('testimonials', 'updated_at', 'DATETIME');

        // Kontrast/tema genişletmesi — var olan kurulumlara kolonları ekle
        $themeCols = [
            'primary_hover_color' => '#D98A00', 'primary_text_color' => '#111827',
            'secondary_text_color' => '#FFFFFF', 'surface_color' => '#FFFFFF',
            'muted_text_color' => '#64748B', 'border_color' => '#E5E7EB',
            'button_primary_bg' => '#F5A400', 'button_primary_text' => '#111827',
            'button_dark_bg' => '#080B0F', 'button_dark_text' => '#FFFFFF',
        ];
        foreach ($themeCols as $col => $def) {
            $this->schema->addColumnIfMissing('theme_settings', $col, 'VARCHAR(20)', $def);
        }

        // Footer web tasarım kredi alanları
        $this->schema->addColumnIfMissing('footer_settings', 'web_design_credit_text', 'VARCHAR(191)', '');
        $this->schema->addColumnIfMissing('footer_settings', 'web_design_credit_url', 'VARCHAR(191)', '');

        $this->upgradeContentPackV2();
    }

    protected function upgradeContentPackV2(): void
    {
        try {
            $stmt = $this->pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = 'content_pack_version' LIMIT 1");
            $stmt->execute();
            $version = (int) ($stmt->fetchColumn() ?: 0);
            if ($version >= 2) {
                return;
            }

            // Yalnız eski paket imzası hâlâ mevcutsa otomatik içerik yenilemesi yap.
            $legacyTitle = (string) ($this->pdo->query("SELECT setting_value FROM settings WHERE setting_key = 'seo_title' LIMIT 1")->fetchColumn() ?: '');
            $legacyServices = (int) $this->pdo->query("SELECT COUNT(*) FROM services")->fetchColumn();
            $looksLikeLegacySeed = $legacyServices === 9 || str_contains($legacyTitle, 'Alanya & Mahmutlar Hafriyat');

            if ($looksLikeLegacySeed) {
                (new Seeder($this->pdo))->upgradeLegacyDemoContent();
                return;
            }

            // Özelleştirilmiş kurulumlarda içerikleri ezme; yalnız sürüm işaretini ekle.
            $now = date('Y-m-d H:i:s');
            $insert = $this->pdo->prepare(
                "INSERT INTO settings (setting_key, setting_value, setting_group, input_type, created_at, updated_at)
                 VALUES ('content_pack_version', '2', 'system', 'text', ?, ?)"
            );
            $insert->execute([$now, $now]);
        } catch (\Throwable $e) {
            // İçerik paketi güncellemesi siteyi açılmaz hâle getirmemeli.
        }
    }

    public function run(): void
    {
        $s = $this->schema;

        $s->create('users', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('email')->unique();
            $t->string('password_hash');
            $t->string('role', 30)->default('admin');
            $t->string('status', 20)->default('active');
            $t->datetime('last_login_at')->nullable();
            $t->timestamps();
        });

        $s->create('settings', function (Blueprint $t) {
            $t->id();
            $t->string('setting_key')->unique();
            $t->text('setting_value')->nullable();
            $t->string('setting_group', 60)->default('general');
            $t->string('input_type', 30)->default('text');
            $t->timestamps();
        });

        $s->create('theme_settings', function (Blueprint $t) {
            $t->id();
            $t->string('primary_color', 20)->default('#F5A400');
            $t->string('primary_hover_color', 20)->default('#D98A00');
            $t->string('primary_text_color', 20)->default('#111827');
            $t->string('secondary_color', 20)->default('#111827');
            $t->string('secondary_text_color', 20)->default('#FFFFFF');
            $t->string('dark_color', 20)->default('#080B0F');
            $t->string('accent_color', 20)->default('#FFB703');
            $t->string('background_color', 20)->default('#F7F4EF');
            $t->string('surface_color', 20)->default('#FFFFFF');
            $t->string('text_color', 20)->default('#111827');
            $t->string('muted_text_color', 20)->default('#64748B');
            $t->string('border_color', 20)->default('#E5E7EB');
            $t->string('button_primary_bg', 20)->default('#F5A400');
            $t->string('button_primary_text', 20)->default('#111827');
            $t->string('button_dark_bg', 20)->default('#080B0F');
            $t->string('button_dark_text', 20)->default('#FFFFFF');
            $t->string('whatsapp_color', 20)->default('#25D366');
            $t->string('border_radius', 20)->default('10px');
            $t->string('card_radius', 20)->default('14px');
            $t->string('shadow_strength', 20)->default('0.10');
            $t->timestamps();
        });

        $s->create('menus', function (Blueprint $t) {
            $t->id();
            $t->string('menu_location', 40)->default('header');
            $t->string('title');
            $t->string('url')->nullable();
            $t->integer('page_id')->nullable();
            $t->string('menu_type', 30)->default('internal');
            $t->string('icon', 60)->nullable();
            $t->string('target', 20)->default('_self');
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('pages', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('excerpt')->nullable();
            $t->text('content')->nullable();
            $t->string('hero_title')->nullable();
            $t->string('hero_subtitle')->nullable();
            $t->string('hero_image')->nullable();
            $t->string('hero_overlay_opacity', 10)->default('0.55');
            $t->string('hero_button_1_text')->nullable();
            $t->string('hero_button_1_url')->nullable();
            $t->string('hero_button_1_type', 20)->default('internal');
            $t->string('hero_button_2_text')->nullable();
            $t->string('hero_button_2_url')->nullable();
            $t->string('hero_button_2_type', 20)->default('internal');
            $t->string('cover_image')->nullable();
            $t->string('seo_title')->nullable();
            $t->text('seo_description')->nullable();
            $t->string('canonical_url')->nullable();
            $t->string('og_image')->nullable();
            $t->boolean('robots_index')->default(1);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('home_sections', function (Blueprint $t) {
            $t->id();
            $t->string('section_key')->unique();
            $t->string('title')->nullable();
            $t->string('subtitle')->nullable();
            $t->text('content_json')->nullable();
            $t->string('image')->nullable();
            $t->string('cta_text')->nullable();
            $t->string('cta_url')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('services', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('short_description')->nullable();
            $t->text('content')->nullable();
            $t->string('icon', 60)->nullable();
            $t->string('card_image')->nullable();
            $t->string('cover_image')->nullable();
            $t->string('hero_title')->nullable();
            $t->string('hero_subtitle')->nullable();
            $t->string('hero_image')->nullable();
            $t->text('advantages_json')->nullable();
            $t->text('usage_areas_json')->nullable();
            $t->text('process_json')->nullable();
            $t->string('seo_title')->nullable();
            $t->text('seo_description')->nullable();
            $t->string('og_image')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_featured')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('service_faqs', function (Blueprint $t) {
            $t->id();
            $t->integer('service_id');
            $t->string('question');
            $t->text('answer')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
        });

        $s->create('equipment', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('brand_model')->nullable();
            $t->string('usage_area')->nullable();
            $t->string('attachments')->nullable();
            $t->text('short_description')->nullable();
            $t->text('content')->nullable();
            $t->string('image')->nullable();
            $t->text('gallery_json')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('projects', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->string('region')->nullable();
            $t->string('service_type')->nullable();
            $t->text('short_description')->nullable();
            $t->text('content')->nullable();
            $t->string('cover_image')->nullable();
            $t->string('before_image')->nullable();
            $t->string('after_image')->nullable();
            $t->text('gallery_json')->nullable();
            $t->string('project_date', 30)->nullable();
            $t->string('seo_title')->nullable();
            $t->text('seo_description')->nullable();
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('gallery', function (Blueprint $t) {
            $t->id();
            $t->string('title')->nullable();
            $t->string('image')->nullable();
            $t->string('video_url')->nullable();
            $t->string('category', 80)->nullable();
            $t->string('alt_text')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('blog_categories', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('description')->nullable();
            $t->string('seo_title')->nullable();
            $t->text('seo_description')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
        });

        $s->create('blog_posts', function (Blueprint $t) {
            $t->id();
            $t->integer('category_id')->nullable();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('excerpt')->nullable();
            $t->text('content_markdown')->nullable();
            $t->string('cover_image')->nullable();
            $t->string('cover_image_alt')->nullable();
            $t->string('cover_image_title')->nullable();
            $t->string('author_name')->nullable();
            $t->string('focus_keyword')->nullable();
            $t->string('seo_title')->nullable();
            $t->text('seo_description')->nullable();
            $t->string('canonical_url')->nullable();
            $t->string('og_title')->nullable();
            $t->text('og_description')->nullable();
            $t->string('og_image')->nullable();
            $t->string('twitter_title')->nullable();
            $t->text('twitter_description')->nullable();
            $t->string('twitter_image')->nullable();
            $t->boolean('robots_index')->default(1);
            $t->boolean('robots_follow')->default(1);
            $t->string('schema_type', 30)->default('BlogPosting');
            $t->integer('related_service_id')->nullable();
            $t->text('related_posts_json')->nullable();
            $t->text('faq_json')->nullable();
            $t->integer('seo_score')->default(0);
            $t->text('seo_suggestions_json')->nullable();
            $t->integer('reading_time')->default(1);
            $t->string('status', 20)->default('draft');
            $t->datetime('published_at')->nullable();
            $t->timestamps();
        });

        $s->create('faqs', function (Blueprint $t) {
            $t->id();
            $t->string('question');
            $t->text('answer')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
        });

        $s->create('testimonials', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('company')->nullable();
            $t->string('location')->nullable();
            $t->text('comment')->nullable();
            $t->integer('rating')->default(5);
            $t->string('image')->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
            $t->timestamps();
        });

        $s->create('popups', function (Blueprint $t) {
            $t->id();
            $t->string('title')->nullable();
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->string('button_text')->nullable();
            $t->string('button_url')->nullable();
            $t->string('button_type', 20)->default('internal');
            $t->boolean('is_active')->default(0);
            $t->integer('delay_seconds')->default(3);
            $t->integer('repeat_after_hours')->default(24);
            $t->string('target_pages', 40)->default('all');
            $t->boolean('show_on_mobile')->default(1);
            $t->string('overlay_opacity', 10)->default('0.6');
            $t->timestamps();
        });

        $s->create('leads', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('phone', 40);
            $t->string('email')->nullable();
            $t->string('service_type')->nullable();
            $t->string('region')->nullable();
            $t->text('message')->nullable();
            $t->string('source', 40)->default('website');
            $t->string('status', 20)->default('new');
            $t->text('admin_note')->nullable();
            $t->string('ip_hash', 64)->nullable();
            $t->string('user_agent')->nullable();
            $t->timestamps();
        });

        $s->create('media', function (Blueprint $t) {
            $t->id();
            $t->string('file_name');
            $t->string('file_path');
            $t->string('file_type', 60)->nullable();
            $t->string('alt_text')->nullable();
            $t->string('title')->nullable();
            $t->integer('uploaded_by')->nullable();
            $t->datetime('created_at')->nullable();
        });

        $s->create('footer_settings', function (Blueprint $t) {
            $t->id();
            $t->string('logo')->nullable();
            $t->text('description')->nullable();
            $t->string('copyright_text')->nullable();
            $t->string('column_1_title')->nullable();
            $t->text('column_1_links_json')->nullable();
            $t->string('column_2_title')->nullable();
            $t->text('column_2_links_json')->nullable();
            $t->string('column_3_title')->nullable();
            $t->text('column_3_content')->nullable();
            $t->string('web_design_credit_text')->nullable();
            $t->string('web_design_credit_url')->nullable();
            $t->string('background_color', 20)->default('#111111');
            $t->string('text_color', 20)->default('#CBD5E1');
            $t->timestamps();
        });

        $s->create('social_links', function (Blueprint $t) {
            $t->id();
            $t->string('platform', 60);
            $t->string('url');
            $t->string('icon', 60)->nullable();
            $t->integer('sort_order')->default(0);
            $t->boolean('is_active')->default(1);
        });

        $s->create('redirects', function (Blueprint $t) {
            $t->id();
            $t->string('old_url');
            $t->string('new_url');
            $t->integer('status_code')->default(301);
            $t->boolean('is_active')->default(1);
            $t->datetime('created_at')->nullable();
        });

        $s->create('notification_settings', function (Blueprint $t) {
            $t->id();
            $t->string('owner_name')->nullable();
            $t->string('owner_phone', 40)->nullable();
            $t->string('owner_email')->nullable();
            $t->boolean('whatsapp_api_enabled')->default(0);
            $t->string('whatsapp_provider', 40)->nullable();
            $t->text('whatsapp_api_token')->nullable();
            $t->string('whatsapp_phone_number_id')->nullable();
            $t->string('whatsapp_template_name')->nullable();
            $t->string('custom_webhook_url')->nullable();
            $t->boolean('sms_enabled')->default(0);
            $t->string('sms_provider', 40)->nullable();
            $t->text('sms_api_key')->nullable();
            $t->boolean('email_enabled')->default(0);
            $t->string('smtp_host')->nullable();
            $t->string('smtp_user')->nullable();
            $t->text('smtp_password')->nullable();
            $t->string('smtp_port', 10)->nullable();
            $t->boolean('telegram_enabled')->default(0);
            $t->text('telegram_bot_token')->nullable();
            $t->string('telegram_chat_id')->nullable();
            $t->boolean('notify_on_new_lead')->default(1);
            $t->boolean('notify_on_contact_form')->default(1);
            $t->boolean('notify_on_whatsapp_click')->default(0);
            $t->boolean('notify_on_popup_click')->default(0);
            $t->boolean('notify_on_admin_login')->default(0);
            $t->boolean('notify_on_new_visitor')->default(0);
            $t->integer('visitor_notification_throttle_minutes')->default(30);
            $t->timestamps();
        });

        $s->create('notification_logs', function (Blueprint $t) {
            $t->id();
            $t->string('event_type', 60)->nullable();
            $t->string('channel', 40)->nullable();
            $t->string('recipient')->nullable();
            $t->text('message')->nullable();
            $t->string('status', 40)->nullable();
            $t->text('provider_response')->nullable();
            $t->integer('related_id')->nullable();
            $t->datetime('created_at')->nullable();
        });

        $s->create('site_events', function (Blueprint $t) {
            $t->id();
            $t->string('event_type', 60);
            $t->string('page_url')->nullable();
            $t->string('source')->nullable();
            $t->string('ip_hash', 64)->nullable();
            $t->string('user_agent')->nullable();
            $t->text('metadata_json')->nullable();
            $t->datetime('created_at')->nullable();
        });

        $this->upgrade(); // sonradan eklenen tablolar (license_logs vb.)
    }
}
