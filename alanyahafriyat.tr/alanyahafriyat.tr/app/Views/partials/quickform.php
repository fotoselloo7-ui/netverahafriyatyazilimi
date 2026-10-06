<?php
/** Yeniden kullanılabilir teklif formu. $source ile kaynak belirlenir. */
$source = $source ?? 'hero';
$services = $services ?? [];
$ok = \App\Core\Session::flash('lead_ok');
?>
<form class="quickform" method="post" action="<?= base_url('teklif') ?>" data-ajax-lead>
    <div class="quickform__head"><h3>Hızlı Teklif Alın</h3></div>
    <div class="quickform__bar"></div>
    <div class="form-msg" data-form-msg></div>
    <?= csrf_field() ?>
    <input type="hidden" name="source" value="<?= e($source) ?>">
    <input type="text" name="website" class="hp" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px" aria-hidden="true">
    <div class="field"><input type="text" name="name" placeholder="Ad Soyad" required></div>
    <div class="field"><input type="tel" name="phone" placeholder="Telefon" required></div>
    <div class="field">
        <select name="service_type">
            <option value="">Hizmet Seçiniz</option>
            <?php foreach ($services as $s): ?>
                <option value="<?= e($s['title']) ?>"><?= e($s['title']) ?></option>
            <?php endforeach; ?>
            <option value="Diğer">Diğer</option>
        </select>
    </div>
    <div class="field"><input type="text" name="region" placeholder="Bölge / Mahalle"></div>
    <div class="field"><textarea name="message" placeholder="Mesajınız"></textarea></div>
    <label class="kvkk"><input type="checkbox" name="kvkk" required> <span>KVKK kapsamında kişisel verilerimin işlenmesini onaylıyorum.</span></label>
    <button type="submit" class="btn btn--primary btn--block"><?= icon('send', 17) ?> Teklif Gönder</button>
</form>
