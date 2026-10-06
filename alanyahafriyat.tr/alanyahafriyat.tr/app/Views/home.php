<?php
$hero = $sections['hero'] ?? [];
$hc = json_decode_safe($hero['content_json'] ?? null);
$heroImg = !empty($hero['image']) ? upload_url($hero['image']) : null;
$overlay = $hc['overlay_opacity'] ?? '0.6';
$b1t = $hc['button_1_text'] ?? 'WhatsApp’tan Teklif Al';
$b1 = build_link($hc['button_1_type'] ?? 'whatsapp', $hc['button_1_url'] ?? '');
$b2t = $hc['button_2_text'] ?? 'Hizmetleri İncele';
$b2 = build_link($hc['button_2_type'] ?? 'internal', $hc['button_2_url'] ?? '/hizmetler');
$badges = $hc['badges'] ?? [];
$showForm = ($hc['show_form'] ?? '1') === '1';
$showBadges = ($hc['show_badges'] ?? '1') === '1';
?>
<!-- HERO -->
<?php if (!empty($hero['is_active'])): ?>
<section class="hero"<?= $heroImg ? ' style="background-image:linear-gradient(rgba(10,10,12,'.e($overlay).'),rgba(10,10,12,'.e($overlay).')),url(\''.e($heroImg).'\')"' : '' ?>>
    <div class="container hero__inner">
        <div class="hero__content">
            <span class="hero__eyebrow"><?= icon('excavator', 15) ?> <?= e(setting('site_tagline', 'Profesyonel Hafriyat Hizmetleri')) ?></span>
            <h1><?= e($hero['title'] ?? 'Alanya ve Mahmutlar’da Profesyonel Hafriyat & Kepçe Hizmetleri') ?></h1>
            <p class="hero__sub"><?= e($hero['subtitle'] ?? '') ?></p>
            <div class="hero__cta">
                <a href="<?= e($b1) ?>" class="btn btn--wa" <?= ($hc['button_1_type'] ?? '') === 'whatsapp' ? 'target="_blank" rel="noopener" data-wa-event' : '' ?>><?= icon('whatsapp', 18) ?> <?= e($b1t) ?></a>
                <a href="<?= e($b2) ?>" class="btn btn--ghost"><?= e($b2t) ?></a>
            </div>
        </div>
        <?php if ($showForm): ?>
            <div class="hero__form">
                <?php include VIEW_PATH . '/partials/quickform.php'; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if ($showBadges && $badges): ?>
<!-- BADGES -->
<div class="badges">
    <div class="container badges__grid">
        <?php foreach ($badges as $b): ?>
            <div class="badge">
                <span class="badge__ico"><?= icon($b['icon'] ?? 'check', 22) ?></span>
                <div><b><?= e($b['title'] ?? '') ?></b><span><?= e($b['text'] ?? '') ?></span></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
<?php endif; ?>

<!-- SERVICES -->
<?php if (!empty($sections['services']['is_active']) && $services): $sec = $sections['services']; ?>
<section class="section" id="hizmetler">
    <div class="container">
        <div class="sec-head">
            <span class="eyebrow">Ne Yapıyoruz</span>
            <h2><?= e($sec['title']) ?></h2>
            <p><?= e($sec['subtitle']) ?></p>
        </div>
        <div class="grid grid--3">
            <?php foreach ($services as $s): ?>
                <article class="scard">
                    <div class="scard__media">
                        <?php if ($s['card_image']): ?><img src="<?= e(upload_url($s['card_image'])) ?>" alt="<?= e($s['title']) ?>" loading="lazy">
                        <?php else: ?><div class="ph-media"><?= icon($s['icon'] ?: 'excavator', 54) ?></div><?php endif; ?>
                        <span class="scard__ico"><?= icon($s['icon'] ?: 'excavator', 24) ?></span>
                    </div>
                    <div class="scard__body">
                        <h3><?= e($s['title']) ?></h3>
                        <p><?= e(str_excerpt($s['short_description'], 110)) ?></p>
                        <div class="scard__foot">
                            <a href="<?= base_url('hizmetler/' . $s['slug']) ?>" class="btn btn--outline btn--sm">Detay</a>
                            <a href="<?= e(whatsapp_link('Merhaba, ' . $s['title'] . ' hizmeti için teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa btn--sm"><?= icon('whatsapp', 15) ?> Teklif</a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <?php $servicesCtaText = trim((string) ($sec['cta_text'] ?? '')) ?: 'Tüm Hizmetler'; $servicesCtaUrl = trim((string) ($sec['cta_url'] ?? '')) ?: '/hizmetler'; ?>
        <div class="center-btn"><a href="<?= e(build_link('internal', $servicesCtaUrl)) ?>" class="btn btn--primary"><?= e($servicesCtaText) ?></a></div>
    </div>
</section>
<?php endif; ?>

