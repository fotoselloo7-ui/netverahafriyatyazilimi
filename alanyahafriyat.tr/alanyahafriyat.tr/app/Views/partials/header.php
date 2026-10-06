<?php $currentPath = current_path(); ?>
<header class="header" id="site-header">
    <div class="container header__inner">
        <a href="<?= base_url() ?>" class="brand" aria-label="<?= e(site_name()) ?>">
            <?php if ($logo = setting('logo')): ?>
                <img src="<?= e(upload_url($logo)) ?>" alt="<?= e(site_name()) ?>" class="brand__logo">
            <?php else: ?>
                <span class="brand__mark"><?= icon('excavator', 26) ?></span>
                <span class="brand__text"><?= e(explode(' ', site_name())[0]) ?><strong><?= e(trim(substr(site_name(), strlen(explode(' ', site_name())[0])))) ?></strong></span>
            <?php endif; ?>
        </a>

        <nav class="nav" id="main-nav" aria-label="Ana menü">
            <div class="nav__head">
                <span class="brand brand--drawer">
                    <span class="brand__mark"><?= icon('excavator', 22) ?></span>
                    <span class="brand__text"><?= e(site_name()) ?></span>
                </span>
                <button class="nav__close" aria-label="Menüyü kapat" data-nav-close><?= icon('x', 20) ?></button>
            </div>
            <div class="nav__links">
                <?php foreach (($headerMenu ?? []) as $item): ?>
                    <?php
                    $href = build_link($item['menu_type'], $item['url']);
                    $active = ($item['url'] === '/' && $currentPath === '/') || ($item['url'] !== '/' && $item['url'] !== '' && str_starts_with($currentPath, rtrim((string) $item['url'], '/')));
                    $isServices = trim((string) $item['url'], '/') === 'hizmetler' && !empty($navServices);
                    ?>
                    <?php if ($isServices): ?>
                        <div class="nav__group<?= $active ? ' is-open' : '' ?>">
                            <div class="nav__link nav__link--split<?= $active ? ' is-active' : '' ?>">
                                <a href="<?= e($href) ?>"><?= e($item['title']) ?></a>
                                <button type="button" class="nav__sub-toggle" aria-label="Alt menüyü aç" data-sub-toggle><?= icon('chevron-down', 18) ?></button>
                            </div>
                            <div class="nav__sub">
                                <?php foreach ($navServices as $ns): ?>
                                    <a href="<?= base_url('hizmetler/' . $ns['slug']) ?>" class="nav__sub-link<?= $currentPath === '/hizmetler/' . $ns['slug'] ? ' is-active' : '' ?>"><?= icon('chevron-right', 14) ?> <?= e($ns['title']) ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?= e($href) ?>" class="nav__link<?= $active ? ' is-active' : '' ?>"<?= $item['target'] === '_blank' ? ' target="_blank" rel="noopener"' : '' ?>>
                            <span><?= e($item['title']) ?></span>
                            <?= icon('chevron-right', 17, 'nav__link-arrow') ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="nav__foot">
                <a href="<?= e(whatsapp_link('Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa btn--block"><?= icon('whatsapp', 18) ?> WhatsApp’tan Teklif Al</a>
                <div class="nav__foot-row">
                    <a href="tel:<?= e(preg_replace('/[^0-9+]/', '', setting('phone', ''))) ?>" class="nav__foot-btn"><?= icon('phone', 17) ?> Hemen Ara</a>
                    <a href="<?= base_url('iletisim') ?>" class="nav__foot-btn"><?= icon('map-pin', 17) ?> Konum</a>
                </div>
                <div class="nav__foot-info"><?= icon('clock', 14) ?> <?= e(setting('working_hours', '')) ?></div>
                <?php if (!empty($socialLinks)): ?>
                <div class="nav__foot-social">
                    <?php foreach ($socialLinks as $s): ?>
                        <?php $socialHref = strtolower((string) ($s['platform'] ?? '')) === 'whatsapp' ? whatsapp_link('Merhaba, bilgi almak istiyorum.') : (string) ($s['url'] ?? '#'); ?>
                        <a href="<?= e($socialHref) ?>" target="_blank" rel="noopener" aria-label="<?= e($s['platform']) ?>"><?= icon($s['icon'] ?: $s['platform'], 17) ?></a>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </nav>

        <div class="header__actions">
            <a href="<?= e(base_url('iletisim')) ?>" class="btn btn--primary btn--sm header__cta"><?= icon('send', 16) ?> Teklif Al</a>
            <button class="nav__toggle" aria-label="Menüyü aç" data-nav-toggle><?= icon('menu', 26) ?></button>
        </div>
    </div>
    <?php /* Overlay header İÇİNDE olmalı: header sticky+z-index ile stacking context
             oluşturur; overlay dışarıda kalırsa menü panelinin ÜSTÜNE biner ve
             yazıları flu/soluk gösterir. İçeride: overlay < panel sıralaması doğru. */ ?>
    <div class="nav__overlay" data-nav-close></div>
</header>
