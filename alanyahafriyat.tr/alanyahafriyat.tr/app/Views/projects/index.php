<?php $ph_title = 'Projelerimiz'; $ph_sub = 'Alanya ve Mahmutlar’da tamamladığımız çalışmalardan bazıları'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container">
        <?php if ($regions || $types): ?>
        <form method="get" style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:30px;align-items:center">
            <select name="bolge" onchange="this.form.submit()" style="padding:11px 16px;border:1px solid var(--line);border-radius:10px;font-family:inherit">
                <option value="">Tüm Bölgeler</option>
                <?php foreach ($regions as $r): ?><option value="<?= e($r) ?>"<?= $activeRegion === $r ? ' selected' : '' ?>><?= e($r) ?></option><?php endforeach; ?>
            </select>
            <select name="hizmet" onchange="this.form.submit()" style="padding:11px 16px;border:1px solid var(--line);border-radius:10px;font-family:inherit">
                <option value="">Tüm Hizmetler</option>
                <?php foreach ($types as $t): ?><option value="<?= e($t) ?>"<?= $activeType === $t ? ' selected' : '' ?>><?= e($t) ?></option><?php endforeach; ?>
            </select>
            <?php if ($activeRegion || $activeType): ?><a href="<?= base_url('projeler') ?>" class="btn btn--outline btn--sm">Filtreyi Temizle</a><?php endif; ?>
        </form>
        <?php endif; ?>

        <?php if (!$projects): ?>
            <p style="color:var(--muted)">Bu filtreye uygun proje bulunamadı.</p>
        <?php else: ?>
        <div class="grid grid--3">
            <?php foreach ($projects as $p): ?>
                <a class="scard" href="<?= base_url('projeler/' . $p['slug']) ?>">
                    <div class="scard__media">
                        <?php if ($p['cover_image']): ?><img src="<?= e(upload_url($p['cover_image'])) ?>" alt="<?= e($p['title']) ?>" title="<?= e($p['service_type'] ?: $p['title']) ?>" width="1200" height="800" loading="lazy" decoding="async" fetchpriority="low">
                        <?php else: ?><div class="ph-media"><?= icon('excavator', 48) ?></div><?php endif; ?>
                    </div>
                    <div class="scard__body" style="text-align:left">
                        <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:8px">
                            <?php if ($p['region']): ?><span style="background:var(--soft);color:var(--muted);font-size:12px;padding:3px 10px;border-radius:20px"><?= e($p['region']) ?></span><?php endif; ?>
                            <?php if ($p['service_type']): ?><span style="background:rgba(245,166,35,.14);color:var(--primary-d);font-size:12px;padding:3px 10px;border-radius:20px"><?= e($p['service_type']) ?></span><?php endif; ?>
                        </div>
                        <h3 style="font-size:17px"><?= e($p['title']) ?></h3>
                        <p><?= e(str_excerpt($p['short_description'], 90)) ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
