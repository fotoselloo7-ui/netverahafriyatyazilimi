<?php
/** Lisans ekranları ortak sekme çubuğu. $licTab: durum|aktif-et|degistir|sunucu-testi */
$licTab = $licTab ?? 'durum';
$tabs = [
    'durum'        => ['Lisans Durumu', 'yonetim/lisans'],
    'aktif-et'     => ['Lisans Aktif Et', 'yonetim/lisans/aktif-et'],
    'degistir'     => ['Lisans Değiştir', 'yonetim/lisans/degistir'],
    'sunucu-testi' => ['Sunucu Testi', 'yonetim/lisans/sunucu-testi'],
];
?>
<div class="lic-tabs">
    <?php foreach ($tabs as $key => [$label, $url]): ?>
        <a href="<?= base_url($url) ?>" class="lic-tab<?= $licTab === $key ? ' is-active' : '' ?>"><?= e($label) ?></a>
    <?php endforeach; ?>
    <form method="post" action="<?= base_url('yonetim/lisans/dogrula') ?>" class="lic-tab-form" title="Bu işlem lisans sunucusuna bağlanarak mevcut lisansı tekrar kontrol eder.">
        <?= csrf_field() ?>
        <button type="submit" class="lic-tab lic-tab--action"><?= icon('search', 14) ?> Yeniden Doğrula</button>
    </form>
</div>
<style>
.lic-tabs{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:20px;border-bottom:2px solid var(--line);padding-bottom:0}
.lic-tab{display:inline-flex;align-items:center;gap:6px;padding:10px 16px;font-size:13.5px;font-weight:600;color:#6b7280;border:1px solid transparent;border-bottom:none;border-radius:9px 9px 0 0;position:relative;top:2px;background:transparent;cursor:pointer;font-family:inherit}
.lic-tab:hover{color:#1f2430;background:#f3f4f6}
.lic-tab.is-active{color:var(--primary);background:#fff;border-color:var(--line);border-bottom:2px solid #fff}
.lic-tab--action{color:#1d4ed8;background:#eff6ff;border-radius:9px;top:0;margin-left:auto;border:1px solid #bfdbfe}
.lic-tab--action:hover{background:#dbeafe;color:#1d4ed8}
.lic-tab-form{margin-left:auto;display:flex}
</style>
