<?php $ph_title = 'Hizmetlerimiz'; $ph_sub = 'Alanya ve Mahmutlar genelinde sunduğumuz profesyonel hafriyat hizmetleri'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container">
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
    </div>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
