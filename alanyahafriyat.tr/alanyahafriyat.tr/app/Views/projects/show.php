<?php
$ph_title = $project['title'];
$ph_sub = trim(($project['region'] ? $project['region'] : '') . ($project['service_type'] ? ' · ' . $project['service_type'] : ''));
$ph_img = $project['cover_image'];
include VIEW_PATH . '/partials/page-hero.php';
?>

<section class="section">
    <div class="container" style="max-width:900px">
        <?php if ($project['before_image'] || $project['after_image']): ?>
        <div class="grid grid--2" style="margin-bottom:30px">
            <?php if ($project['before_image']): ?>
                <div><div class="about-media" style="aspect-ratio:16/10"><img src="<?= e(upload_url($project['before_image'])) ?>" alt="Öncesi"></div><p style="text-align:center;margin-top:8px;color:var(--muted);font-weight:600">Öncesi</p></div>
            <?php endif; ?>
            <?php if ($project['after_image']): ?>
                <div><div class="about-media" style="aspect-ratio:16/10"><img src="<?= e(upload_url($project['after_image'])) ?>" alt="Sonrası"></div><p style="text-align:center;margin-top:8px;color:var(--primary-d);font-weight:600">Sonrası</p></div>
            <?php endif; ?>
        </div>
        <?php elseif ($project['cover_image']): ?>
        <div class="about-media" style="aspect-ratio:16/9;margin-bottom:30px"><img src="<?= e(upload_url($project['cover_image'])) ?>" alt="<?= e($project['title']) ?>" title="<?= e($project['service_type'] ?: $project['title']) ?>" width="1600" height="900" decoding="async"></div>
        <?php endif; ?>

        <div class="prose" style="margin:0 0 20px"><?= $project['content'] ?></div>

        <div style="display:flex;gap:20px;flex-wrap:wrap;padding:18px;background:var(--soft);border-radius:12px">
            <?php if ($project['region']): ?><div><span style="color:var(--muted);font-size:13px">Bölge</span><br><strong><?= e($project['region']) ?></strong></div><?php endif; ?>
            <?php if ($project['service_type']): ?><div><span style="color:var(--muted);font-size:13px">Hizmet</span><br><strong><?= e($project['service_type']) ?></strong></div><?php endif; ?>
            <?php if ($project['project_date']): ?><div><span style="color:var(--muted);font-size:13px">Tarih</span><br><strong><?= e($project['project_date']) ?></strong></div><?php endif; ?>
        </div>

        <?php if ($gallery): ?>
        <div class="ggrid" style="margin-top:26px">
            <?php foreach ($gallery as $g): ?><a class="gitem" href="<?= e(upload_url($g)) ?>" data-lightbox><img src="<?= e(upload_url($g)) ?>" alt="<?= e($project['title']) ?>" width="1200" height="800" loading="lazy" decoding="async" fetchpriority="low"></a><?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>

    <?php if ($related): ?>
    <div class="container" style="margin-top:44px">
        <h2 style="font-size:24px;margin-bottom:20px">Diğer Projeler</h2>
        <div class="grid grid--3">
            <?php foreach ($related as $r): ?>
                <a class="scard" href="<?= base_url('projeler/' . $r['slug']) ?>">
                    <div class="scard__media"><?php if ($r['cover_image']): ?><img src="<?= e(upload_url($r['cover_image'])) ?>" alt="<?= e($r['title']) ?>"><?php else: ?><div class="ph-media"><?= icon('excavator', 40) ?></div><?php endif; ?></div>
                    <div class="scard__body" style="text-align:left"><h3 style="font-size:16px"><?= e($r['title']) ?></h3><p><?= e($r['region']) ?></p></div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
