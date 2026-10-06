<?php $m = $item; $isEdit = $m !== null; $action = $isEdit ? base_url('yonetim/makine/' . $m['id']) : base_url('yonetim/makine/yeni'); $val = fn ($k, $d = '') => e($m[$k] ?? $d); ?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-grid a-grid--2" style="align-items:start">
        <div class="a-card">
            <div class="a-card__head"><h2>Makine Bilgileri</h2></div>
            <div class="a-field"><label>Başlık *</label><input type="text" name="title" value="<?= $val('title') ?>" required></div>
            <div class="a-field"><label>Slug</label><input type="text" name="slug" value="<?= $val('slug') ?>"></div>
            <div class="a-field"><label>Marka / Model</label><input type="text" name="brand_model" value="<?= $val('brand_model') ?>"></div>
            <div class="a-field"><label>Kullanım Alanı</label><input type="text" name="usage_area" value="<?= $val('usage_area') ?>"></div>
            <div class="a-field"><label>Ataşmanlar</label><input type="text" name="attachments" value="<?= $val('attachments') ?>"></div>
            <div class="a-field"><label>Özellikler (• ile ayırın)</label><textarea name="short_description"><?= $val('short_description') ?></textarea><small>örn: Ağırlık: 20 Ton • Kova: 1.1 m³ • Güçlü</small></div>
            <div class="a-field"><label>İçerik (HTML)</label><textarea name="content"><?= $val('content') ?></textarea></div>
        </div>
        <div>
            <div class="a-card">
                <div class="a-card__head"><h2>Yayın</h2></div>
                <div class="a-field"><label>Sıralama</label><input type="number" name="sort_order" value="<?= (int) ($m['sort_order'] ?? 0) ?>"></div>
                <label class="a-check"><input type="checkbox" name="is_active" <?= ($m['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif</label>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>Görsel</h2></div>
                <?php $if_name='image'; $if_current=$m['image']??''; $if_label='Makine Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
    <a href="<?= base_url('yonetim/makine') ?>" class="btn btn--light">İptal</a>
</form>
