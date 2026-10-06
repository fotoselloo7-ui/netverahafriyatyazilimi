<?php
$key = (string) $section['section_key'];
$isHero = $key === 'hero';
$isProcess = $key === 'process';
$ctaSections = ['services', 'equipment', 'gallery', 'projects', 'machine_anim', 'final_cta'];
$typeOpts = ['internal' => 'İç Sayfa', 'external' => 'Dış Link', 'whatsapp' => 'WhatsApp', 'phone' => 'Telefon', 'anchor' => 'Sayfa İçi'];
$badges = $isHero && isset($content['badges']) && is_array($content['badges']) ? $content['badges'] : [];
$steps = $isProcess && is_array($content) ? $content : [];
?>
<form method="post" action="<?= base_url('yonetim/anasayfa/' . $section['id']) ?>" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="a-card">
        <div class="a-card__head">
            <h2>Bölüm: <?= e($key) ?></h2>
            <a href="<?= base_url('yonetim/anasayfa') ?>" class="btn btn--light btn--sm">&larr; Geri</a>
        </div>

        <div class="a-field"><label>Başlık</label><input type="text" name="title" value="<?= e($section['title']) ?>"></div>
        <div class="a-field"><label>Alt Başlık</label><textarea name="subtitle"><?= e($section['subtitle']) ?></textarea></div>

        <?php
        $moduleNotes = [
            'services' => 'Hizmet kartları: Yönetim > Hizmetler modülünden yönetilir.',
            'equipment' => 'Makine kartları: Yönetim > Makine Parkuru modülünden yönetilir.',
            'gallery' => 'Galeri görselleri: Yönetim > Galeri modülünden yönetilir.',
            'projects' => 'Proje kartları: Yönetim > Projeler modülünden yönetilir. Yalnız gerçek saha verisi ve gerçek görseller yayınlanmalıdır.',
            'regions' => 'Bölge etiketleri: Yönetim > Çalışma Bölgeleri modülünden yönetilir.',
            'blog' => 'Yazılar: Yönetim > Blog modülünden yönetilir.',
            'faq' => 'Sorular: Yönetim > SSS modülünden yönetilir.',
        ];
        ?>
        <?php if (isset($moduleNotes[$key])): ?><p class="help"><?= e($moduleNotes[$key]) ?></p><?php endif; ?>

        <div class="a-row">
            <div class="a-field">
                <label>Yönetim Sırası</label>
                <input type="number" name="sort_order" value="<?= (int) $section['sort_order'] ?>">
                <small>Bu değer yalnızca yönetim panelindeki liste sırasını belirler. Ön yüz bölüm sırası tema tarafından sabittir.</small>
            </div>
            <div class="a-field" style="display:flex;align-items:flex-end">
                <label class="a-check"><input type="checkbox" name="is_active" <?= $section['is_active'] ? 'checked' : '' ?>> Bölüm Aktif</label>
            </div>
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

            <div class="section-title">Güven Rozetleri</div>
            <p class="help">Ana sayfada hero altındaki hızlı avantaj satırını buradan yönetebilirsiniz.</p>
            <div id="badge-list">
                <?php foreach (($badges ?: [['icon'=>'zap','title'=>'','text'=>'']]) as $b): ?>
                    <div class="a-row badge-admin-row" style="margin-bottom:10px">
                        <div class="a-field"><label>İkon</label><input type="text" name="badge_icon[]" value="<?= e($b['icon'] ?? 'check') ?>" placeholder="zap"></div>
                        <div class="a-field"><label>Başlık</label><input type="text" name="badge_title[]" value="<?= e($b['title'] ?? '') ?>"></div>
                        <div class="a-field"><label>Açıklama</label><input type="text" name="badge_text[]" value="<?= e($b['text'] ?? '') ?>"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn--light btn--sm" onclick="addBadge()"><?= icon('plus', 14) ?> Rozet Ekle</button>

            <?php $if_name = 'image'; $if_current = $section['image']; $if_label = 'Hero Görseli'; $if_remove = 'remove_image'; include VIEW_PATH . '/admin/partials/image-field.php'; ?>

        <?php elseif ($isProcess): ?>
            <div class="section-title">Çalışma Süreci Adımları</div>
            <p class="help">Ana sayfadaki süreç kartlarının ikon, başlık ve açıklamalarını buradan değiştirin.</p>
            <div id="step-list">
                <?php foreach (($steps ?: [['icon'=>'check','title'=>'','text'=>'']]) as $st): ?>
                    <div class="a-row step-admin-row" style="margin-bottom:10px">
                        <div class="a-field"><label>İkon</label><input type="text" name="step_icon[]" value="<?= e($st['icon'] ?? 'check') ?>" placeholder="check"></div>
                        <div class="a-field"><label>Başlık</label><input type="text" name="step_title[]" value="<?= e($st['title'] ?? '') ?>"></div>
                        <div class="a-field"><label>Açıklama</label><input type="text" name="step_text[]" value="<?= e($st['text'] ?? '') ?>"></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <button type="button" class="btn btn--light btn--sm" onclick="addStep()"><?= icon('plus', 14) ?> Adım Ekle</button>

        <?php elseif (in_array($key, $ctaSections, true)): ?>
            <div class="section-title">Bölüm Butonu</div>
            <div class="a-row">
                <div class="a-field"><label>CTA Metni</label><input type="text" name="cta_text" value="<?= e($section['cta_text']) ?>" placeholder="Örn: Tüm Hizmetler"></div>
                <div class="a-field"><label>CTA Link</label><input type="text" name="cta_url" value="<?= e($section['cta_url']) ?>" placeholder="/hizmetler"></div>
            </div>
            <p class="help">Boş bırakılırsa bölümün varsayılan butonu kullanılır.</p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
</form>

<script>
function addBadge(){
    var d=document.createElement('div');
    d.className='a-row badge-admin-row';
    d.style.marginBottom='10px';
    d.innerHTML='<div class="a-field"><label>İkon</label><input type="text" name="badge_icon[]" value="check"></div><div class="a-field"><label>Başlık</label><input type="text" name="badge_title[]"></div><div class="a-field"><label>Açıklama</label><input type="text" name="badge_text[]"></div>';
    document.getElementById('badge-list').appendChild(d);
}
function addStep(){
    var d=document.createElement('div');
    d.className='a-row step-admin-row';
    d.style.marginBottom='10px';
    d.innerHTML='<div class="a-field"><label>İkon</label><input type="text" name="step_icon[]" value="check"></div><div class="a-field"><label>Başlık</label><input type="text" name="step_title[]"></div><div class="a-field"><label>Açıklama</label><input type="text" name="step_text[]"></div>';
    document.getElementById('step-list').appendChild(d);
}
</script>
