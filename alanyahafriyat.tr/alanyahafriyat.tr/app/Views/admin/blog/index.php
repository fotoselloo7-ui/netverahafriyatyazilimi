<div class="a-grid a-grid--2" style="align-items:start">
    <div class="a-card">
        <div class="a-card__head"><h2>Blog Yazıları (<?= count($posts) ?>)</h2><a href="<?= base_url('yonetim/blog/yeni') ?>" class="btn btn--primary btn--sm"><?= icon('plus', 15) ?> Yeni Yazı</a></div>
        <?php if (!$posts): ?><div class="empty">Henüz yazı yok.</div><?php else: ?>
        <table class="a-table">
            <thead><tr><th>Başlık</th><th>Kategori</th><th>Durum</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($posts as $p): ?>
                <tr>
                    <td><strong><?= e(str_excerpt($p['title'], 45)) ?></strong><br><small><?= e($p['slug']) ?></small></td>
                    <td><?= e($p['category_title'] ?: '-') ?></td>
                    <td><span class="tag <?= $p['status'] === 'published' ? 'tag--ok' : 'tag--warn' ?>"><?= $p['status'] === 'published' ? 'Yayında' : 'Taslak' ?></span></td>
                    <td class="actions">
                        <a href="<?= base_url('yonetim/blog/' . $p['id']) ?>" class="btn btn--light btn--sm">Düzenle</a>
                        <form method="post" action="<?= base_url('yonetim/blog/' . $p['id'] . '/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><button class="btn btn--danger btn--sm"><?= icon('x', 14) ?></button></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="a-card">
        <div class="a-card__head"><h2>Kategoriler</h2></div>
        <table class="a-table" style="margin-bottom:16px">
            <tbody>
            <?php foreach ($categories as $c): ?>
                <tr><td><strong><?= e($c['title']) ?></strong></td><td><small><?= e($c['slug']) ?></small></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <form method="post" action="<?= base_url('yonetim/blog-kategori/kaydet') ?>">
            <?= csrf_field() ?>
            <div class="a-field"><label>Yeni Kategori</label><input type="text" name="title" placeholder="Kategori adı" required></div>
            <div class="a-field"><label>Açıklama</label><input type="text" name="description"></div>
            <button class="btn btn--dark btn--sm"><?= icon('plus', 14) ?> Kategori Ekle</button>
        </form>
    </div>
</div>
