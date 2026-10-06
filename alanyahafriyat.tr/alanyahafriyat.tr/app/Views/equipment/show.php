<?php $ph_title = $item['title']; $ph_sub = $item['usage_area'] ?: ''; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container layout-2">
        <div class="about-media" style="aspect-ratio:4/3">
            <?php if ($item['image']): ?><img src="<?= e(upload_url($item['image'])) ?>" alt="<?= e($item['title']) ?>">
            <?php else: ?><div class="ph-media"><?= icon('truck', 90) ?></div><?php endif; ?>
        </div>
        <div>
            <h2 style="font-size:26px;margin-bottom:10px"><?= e($item['title']) ?></h2>
            <?php if ($item['brand_model']): ?><p style="color:var(--muted);margin-bottom:14px"><strong>Model:</strong> <?= e($item['brand_model']) ?></p><?php endif; ?>
            <div class="prose" style="margin:0 0 18px"><?= $item['content'] ?></div>
            <ul class="about-feats" style="margin-bottom:20px">
                <?php if ($item['usage_area']): ?><li><span class="fico"><?= icon('check', 18) ?></span> <strong>Kullanım:</strong>&nbsp;<?= e($item['usage_area']) ?></li><?php endif; ?>
                <?php if ($item['attachments']): ?><li><span class="fico"><?= icon('check', 18) ?></span> <strong>Ataşmanlar:</strong>&nbsp;<?= e($item['attachments']) ?></li><?php endif; ?>
            </ul>
            <a href="<?= e(whatsapp_link('Merhaba, ' . $item['title'] . ' için teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa"><?= icon('whatsapp', 18) ?> Bu Makine İçin Teklif Al</a>
            <a href="<?= base_url('makine-parkuru') ?>" class="btn btn--outline">Tüm Makineler</a>
        </div>
    </div>

    <?php if ($gallery): ?>
    <div class="container" style="margin-top:30px">
        <div class="ggrid">
            <?php foreach ($gallery as $g): ?>
                <a class="gitem" href="<?= e(upload_url($g)) ?>" data-lightbox><img src="<?= e(upload_url($g)) ?>" alt="<?= e($item['title']) ?>" loading="lazy"></a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
