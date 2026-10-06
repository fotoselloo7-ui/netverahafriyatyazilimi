<div class="a-card">
    <div class="a-card__head">
        <h2>Teklifler (<?= (int) $total ?>)</h2>
        <a href="<?= base_url('yonetim/teklifler/disa-aktar') ?>" class="btn btn--dark btn--sm"><?= icon('arrow-right', 14) ?> CSV İndir</a>
    </div>
    <form method="get" style="display:flex;gap:10px;margin-bottom:16px;flex-wrap:wrap">
        <input type="text" name="q" value="<?= e($search) ?>" placeholder="Ara: ad, telefon, mesaj" style="flex:1;min-width:200px;padding:9px 12px;border:1px solid var(--line);border-radius:9px">
        <select name="durum" style="padding:9px 12px;border:1px solid var(--line);border-radius:9px">
            <?php foreach (['' => 'Tüm Durumlar', 'new' => 'Yeni', 'contacted' => 'İletişime Geçildi', 'closed' => 'Kapandı'] as $k => $v): ?>
                <option value="<?= $k ?>" <?= $status === $k ? 'selected' : '' ?>><?= $v ?></option>
            <?php endforeach; ?>
        </select>
        <button class="btn btn--primary btn--sm"><?= icon('search', 14) ?> Filtrele</button>
    </form>

    <?php if (!$rows): ?><div class="empty">Kayıt bulunamadı.</div><?php else: ?>
    <table class="a-table">
        <thead><tr><th>Ad</th><th>Telefon</th><th>Hizmet</th><th>Bölge</th><th>Kaynak</th><th>Durum</th><th>Tarih</th><th></th></tr></thead>
        <tbody>
        <?php foreach ($rows as $l): ?>
            <tr>
                <td><strong><?= e($l['name']) ?></strong></td>
                <td><a href="tel:<?= e($l['phone']) ?>"><?= e($l['phone']) ?></a></td>
                <td><?= e($l['service_type'] ?: '-') ?></td>
                <td><?= e($l['region'] ?: '-') ?></td>
                <td><small><?= e($l['source']) ?></small></td>
                <td><span class="tag <?= $l['status'] === 'new' ? 'tag--new' : 'tag--off' ?>"><?= e($l['status']) ?></span></td>
                <td><small><?= e(date('d.m.Y H:i', strtotime($l['created_at'] ?? 'now'))) ?></small></td>
                <td class="actions"><a href="<?= base_url('yonetim/teklifler/' . $l['id']) ?>" class="btn btn--light btn--sm">Detay</a></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <?php if ($pages > 1): ?>
    <div style="display:flex;gap:6px;margin-top:16px;flex-wrap:wrap">
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="<?= base_url('yonetim/teklifler?sayfa=' . $i . '&q=' . urlencode($search) . '&durum=' . urlencode($status)) ?>" class="btn <?= $i === $page ? 'btn--primary' : 'btn--light' ?> btn--sm"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>
