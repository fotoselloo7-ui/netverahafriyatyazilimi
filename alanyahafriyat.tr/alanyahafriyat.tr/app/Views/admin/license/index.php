<?php
$state = $status['state'] ?? 'local';
/* [tag sınıfı, etiket, vurgu rengi] */
$badges = [
    'local'            => ['tag--warn', 'YEREL GELİŞTİRME MODU', '#0369a1'],
    'active'           => ['tag--ok', 'AKTİF', '#16a34a'],
    'grace'            => ['tag--warn', 'GRACE PERIOD (ÇEVRİMDIŞI)', '#d97706'],
    'needs_activation' => ['tag--warn', 'LİSANS YOK — AKTİVASYON GEREKLİ', '#ea580c'],
    'unconfigured'     => ['tag--off', 'SUNUCU YAPILANDIRILMAMIŞ', '#6b7280'],
    'suspended'        => ['tag--off', 'ASKIYA ALINMIŞ', '#dc2626'],
    'expired'          => ['tag--off', 'SÜRESİ DOLMUŞ', '#dc2626'],
    'domain_mismatch'  => ['tag--warn', 'DOMAIN UYUŞMAZLIĞI', '#ea580c'],
    'invalid'          => ['tag--off', 'GEÇERSİZ', '#dc2626'],
    'unreachable'      => ['tag--off', 'API ERİŞİLEMİYOR', '#ea580c'],
    'grace_expired'    => ['tag--off', 'GRACE SÜRESİ DOLDU', '#dc2626'],
];
$badge = $badges[$state] ?? ['tag--off', mb_strtoupper($state), '#6b7280'];
$supportWa = whatsapp_link('Merhaba, ' . site_name() . ' yazılımı lisansı hakkında destek almak istiyorum.');
$customer = $payload['customer'] ?? [];
$licInfo = $payload['license'] ?? [];
$licTab = 'durum';
include VIEW_PATH . '/admin/license/_tabs.php';
?>

<?php /* ---- Üst durum kartı ---- */ ?>
<div class="lic-hero" style="--lic-accent:<?= $badge[2] ?>">
    <div class="lic-hero__icon"><?= icon('shield', 30) ?></div>
    <div class="lic-hero__main">
        <div class="lic-hero__state"><?= e($badge[1]) ?></div>
        <div class="lic-hero__sub">
            <?php if ($state === 'active'): ?>Lisansınız geçerli — sistem tam yetkiyle çalışıyor.
            <?php elseif ($state === 'grace'): ?>Lisans sunucusuna ulaşılamıyor; sistem çevrimdışı çalışma süresi içinde. Kalan: <strong><?= (int) ($status['grace_remaining_days'] ?? 0) ?> gün</strong>.
            <?php elseif ($state === 'needs_activation'): ?>Bu kurulum için henüz lisans anahtarı girilmedi. "Lisans Aktif Et" sekmesinden anahtarınızı girin.
            <?php elseif ($state === 'local'): ?>Yerel geliştirme modu (<code>DIGIKEY_ENV=local</code>) — lisans kilidi uygulanmıyor. Canlıda bu satırı kaldırın veya <code>production</code> yapın.
            <?php elseif ($state === 'unconfigured'): ?><code>.env</code> içinde <code>DIGIKEY_BASE_URL</code> tanımlanmalı — lisans sunucusu belirtilmeden doğrulama yapılamaz.
            <?php elseif ($state === 'domain_mismatch'): ?>Bu lisans bu alan adı için tanımlı değil (<code><?= e($domain) ?></code>).
            <?php elseif (!empty($status['message'])): ?><?= e($status['message']) ?>
            <?php else: ?>Lisans doğrulanamadı. Destek ile iletişime geçin.<?php endif; ?>
        </div>
    </div>
    <span class="tag <?= $badge[0] ?>" style="flex:none"><?= e($badge[1]) ?></span>
</div>

