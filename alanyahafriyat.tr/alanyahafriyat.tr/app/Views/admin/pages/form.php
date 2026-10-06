<?php $pg = $page; $isEdit = $pg !== null; $action = $isEdit ? base_url('yonetim/sayfalar/' . $pg['id']) : base_url('yonetim/sayfalar/yeni'); $val = fn ($k, $d = '') => e($pg[$k] ?? $d); ?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-grid a-grid--2" style="align-items:start">
        <div class="a-card">
            <div class="a-card__head"><h2>Sayfa İçeriği</h2></div>
            <div class="a-field"><label>Başlık *</label><input type="text" name="title" value="<?= $val('title') ?>" required></div>
            <div class="a-field"><label>Slug</label><input type="text" name="slug" value="<?= $val('slug') ?>"></div>
            <div class="a-field"><label>Hero Başlık</label><input type="text" name="hero_title" value="<?= $val('hero_title') ?>"></div>
            <div class="a-field"><label>Hero Alt Başlık</label><input type="text" name="hero_subtitle" value="<?= $val('hero_subtitle') ?>"></div>
            <div class="a-field"><label>Özet</label><textarea name="excerpt" style="min-height:60px"><?= $val('excerpt') ?></textarea></div>
            <div class="a-field"><label>İçerik (HTML)</label><textarea name="content" style="min-height:280px"><?= $val('content') ?></textarea></div>
        </div>
        <div>
            <div class="a-card">
                <div class="a-card__head"><h2>Yayın</h2></div>
                <label class="a-check" style="margin-bottom:12px"><input type="checkbox" name="is_active" <?= ($pg['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif</label><br>
                <label class="a-check"><input type="checkbox" name="robots_index" <?= ($pg['robots_index'] ?? 1) ? 'checked' : '' ?>> Arama motorları indexlesin</label>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>Hero Görseli</h2></div>
                <?php $if_name='hero_image'; $if_current=$pg['hero_image']??''; $if_label='Hero Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>SEO</h2></div>
                <div class="a-field"><label>SEO Başlık</label><input type="text" name="seo_title" value="<?= $val('seo_title') ?>"></div>
                <div class="a-field"><label>SEO Açıklama</label><textarea name="seo_description"><?= $val('seo_description') ?></textarea></div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
    <a href="<?= base_url('yonetim/sayfalar') ?>" class="btn btn--light">İptal</a>
</form>