<!-- EQUIPMENT -->
<?php if (!empty($sections['equipment']['is_active']) && $equipment): $sec = $sections['equipment']; ?>
<section class="section section--soft" id="makine">
    <div class="container">
        <div class="grid grid--2" style="align-items:center;gap:40px;margin-bottom:34px">
            <div class="equip-intro">
                <span class="eyebrow" style="color:var(--color-primary);font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-size:13px">Makine Parkurumuz</span>
                <h2><?= e($sec['title']) ?></h2>
                <p><?= e($sec['subtitle']) ?></p>
                <?php $equipmentCtaText = trim((string) ($sec['cta_text'] ?? '')) ?: 'Tüm Makineler'; $equipmentCtaUrl = trim((string) ($sec['cta_url'] ?? '')) ?: '/makine-parkuru'; ?>
                <a href="<?= e(build_link('internal', $equipmentCtaUrl)) ?>" class="btn btn--primary"><?= e($equipmentCtaText) ?></a>
            </div>
            <div></div>
        </div>
        <div class="grid grid--4">
            <?php foreach ($equipment as $m): $specs = array_filter(array_map('trim', explode('•', (string) $m['short_description']))); ?>
                <article class="ecard">
                    <div class="ecard__media">
                        <?php if ($m['image']): ?><img src="<?= e(upload_url($m['image'])) ?>" alt="<?= e($m['title']) ?>" loading="lazy">
                        <?php else: ?><div class="ph-media"><?= icon('truck', 48) ?></div><?php endif; ?>
                    </div>
                    <div class="ecard__body">
                        <h3><?= e($m['title']) ?></h3>
                        <ul class="ecard__specs">
                            <?php foreach ($specs as $sp): ?><li><?= e($sp) ?></li><?php endforeach; ?>
                        </ul>
                        <a href="<?= e(whatsapp_link('Merhaba, ' . $m['title'] . ' için teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa btn--sm btn--block"><?= icon('whatsapp', 15) ?> Bu Makine İçin Teklif</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- PROCESS -->
<?php if (!empty($sections['process']['is_active'])): $sec = $sections['process']; $steps = json_decode_safe($sec['content_json']); ?>
<section class="section">
    <div class="container">
        <div class="sec-head"><span class="eyebrow">Nasıl Çalışıyoruz</span><h2><?= e($sec['title']) ?></h2><p><?= e($sec['subtitle']) ?></p></div>
        <div class="process">
            <?php foreach ($steps as $st): ?>
                <div class="pstep">
                    <div class="pstep__ico"><?= icon($st['icon'] ?? 'check', 30) ?></div>
                    <h4><?= e($st['title']) ?></h4>
                    <p><?= e($st['text']) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ŞANTİYE ANİMASYONU (admin: Ana Sayfa Bölümleri > machine_anim) -->
<?php if (!empty($sections['machine_anim']['is_active'])) { include VIEW_PATH . '/partials/machine-animation.php'; } ?>

<!-- GALLERY -->
<?php if (!empty($sections['gallery']['is_active']) && $gallery): $sec = $sections['gallery']; ?>
<section class="section section--soft">
    <div class="container">
        <div class="sec-head"><span class="eyebrow">Sahadan</span><h2><?= e($sec['title']) ?></h2><p><?= e($sec['subtitle']) ?></p></div>
        <div class="ggrid">
            <?php foreach (array_slice($gallery, 0, 8) as $g): ?>
                <a class="gitem" href="<?= $g['image'] ? e(upload_url($g['image'])) : '#' ?>" data-lightbox>
                    <?php if ($g['image']): ?><img src="<?= e(upload_url($g['image'])) ?>" alt="<?= e($g['alt_text'] ?: $g['title']) ?>" loading="lazy">
                    <?php else: ?><div class="ph-media"><?= icon('excavator', 46) ?></div><?php endif; ?>
                    <span class="gitem__cap"><?= icon('map-pin', 15) ?> <?= e($g['title']) ?></span>
                </a>
            <?php endforeach; ?>
        </div>
        <?php $galleryCtaText = trim((string) ($sec['cta_text'] ?? '')) ?: 'Tüm Galeri'; $galleryCtaUrl = trim((string) ($sec['cta_url'] ?? '')) ?: '/galeri'; ?>
        <div class="center-btn"><a href="<?= e(build_link('internal', $galleryCtaUrl)) ?>" class="btn btn--outline"><?= e($galleryCtaText) ?></a></div>
    </div>
</section>
<?php endif; ?>

<!-- PROJECTS -->
<?php if (!empty($sections['projects']['is_active']) && !empty($projects)): $sec = $sections['projects']; ?>
<section class="section">
    <div class="container">
        <div class="sec-head">
            <span class="eyebrow">Gerçek Saha Çalışmaları</span>
            <h2><?= e($sec['title']) ?></h2>
            <p><?= e($sec['subtitle']) ?></p>
        </div>
        <div class="grid grid--3">
            <?php foreach ($projects as $project): ?>
                <a class="scard" href="<?= base_url('projeler/' . $project['slug']) ?>">
                    <div class="scard__media">
                        <?php if (!empty($project['cover_image'])): ?>
                            <img src="<?= e(upload_url($project['cover_image'])) ?>" alt="<?= e($project['title']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="ph-media"><?= icon('excavator', 42) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="scard__body">
                        <h3><?= e($project['title']) ?></h3>
                        <p><?= e(str_excerpt($project['short_description'] ?? '', 120)) ?></p>
                        <div class="scard__foot">
                            <?php if (!empty($project['region'])): ?><span class="region-chip" style="padding:7px 12px;box-shadow:none"><?= icon('map-pin', 13) ?> <?= e($project['region']) ?></span><?php endif; ?>
                            <?php if (!empty($project['project_date'])): ?><span class="region-chip" style="padding:7px 12px;box-shadow:none"><?= icon('calendar', 13) ?> <?= e($project['project_date']) ?></span><?php endif; ?>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <div class="center-btn"><a href="<?= base_url('projeler') ?>" class="btn btn--primary">Tüm Projeler</a></div>
    </div>
