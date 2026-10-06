<?php $ph_title = 'İletişim'; $ph_sub = 'Hafriyat ve kepçe hizmetleri için bize ulaşın'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container layout-2 layout-2--wide">
        <div>
            <h2 style="font-size:26px;margin-bottom:18px">Bize Ulaşın</h2>
            <div class="contact-list">
                <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', setting('phone', ''))) ?>" class="contact-row">
                    <span class="badge__ico"><?= icon('phone', 20) ?></span><div><b>Telefon</b><span><?= e(setting('phone', '')) ?></span></div>
                </a>
                <a href="<?= e(whatsapp_link('Merhaba, bilgi almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="contact-row">
                    <span class="badge__ico"><?= icon('whatsapp', 20) ?></span><div><b>WhatsApp</b><span><?= e(setting('whatsapp_number', setting('phone', ''))) ?></span></div>
                </a>
                <a href="mailto:<?= e(setting('email', '')) ?>" class="contact-row">
                    <span class="badge__ico"><?= icon('mail', 20) ?></span><div><b>E-posta</b><span><?= e(setting('email', '')) ?></span></div>
                </a>
                <div class="contact-row">
                    <span class="badge__ico"><?= icon('map-pin', 20) ?></span><div><b>Adres</b><span><?= e(setting('address', '')) ?></span></div>
                </div>
                <div class="contact-row">
                    <span class="badge__ico"><?= icon('clock', 20) ?></span><div><b>Çalışma Saatleri</b><span><?= e(setting('working_hours', '')) ?></span></div>
                </div>
            </div>
            <?php $map = map_embed_url((string) setting('map_embed', '')); if ($map !== ''): ?>
            <div id="konum" style="margin-top:22px;border-radius:14px;overflow:hidden;border:1px solid var(--line)">
                <iframe src="<?= e($map) ?>" width="100%" height="260" style="border:0;display:block" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <?php endif; ?>
        </div>

        <div>
            <div class="scard" style="padding:28px">
                <h2 style="font-size:22px;margin-bottom:6px">Teklif Formu</h2>
                <p style="color:var(--muted);margin-bottom:18px">Formu doldurun, en kısa sürede size dönüş yapalım.</p>
                <?php include VIEW_PATH . '/partials/flash.php'; ?>
                <form method="post" action="<?= base_url('iletisim') ?>" data-ajax-lead>
                    <div class="form-msg" data-form-msg></div>
                    <?= csrf_field() ?>
                    <input type="hidden" name="source" value="contact">
                    <input type="text" name="website" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
                    <div class="grid grid--2" style="gap:14px">
                        <div class="cfield"><label>Ad Soyad *</label><input type="text" name="name" value="<?= e(old('name')) ?>" required></div>
                        <div class="cfield"><label>Telefon *</label><input type="tel" name="phone" value="<?= e(old('phone')) ?>" required></div>
                    </div>
                    <div class="grid grid--2" style="gap:14px">
                        <div class="cfield"><label>E-posta</label><input type="email" name="email" value="<?= e(old('email')) ?>"></div>
                        <div class="cfield"><label>Hizmet</label>
                            <select name="service_type">
                                <option value="">Seçiniz</option>
                                <?php foreach ($services as $s): ?><option value="<?= e($s['title']) ?>"><?= e($s['title']) ?></option><?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="cfield"><label>Bölge / Mahalle</label><input type="text" name="region" value="<?= e(old('region')) ?>"></div>
                    <div class="cfield"><label>Mesajınız</label><textarea name="message" rows="4"></textarea></div>
                    <label class="kvkk" style="color:var(--muted)"><input type="checkbox" name="kvkk" required> <span>KVKK kapsamında kişisel verilerimin işlenmesini onaylıyorum.</span></label>
                    <button type="submit" class="btn btn--primary btn--block" style="margin-top:8px"><?= icon('send', 17) ?> Teklif Gönder</button>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
.contact-row{display:flex;gap:14px;align-items:center;padding:14px;border:1px solid var(--line);border-radius:12px;margin-bottom:12px;transition:.2s}
a.contact-row:hover{border-color:var(--color-primary)}
.contact-row b{display:block;font-size:15px}
.contact-row span{color:var(--muted);font-size:14px}
.cfield{margin-bottom:14px}
.cfield label{display:block;font-size:13px;font-weight:600;margin-bottom:6px;color:#444}
.cfield input,.cfield select,.cfield textarea{width:100%;padding:11px 13px;border:1px solid var(--line);border-radius:10px;font-family:inherit;font-size:14px}
.cfield input:focus,.cfield select:focus,.cfield textarea:focus{outline:none;border-color:var(--color-primary)}
</style>
