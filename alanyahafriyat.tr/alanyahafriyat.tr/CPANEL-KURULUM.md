# Ersan Hafriyat CMS — cPanel / Production Kurulum Rehberi

Bu belge, projeyi paylaşımlı hosting (cPanel) veya herhangi bir Apache + PHP 8 +
MySQL ortamına kurmak için gerekli adımları içerir.

## Gereksinimler
- PHP 8.1+ (öneri 8.3) — `pdo_mysql`, `mbstring`, `openssl`, `gd`, `fileinfo` eklentileri
- MySQL 5.7+ / MariaDB 10.4+
- Apache `mod_rewrite` (temiz URL için)

---

## 1) Veritabanı
1. cPanel → **MySQL Databases**: yeni bir veritabanı ve kullanıcı oluşturun, kullanıcıyı veritabanına tam yetkiyle ekleyin.
2. cPanel → **phpMyAdmin** → oluşturduğunuz veritabanını seçin → **İçe Aktar (Import)** → `database/database.sql` dosyasını yükleyin.
   - Tek dosyadır; tüm tablolar (25 tablo), tema, menü, sayfalar, hizmetler, makineler, projeler, blog, SSS, popup, footer, bildirim ve lisans tabloları + admin kullanıcısı gelir.

## 2) Dosyaların Yüklenmesi

### Yöntem A — Hepsi `public_html` (en kolay)
- Tüm proje klasörünü `public_html` içine yükleyin.
- Kökteki `.htaccess` gelen istekleri otomatik olarak `public/` klasörüne yönlendirir.
- `app/`, `config/`, `database/`, `routes/`, `storage/` klasörlerinde deny-all `.htaccess` bulunur; doğrudan erişime kapalıdır.

### Yöntem B — `public/` web kökü (daha güvenli, önerilen)
- Proje klasörünü web kökü **dışına** (örn. `/home/kullanici/ersan/`) yükleyin.
- Domain'in **Document Root**'unu `/home/kullanici/ersan/public` yapın (cPanel → Domains).
- Böylece yalnızca `public/` internete açık olur.

## 3) .env Ayarları
`.env.example` dosyasını `.env` olarak kopyalayın ve doldurun:

```
APP_ENV=production
APP_DEBUG=false
APP_URL=https://alanadınız.com
APP_KEY=<uzun-rastgele-değer>

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=<db_adı>
DB_USERNAME=<db_kullanıcı>
DB_PASSWORD=<db_şifre>

# Lisans (DijiKey License Center)
DIGIKEY_ENV=production
DIGIKEY_BASE_URL=https://lisans-sunucunuz.com
DIGIKEY_API_SECRET=<merkezdeki API_SECRET ile aynı>
DIGIKEY_PRODUCT_SLUG=ersan-hafriyat-cms
DIGIKEY_CACHE_SECRET=<uzun-rastgele-değer>
```

## 4) Dosya İzinleri
- `storage/` ve alt klasörleri (`storage/logs`, `storage/license`) → **yazılabilir** (755 / gerekiyorsa 775).
- `public/uploads/` → **yazılabilir** (755 / 775).
- Diğer tüm dosyalar 644, klasörler 755 önerilir.
- `.env` dosyası 600 (yalnızca sahip okuyabilsin).

## 5) İlk Giriş ve Lisans
1. `https://alanadınız.com/yonetim/giris` → admin girişi:
   - E-posta: `admin@ersanhafriyat.local` · Şifre: `ChangeMe8020!`
   - **İlk işiniz: şifreyi değiştirin / admin e-postasını güncelleyin.**
2. `DIGIKEY_ENV=production` iken admin paneli lisans ister:
   - **Yönetim → Sistem Lisansı → Lisansı Aktif Et** → size verilen lisans anahtarını girin.
   - Lisans bu alan adına bağlanır (activate → verify → heartbeat).
3. Genel Ayarlar, Tema/Renkler, Footer kredi, iletişim bilgileri, hero metinleri vb. panelden düzenlenebilir.

## 6) Güvenlik Kontrol Listesi
- [x] `public/uploads/` içinde PHP çalıştırma kapalı (`.htaccess`).
- [x] `app/config/database/routes/storage` deny-all `.htaccess`.
- [x] `.env`, `*.sqlite`, `*.sql`, `*.md`, `*.log` kök `.htaccess` ile korunur.
- [x] Dizin listeleme kapalı (`Options -Indexes`).
- [x] Güvenlik başlıkları (X-Content-Type-Options, X-Frame-Options, Referrer-Policy).
- [x] Lisans önbelleği HMAC imzalı; anahtar AES ile şifreli saklanır.
- [ ] Admin şifresini değiştirin.
- [ ] `APP_DEBUG=false` olduğundan emin olun.

## Notlar
- `public/router.php` yalnızca yerel geliştirme (`php -S`) içindir; production'da Apache `.htaccess` devrededir.
- SQLite yalnızca yerel geliştirme kolaylığı içindir; production'da MySQL kullanın.
