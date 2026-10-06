<?php
$fs = $footerSettings ?? [];
$col1 = json_decode_safe($fs['column_1_links_json'] ?? null);
$col2 = json_decode_safe($fs['column_2_links_json'] ?? null);
$fbg = $fs['background_color'] ?? '#111111';
$ftext = $fs['text_color'] ?? '#CBD5E1';
?>
<footer class="footer" style="--footer-bg: <?= e($fbg) ?>; --footer-text: <?= e($ftext) ?>;">
    <div class="container footer__grid">
        <div class="footer__col footer__brand">
            <a href="<?= base_url() ?>" class="brand brand--footer">
                <?php if ($logo = setting('logo')): ?>
                    <img src="<?= e(upload_url($logo)) ?>" alt="<?= e(site_name()) ?>" class="brand__logo">
                <?php else: ?>
                    <span class="brand__mark"><?= icon('excavator', 26) ?></span>
                    <span class="brand__text"><?= e(site_name()) ?></span>
                <?php endif; ?>
            </a>
            <p class="footer__about"><?= e($fs['description'] ?? setting('footer_about', '')) ?></p>
            <div class="footer__social">
                <?php foreach (($socialLinks ?? []) as $s): ?>
                    <a href="<?= e($s['url']) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['platform']) ?>"><?= icon($s['icon'] ?: $s['platform'], 18) ?></a>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="footer__col">
            <h4 class="footer__title"><?= e($fs['column_1_title'] ?? 'Hizmetlerimiz') ?></h4>
            <ul class="footer__links">
                <?php foreach ($col1 as $l): ?>
                    <li><a href="<?= e(base_url(ltrim($l['url'] ?? '#', '/'))) ?>"><?= e($l['title'] ?? '') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer__col">
            <h4 class="footer__title"><?= e($fs['column_2_title'] ?? 'Hızlı Linkler') ?></h4>
            <ul class="footer__links">
                <?php foreach ($col2 as $l): ?>
                    <li><a href="<?= e(base_url(ltrim($l['url'] ?? '#', '/'))) ?>"><?= e($l['title'] ?? '') ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="footer__col">
            <h4 class="footer__title">İletişim</h4>
            <ul class="footer__contact">
                <li><?= icon('phone', 16) ?> <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', setting('phone', ''))) ?>"><?= e(setting('phone', '')) ?></a></li>
                <li><?= icon('mail', 16) ?> <a href="mailto:<?= e(setting('email', '')) ?>"><?= e(setting('email', '')) ?></a></li>
                <li><?= icon('map-pin', 16) ?> <span><?= e(setting('address', '')) ?></span></li>
                <li><?= icon('clock', 16) ?> <span><?= e(setting('working_hours', '')) ?></span></li>
            </ul>
        </div>
    </div>

<?php
    $creditText = trim((string) setting('web_design_credit_text', ''));
    $creditUrl  = trim((string) setting('web_design_credit_url', ''));
    ?>
    <div class="footer__bottom">
        <div class="container footer__bottom-inner">
            <span class="footer__copyright"><?= e($fs['copyright_text'] ?? ('© ' . date('Y') . ' ' . site_name())) ?></span>
            <div class="footer__legal">
                <a href="<?= base_url('sayfa/gizlilik-politikasi') ?>">Gizlilik Politikası</a>
                <a href="<?= base_url('sayfa/kvkk') ?>">KVKK</a>
                <a href="<?= base_url('sayfa/cerez-politikasi') ?>">Çerez Politikası</a>
            </div>
            <?php if ($creditText !== ''): ?>
                <span class="footer__credit">
                    <?php if ($creditUrl !== ''): ?>
                        <a href="<?= e($creditUrl) ?>" target="_blank" rel="noopener noreferrer"><?= e($creditText) ?></a>
                    <?php else: ?>
                        <?= e($creditText) ?>
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </div>
    </div>
</footer>
