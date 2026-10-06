<?php
$btnHref = build_link($popup['button_type'] ?? 'internal', $popup['button_url'] ?? '');
?>
<div class="popup" id="site-popup"
     data-delay="<?= (int) ($popup['delay_seconds'] ?? 3) ?>"
     data-repeat="<?= (int) ($popup['repeat_after_hours'] ?? 24) ?>"
     data-mobile="<?= (int) ($popup['show_on_mobile'] ?? 1) ?>"
     data-target="<?= e($popup['target_pages'] ?? 'all') ?>"
     data-id="<?= (int) $popup['id'] ?>"
     style="--popup-overlay: <?= e($popup['overlay_opacity'] ?? '0.6') ?>;">
    <div class="popup__overlay" data-popup-close></div>
    <div class="popup__box">
        <button class="popup__close" aria-label="Kapat" data-popup-close><?= icon('x', 22) ?></button>
        <?php if (!empty($popup['image'])): ?>
            <img src="<?= e(upload_url($popup['image'])) ?>" alt="" class="popup__img">
        <?php endif; ?>
        <div class="popup__body">
            <h3 class="popup__title"><?= e($popup['title'] ?? '') ?></h3>
            <p class="popup__desc"><?= e($popup['description'] ?? '') ?></p>
            <?php if (!empty($popup['button_text'])): ?>
                <a href="<?= e($btnHref) ?>" class="btn btn--primary"
                   <?= ($popup['button_type'] ?? '') === 'whatsapp' ? 'target="_blank" rel="noopener"' : '' ?>
                   data-popup-btn data-popup-id="<?= (int) $popup['id'] ?>"><?= e($popup['button_text']) ?></a>
            <?php endif; ?>
        </div>
    </div>
</div>
