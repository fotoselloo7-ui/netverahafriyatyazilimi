<div class="a-card">
    <div class="a-card__head"><h2>Sayfalar (<?= count($pages) ?>)</h2><a href="<?= base_url('yonetim/sayfalar/yeni') ?>" class="btn btn--primary btn--sm"><?= icon('plus', 15) ?> Yeni Sayfa</a></div>
    <table class="a-table">
        <thead><tr><th>Başlık</th><th>Slug</th><th>Durum</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($pages as $p): ?>
            <tr>
                <td><strong><?= e($p['title']) ?></strong></td>
                <td><small><a href="<?= base_url('sayfa/' . $p['slug']) ?>" target="_blank"><?= e($p['slug']) ?></a></small></td>
                <td><span class="tag <?= $p['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $p['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                <td class="actions">
                    <a href="<?= base_url('yonetim/sayfalar/' . $p['id']) ?>" class="btn btn--light btn--sm">Düzenle</a>
                    <?php if (!in_array($p['slug'], ['hakkimizda'], true)): ?>
                    <form method="post" action="<?= base_url('yonetim/sayfalar/' . $p['id'] . '/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><button class="btn btn--danger btn--sm"><?= icon('x', 13) ?></button></form>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
