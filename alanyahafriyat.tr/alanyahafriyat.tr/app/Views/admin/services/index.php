<div class="a-card">
    <div class="a-card__head"><h2>Hizmetler (<?= count($services) ?>)</h2><a href="<?= base_url('yonetim/hizmetler/yeni') ?>" class="btn btn--primary btn--sm"><?= icon('plus', 15) ?> Yeni Hizmet</a></div>
    <?php if (!$services): ?><div class="empty">Henüz hizmet yok.</div><?php else: ?>
    <table class="a-table">
        <thead><tr><th>Başlık</th><th>Slug</th><th>Sıra</th><th>Öne Çıkan</th><th>Durum</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($services as $s): ?>
            <tr>
                <td><strong><?= e($s['title']) ?></strong></td>
                <td><small><?= e($s['slug']) ?></small></td>
                <td><?= (int) $s['sort_order'] ?></td>
                <td><?= $s['is_featured'] ? '<span class="tag tag--ok">Evet</span>' : '<span class="tag tag--off">Hayır</span>' ?></td>
                <td><span class="tag <?= $s['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $s['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                <td class="actions">
                    <a href="<?= base_url('yonetim/hizmetler/' . $s['id']) ?>" class="btn btn--light btn--sm">Düzenle</a>
                    <form method="post" action="<?= base_url('yonetim/hizmetler/' . $s['id'] . '/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><button class="btn btn--danger btn--sm"><?= icon('x', 14) ?></button></form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
