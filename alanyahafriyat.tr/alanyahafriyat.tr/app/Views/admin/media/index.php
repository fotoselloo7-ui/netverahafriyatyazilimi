<div class="a-grid a-grid--2" style="align-items:start">
    <div class="a-card">
        <div class="a-card__head"><h2>Dosya Yükle</h2></div>
        <form method="post" action="<?= base_url('yonetim/medya/yukle') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="a-field"><label>Görsel Seç</label><input type="file" name="file" accept="image/*" required></div>
            <div class="a-field"><label>Başlık</label><input type="text" name="title"></div>
            <div class="a-field"><label>Alt Metin</label><input type="text" name="alt_text"></div>
            <button class="btn btn--primary"><?= icon('plus', 15) ?> Yükle</button>
        </form>
        <p class="help" style="margin-top:14px">Güvenlik: sadece resim (JPG/PNG/WEBP/GIF), rastgele dosya adı, MIME + uzantı kontrolü, upload klasöründe PHP çalıştırma kapalı.</p>
    </div>
    <div class="a-card">
        <div class="a-card__head"><h2>Medya (<?= count($items) ?>)</h2></div>
        <?php if (!$items): ?><div class="empty">Henüz dosya yok.</div><?php else: ?>
        <div class="media-grid">
            <?php foreach ($items as $m): ?>
                <div class="media-item">
                    <img src="<?= e(upload_url($m['file_path'])) ?>" alt="<?= e($m['alt_text']) ?>">
                    <div class="media-item__foot">
                        <small title="<?= e($m['file_name']) ?>"><?= e(str_excerpt($m['title'] ?: $m['file_name'], 14)) ?></small>
                        <form method="post" action="<?= base_url('yonetim/medya/' . $m['id'] . '/sil') ?>" onsubmit="return confirm('Silinsin mi?')"><?= csrf_field() ?><button class="btn btn--danger btn--sm" style="padding:4px 8px"><?= icon('x', 13) ?></button></form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
