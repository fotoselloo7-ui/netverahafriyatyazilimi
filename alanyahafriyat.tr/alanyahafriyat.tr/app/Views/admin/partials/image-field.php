<?php
/** $if_name, $if_current, $if_label, optional $if_remove */
$if_label = $if_label ?? 'Görsel';
$if_current = $if_current ?? '';
?>
<div class="a-field">
    <label><?= e($if_label) ?></label>
    <?php if ($if_current): ?>
        <div style="margin-bottom:8px;display:flex;align-items:center;gap:12px">
            <img src="<?= e(upload_url($if_current)) ?>" alt="" style="width:90px;height:64px;object-fit:cover;border-radius:8px;border:1px solid var(--line)">
            <?php if (!empty($if_remove)): ?>
                <label class="a-check" style="font-weight:400;font-size:13px"><input type="checkbox" name="<?= e($if_remove) ?>" value="1"> Görseli kaldır</label>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <input type="file" name="<?= e($if_name) ?>" accept="image/*">
    <small>JPG, PNG, WEBP veya GIF. Maks. 5MB.</small>
</div>
<?php $if_current = ''; $if_remove = null; ?>