</section>
<?php endif; ?>

<!-- REGIONS (kaynak: service_regions tablosu — admin: Çalışma Bölgeleri) -->
<?php if (!empty($sections['regions']['is_active'])): $sec = $sections['regions'];
    // Yeni CMS modülü öncelikli; tablo boşsa eski JSON içeriğe düş (geri uyumluluk)
    $regionChips = !empty($serviceRegions)
        ? array_column($serviceRegions, 'title')
        : json_decode_safe($sec['content_json']);
?>
<section class="section">
    <div class="container">
        <div class="sec-head"><span class="eyebrow">Nerede</span><h2><?= e($sec['title']) ?></h2><p><?= e($sec['subtitle']) ?></p></div>
        <div class="regions">
            <?php foreach ($regionChips as $r): ?>
                <span class="region-chip"><?= icon('map-pin', 15) ?> <?= e($r) ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- BLOG + FAQ split -->
<?php if ((!empty($sections['blog']['is_active']) && $posts) || (!empty($sections['faq']['is_active']) && $faqs)): ?>
<section class="section section--soft">
    <div class="container split">
        <?php if (!empty($sections['blog']['is_active'])): $sec = $sections['blog']; ?>
        <div>
            <div class="sec-head sec-head--left" style="margin-bottom:26px"><h2 style="font-size:26px"><?= e($sec['title']) ?></h2><p><?= e($sec['subtitle']) ?></p></div>
            <div class="grid" style="gap:20px">
                <?php foreach ($posts as $p): $d = strtotime($p['published_at'] ?? 'now'); ?>
                    <article class="bcard" style="flex-direction:row">
                        <a href="<?= base_url('blog/' . $p['slug']) ?>" class="bcard__media" style="width:140px;flex:none;aspect-ratio:1">
                            <?php if ($p['cover_image']): ?><img src="<?= e(upload_url($p['cover_image'])) ?>" alt="<?= e($p['title']) ?>">
                            <?php else: ?><div class="ph-media"><?= icon('excavator', 34) ?></div><?php endif; ?>
                            <span class="bcard__date"><b><?= date('d', $d) ?></b><span><?= strtoupper(strftime_tr($d)) ?></span></span>
                        </a>
                        <div class="bcard__body">
                            <h3 style="font-size:16px"><a href="<?= base_url('blog/' . $p['slug']) ?>"><?= e($p['title']) ?></a></h3>
                            <p><?= e(str_excerpt($p['excerpt'], 90)) ?></p>
                            <a href="<?= base_url('blog/' . $p['slug']) ?>" class="bcard__more">Devamını Oku <?= icon('arrow-right', 15) ?></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($sections['faq']['is_active']) && $faqs): $sec = $sections['faq']; ?>
        <div>
            <div class="sec-head sec-head--left" style="margin-bottom:26px"><h2 style="font-size:26px"><?= e($sec['title']) ?></h2><p><?= e($sec['subtitle']) ?></p></div>
            <div class="faq">
                <?php foreach ($faqs as $f): ?>
                    <div class="faq__item">
                        <button class="faq__q" type="button"><?= e($f['question']) ?><span class="plus"><?= icon('plus', 16) ?></span></button>
                        <div class="faq__a"><div class="faq__a-inner"><?= e($f['answer']) ?></div></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<!-- FINAL CTA -->
<?php if (!empty($sections['final_cta']['is_active'])): $sec = $sections['final_cta']; ?>
<section class="final-cta">
    <div class="container final-cta__inner">
        <div><h2><?= e($sec['title']) ?></h2><p><?= e($sec['subtitle']) ?></p></div>
        <div class="final-cta__btns">
            <a href="<?= e(whatsapp_link('Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--dark"><?= icon('whatsapp', 18) ?> WhatsApp</a>
            <?php $finalCtaText = trim((string) ($sec['cta_text'] ?? '')) ?: 'Teklif Al'; $finalCtaUrl = trim((string) ($sec['cta_url'] ?? '')) ?: '/iletisim'; ?>
            <a href="<?= e(build_link('internal', $finalCtaUrl)) ?>" class="btn btn--dark" style="background:#fff;color:#111"><?= icon('star', 17) ?> <?= e($finalCtaText) ?></a>
        </div>
    </div>
</section>
<?php endif; ?>
