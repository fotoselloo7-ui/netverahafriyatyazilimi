<?php
$colors = [
    'primary_color' => 'Ana Renk (Primary)', 'primary_hover_color' => 'Primary Hover',
    'primary_text_color' => 'Primary Üzeri Metin', 'secondary_color' => 'İkincil (Secondary)',
    'secondary_text_color' => 'Secondary Üzeri Metin', 'dark_color' => 'Koyu (Dark)', 'accent_color' => 'Vurgu (Accent)',
    'background_color' => 'Arka Plan (Background)', 'surface_color' => 'Kart/Yüzey (Surface)',
    'text_color' => 'Metin (Text)', 'muted_text_color' => 'Soluk Metin (Muted)',
    'border_color' => 'Çerçeve (Border)', 'button_primary_bg' => 'Primary Buton Zemin',
    'button_primary_text' => 'Primary Buton Metin', 'button_dark_bg' => 'Koyu Buton Zemin',
    'button_dark_text' => 'Koyu Buton Metin', 'whatsapp_color' => 'WhatsApp',
];
$defaults = [
    'primary_color'=>'#F5A400','primary_hover_color'=>'#D98A00','primary_text_color'=>'#111827',
    'secondary_color'=>'#111827','secondary_text_color'=>'#FFFFFF','dark_color'=>'#080B0F','accent_color'=>'#FFB703',
    'background_color'=>'#F7F4EF','surface_color'=>'#FFFFFF','text_color'=>'#111827',
    'muted_text_color'=>'#64748B','border_color'=>'#E5E7EB','button_primary_bg'=>'#F5A400',
    'button_primary_text'=>'#111827','button_dark_bg'=>'#080B0F','button_dark_text'=>'#FFFFFF',
    'whatsapp_color'=>'#25D366',
];
$c = fn ($k, $d) => e($theme[$k] ?? $d);
$curPrimary = strtolower((string) ($theme['primary_color'] ?? ''));
$curBg = strtolower((string) ($theme['background_color'] ?? ''));
?>
<div class="a-card">
    <div class="a-card__head"><h2><?= icon('star', 18) ?> Hazır Renk Paletleri</h2></div>
    <p class="help">Bir palet seçip <strong>Uygula</strong>'ya basın — tüm site (header, butonlar, kartlar, footer, vurgular) o renklere geçer. Her palet kontrast garantilidir. Aşağıdan tek tek de düzenleyebilirsiniz.</p>
    <div class="palette-grid">
        <?php foreach ($palettes as $key => $pal): $col = $pal['colors'];
            $active = strtolower($col['primary_color']) === $curPrimary && strtolower($col['background_color']) === $curBg; ?>
            <form method="post" action="<?= base_url('yonetim/tema/palet') ?>" class="palette-card<?= $active ? ' is-active' : '' ?>">
                <?= csrf_field() ?>
                <input type="hidden" name="palette" value="<?= e($key) ?>">
                <div class="palette-preview" style="background:<?= e($col['background_color']) ?>;border-color:<?= e($col['border_color']) ?>">
                    <div class="palette-bar" style="background:<?= e($col['dark_color']) ?>"></div>
                    <div class="palette-chip" style="background:<?= e($col['button_primary_bg']) ?>;color:<?= e($col['button_primary_text']) ?>">Aa</div>
                    <div class="palette-dots">
                        <span style="background:<?= e($col['primary_color']) ?>"></span>
                        <span style="background:<?= e($col['secondary_color']) ?>"></span>
                        <span style="background:<?= e($col['accent_color']) ?>"></span>
                        <span style="background:<?= e($col['surface_color']) ?>;border:1px solid <?= e($col['border_color']) ?>"></span>
                    </div>
                </div>
                <div class="palette-name"><?= e($pal['name']) ?><?php if ($active): ?> <span class="palette-active">✓ Aktif</span><?php endif; ?></div>
                <button type="submit" class="palette-apply" style="background:<?= e($col['button_primary_bg']) ?>;color:<?= e($col['button_primary_text']) ?>"><?= $active ? 'Uygulandı' : 'Uygula' ?></button>
            </form>
        <?php endforeach; ?>
    </div>
</div>
<style>
.palette-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(170px,1fr));gap:16px}
.palette-card{border:1px solid var(--line);border-radius:14px;padding:12px;text-align:center;transition:.18s;background:#fff;box-shadow:0 1px 3px rgba(0,0,0,.05)}
.palette-card:hover{border-color:var(--primary);transform:translateY(-3px);box-shadow:0 10px 22px rgba(0,0,0,.09)}
.palette-card.is-active{border-color:var(--primary);box-shadow:0 0 0 3px rgba(245,164,0,.22)}
.palette-preview{position:relative;height:74px;border:1px solid;border-radius:10px;margin-bottom:12px;overflow:hidden}
.palette-bar{position:absolute;top:0;left:0;right:0;height:22px}
.palette-chip{position:absolute;right:10px;top:12px;width:34px;height:34px;border-radius:9px;display:grid;place-items:center;font-weight:800;font-size:14px;box-shadow:0 2px 6px rgba(0,0,0,.2)}
.palette-dots{position:absolute;left:10px;bottom:10px;display:flex;gap:5px}
.palette-dots span{width:16px;height:16px;border-radius:50%;display:block;box-shadow:0 1px 2px rgba(0,0,0,.15)}
.palette-name{font-size:13.5px;font-weight:600;margin-bottom:10px;color:#1f2430}
.palette-active{color:#16a34a;font-size:12px;font-weight:700}
.palette-apply{width:100%;border:none;border-radius:9px;padding:9px;font-weight:700;font-size:13.5px;cursor:pointer;font-family:inherit;transition:filter .15s}
.palette-apply:hover{filter:brightness(.94)}
</style>

<form method="post" action="<?= base_url('yonetim/tema') ?>">
    <?= csrf_field() ?>
    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('tag', 18) ?> Renkleri Elle Düzenle</h2></div>
        <p class="help">Renkleri hex kodu ile değiştirin. Bir zemin rengini değiştirip ona bağlı metin rengini değiştirmezseniz sistem okunabilir kontrastı otomatik seçer. Kaydettiğinizde tüm sitede anında güncellenir.</p>
        <div class="a-grid a-grid--2">
            <?php foreach ($colors as $key => $label): $val = $theme[$key] ?? ($defaults[$key] ?? '#000000'); ?>
                <div class="a-field">
                    <label><?= e($label) ?></label>
                    <div class="color-field">
                        <input type="color" value="<?= e($val) ?>" oninput="this.nextElementSibling.value=this.value">
                        <input type="text" name="<?= e($key) ?>" value="<?= e($val) ?>" pattern="#[0-9a-fA-F]{6}" oninput="this.previousElementSibling.value=this.value">
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('layers', 18) ?> Şekil / Gölge</h2></div>
        <div class="a-row--3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:16px">
            <div class="a-field"><label>Buton Köşe Yuvarlaklığı</label><input type="text" name="border_radius" value="<?= $c('border_radius', '10px') ?>"><small>örn: 10px</small></div>
            <div class="a-field"><label>Kart Köşe Yuvarlaklığı</label><input type="text" name="card_radius" value="<?= $c('card_radius', '14px') ?>"><small>örn: 14px</small></div>
            <div class="a-field"><label>Gölge Yoğunluğu</label><input type="text" name="shadow_strength" value="<?= $c('shadow_strength', '0.10') ?>"><small>0.00 - 1.00 arası</small></div>
        </div>
    </div>

    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Temayı Kaydet</button>
</form>
