# Ersan Hafriyat

Alanya & Mahmutlar merkezli hafriyat, kepçe kiralama, temel kazısı, moloz taşıma, altyapı ve çevre düzenleme hizmetleri için kurumsal web sitesi + yönetim paneli (CMS).

PHP 8 + MVC + PDO. Veritabanı olarak **SQLite** (sıfır kurulum, varsayılan) veya **MySQL/MariaDB** kullanılabilir.

## Yerel Çalıştırma

```bash
php -S 127.0.0.1:8020 -t public public/router.php
```

Windows'ta kısayol: `start-8020.bat`

Ardından:
- Site:  http://127.0.0.1:8020
- Yönetim: http://127.0.0.1:8020/yonetim/giris

> Not: Temiz URL'ler için `router.php` yönlendiricisi gereklidir. Apache/cPanel ortamında bunun yerine dahil edilen `.htaccess` dosyaları devreye girer.

### Admin Giriş (yerel geliştirme)
- E-posta: `admin@ersanhafriyat.local`
- Şifre: `ChangeMe8020!`

İlk çalıştırmada veritabanı şeması + demo içerik otomatik oluşturulur (`storage/database.sqlite`).

## Ortam Ayarları (.env)

```
DB_CONNECTION=sqlite          # veya mysql
DB_DATABASE_SQLITE=storage/database.sqlite
DB_HOST=127.0.0.1
DB_DATABASE=ersan_hafriyat
DB_USERNAME=root
DB_PASSWORD=
```

MySQL'e geçmek için `DB_CONNECTION=mysql` yapıp veritabanı bilgilerini girin; şema ve seed ilk istekte otomatik kurulur.

## Yapı

```
app/
  Core/         Çekirdek (Router, Database, Migrator, Seeder, View, Auth, Csrf...)
  Controllers/  Frontend + Admin denetleyiciler
  Models/       Veri modelleri
  Services/     SettingsService, NotificationService, LeadService, Markdown, UploadService
  Views/        Şablonlar (layouts, partials, admin)
config/         Uygulama & DB konfigürasyonu
public/         Front controller (index.php), assets, uploads
routes/web.php  Rotalar
storage/        SQLite DB + loglar
```

## Öne Çıkan Özellikler

- Tamamen yönetilebilir CMS (19 modül): Genel Ayarlar, Tema/Renkler, Menü, Sayfalar,
  Ana Sayfa Bölümleri, Hizmetler, Makine Parkuru, Projeler, Galeri, Blog (Markdown),
  SSS, Popup, Teklifler/Leadler, Bildirim, Medya Kütüphanesi.
- CSS variables ile admin panelden hex renk yönetimi.
- Site adı değişince header, footer, admin üst bar, SEO/OG başlık ve LocalBusiness schema otomatik güncellenir.
- Hero, butonlar, bölümler ve footer tamamen admin panelden düzenlenebilir.
- Lead/teklif sistemi: CSRF + honeypot + telefon doğrulama + XSS temizliği + IP hash.
- Bildirim sistemi: WhatsApp Cloud API / Telegram / SMS / E-posta (kimlik bilgisi yoksa
  sistem bozulmaz, `skipped_missing_credentials` loglanır).
- Güvenli görsel yükleme (MIME + uzantı + getimagesize kontrolü, rastgele ad, uploads'ta PHP kapalı).
- SEO: meta/OG/Twitter, LocalBusiness/Service/FAQ/Article schema, `sitemap.xml`, `robots.txt`.
- Responsive tasarım, sticky header, floating WhatsApp, mobil alt aksiyon barı, popup, 404.

## Production Notları

- `.env` içinde `APP_ENV=production`, `APP_DEBUG=false` yapın.
- Admin şifresini değiştirin.
- MySQL kullanacaksanız `DB_CONNECTION=mysql` ayarlayın.
- `storage/` ve `public/uploads/` yazılabilir olmalı.