<div class="a-grid a-grid--2" style="align-items:start;grid-template-columns:1.35fr 1fr">
    <?php /* ---- Sol: lisans bilgileri ---- */ ?>
    <div class="a-card">
        <div class="a-card__head"><h2><?= icon('clipboard', 18) ?> Lisans Bilgileri</h2></div>
        <table class="a-table">
            <tr><th style="width:170px">Ürün</th><td><?= e(($payload['product']['name'] ?? '') ?: site_name()) ?></td></tr>
            <tr><th>Product Slug</th><td><code><?= e($productSlug) ?></code></td></tr>
            <tr><th>Yazılım Sürümü</th><td>v<?= e($appVersion) ?></td></tr>
            <tr><th>Çalışma Modu</th><td><?= $mode === 'production' ? '<span class="tag tag--ok">production</span>' : '<span class="tag tag--warn">local (geliştirme)</span>' ?></td></tr>
            <tr><th>Alan Adı (Domain)</th><td><code><?= e($domain) ?></code></td></tr>
            <tr><th>Lisans Anahtarı</th><td><?= $maskedKey !== '' ? '<code>' . e($maskedKey) . '</code>' : '<span class="tag tag--off">Girilmedi</span>' ?></td></tr>
            <?php if (!empty($customer['name'] ?? '')): ?><tr><th>Lisans Sahibi</th><td><?= e($customer['name']) ?></td></tr><?php endif; ?>
            <?php if (!empty($status['expires_at'] ?? ($licInfo['expires_at'] ?? ''))): ?>
                <tr><th>Bitiş Tarihi</th><td><?= e($status['expires_at'] ?? $licInfo['expires_at']) ?></td></tr>
            <?php endif; ?>
            <tr><th>Son Doğrulama</th><td><?= $lastVerified !== '' ? e($lastVerified) : '—' ?></td></tr>
            <tr><th>Son Heartbeat</th><td><?= $lastHeartbeat !== '' ? e($lastHeartbeat) : '—' ?></td></tr>
            <tr><th>Grace Bitişi</th><td><?= $graceUntil !== '' ? e($graceUntil) : '—' ?><?php if ($state === 'grace'): ?> <span class="tag tag--warn">kalan <?= (int) ($status['grace_remaining_days'] ?? 0) ?> gün</span><?php endif; ?></td></tr>
            <tr><th>Doğrulama Aralığı</th><td><?= (int) $verifyHours ?> saat (önbellekli)</td></tr>
            <tr><th>Grace Süresi</th><td><?= (int) $graceDays ?> gün</td></tr>
            <tr><th>Önbellek (HMAC)</th><td>
                <?php if ($cacheState === 'valid'): ?><span class="tag tag--ok">Geçerli</span> <small><?= e($cacheAt) ?></small>
                <?php elseif ($cacheState === 'invalid'): ?><span class="tag tag--off">Geçersiz (imza bozuk)</span>
                <?php else: ?><span class="tag tag--off">Yok</span><?php endif; ?>
            </td></tr>
        </table>
    </div>

    <?php /* ---- Sağ: hızlı işlemler + lisans kontrol linkleri ---- */ ?>
    <div>
        <div class="a-card">
            <div class="a-card__head"><h2><?= icon('zap', 18) ?> Hızlı İşlemler</h2></div>
            <div class="lic-actions">
                <a href="<?= base_url('yonetim/lisans/aktif-et') ?>" class="btn btn--primary btn--block"><?= icon('check', 15) ?> <?= $maskedKey === '' ? 'Lisans Aktif Et' : 'Yeni Anahtar Gir' ?></a>
                <a href="<?= base_url('yonetim/lisans/degistir') ?>" class="btn btn--light btn--block"><?= icon('settings', 15) ?> Lisans Değiştir</a>
                <form method="post" action="<?= base_url('yonetim/lisans/dogrula') ?>">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn--dark btn--block"><?= icon('search', 15) ?> Yeniden Doğrula</button>
                </form>
                <small style="color:var(--muted);display:block;margin:-4px 0 6px">Bu işlem lisans sunucusuna bağlanarak mevcut lisansı tekrar kontrol eder (24 saatlik önbelleği atlar).</small>
                <a href="<?= base_url('yonetim/lisans/sunucu-testi') ?>" class="btn btn--light btn--block"><?= icon('git-branch', 15) ?> Sunucuyu Test Et</a>
                <a href="<?= e($supportWa) ?>" target="_blank" rel="noopener" class="btn btn--light btn--block" style="color:#16a34a"><?= icon('whatsapp', 15) ?> Destek Al</a>
            </div>
        </div>

        <div class="a-card">
            <div class="a-card__head"><h2><?= icon('git-branch', 18) ?> Lisans Kontrol Linkleri</h2></div>
            <?php if ($baseUrl === ''): ?>
                <div class="a-flash a-flash--err" style="margin-bottom:0"><?= icon('x', 16) ?> Lisans sunucusu yapılandırılmamış — <code>.env</code> içinde <code>DIGIKEY_BASE_URL</code> girin.</div>
            <?php else: ?>
                <table class="a-table">
                    <tr><th style="width:110px">Sunucu</th><td><a href="<?= e($baseUrl) ?>" target="_blank" rel="noopener noreferrer"><small><?= e($baseUrl) ?></small></a></td></tr>
                    <tr><th>Health</th><td><small><code><?= e($endpoints['health']) ?></code></small></td></tr>
                    <tr><th>Verify</th><td><small><code><?= e($endpoints['verify']) ?></code></small></td></tr>
                    <tr><th>Activate</th><td><small><code><?= e($endpoints['activate']) ?></code></small></td></tr>
                    <tr><th>Heartbeat</th><td><small><code><?= e($endpoints['heartbeat']) ?></code></small></td></tr>
                </table>
                <small style="color:var(--muted)">Uçların erişilebilirliğini "Sunucuyu Test Et" ekranından kontrol edebilirsiniz. API secret ve lisans anahtarı hiçbir zaman görüntülenmez.</small>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php /* ---- Alt: loglar ---- */ ?>
