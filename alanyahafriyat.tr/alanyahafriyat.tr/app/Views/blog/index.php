<?php $ph_title = $activeCat ? $activeCat['title'] : 'Blog'; $ph_sub = 'Hafriyat, kepçe kiralama ve iş makineleri hakkında faydalı içerikler'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container layout-sidebar layout-sidebar--sm">
        <div>
            <?php if (!$posts): ?>
                <p style="color:var(--muted)">Henüz yazı bulunmuyor.</p>
            <?php else: ?>
            <div class="grid" style="gap:24px">
                <?php foreach ($posts as $p): $d = strtotime($p['published_at'] ?? 'now'); ?>
                    <article class="bcard" style="flex-direction:row">
                        <a href="<?= base_url('blog/' . $p['slug']) ?>" class="bcard__media" style="width:220px;flex:none;aspect-ratio:4/3">
                            <?php if ($p['cover_image']): ?><img src="<?= e(upload_url($p['cover_image'])) ?>" alt="<?= e($p['title']) ?>">
                            <?php else: ?><div class="ph-media"><?= icon('excavator', 40) ?></div><?php endif; ?>
                            <span class="bcard__date"><b><?= date('d', $d) ?></b><span><?= strtoupper(strftime_tr($d)) ?></span></span>
                        </a>
                        <div class="bcard__body">
                            <?php if (!empty($p['category_title'])): ?><span style="color:var(--color-primary);font-size:12px;font-weight:600;text-transform:uppercase"><?= e($p['category_title']) ?></span><?php endif; ?>
                            <h3 style="font-size:19px;margin:6px 0 10px"><a href="<?= base_url('blog/' . $p['slug']) ?>"><?= e($p['title']) ?></a></h3>
                            <p><?= e(str_excerpt($p['excerpt'], 150)) ?></p>
                            <a href="<?= base_url('blog/' . $p['slug']) ?>" class="bcard__more">Devamını Oku <?= icon('arrow-right', 15) ?></a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <?php include VIEW_PATH . '/partials/blog-sidebar.php'; ?>
    </div>
</section>
