<?php
$d = strtotime($post['published_at'] ?? 'now');
$ph_title = $post['title'];
$ph_img = $post['cover_image'];
include VIEW_PATH . '/partials/page-hero.php';
?>

<section class="section">
    <div class="container layout-sidebar layout-sidebar--sm">
        <article>
            <div style="display:flex;gap:16px;color:var(--muted);font-size:14px;margin-bottom:20px;flex-wrap:wrap">
                <?php if (!empty($post['author_name'])): ?><span><?= icon('users', 15) ?> <?= e($post['author_name']) ?></span><?php endif; ?>
                <span><?= icon('clock', 15) ?> <?= tr_date($post['published_at']) ?></span>
                <span><?= icon('search', 15) ?> <?= (int) $post['reading_time'] ?> dk okuma</span>
                <?php if (!empty($post['category_title'])): ?><a href="<?= base_url('blog/kategori/' . $post['category_slug']) ?>" style="color:var(--color-primary)"># <?= e($post['category_title']) ?></a><?php endif; ?>
            </div>

            <?php if ($post['cover_image']): ?>
            <div class="about-media" style="aspect-ratio:16/9;margin-bottom:24px">
                <img src="<?= e(upload_url($post['cover_image'])) ?>" width="1200" height="675" decoding="async"
                     alt="<?= e($post['cover_image_alt'] ?: $post['title']) ?>"
                     <?= !empty($post['cover_image_title']) ? 'title="' . e($post['cover_image_title']) . '"' : '' ?>>
            </div>
            <?php endif; ?>

            <?php if (count($toc) > 1): ?>
            <div class="scard" style="padding:20px;text-align:left;margin-bottom:24px">
                <strong style="display:block;margin-bottom:10px"><?= icon('clipboard', 17) ?> İçindekiler</strong>
                <ul>
                    <?php foreach ($toc as $h): ?>
                        <li style="padding:4px 0;margin-left:<?= ($h['level'] - 1) * 14 ?>px"><a href="#<?= e($h['id']) ?>" style="font-size:14px;color:var(--muted)"><?= e($h['text']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>

            <div class="prose"><?= $contentHtml ?></div>

            <?php if (!empty($faqs)): ?>
            <h2 style="font-size:22px;margin:34px 0 16px">Sık Sorulan Sorular</h2>
            <div class="faq" style="margin:0">
                <?php foreach ($faqs as $f): ?>
                    <div class="faq__item">
                        <button class="faq__q" type="button"><?= e($f['question'] ?? '') ?><span class="plus"><?= icon('plus', 16) ?></span></button>
                        <div class="faq__a"><div class="faq__a-inner"><?= e($f['answer'] ?? '') ?></div></div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>

            <?php if (!empty($relatedService)): ?>
            <div class="scard" style="margin-top:30px;padding:22px;text-align:left;display:flex;gap:16px;align-items:center;flex-wrap:wrap;border-left:4px solid var(--color-primary)">
                <span style="width:52px;height:52px;flex:none;display:grid;place-items:center;background:var(--color-primary);color:var(--color-primary-text);border-radius:12px"><?= icon($relatedService['icon'] ?: 'excavator', 26) ?></span>
                <div style="flex:1;min-width:200px">
                    <b style="display:block;font-size:16px"><?= e($relatedService['title']) ?></b>
                    <span style="color:var(--muted);font-size:14px"><?= e(str_excerpt($relatedService['short_description'], 90)) ?></span>
                </div>
                <a href="<?= base_url('hizmetler/' . $relatedService['slug']) ?>" class="btn btn--primary btn--sm">Hizmeti İncele</a>
            </div>
            <?php endif; ?>

            <div class="scard" style="padding:24px;text-align:center;background:var(--color-primary);margin-top:30px">
                <h3 style="color:var(--color-primary-text);font-size:20px;margin-bottom:8px">Hafriyat veya Kepçe Kiralama İçin Teklif Alın</h3>
                <p style="color:var(--color-primary-text);opacity:.8;margin-bottom:16px">Projeniz için ücretsiz keşif ve en uygun fiyat teklifi.</p>
                <a href="<?= e(whatsapp_link('Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--dark"><?= icon('whatsapp', 18) ?> WhatsApp’tan Teklif Al</a>
            </div>

            <?php if (!empty($relatedPosts)): ?>
            <h2 style="font-size:22px;margin:34px 0 16px">İlgili Yazılar</h2>
            <div class="grid grid--3">
                <?php foreach ($relatedPosts as $rp): ?>
                    <a class="scard" href="<?= base_url('blog/' . $rp['slug']) ?>">
                        <div class="scard__media">
                            <?php if ($rp['cover_image']): ?><img src="<?= e(upload_url($rp['cover_image'])) ?>" alt="<?= e($rp['title']) ?>" loading="lazy">
                            <?php else: ?><div class="ph-media"><?= icon('excavator', 36) ?></div><?php endif; ?>
                        </div>
                        <div class="scard__body"><h3 style="font-size:15px"><?= e(str_excerpt($rp['title'], 60)) ?></h3></div>
                    </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </article>

        <?php include VIEW_PATH . '/partials/blog-sidebar.php'; ?>
    </div>
</section>
