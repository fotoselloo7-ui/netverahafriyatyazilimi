<?php $ph_title = 'Makine Parkurumuz'; $ph_sub = 'Güçlü, bakımlı ve modern iş makinelerimizle tüm hafriyat işlerinizi güvenle üstleniyoruz.'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="grid grid--3 equipment-grid">
            <?php foreach ($equipment as $m): $specs = array_filter(array_map('trim', explode('•', (string) $m['short_description']))); ?>
                <article class="ecard">
                    <a href="<?= base_url('makine-parkuru/' . $m['slug']) ?>" class="ecard__media">
                        <?php if ($m['image']): ?><img src="<?= e(upload_url($m['image'])) ?>" alt="<?= e($m['title']) ?>" title="<?= e($m['title'] . ' - Ersan Hafriyat') ?>" width="900" height="560" loading="lazy" decoding="async" fetchpriority="low">
                        <?php else: ?><div class="ph-media"><?= icon('truck', 48) ?></div><?php endif; ?>
                    </a>
                    <div class="ecard__body">
                        <h3><a href="<?= base_url('makine-parkuru/' . $m['slug']) ?>"><?= e($m['title']) ?></a></h3>
                        <?php if ($m['usage_area']): ?><p style="color:var(--muted);font-size:13px;margin-bottom:8px"><?= e($m['usage_area']) ?></p><?php endif; ?>
                        <ul class="ecard__specs"><?php foreach ($specs as $sp): ?><li><?= e($sp) ?></li><?php endforeach; ?></ul>
                        <a href="<?= e(whatsapp_link('Merhaba, ' . $m['title'] . ' için teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa btn--sm btn--block"><?= icon('whatsapp', 15) ?> Bu Makine İçin Teklif</a>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
