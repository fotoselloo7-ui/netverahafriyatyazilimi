<?php if (!empty($mobileBar)): ?>
<nav class="mobilebar">
    <?php foreach ($mobileBar as $item): ?>
        <?php
        $type = $item['menu_type'];
        $href = match ($type) {
            'phone'    => 'tel:' . preg_replace('/[^0-9+]/', '', $item['url'] ?: setting('phone', '')),
            'whatsapp' => whatsapp_link($item['url'] ?: 'Merhaba, teklif almak istiyorum.'),
            'external' => (($item['icon'] ?? '') === 'map-pin' || mb_strtolower((string) ($item['title'] ?? ''), 'UTF-8') === 'konum') ? base_url('iletisim#konum') : (string) ($item['url'] ?: '#'),
            default    => (($item['icon'] ?? '') === 'map-pin' || mb_strtolower((string) ($item['title'] ?? ''), 'UTF-8') === 'konum') ? base_url('iletisim#konum') : base_url(ltrim($item['url'] ?: '/', '/')),
        };
        $waAttr = $type === 'whatsapp' ? ' data-wa-event target="_blank" rel="noopener"' : '';
        ?>
        <a href="<?= e($href) ?>" class="mobilebar__item"<?= $waAttr ?>>
            <?= icon($item['icon'] ?: 'chevron-right', 22) ?>
            <span><?= e($item['title']) ?></span>
        </a>
    <?php endforeach; ?>
</nav>
<?php endif; ?>
