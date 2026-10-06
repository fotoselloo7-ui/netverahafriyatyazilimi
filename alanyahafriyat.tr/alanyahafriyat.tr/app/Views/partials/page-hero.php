<?php
/** @var string $ph_title */
$ph_title = $ph_title ?? ($pageTitle ?? '');
$ph_sub = $ph_sub ?? '';
$ph_img = $ph_img ?? null;
$crumbs = $breadcrumb ?? [];
?>
<section class="page-hero"<?= $ph_img ? ' style="background-image:linear-gradient(rgba(10,10,12,.7),rgba(10,10,12,.65)),url(\''.e(upload_url($ph_img)).'\')"' : '' ?>>
    <div class="container">
        <h1><?= e($ph_title) ?></h1>
        <?php if ($ph_sub): ?><p style="color:#d7d9dd;max-width:640px"><?= e($ph_sub) ?></p><?php endif; ?>
        <?php if ($crumbs): ?>
        <div class="breadcrumb" style="margin-top:12px">
            <?php foreach ($crumbs as $i => $c): ?>
                <?php if ($c[1]): ?><a href="<?= e($c[1]) ?>"><?= e($c[0]) ?></a><?php else: ?><span class="cur"><?= e($c[0]) ?></span><?php endif; ?>
                <?php if ($i < count($crumbs) - 1): ?><?= icon('chevron-right', 14) ?><?php endif; ?>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>
