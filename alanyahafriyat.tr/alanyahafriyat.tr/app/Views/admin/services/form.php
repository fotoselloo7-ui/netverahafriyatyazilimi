<?php
$s = $service;
$isEdit = $s !== null;
$action = $isEdit ? base_url('yonetim/hizmetler/' . $s['id']) : base_url('yonetim/hizmetler/yeni');
$val = fn ($k, $d = '') => e($s[$k] ?? $d);
$adv = implode("\n", json_decode_safe($s['advantages_json'] ?? null));
$usage = implode("\n", json_decode_safe($s['usage_areas_json'] ?? null));
$process = json_decode_safe($s['process_json'] ?? null);
?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-grid a-grid--2" style="align-items:start">
        <div>
            <div class="a-card">
                <div class="a-card__head"><h2>Temel Bilgiler</h2></div>
                <div class="a-field"><label>Başlık *</label><input type="text" name="title" value="<?= $val('title') ?>" required></div>
                <div class="a-field"><label>Slug (boş bırakılırsa otomatik)</label><input type="text" name="slug" value="<?= $val('slug') ?>"></div>
                <div class="a-field"><label>Kısa Açıklama</label><textarea name="short_description"><?= $val('short_description') ?></textarea></div>
                <div class="a-field"><label>İçerik (HTML)</label><textarea name="content" style="min-height:180px"><?= $val('content') ?></textarea></div>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>Avantajlar & Kullanım</h2></div>
                <div class="a-field"><label>Avantajlar (her satır bir madde)</label><textarea name="advantages"><?= e($adv) ?></textarea></div>
                <div class="a-field"><label>Kullanım Alanları (her satır bir madde)</label><textarea name="usage_areas"><?= e($usage) ?></textarea></div>
            </div>

            <div class="a-card" id="process-box">
                <div class="a-card__head"><h2>Hizmet Süreci</h2><button type="button" class="btn btn--light btn--sm" onclick="addProcess()"><?= icon('plus', 14) ?> Adım</button></div>
                <div id="process-list">
                    <?php foreach (($process ?: [['title'=>'','text'=>'']]) as $p): ?>
                    <div class="a-row" style="margin-bottom:10px">
                        <input type="text" name="process_title[]" placeholder="Adım başlığı" value="<?= e($p['title'] ?? '') ?>">
                        <input type="text" name="process_text[]" placeholder="Adım açıklaması" value="<?= e($p['text'] ?? '') ?>">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="a-card" id="faq-box">
                <div class="a-card__head"><h2>Hizmet SSS</h2><button type="button" class="btn btn--light btn--sm" onclick="addFaq()"><?= icon('plus', 14) ?> Soru</button></div>
                <div id="faq-list">
                    <?php foreach (($faqs ?: [['question'=>'','answer'=>'']]) as $f): ?>
                    <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed var(--line)">
                        <input type="text" name="faq_question[]" placeholder="Soru" value="<?= e($f['question'] ?? '') ?>" style="margin-bottom:6px">
                        <textarea name="faq_answer[]" placeholder="Cevap" style="min-height:60px"><?= e($f['answer'] ?? '') ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div>
            <div class="a-card">
                <div class="a-card__head"><h2>Yayın</h2></div>
                <div class="a-field"><label>İkon adı</label><input type="text" name="icon" value="<?= $val('icon', 'excavator') ?>"><small>excavator, truck, layers, git-branch, trees, mountain, droplet</small></div>
                <div class="a-field"><label>Sıralama</label><input type="number" name="sort_order" value="<?= (int) ($s['sort_order'] ?? 0) ?>"></div>
                <label class="a-check" style="margin-bottom:12px"><input type="checkbox" name="is_featured" <?= ($s['is_featured'] ?? 0) ? 'checked' : '' ?>> Ana sayfada öne çıkar</label><br>
                <label class="a-check"><input type="checkbox" name="is_active" <?= ($s['is_active'] ?? 1) ? 'checked' : '' ?>> Aktif</label>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>Görseller</h2></div>
                <?php $if_name='card_image'; $if_current=$s['card_image']??''; $if_label='Kart Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
                <?php $if_name='hero_image'; $if_current=$s['hero_image']??''; $if_label='Hero Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
            </div>
            <div class="a-card">
                <div class="a-card__head"><h2>SEO</h2></div>
                <div class="a-field"><label>SEO Başlık</label><input type="text" name="seo_title" value="<?= $val('seo_title') ?>"></div>
                <div class="a-field"><label>SEO Açıklama</label><textarea name="seo_description"><?= $val('seo_description') ?></textarea></div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
    <a href="<?= base_url('yonetim/hizmetler') ?>" class="btn btn--light">İptal</a>
</form>
<script>
function addProcess(){var d=document.createElement('div');d.className='a-row';d.style.marginBottom='10px';d.innerHTML='<input type="text" name="process_title[]" placeholder="Adım başlığı"><input type="text" name="process_text[]" placeholder="Adım açıklaması">';document.getElementById('process-list').appendChild(d)}
function addFaq(){var d=document.createElement('div');d.style.cssText='margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed #e5e7eb';d.innerHTML='<input type="text" name="faq_question[]" placeholder="Soru" style="margin-bottom:6px"><textarea name="faq_answer[]" placeholder="Cevap" style="min-height:60px"></textarea>';document.getElementById('faq-list').appendChild(d)}
</script>
