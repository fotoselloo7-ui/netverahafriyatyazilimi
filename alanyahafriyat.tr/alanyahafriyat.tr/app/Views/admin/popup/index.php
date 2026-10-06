<?php $val = fn ($k, $d = '') => e($popup[$k] ?? $d); ?>
<form method="post" action="<?= base_url('yonetim/popup/' . $popup['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-grid a-grid--2" style="align-items:start">
        <div class="a-card">
            <div class="a-card__head"><h2>Popup İçeriği</h2><label class="a-check"><input type="checkbox" name="is_active" <?= $popup['is_active'] ? 'checked' : '' ?>> Aktif</label></div>
            <div class="a-field"><label>Başlık</label><input type="text" name="title" value="<?= $val('title') ?>"></div>
            <div class="a-field"><label>Açıklama</label><textarea name="description"><?= $val('description') ?></textarea></div>
            <div class="a-row">
                <div class="a-field"><label>Buton Metni</label><input type="text" name="button_text" value="<?= $val('button_text') ?>"></div>
                <div class="a-field"><label>Buton Tipi</label><select name="button_type"><?php foreach (['whatsapp'=>'WhatsApp','internal'=>'İç Link','external'=>'Dış Link','phone'=>'Telefon'] as $k=>$v): ?><option value="<?= $k ?>" <?= $popup['button_type']===$k?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></div>
            </div>
            <div class="a-field"><label>Buton Link / Mesaj</label><input type="text" name="button_url" value="<?= $val('button_url') ?>"></div>
            <?php $if_name='image'; $if_current=$popup['image']??''; $if_label='Popup Görseli'; $if_remove='remove_image'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
        </div>
        <div class="a-card">
            <div class="a-card__head"><h2>Davranış</h2></div>
            <div class="a-row">
                <div class="a-field"><label>Gecikme (saniye)</label><input type="number" name="delay_seconds" value="<?= (int) $popup['delay_seconds'] ?>"></div>
                <div class="a-field"><label>Tekrar (saat)</label><input type="number" name="repeat_after_hours" value="<?= (int) $popup['repeat_after_hours'] ?>"></div>
            </div>
            <div class="a-field"><label>Gösterim</label><select name="target_pages"><?php foreach (['all'=>'Tüm Site','home'=>'Sadece Ana Sayfa'] as $k=>$v): ?><option value="<?= $k ?>" <?= $popup['target_pages']===$k?'selected':'' ?>><?= $v ?></option><?php endforeach; ?></select></div>
            <div class="a-field"><label>Overlay Karartma (0-1)</label><input type="text" name="overlay_opacity" value="<?= $val('overlay_opacity', '0.6') ?>"></div>
            <label class="a-check"><input type="checkbox" name="show_on_mobile" <?= $popup['show_on_mobile'] ? 'checked' : '' ?>> Mobilde göster</label>
        </div>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
</form>
