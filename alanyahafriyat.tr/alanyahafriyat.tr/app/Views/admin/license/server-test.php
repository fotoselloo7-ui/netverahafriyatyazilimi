<?php
$licTab = 'sunucu-testi';
include VIEW_PATH . '/admin/license/_tabs.php';
$epLabels = ['health' => 'Health / Test', 'verify' => 'Verify', 'activate' => 'Activate', 'heartbeat' => 'Heartbeat'];
$stateBadges = [
    'success'      => ['tag--ok', 'BAŞARILI'],
    'timeout'      => ['tag--off', 'ZAMAN AŞIMI'],
    'not_found'    => ['tag--off', '404 — ENDPOINT BULUNAMADI'],
    'unreachable'  => ['tag--off', 'API BAĞLANTISI KURULAMADI'],
    'bad_format'   => ['tag--warn', 'YANIT VAR — FORMAT HATALI'],
    'http_error'   => ['tag--warn', 'HTTP HATASI'],
    'unconfigured' => ['tag--warn', 'BASE URL BOŞ'],
];
$renderCheck = function (array $c) use ($stateBadges, $epLabels) {
    $b = $stateBadges[$c['state'] ?? ''] ?? ['tag--off', $c['state'] ?? '-'];
    ?>
    <tr>
        <td><strong><?= e($epLabels[$c['name']] ?? $c['name']) ?></strong><br><small><code><?= e($c['url'] ?: '—') ?></code></small></td>
        <td><span class="tag <?= $b[0] ?>"><?= e($b[1]) ?></span></td>
        <td><?= (int) ($c['ms'] ?? 0) ?> ms</td>
        <td><small><?= e($c['detail'] ?? '') ?></small></td>
    </tr>
    <?php
};
?>
<div class="a-card" style="max-width:860px">
    <div class="a-card__head"><h2><?= icon('git-branch', 18) ?> Lisans Sunucusu Testi</h2><a href="<?= base_url('yonetim/lisans') ?>" class="btn btn--light btn--sm">&larr; Lisans Durumu</a></div>
    <p class="help">Lisans sunucusu ve API uçlarının erişilebilirliğini kontrol eder. Bu test <strong>yalnızca bağlantı/uç kontrolüdür</strong> — lisans aktive etmez. Sonuçlar lisans loglarına kaydedilir. API secret ve lisans anahtarı görüntülenmez.</p>

    <table class="a-table" style="margin-bottom:18px">
        <tr><th style="width:180px">Lisans Sunucusu</th><td><?= $baseUrl !== '' ? '<a href="' . e($baseUrl) . '" target="_blank" rel="noopener noreferrer"><code>' . e($baseUrl) . '</code></a>' : '<span class="tag tag--off">Yapılandırılmadı — .env içinde DIGIKEY_BASE_URL girin</span>' ?></td></tr>
        <tr><th>Product Slug</th><td><code><?= e($productSlug) ?></code></td></tr>
        <tr><th>Domain (normalize)</th><td><code><?= e($domain) ?></code></td></tr>
        <tr><th>Zaman Aşımı</th><td><?= (int) $timeout ?> sn</td></tr>
        <tr><th>API Secret</th><td><?= $hasSecret ? '<span class="tag tag--ok">Tanımlı</span>' : '<span class="tag tag--warn">Boş — imzalı istekler reddedilebilir</span>' ?></td></tr>
        <tr><th>Çalışma Modu</th><td><code><?= e($mode) ?></code></td></tr>
    </table>

    <div class="a-card__head" style="margin-bottom:10px"><h2 style="font-size:15px"><?= icon('map-pin', 16) ?> Lisans Kontrol Linkleri / Uç Testleri</h2></div>
    <table class="a-table" style="margin-bottom:18px">
        <thead><tr><th>Uç</th><th>Endpoint</th><th style="width:150px"></th></tr></thead>
        <tbody>
        <?php foreach ($epLabels as $key => $label): ?>
            <tr>
                <td><strong><?= e($label) ?></strong></td>
                <td><small><code><?= e($endpoints[$key] ?: '—') ?></code></small></td>
                <td>
                    <form method="post" action="<?= base_url('yonetim/lisans/sunucu-testi') ?>" style="display:inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="endpoint" value="<?= e($key) ?>">
                        <button type="submit" class="btn btn--light btn--sm" <?= $baseUrl === '' ? 'disabled' : '' ?>><?= icon('zap', 13) ?> Kontrol Et</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <form method="post" action="<?= base_url('yonetim/lisans/sunucu-testi') ?>">
        <?= csrf_field() ?>
        <button type="submit" class="btn btn--primary" <?= $baseUrl === '' ? 'disabled title="Önce DIGIKEY_BASE_URL ayarlayın"' : '' ?>><?= icon('zap', 16) ?> Lisans Sunucusunu Test Et (tüm uçlar)</button>
    </form>

    <?php if ($single !== null): ?>
        <div style="margin-top:22px">
            <div class="section-title">Uç Testi Sonucu</div>
            <table class="a-table"><thead><tr><th>Uç</th><th>Sonuç</th><th>Süre</th><th>Detay</th></tr></thead><tbody>
                <?php $renderCheck($single); ?>
            </tbody></table>
        </div>
    <?php endif; ?>

    <?php if ($result !== null): ?>
        <?php
        $overall = [
            'success'      => ['tag--ok', 'BAŞARILI — sunucu erişilebilir'],
            'timeout'      => ['tag--off', 'ZAMAN AŞIMI'],
            'unreachable'  => ['tag--off', 'ULAŞILAMADI'],
            'unconfigured' => ['tag--warn', 'BASE URL BOŞ'],
        ][$result['state']] ?? ['tag--off', $result['state']];
        ?>
        <div style="margin-top:22px">
            <div class="section-title">Genel Test Sonucu: <span class="tag <?= $overall[0] ?>"><?= e($overall[1]) ?></span></div>
            <?php if (!empty($result['message'])): ?><p class="help"><?= e($result['message']) ?></p><?php endif; ?>
            <?php if (!empty($result['checks'])): ?>
            <table class="a-table"><thead><tr><th>Uç</th><th>Sonuç</th><th>Süre</th><th>Detay</th></tr></thead><tbody>
                <?php foreach ($result['checks'] as $c) { $renderCheck($c); } ?>
            </tbody></table>
            <?php endif; ?>
            <?php foreach (($result['warnings'] ?? []) as $w): ?>
                <div class="a-flash" style="background:#fef3c7;color:#b45309;border:1px solid #fde68a;margin-top:12px"><?= icon('shield', 16) ?> <?= e($w) ?></div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
