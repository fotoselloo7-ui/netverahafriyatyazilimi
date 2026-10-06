<?php
$nav = [
    ['yonetim', 'Dashboard', 'excavator'],
    ['yonetim/ayarlar', 'Genel Ayarlar', 'settings'],
    ['yonetim/tema', 'Tema / Renkler', 'tag'],
    ['yonetim/menu', 'Menü Yönetimi', 'menu'],
    ['yonetim/sayfalar', 'Sayfalar', 'layers'],
    ['yonetim/anasayfa', 'Ana Sayfa Bölümleri', 'clipboard'],
    ['yonetim/hizmetler', 'Hizmetler', 'git-branch'],
    ['yonetim/makine', 'Makine Parkuru', 'truck'],
    ['yonetim/projeler', 'Projeler', 'award'],
    ['yonetim/bolgeler', 'Çalışma Bölgeleri', 'map-pin'],
    ['yonetim/galeri', 'Galeri', 'search'],
    ['yonetim/blog', 'Blog', 'message-circle'],
    ['yonetim/yorumlar', 'Müşteri Yorumları', 'star'],
    ['yonetim/sss', 'SSS', 'plus'],
    ['yonetim/popup', 'Popup', 'star'],
    ['yonetim/teklifler', 'Teklifler / Leadler', 'send'],
    ['yonetim/bildirim', 'Bildirim Ayarları', 'phone'],
    ['yonetim/medya', 'Medya Kütüphanesi', 'map-pin'],
    ['yonetim/lisans', 'Sistem Lisansı', 'shield'],
];
$cur = $currentAdminPath ?? current_path();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? 'Yönetim') ?> | <?= e(site_name()) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/admin.css') ?>?v=4">
    <style>:root{--primary:<?= e(theme('primary_color', '#F5A623')) ?>}</style>
</head>
<body>
<div class="admin">
    <aside class="sidebar" id="sidebar">
        <div class="sidebar__brand">
            <span class="sidebar__mark"><?= icon('excavator', 24) ?></span>
            <b><?= e($siteName ?? site_name()) ?></b>
        </div>
        <nav class="sidebar__nav">
            <?php foreach ($nav as [$path, $label, $ic]): ?>
                <?php $active = $cur === '/' . $path || ($path !== 'yonetim' && str_starts_with($cur, '/' . $path)); ?>
                <a href="<?= base_url($path) ?>" class="sidebar__link<?= $active ? ' is-active' : '' ?>"><?= icon($ic, 18) ?> <span><?= e($label) ?></span></a>
                <?php if ($path === 'yonetim/lisans' && str_starts_with($cur, '/yonetim/lisans')): ?>
                    <div class="sidebar__sub">
                        <a href="<?= base_url('yonetim/lisans') ?>" class="<?= $cur === '/yonetim/lisans' ? 'is-active' : '' ?>">Lisans Durumu</a>
                        <a href="<?= base_url('yonetim/lisans/aktif-et') ?>" class="<?= $cur === '/yonetim/lisans/aktif-et' ? 'is-active' : '' ?>">Lisans Aktif Et</a>
                        <a href="<?= base_url('yonetim/lisans/degistir') ?>" class="<?= $cur === '/yonetim/lisans/degistir' ? 'is-active' : '' ?>">Lisans Değiştir</a>
                        <a href="<?= base_url('yonetim/lisans/dogrula') ?>">Yeniden Doğrula</a>
                        <a href="<?= base_url('yonetim/lisans/sunucu-testi') ?>" class="<?= $cur === '/yonetim/lisans/sunucu-testi' ? 'is-active' : '' ?>">Sunucu Testi</a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <a href="<?= base_url('yonetim/cikis') ?>" class="sidebar__link sidebar__link--out"><?= icon('x', 18) ?> <span>Çıkış</span></a>
        </nav>
    </aside>

    <div class="admin__main">
        <header class="admin__top">
            <button class="admin__toggle" id="sidebar-toggle"><?= icon('menu', 22) ?></button>
            <div class="admin__title"><h1><?= e($pageTitle ?? 'Dashboard') ?></h1></div>
            <div class="admin__actions">
                <a href="<?= base_url() ?>" target="_blank" class="btn-ghost"><?= icon('arrow-right', 16) ?> Siteyi Gör</a>
                <div class="admin__user">
                    <span class="admin__avatar"><?= e(mb_substr($adminUser['name'] ?? 'A', 0, 1)) ?></span>
                    <span><?= e($adminUser['name'] ?? 'Yönetici') ?></span>
                </div>
            </div>
        </header>

        <main class="admin__content">
            <?php if (!empty($flashOk)): ?><div class="a-flash a-flash--ok"><?= icon('check-circle', 18) ?> <?= e($flashOk) ?></div><?php endif; ?>
            <?php if (!empty($flashErr)): ?><div class="a-flash a-flash--err"><?= icon('x', 18) ?> <?= e($flashErr) ?></div><?php endif; ?>
            <?php if (!empty($licenseStatus) && ($licenseStatus['state'] ?? '') === 'grace' && !str_starts_with($cur, '/yonetim/lisans')): ?>
                <div class="a-flash" style="background:#fef3c7;color:#b45309;border:1px solid #fde68a">
                    <?= icon('shield', 18) ?> Lisans sunucusuna ulaşılamadı. Sistem grace period içinde çalışıyor.
                    Kalan süre: <strong><?= (int) ($licenseStatus['grace_remaining_days'] ?? 0) ?> gün</strong>.
                    <a href="<?= base_url('yonetim/lisans') ?>" style="color:inherit;text-decoration:underline;font-weight:600;margin-left:6px">Detay</a>
                </div>
            <?php endif; ?>
            <?= $content ?>
        </main>
    </div>
</div>
<div class="sidebar__overlay" id="sidebar-overlay"></div>
<script>
document.getElementById('sidebar-toggle').addEventListener('click',function(){document.getElementById('sidebar').classList.toggle('is-open');document.getElementById('sidebar-overlay').classList.toggle('is-open')});
document.getElementById('sidebar-overlay').addEventListener('click',function(){document.getElementById('sidebar').classList.remove('is-open');this.classList.remove('is-open')});
</script>
</body>
</html>
