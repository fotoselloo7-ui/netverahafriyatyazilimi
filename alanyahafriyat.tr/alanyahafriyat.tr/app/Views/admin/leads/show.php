<div class="a-grid a-grid--2">
    <div class="a-card">
        <div class="a-card__head"><h2>Teklif Detayı</h2><a href="<?= base_url('yonetim/teklifler') ?>" class="btn btn--light btn--sm">&larr; Liste</a></div>
        <table class="a-table">
            <tr><th style="width:140px">Ad Soyad</th><td><?= e($lead['name']) ?></td></tr>
            <tr><th>Telefon</th><td><a href="tel:<?= e($lead['phone']) ?>"><?= e($lead['phone']) ?></a> &nbsp; <a href="<?= e(whatsapp_link('Merhaba ' . $lead['name'])) ?>" target="_blank" style="color:var(--ok)"><?= icon('whatsapp', 14) ?> WhatsApp</a></td></tr>
            <tr><th>E-posta</th><td><?= e($lead['email'] ?: '-') ?></td></tr>
            <tr><th>Hizmet</th><td><?= e($lead['service_type'] ?: '-') ?></td></tr>
            <tr><th>Bölge</th><td><?= e($lead['region'] ?: '-') ?></td></tr>
            <tr><th>Mesaj</th><td><?= nl2br(e($lead['message'] ?: '-')) ?></td></tr>
            <tr><th>Kaynak</th><td><?= e($lead['source']) ?></td></tr>
            <tr><th>Tarih</th><td><?= e(date('d.m.Y H:i', strtotime($lead['created_at'] ?? 'now'))) ?></td></tr>
        </table>
    </div>
    <div class="a-card">
        <div class="a-card__head"><h2>Durum & Not</h2></div>
        <form method="post" action="<?= base_url('yonetim/teklifler/' . $lead['id']) ?>">
            <?= csrf_field() ?>
            <div class="a-field"><label>Durum</label>
                <select name="status">
                    <?php foreach (['new' => 'Yeni', 'contacted' => 'İletişime Geçildi', 'quoted' => 'Teklif Verildi', 'closed' => 'Kapandı'] as $k => $v): ?>
                        <option value="<?= $k ?>" <?= $lead['status'] === $k ? 'selected' : '' ?>><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="a-field"><label>Yönetici Notu</label><textarea name="admin_note"><?= e($lead['admin_note'] ?? '') ?></textarea></div>
            <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Güncelle</button>
        </form>
    </div>
</div>
