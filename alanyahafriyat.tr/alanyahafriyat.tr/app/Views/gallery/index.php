<?php $ph_title = 'Galeri'; $ph_sub = 'Sahadaki hafriyat ve iş makinesi çalışmalarımızdan kareler'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container">
        <?php if ($categories): ?>
        <div class="regions" style="justify-content:center;margin-bottom:30px">
            <a href="<?= base_url('galeri') ?>" class="region-chip<?= $activeCat === '' ? ' is-active' : '' ?>" style="<?= $activeCat === '' ? 'border-color:var(--color-primary);color:var(--color-primary)' : '' ?>">Tümü</a>
            <?php foreach ($categories as $c): ?>
                <a href="<?= base_url('galeri?kategori=' . urlencode($c)) ?>" class="region-chip" style="<?= $activeCat === $c ? 'border-color:var(--color-primary);color:var(--color-primary)' : '' ?>"><?= e($c) ?></a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <?php if (!$items): ?>
            <p style="color:var(--muted);text-align:center">Bu kategoride görsel bulunamadı.</p>
        <?php else: ?>
        <div class="ggrid">
            <?php foreach ($items as $g): ?>
                <?php if (!empty($g['video_url'])): ?>
                    <a class="gitem" href="<?= e($g['video_url']) ?>" target="_blank" rel="noopener">
                        <?php if ($g['image']): ?><img src="<?= e(upload_url($g['image'])) ?>" alt="<?= e($g['alt_text'] ?: $g['title']) ?>" loading="lazy"><?php else: ?><div class="ph-media"><?= icon('excavator', 44) ?></div><?php endif; ?>
                        <span class="gitem__cap"><?= icon('chevron-right', 15) ?> <?= e($g['title']) ?></span>
                    </a>
                <?php else: ?>
                    <a class="gitem" href="<?= $g['image'] ? e(upload_url($g['image'])) : '#' ?>" data-lightbox>
                        <?php if ($g['image']): ?><img src="<?= e(upload_url($g['image'])) ?>" alt="<?= e($g['alt_text'] ?: $g['title']) ?>" loading="lazy"><?php else: ?><div class="ph-media"><?= icon('excavator', 44) ?></div><?php endif; ?>
                        <?php if ($g['title']): ?><span class="gitem__cap"><?= icon('map-pin', 15) ?> <?= e($g['title']) ?></span><?php endif; ?>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
