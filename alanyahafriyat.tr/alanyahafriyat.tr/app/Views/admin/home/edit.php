<?php $isHero = $section['section_key'] === 'hero'; $typeOpts = ['internal' => 'İç Sayfa', 'external' => 'Dış Link', 'whatsapp' => 'WhatsApp', 'phone' => 'Telefon', 'anchor' => 'Sayfa İçi']; ?>
<form method="post" action="<?= base_url('yonetim/anasayfa/' . $section['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-card">
        <div class="a-card__head">
            <h2>Bölüm: <?= e($section['section_key']) ?></h2>
            <a href="<?= base_url('yonetim/anasayfa') ?>" class="btn btn--light btn--sm">&larr; Geri</a>
        </div>
        <div class="a-field"><label>Başlık</label><input type="text" name="title" value="<?= e($section['title']) ?>"></div>
        <div class="a-field"><label>Alt Başlık</label><textarea name="subtitle"><?= e($section['subtitle']) ?></textarea></div>
        <div class="a-row">
            <div class="a-field"><label>Yönetim Sırası</label><input type="number" name="sort_order" value="<?= (int) $section['sort_order'] ?>"><small>Bu değer yönetim listesindeki sırayı belirler; ön yüz bölüm dizilimi tema tasarımında sabittir.</small></div>
            <div class="a-field" style="display:flex;align-items:flex-end"><label class="a-check"><input type="checkbox" name="is_active" <?= $section['is_active'] ? 'checked' : '' ?>> Bölüm Aktif</label></div>
        </div>

        <?php if ($isHero): ?>
        <div class="section-title">Hero Butonları</div>
        <div class="a-row">
            <div class="a-field"><label>Buton 1 Metni</label><input type="text" name="button_1_text" value="<?= e($content['button_1_text'] ?? '') ?>"></div>
            <div class="a-field"><label>Buton 1 Link / Mesaj</label><input type="text" name="button_1_url" value="<?= e($content['button_1_url'] ?? '') ?>"></div>
        </div>
        <div class="a-field"><label>Buton 1 Tipi</label><select name="button_1_type"><?php foreach ($typeOpts as $k => $v): ?><option value="<?= $k ?>" <?= ($content['button_1_type'] ?? '') === $k ? 'selected' : '' ?>><?= $v ?></option><?php endforeach; ?></select></div>
        <div class="a-row">
            <div class="a-field"><label>Buton 2 Metni</label><input type="text" name="button_2_text" value="<?= e($content['button_2_text'] ?? '') ?>"></div>
            <div class="a-field"><label>Buton 2 Link / Mesaj</label><input type="text" name="button_2_url" value="<?= e($content['button_2_url'] ?? '') ?>"></div>
        </div>
        <div class="a-field"><label>Buton 2 Tipi</label><select name="button_2_type"><?php foreach ($typeOpts as $k => $v): ?><option value="<?= $k ?>" <?= ($content['button_2_type'] ?? '') === $k ? 'selected' : '' ?>><?= $v ?></option><?php endforeach; ?></select></div>
        <div class="a-row">
            <div class="a-field"><label>Overlay Karartma (0-1)</label><input type="text" name="overlay_opacity" value="<?= e($content['overlay_opacity'] ?? '0.6') ?>"></div>
            <div class="a-field" style="display:flex;align-items:flex-end;gap:20px">
                <label class="a-check"><input type="checkbox" name="show_form" <?= ($content['show_form'] ?? '1') === '1' ? 'checked' : '' ?>> Teklif Formu</label>
                <label class="a-check"><input type="checkbox" name="show_badges" <?= ($content['show_badges'] ?? '1') === '1' ? 'checked' : '' ?>> Güven Rozetleri</label>
            </div>
        </div>
        <?php elseif ($section['section_key'] === 'machine_anim'): ?>
        <div class="a-row">
            <div class="a-field"><label>CTA Metni</label><input type="text" name="cta_text" value="<?= e($section['cta_text']) ?>"></div>
            <div class="a-field"><label>CTA Link</label><input type="text" name="cta_url" value="<?= e($section['cta_url']) ?>"></div>
        </div>
        <?php endif; ?>

        <?php if ($isHero): ?>
            <?php $if_name = 'image'; $if_current = $section['image']; $if_label = 'Hero Görseli'; $if_remove = 'remove_image'; include VIEW_PATH . '/admin/partials/image-field.php'; ?>
        <?php endif; ?>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
</form>
