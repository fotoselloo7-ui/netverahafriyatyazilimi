<div class="a-card">
    <div class="a-card__head"><h2>Makine Parkuru (<?= count($items) ?>)</h2><a href="<?= base_url('yonetim/makine/yeni') ?>" class="btn btn--primary btn--sm"><?= icon('plus', 15) ?> Yeni Makine</a></div>
    <?php if (!$items): ?><div class="empty">Henüz makine yok.</div><?php else: ?>
    <table class="a-table">
        <thead><tr><th>Görsel</th><th>Başlık</th><th>Kullanım</th><th>Sıra</th><th>Durum</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($items as $m): ?>
            <tr>
                <td><?php if ($m['image']): ?><img src="<?= e(upload_url($m['image'])) ?>" style="width:56px;height:40px;object-fit:cover;border-radius:6px"><?php else: ?><span class="tag tag--off">-</span><?php endif; ?></td>
                <td><strong><?= e($m['title']) ?></strong></td>
                <td><small><?= e($m['usage_area']) ?></small></td>
                <td><?= (int) $m['sort_order'] ?></td>
                <td><span class="tag <?= $m['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $m['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                <td class="actions">
                    <a href="<?= base_url('yonetim/makine/' . $m['id']) ?>" class="btn btn--light btn--sm">Düzenle</a>
                    <form method="post" action="<?= base_url('yonetim/makine/' . $m['id'] . '/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><button class="btn btn--danger btn--sm"><?= icon('x', 14) ?></button></form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>
