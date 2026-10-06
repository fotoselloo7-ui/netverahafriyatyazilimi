<div class="a-card">
    <div class="a-card__head"><h2>Ana Sayfa Bölümleri</h2></div>
    <p class="help">Her bölümü düzenleyebilir, aktif/pasif yapabilir ve sıralayabilirsiniz.</p>
    <table class="a-table">
        <thead><tr><th>Bölüm</th><th>Başlık</th><th>Sıra</th><th>Durum</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($sections as $sec): ?>
            <tr>
                <td><strong><?= e($sec['section_key']) ?></strong></td>
                <td><?= e(str_excerpt($sec['title'], 50)) ?></td>
                <td><?= (int) $sec['sort_order'] ?></td>
                <td><span class="tag <?= $sec['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $sec['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                <td class="actions"><a href="<?= base_url('yonetim/anasayfa/' . $sec['id']) ?>" class="btn btn--light btn--sm"><?= icon('settings', 14) ?> Düzenle</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
