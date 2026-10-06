<div class="a-grid a-grid--2" style="align-items:start">
    <div class="a-card">
        <div class="a-card__head"><h2>Görsel Ekle</h2></div>
        <form method="post" action="<?= base_url('yonetim/galeri/yeni') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <div class="a-field"><label>Başlık</label><input type="text" name="title"></div>
            <div class="a-field"><label>Kategori</label><input type="text" name="category" placeholder="örn: Temel Kazısı"></div>
            <div class="a-field"><label>Görsel</label><input type="file" name="image" accept="image/*"></div>
            <div class="a-field"><label>veya Video URL (YouTube vb.)</label><input type="url" name="video_url"></div>
            <div class="a-field"><label>Alt Metin</label><input type="text" name="alt_text"></div>
            <button class="btn btn--primary"><?= icon('plus', 15) ?> Ekle</button>
        </form>
    </div>
    <div class="a-card">
        <div class="a-card__head"><h2>Galeri (<?= count($items) ?>)</h2></div>
        <?php if (!$items): ?><div class="empty">Henüz görsel yok.</div><?php else: ?>
        <div class="media-grid">
            <?php foreach ($items as $g): ?>
                <div class="media-item">
                    <?php if ($g['image']): ?><img src="<?= e(upload_url($g['image'])) ?>" alt="">
                    <?php else: ?><div style="aspect-ratio:1;display:grid;place-items:center;background:#f3f4f6;color:#9ca3af"><?= icon('message-circle', 30) ?></div><?php endif; ?>
                    <div class="media-item__foot">
                        <small><?= e(str_excerpt($g['title'], 16)) ?></small>
                        <form method="post" action="<?= base_url('yonetim/galeri/' . $g['id'] . '/sil') ?>" onsubmit="return confirm('Silinsin mi?')"><?= csrf_field() ?><button class="btn btn--danger btn--sm" style="padding:4px 8px"><?= icon('x', 13) ?></button></form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
