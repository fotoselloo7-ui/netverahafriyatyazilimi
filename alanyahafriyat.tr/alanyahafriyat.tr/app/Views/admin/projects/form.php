<?php $p = $item; $isEdit = $p !== null; $action = $isEdit ? base_url('yonetim/projeler/' . $p['id']) : base_url('yonetim/projeler/yeni'); $val = fn ($k, $d = '') => e($p[$k] ?? $d); ?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-grid a-grid--2" style="align-items:start">
        <div class="a-card">
            <div class="a-card__head"><h2>Proje Bilgileri</h2></div>
            <div class="a-field"><label>Başlık *</label><input type="text" name="title" value="<?= $val('title') ?>" required></div>
            <div class="a-field"><label>Slug</label><input type="text" name="slug" value="<?= $val('slug') ?>"></div>
            <div class="a-row">
                <div class="a-field"><label>Bölge</label><input type="text" name="region" value="<?= $val('region') ?>"></div>
                <div class="a-field"><label>Hizmet Türü</label><input type="text" name="service_type" value="<?= $val('service_type') ?>"></div>
            </div>
            <div class="a-field"><label>Proje Tarihi</label><input type="text" name="project_date" value="<?= $val('project_date') ?>" placeholder="2024"></div>
            <div class="a-field"><label>Kısa Açıklama</label><textarea name="short_description"><?= $val('short_description') ?></textarea></div>
            <div class="a-field"><label>İçerik (HTML)</label><textarea name="content" style="min-height:160px"><?= $val('content') ?></textarea></div>
        </div>
        <div>
            <div class="a-card">
                <div class="a-card__head"><h2>Yayın</h2></div>
                <label class="a-check"><input type="checkbox" name="is_active" <?= ($p['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif</label>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>Görseller</h2></div>
                <?php $if_name='cover_image'; $if_current=$p['cover_image']??''; $if_label='Kapak Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
                <?php $if_name='before_image'; $if_current=$p['before_image']??''; $if_label='Öncesi Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
                <?php $if_name='after_image'; $if_current=$p['after_image']??''; $if_label='Sonrası Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>SEO</h2></div>
                <div class="a-field"><label>SEO Başlık</label><input type="text" name="seo_title" value="<?= $val('seo_title') ?>"></div>
                <div class="a-field"><label>SEO Açıklama</label><textarea name="seo_description"><?= $val('seo_description') ?></textarea></div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
    <a href="<?= base_url('yonetim/projeler') ?>" class="btn btn--light">İptal</a>
</form>