<div class="a-card">
    <div class="a-card__head"><h2><?= icon('layers', 18) ?> Lisans Logları</h2></div>
    <?php if (!$logs): ?><div class="empty">Henüz lisans olayı kaydedilmedi.</div><?php else: ?>
    <table class="a-table">
        <thead><tr><th>Olay</th><th>Durum</th><th>Mesaj</th><th>İstek URL</th><th>Tarih</th></tr></thead>
        <tbody>
        <?php foreach ($logs as $log): ?>
            <tr>
                <td><span class="tag tag--new"><?= e($log['event_type']) ?></span></td>
                <td><span class="tag <?= in_array($log['status'] ?? '', ['active', 'success'], true) ? 'tag--ok' : 'tag--warn' ?>"><?= e($log['status'] ?? '-') ?></span></td>
                <td><small><?= e(str_excerpt($log['message'] ?? '', 60)) ?></small></td>
                <td><small><?= e(str_excerpt($log['request_url'] ?? '', 34)) ?></small></td>
                <td><small><?= e(date('d.m.Y H:i', strtotime($log['created_at'] ?? 'now'))) ?></small></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<style>
.lic-hero{display:flex;align-items:center;gap:16px;background:#fff;border:1px solid var(--line);border-left:5px solid var(--lic-accent,#6b7280);border-radius:14px;padding:18px 22px;margin-bottom:20px}
.lic-hero__icon{width:56px;height:56px;flex:none;display:grid;place-items:center;border-radius:14px;background:color-mix(in srgb,var(--lic-accent) 14%,#fff);color:var(--lic-accent)}
.lic-hero__main{flex:1;min-width:0}
.lic-hero__state{font-weight:700;font-size:15px;color:var(--lic-accent);letter-spacing:.4px}
.lic-hero__sub{font-size:13.5px;color:#4b5563;margin-top:2px}
.lic-actions{display:grid;gap:10px}
</style>
