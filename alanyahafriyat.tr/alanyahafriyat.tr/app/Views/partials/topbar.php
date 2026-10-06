<div class="topbar">
    <div class="container topbar__inner">
        <div class="topbar__left">
            <?= icon('excavator', 16, 'topbar__ico') ?>
            <span class="topbar__text"><?= e(setting('top_bar_text', 'Alanya, Mahmutlar ve Çevresi Hizmetinizde!')) ?></span>
        </div>
        <div class="topbar__right">
            <span class="topbar__item topbar__item--clock"><?= icon('clock', 15) ?> <span><?= e(setting('working_hours', 'Pzt - Cmt: 08:00 - 18:00')) ?></span></span>
            <a class="topbar__item topbar__item--phone" href="tel:<?= e(preg_replace('/[^0-9+]/', '', setting('phone', ''))) ?>"><?= icon('phone', 15) ?> <span><?= e(setting('phone', '')) ?></span></a>
            <a class="topbar__item topbar__item--wa" href="<?= e(whatsapp_link('Merhaba, bilgi almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event><?= icon('whatsapp', 15) ?> <span>WhatsApp</span></a>
        </div>
    </div>
</div>
