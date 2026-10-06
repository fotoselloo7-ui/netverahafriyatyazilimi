<div class="a-grid a-grid--4" style="margin-bottom:24px">
    <div class="stat"><span class="stat__ico"><?= icon('send', 24) ?></span><div><b><?= $stats['leads'] ?></b><span>Toplam Teklif</span></div></div>
    <div class="stat"><span class="stat__ico" style="background:rgba(29,78,216,.12);color:#1d4ed8"><?= icon('message-circle', 24) ?></span><div><b><?= $stats['leads_new'] ?></b><span>Yeni Teklif</span></div></div>
    <div class="stat"><span class="stat__ico" style="background:rgba(22,163,74,.12);color:#16a34a"><?= icon('whatsapp', 24) ?></span><div><b><?= $stats['wa_clicks'] ?></b><span>WhatsApp Tıklama</span></div></div>
    <div class="stat"><span class="stat__ico"><?= icon('git-branch', 24) ?></span><div><b><?= $stats['services'] ?></b><span>Aktif Hizmet</span></div></div>
</div>

<div class="a-grid a-grid--4" style="margin-bottom:24px">
    <div class="stat"><span class="stat__ico"><?= icon('award', 24) ?></span><div><b><?= $stats['projects'] ?></b><span>Proje</span></div></div>
    <div class="stat"><span class="stat__ico"><?= icon('truck', 24) ?></span><div><b><?= $stats['equipment'] ?></b><span>Makine</span></div></div>
    <div class="stat"><span class="stat__ico"><?= icon('message-circle', 24) ?></span><div><b><?= $stats['posts'] ?></b><span>Blog Yazısı</span></div></div>
    <div class="stat"><span class="stat__ico"><?= icon('search', 24) ?></span><div><b><?= $stats['gallery'] ?></b><span>Galeri Görseli</span></div></div>
</div>

<div class="a-grid a-grid--2">
    <div class="a-card">
        <div class="a-card__head"><h2>Son Teklifler</h2><a href="<?= base_url('yonetim/teklifler') ?>" class="btn btn--light btn--sm">Tümü</a></div>
        <?php if (!$recentLeads): ?><div class="empty">Henüz teklif yok.</div><?php else: ?>
        <table class="a-table">
            <thead><tr><th>Ad</th><th>Telefon</th><th>Hizmet</th><th>Durum</th></tr></thead>
            <tbody>
            <?php foreach ($recentLeads as $l): ?>
                <tr>
                    <td><a href="<?= base_url('yonetim/teklifler/' . $l['id']) ?>"><strong><?= e($l['name']) ?></strong></a></td>
                    <td><?= e($l['phone']) ?></td>
                    <td><?= e($l['service_type'] ?: '-') ?></td>
                    <td><span class="tag <?= $l['status'] === 'new' ? 'tag--new' : 'tag--off' ?>"><?= e($l['status']) ?></span></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2>Son Etkinlikler</h2></div>
        <?php if (!$recentEvents): ?><div class="empty">Henüz etkinlik yok.</div><?php else: ?>
        <table class="a-table">
            <thead><tr><th>Olay</th><th>Sayfa</th><th>Tarih</th></tr></thead>
            <tbody>
            <?php foreach ($recentEvents as $ev): ?>
                <tr>
                    <td><span class="tag tag--warn"><?= e($ev['event_type']) ?></span></td>
                    <td><small><?= e(str_excerpt($ev['page_url'], 30)) ?></small></td>
                    <td><small><?= e(date('d.m H:i', strtotime($ev['created_at'] ?? 'now'))) ?></small></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div class="a-card">
    <div class="a-card__head"><h2>Hızlı İşlemler</h2></div>
    <div style="display:flex;gap:12px;flex-wrap:wrap">
        <a href="<?= base_url('yonetim/hizmetler/yeni') ?>" class="btn btn--primary"><?= icon('plus', 16) ?> Hizmet Ekle</a>
        <a href="<?= base_url('yonetim/blog/yeni') ?>" class="btn btn--dark"><?= icon('plus', 16) ?> Blog Yazısı</a>
        <a href="<?= base_url('yonetim/projeler/yeni') ?>" class="btn btn--dark"><?= icon('plus', 16) ?> Proje Ekle</a>
        <a href="<?= base_url('yonetim/tema') ?>" class="btn btn--light"><?= icon('tag', 16) ?> Tema Renkleri</a>
        <a href="<?= base_url('yonetim/ayarlar') ?>" class="btn btn--light"><?= icon('settings', 16) ?> Genel Ayarlar</a>
    </div>
</div>
