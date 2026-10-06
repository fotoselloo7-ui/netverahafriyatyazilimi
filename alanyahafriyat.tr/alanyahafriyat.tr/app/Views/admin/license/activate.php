<?php
$isChange = !empty($change);
$actionUrl = base_url($isChange ? 'yonetim/lisans/degistir' : 'yonetim/lisans/aktif-et');
$supportWa = whatsapp_link('Merhaba, ' . site_name() . ' yazılımı lisans aktivasyonu için destek almak istiyorum.');
$licTab = $isChange ? 'degistir' : 'aktif-et';
include VIEW_PATH . '/admin/license/_tabs.php';
?>
<div class="a-card" style="max-width:680px">
    <div class="a-card__head">
        <h2><?= icon('shield', 18) ?> <?= $isChange ? 'Lisans Değiştir' : 'Lisans Aktif Et' ?></h2>
        <a href="<?= base_url('yonetim/lisans') ?>" class="btn btn--light btn--sm">&larr; Lisans Durumu</a>
    </div>

    <?php if (!$isChange): ?>
        <p class="help">Yazılım firmanızdan aldığınız <strong>lisans anahtarını</strong> girin. Sistem, anahtarı DijiKey lisans sunucusunda doğrular; başarılı olursa lisans bu alan adına bağlanır, önbellek oluşturulur ve son doğrulama tarihi güncellenir.</p>
    <?php else: ?>
        <p class="help">Yeni anahtar önce lisans sunucusunda <strong>doğrulanır</strong>; yalnızca doğrulama başarılı olursa eski önbellek temizlenir ve yeni lisans kaydedilir. Yeni anahtar geçersiz çıkarsa <strong>mevcut lisansınız aynen korunur</strong>.</p>
        <table class="a-table" style="margin-bottom:18px">
            <tr><th style="width:180px">Mevcut Lisans</th><td><?= !empty($maskedKey) ? '<code>' . e($maskedKey) . '</code>' : '<span class="tag tag--off">Girilmedi</span>' ?></td></tr>
            <?php if (!empty($curState)): ?><tr><th>Mevcut Durum</th><td><span class="tag <?= $curState === 'active' ? 'tag--ok' : 'tag--warn' ?>"><?= e($curState) ?></span></td></tr><?php endif; ?>
            <tr><th>Son Doğrulama</th><td><?= !empty($lastVerified) ? e($lastVerified) : '—' ?></td></tr>
        </table>
    <?php endif; ?>

    <?php if ($mode === 'local'): ?>
        <div class="a-flash" style="background:#e0f2fe;color:#0369a1;border:1px solid #bae6fd;margin-bottom:16px"><?= icon('settings', 16) ?> Yerel geliştirme modu — lisans kilidi uygulanmıyor ama aktivasyon akışı gerçek sunucuya karşı test edilebilir.</div>
    <?php endif; ?>
    <?php if ($baseUrl === ''): ?>
        <div class="a-flash a-flash--err" style="margin-bottom:16px"><?= icon('x', 16) ?> Lisans sunucusu yapılandırılmamış: <code>.env</code> içinde <code>DIGIKEY_BASE_URL</code> ayarlanmalı. Bu ayar yapılmadan aktivasyon gerçekleştirilemez.</div>
    <?php endif; ?>

    <form method="post" action="<?= $actionUrl ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="form_mode" value="<?= $isChange ? 'change' : 'activate' ?>">
        <div class="a-field">
            <label><?= $isChange ? 'Yeni Lisans Anahtarı' : 'Lisans Anahtarı' ?> *</label>
            <input type="text" name="license_key" placeholder="Lisans anahtarınızı girin" required autofocus autocomplete="off" spellcheck="false" style="font-family:monospace;letter-spacing:1px;font-size:15px">
            <small>Anahtar, satın alma sonrası tarafınıza iletilen belgede yer alır.</small>
        </div>
        <div class="a-row">
            <div class="a-field">
                <label>Alan Adı (otomatik)</label>
                <input type="text" value="<?= e($domain) ?>" disabled>
            </div>
            <div class="a-field">
                <label>Product Slug</label>
                <input type="text" value="<?= e($productSlug) ?>" disabled>
            </div>
        </div>
        <div class="a-field">
            <label>Lisans Sunucusu</label>
            <input type="text" value="<?= e($baseUrl ?: '— yapılandırılmadı —') ?>" disabled>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
            <button type="submit" class="btn btn--primary" <?= $baseUrl === '' ? 'disabled title="Önce DIGIKEY_BASE_URL ayarlayın"' : '' ?>><?= icon('check', 16) ?> <?= $isChange ? 'Yeni Lisansı Aktif Et' : 'Lisansı Aktif Et' ?></button>
            <a href="<?= e($supportWa) ?>" target="_blank" rel="noopener" class="btn btn--dark"><?= icon('whatsapp', 15) ?> Destek / WhatsApp</a>
        </div>
    </form>
</div>
