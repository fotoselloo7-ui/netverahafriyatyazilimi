<?php
$s = fn ($k, $d = '') => e($settings[$k] ?? $d);
$socialLinks = $socialLinks ?? [];
?>
<form method="post" action="<?= base_url('yonetim/ayarlar') ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('settings', 18) ?> Genel Bilgiler</h2></div>
        <p class="help">Site adı değişince header, footer, admin üst bar, SEO başlığı ve schema dahil tüm alanlarda otomatik güncellenir.</p>
        <div class="a-row">
            <div class="a-field"><label>Site Adı</label><input type="text" name="site_name" value="<?= $s('site_name') ?>"></div>
            <div class="a-field"><label>Slogan / Tagline</label><input type="text" name="site_tagline" value="<?= $s('site_tagline') ?>"></div>
        </div>
        <div class="a-field"><label>Üst Bar Metni</label><input type="text" name="top_bar_text" value="<?= $s('top_bar_text') ?>"></div>
        <div class="a-row">
            <?php $if_name = 'logo'; $if_current = $settings['logo'] ?? ''; $if_label = 'Logo'; $if_remove = 'remove_logo'; include VIEW_PATH . '/admin/partials/image-field.php'; ?>
            <?php $if_name = 'og_image'; $if_current = $settings['og_image'] ?? ''; $if_label = 'OG / Paylaşım Görseli'; include VIEW_PATH . '/admin/partials/image-field.php'; ?>
        </div>
        <div class="a-field"><label>Footer Açıklaması</label><textarea name="footer_about"><?= $s('footer_about') ?></textarea></div>
        <div class="a-row">
            <div class="a-field"><label>Web Tasarım Kredisi Metni</label><input type="text" name="web_design_credit_text" value="<?= $s('web_design_credit_text') ?>" placeholder="örn: Netvera Teknoloji Yazılım"><small>Boş bırakılırsa footer'da hiç gösterilmez. "Web Tasarım:" etiketi otomatik eklenmez.</small></div>
            <div class="a-field"><label>Web Tasarım Kredisi Linki</label><input type="text" name="web_design_credit_url" value="<?= $s('web_design_credit_url') ?>" placeholder="https://... (opsiyonel)"><small>Link verilirse metin tıklanabilir olur.</small></div>
        </div>
        <label class="a-check" style="margin-top:6px"><input type="checkbox" name="floating_whatsapp_enabled" value="1" <?= (string) ($settings['floating_whatsapp_enabled'] ?? '0') === '1' ? 'checked' : '' ?>> Sağ altta yuvarlak (floating) WhatsApp butonu göster</label>
    </div>

    <div class="a-card">
        <div class="a-card__head">
            <h2><?= icon('message-circle', 18) ?> Footer Sosyal Medya</h2>
            <button type="button" class="btn btn--light btn--sm" onclick="addSocialRow()"><?= icon('plus', 14) ?> Hesap Ekle</button>
        </div>
        <p class="help">Footer'daki logo altı sosyal ikonları buradan yönetilir. WhatsApp URL alanını boş veya # bırakırsanız Genel Ayarlar'daki WhatsApp numarası kullanılır.</p>
        <div id="social-list">
            <?php
            $socialRows = $socialLinks ?: [
                ['platform'=>'whatsapp','url'=>'#','icon'=>'whatsapp','sort_order'=>0,'is_active'=>1],
                ['platform'=>'instagram','url'=>'','icon'=>'instagram','sort_order'=>1,'is_active'=>0],
                ['platform'=>'facebook','url'=>'','icon'=>'facebook','sort_order'=>2,'is_active'=>0],
                ['platform'=>'youtube','url'=>'','icon'=>'youtube','sort_order'=>3,'is_active'=>0],
            ];
            foreach ($socialRows as $social): ?>
                <div class="social-admin-row">
                    <div class="a-field">
                        <label>Platform</label>
                        <input type="text" name="social_platform[]" value="<?= e($social['platform'] ?? '') ?>" placeholder="instagram">
                    </div>
                    <div class="a-field social-url-field">
                        <label>Profil / Bağlantı</label>
                        <input type="text" name="social_url[]" value="<?= e($social['url'] ?? '') ?>" placeholder="https://...">
                    </div>
                    <div class="a-field">
                        <label>İkon</label>
                        <input type="text" name="social_icon[]" value="<?= e($social['icon'] ?? '') ?>" placeholder="instagram">
                    </div>
                    <div class="a-field">
                        <label>Sıra</label>
                        <input type="number" name="social_sort[]" value="<?= (int) ($social['sort_order'] ?? 0) ?>">
                    </div>
                    <div class="a-field">
                        <label>Durum</label>
                        <select name="social_status[]">
                            <option value="1" <?= (int) ($social['is_active'] ?? 1) === 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= (int) ($social['is_active'] ?? 1) === 0 ? 'selected' : '' ?>>Pasif</option>
                        </select>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('phone', 18) ?> İletişim Bilgileri</h2></div>
        <div class="a-row">
            <div class="a-field"><label>Telefon</label><input type="text" name="phone" value="<?= $s('phone') ?>"></div>
            <div class="a-field"><label>WhatsApp Numarası (sadece rakam, örn. 905321234567)</label><input type="text" name="whatsapp_number" value="<?= $s('whatsapp_number') ?>"></div>
        </div>
        <div class="a-row">
            <div class="a-field"><label>E-posta</label><input type="email" name="email" value="<?= $s('email') ?>"></div>
            <div class="a-field"><label>Çalışma Saatleri</label><input type="text" name="working_hours" value="<?= $s('working_hours') ?>"></div>
        </div>
        <div class="a-field"><label>Adres</label><input type="text" name="address" value="<?= $s('address') ?>"></div>
        <div class="a-field"><label>Google Maps Embed URL</label><input type="text" name="map_embed" value="<?= $s('map_embed') ?>"><small>Google Maps &gt; Paylaş &gt; Harita yerleştir bölümündeki tam iframe kodunu veya yalnızca src bağlantısını yapıştırabilirsiniz.</small></div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('search', 18) ?> SEO Ayarları</h2></div>
        <div class="a-field"><label>SEO Başlığı (fallback)</label><input type="text" name="seo_title" value="<?= $s('seo_title') ?>"></div>
        <div class="a-field"><label>SEO Açıklaması</label><textarea name="seo_description"><?= $s('seo_description') ?></textarea></div>
        <div class="a-field"><label>Anahtar Kelimeler</label><input type="text" name="seo_keywords" value="<?= $s('seo_keywords') ?>"></div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('award', 18) ?> Hakkımızda Sayaçları</h2></div>
        <div class="a-row--3" style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px">
            <div class="a-field"><label>Yıllık Deneyim</label><input type="text" name="about_counter_experience" value="<?= $s('about_counter_experience') ?>"></div>
            <div class="a-field"><label>Tamamlanan Proje</label><input type="text" name="about_counter_projects" value="<?= $s('about_counter_projects') ?>"></div>
            <div class="a-field"><label>Uzman Personel</label><input type="text" name="about_counter_staff" value="<?= $s('about_counter_staff') ?>"></div>
            <div class="a-field"><label>Destek</label><input type="text" name="about_counter_support" value="<?= $s('about_counter_support') ?>"></div>
        </div>
    </div>

    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Ayarları Kaydet</button>
</form>

<style>
.social-admin-row{display:grid;grid-template-columns:1fr 2fr 1fr 90px 110px;gap:12px;align-items:end;padding:12px 0;border-bottom:1px dashed var(--line)}
.social-admin-row:last-child{border-bottom:0}
@media(max-width:900px){.social-admin-row{grid-template-columns:1fr 1fr}.social-url-field{grid-column:1/-1}}
</style>
<script>
function addSocialRow(){
    var list=document.getElementById('social-list');
    var row=document.createElement('div');
    row.className='social-admin-row';
    row.innerHTML=
        '<div class="a-field"><label>Platform</label><input type="text" name="social_platform[]" placeholder="instagram"></div>'+
        '<div class="a-field social-url-field"><label>Profil / Bağlantı</label><input type="text" name="social_url[]" placeholder="https://..."></div>'+
        '<div class="a-field"><label>İkon</label><input type="text" name="social_icon[]" placeholder="instagram"></div>'+
        '<div class="a-field"><label>Sıra</label><input type="number" name="social_sort[]" value="0"></div>'+
        '<div class="a-field"><label>Durum</label><select name="social_status[]"><option value="1">Aktif</option><option value="0">Pasif</option></select></div>';
    list.appendChild(row);
}
</script>
