<div class="a-grid a-grid--2" style="align-items:start">
    <div class="a-card">
        <div class="a-card__head"><h2>Müşteri Yorumları (<?= count($items) ?>)</h2></div>
        <p class="help">Aktif yorumlar Hakkımızda sayfasındaki "Müşterilerimiz Ne Diyor?" bölümünde görünür.</p>
        <?php if (!$items): ?><div class="empty">Henüz yorum yok.</div><?php else: ?>
        <table class="a-table">
            <thead><tr><th></th><th>Müşteri</th><th>Puan</th><th>Durum</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($items as $t): ?>
                <tr>
                    <td style="width:46px">
                        <?php if (!empty($t['image'])): ?><img src="<?= e(upload_url($t['image'])) ?>" style="width:38px;height:38px;object-fit:cover;border-radius:50%">
                        <?php else: ?><span style="width:38px;height:38px;display:grid;place-items:center;background:var(--soft);border-radius:50%;font-weight:700"><?= e(mb_substr($t['name'], 0, 1)) ?></span><?php endif; ?>
                    </td>
                    <td><strong><?= e($t['name']) ?></strong><br><small><?= e(trim(($t['company'] ?? '') . ' ' . ($t['location'] ? '· ' . $t['location'] : ''))) ?></small></td>
                    <td><?= str_repeat('★', (int) $t['rating']) ?></td>
                    <td><span class="tag <?= $t['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $t['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                    <td class="actions">
                        <button type="button" class="btn btn--light btn--sm" onclick='editTesti(<?= json_encode($t, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Düzenle</button>
                        <form method="post" action="<?= base_url('yonetim/yorumlar/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $t['id'] ?>"><button class="btn btn--danger btn--sm"><?= icon('x', 13) ?></button></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="a-card" id="testi-form" style="border:2px solid var(--primary)">
        <div class="a-card__head"><h2 id="testi-title">Yeni Yorum</h2></div>
        <form method="post" action="<?= base_url('yonetim/yorumlar/kaydet') ?>" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="t-id" value="0">
            <div class="a-row">
                <div class="a-field"><label>Müşteri Adı *</label><input type="text" name="name" id="t-name" required></div>
                <div class="a-field"><label>Firma (opsiyonel)</label><input type="text" name="company" id="t-company"></div>
            </div>
            <div class="a-row">
                <div class="a-field"><label>Lokasyon</label><input type="text" name="location" id="t-location" placeholder="örn: Mahmutlar"></div>
                <div class="a-field"><label>Puan</label>
                    <select name="rating" id="t-rating"><?php for ($i = 5; $i >= 1; $i--): ?><option value="<?= $i ?>"><?= str_repeat('★', $i) ?></option><?php endfor; ?></select>
                </div>
            </div>
            <div class="a-field"><label>Yorum *</label><textarea name="comment" id="t-comment" required style="min-height:90px"></textarea></div>
            <div class="a-field"><label>Müşteri Görseli (opsiyonel)</label><input type="file" name="image" accept="image/*"><small>Düzenlemede yeni görsel seçilirse eskisiyle değişir.</small></div>
            <div class="a-row">
                <div class="a-field"><label>Sıra</label><input type="number" name="sort_order" id="t-sort" value="0"></div>
                <div class="a-field" style="display:flex;align-items:flex-end;gap:16px">
                    <label class="a-check"><input type="checkbox" name="is_active" id="t-active" checked> Aktif</label>
                    <label class="a-check"><input type="checkbox" name="remove_image" value="1"> Görseli kaldır</label>
                </div>
            </div>
            <button class="btn btn--primary"><?= icon('check', 15) ?> Kaydet</button>
            <button type="button" class="btn btn--light" onclick="resetTesti()">Temizle</button>
        </form>
    </div>
</div>
<script>
function editTesti(t){
  document.getElementById('t-id').value=t.id;
  document.getElementById('t-name').value=t.name||'';
  document.getElementById('t-company').value=t.company||'';
  document.getElementById('t-location').value=t.location||'';
  document.getElementById('t-rating').value=t.rating||5;
  document.getElementById('t-comment').value=t.comment||'';
  document.getElementById('t-sort').value=t.sort_order||0;
  document.getElementById('t-active').checked=t.is_active==1;
  document.getElementById('testi-title').textContent='Yorum Düzenle: '+t.name;
  document.getElementById('testi-form').scrollIntoView({behavior:'smooth'});
}
function resetTesti(){
  ['t-name','t-company','t-location','t-comment'].forEach(function(i){document.getElementById(i).value='';});
  document.getElementById('t-id').value=0;document.getElementById('t-sort').value=0;document.getElementById('t-rating').value=5;
  document.getElementById('t-active').checked=true;
  document.getElementById('testi-title').textContent='Yeni Yorum';
}
</script>
