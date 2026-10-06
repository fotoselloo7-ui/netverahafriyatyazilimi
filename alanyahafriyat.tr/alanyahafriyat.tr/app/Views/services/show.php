<?php
$ph_title = $service['hero_title'] ?: $service['title'];
$ph_sub = $service['hero_subtitle'] ?: '';
$ph_img = $service['hero_image'] ?: $service['cover_image'];
include VIEW_PATH . '/partials/page-hero.php';
?>

<section class="section">
    <div class="container layout-sidebar">
        <div>
            <div class="prose" style="margin:0 0 30px"><?= $service['content'] ?></div>

            <?php if ($advantages): ?>
            <h2 style="font-size:24px;margin-bottom:16px"><?= icon('check-circle', 22) ?> Avantajlar</h2>
            <ul class="about-feats" style="margin-bottom:34px">
                <?php foreach ($advantages as $a): ?>
                    <li><span class="fico"><?= icon('check', 18) ?></span> <?= e($a) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <?php if ($usageAreas): ?>
            <h2 style="font-size:24px;margin-bottom:16px">Kullanım Alanları</h2>
            <div class="regions" style="justify-content:flex-start;margin-bottom:34px">
                <?php foreach ($usageAreas as $u): ?><span class="region-chip"><?= icon('chevron-right', 15) ?> <?= e($u) ?></span><?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($serviceRegions)): ?>
            <h2 style="font-size:24px;margin-bottom:16px">Hizmet Bölgelerimiz</h2>
            <div class="regions" style="justify-content:flex-start;margin-bottom:34px">
                <?php foreach ($serviceRegions as $reg): ?><span class="region-chip"><?= icon('map-pin', 15) ?> <?= e($reg['title']) ?></span><?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($process): ?>
            <h2 style="font-size:24px;margin-bottom:20px">Hizmet Sürecimiz</h2>
            <div class="grid grid--2" style="margin-bottom:34px">
                <?php foreach ($process as $i => $p): ?>
                    <div class="scard" style="padding:20px;display:flex;gap:14px;align-items:flex-start;text-align:left">
                        <span class="badge__ico" style="flex:none"><?= $i + 1 ?></span>
                        <div><b style="display:block;margin-bottom:4px"><?= e($p['title'] ?? '') ?></b><span style="color:var(--muted);font-size:14px"><?= e($p['text'] ?? '') ?></span></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($faqs): ?>
            <h2 style="font-size:24px;margin-bottom:18px">Sık Sorulan Sorular</h2>
            <div class="faq" style="margin:0 0 20px">
                <?php foreach ($faqs as $f): ?>
                    <div class="faq__item">
                        <button class="faq__q" type="button"><?= e($f['question']) ?><span class="plus"><?= icon('plus', 16) ?></span></button>
                        <div class="faq__a"><div class="faq__a-inner"><?= e($f['answer']) ?></div></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if ($related): ?>
            <h2 style="font-size:24px;margin:34px 0 18px">İlgili Projeler</h2>
            <div class="grid grid--3">
                <?php foreach ($related as $r): ?>
                    <a class="scard" href="<?= base_url('projeler/' . $r['slug']) ?>">
                        <div class="scard__media"><?php if ($r['cover_image']): ?><img src="<?= e(upload_url($r['cover_image'])) ?>" alt="<?= e($r['title']) ?>"><?php else: ?><div class="ph-media"><?= icon('excavator', 40) ?></div><?php endif; ?></div>
                        <div class="scard__body" style="text-align:left"><h3 style="font-size:16px"><?= e($r['title']) ?></h3><p><?= e($r['region']) ?></p></div>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <aside>
            <div style="position:sticky;top:100px">
                <?php $source = 'service:' . $service['slug']; include VIEW_PATH . '/partials/quickform.php'; ?>
                <a href="<?= e(whatsapp_link('Merhaba, ' . $service['title'] . ' hizmeti için teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa btn--block" style="margin-top:14px"><?= icon('whatsapp', 18) ?> WhatsApp’tan Teklif Al</a>
            </div>

            <div class="scard" style="margin-top:20px;padding:20px;text-align:left">
                <h3 style="font-size:17px;margin-bottom:12px">Diğer Hizmetler</h3>
                <ul>
                    <?php foreach (array_slice($services, 0, 8) as $os): ?>
                        <li style="padding:7px 0;border-bottom:1px solid var(--line)"><a href="<?= base_url('hizmetler/' . $os['slug']) ?>" style="display:flex;gap:8px;align-items:center;font-size:14px<?= $os['id'] === $service['id'] ? ';color:var(--color-primary);font-weight:600' : '' ?>"><?= icon('chevron-right', 15) ?> <?= e($os['title']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </aside>
    </div>
</section>

<?php $cta_wa = 'Merhaba, ' . $service['title'] . ' hizmeti için teklif almak istiyorum.'; include VIEW_PATH . '/partials/cta.php'; ?>
