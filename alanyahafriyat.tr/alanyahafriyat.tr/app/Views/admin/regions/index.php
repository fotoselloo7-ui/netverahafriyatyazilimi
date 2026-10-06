<div class="a-grid a-grid--2" style="align-items:start">
    <div class="a-card">
        <div class="a-card__head"><h2>Bölgeler (<?= count($regions) ?>)</h2></div>
        <p class="help">Buradaki bölgeler ana sayfadaki "Çalışma Bölgelerimiz" alanında ve hizmet detay sayfalarında görünür. Şehir/ilçe/mahalle tamamen size aittir — İstanbul ilçeleri de eklenebilir.</p>
        <?php if (!$regions): ?><div class="empty">Henüz bölge yok.</div><?php else: ?>
        <table class="a-table">
            <thead><tr><th>Bölge</th><th>Şehir / İlçe</th><th>Sıra</th><th>Durum</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($regions as $r): ?>
                <tr>
                    <td><strong><?= e($r['title']) ?></strong><br><small><?= e($r['slug']) ?></small></td>
                    <td><small><?= e(trim(($r['city'] ?: '') . ' / ' . ($r['district'] ?: ''), ' /')) ?><?= $r['neighborhood'] ? ' / ' . e($r['neighborhood']) : '' ?></small></td>
                    <td><?= (int) $r['sort_order'] ?></td>
                    <td><span class="tag <?= $r['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $r['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                    <td class="actions">
                        <button type="button" class="btn btn--light btn--sm" onclick='editRegion(<?= json_encode($r, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Düzenle</button>
                        <form method="post" action="<?= base_url('yonetim/bolgeler/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="btn btn--danger btn--sm"><?= icon('x', 13) ?></button></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>

    <div class="a-card" id="region-form" style="border:2px solid var(--primary)">
        <div class="a-card__head"><h2 id="region-title">Yeni Bölge</h2></div>
        <form method="post" action="<?= base_url('yonetim/bolgeler/kaydet') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="r-id" value="0">
            <div class="a-row">
                <div class="a-field"><label>Bölge Adı *</label><input type="text" name="title" id="r-title" required placeholder="örn: Mahmutlar"></div>
                <div class="a-field"><label>Slug (boşsa otomatik)</label><input type="text" name="slug" id="r-slug"></div>
            </div>
            <div class="a-row--3" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
                <div class="a-field"><label>Şehir</label><input type="text" name="city" id="r-city" placeholder="Antalya"></div>
                <div class="a-field"><label>İlçe</label><input type="text" name="district" id="r-district" placeholder="Alanya"></div>
                <div class="a-field"><label>Mahalle</label><input type="text" name="neighborhood" id="r-neighborhood"></div>
            </div>
            <div class="a-field"><label>Açıklama</label><textarea name="description" id="r-desc" style="min-height:60px"></textarea></div>
            <div class="a-row">
                <div class="a-field"><label>SEO Başlık</label><input type="text" name="seo_title" id="r-seotitle"></div>
                <div class="a-field"><label>SEO Açıklama</label><input type="text" name="seo_description" id="r-seodesc"></div>
            </div>
            <div class="a-row">
                <div class="a-field"><label>Sıra</label><input type="number" name="sort_order" id="r-sort" value="0"></div>
                <div class="a-field" style="display:flex;align-items:flex-end"><label class="a-check"><input type="checkbox" name="is_active" id="r-active" checked> Aktif</label></div>
            </div>
            <button class="btn btn--primary"><?= icon('check', 15) ?> Kaydet</button>
            <button type="button" class="btn btn--light" onclick="resetRegion()">Temizle</button>
        </form>
    </div>
</div>
<script>
function editRegion(r){
  document.getElementById('r-id').value=r.id;
  document.getElementById('r-title').value=r.title||'';
  document.getElementById('r-slug').value=r.slug||'';
  document.getElementById('r-city').value=r.city||'';
  document.getElementById('r-district').value=r.district||'';
  document.getElementById('r-neighborhood').value=r.neighborhood||'';
  document.getElementById('r-desc').value=r.description||'';
  document.getElementById('r-seotitle').value=r.seo_title||'';
  document.getElementById('r-seodesc').value=r.seo_description||'';
  document.getElementById('r-sort').value=r.sort_order||0;
  document.getElementById('r-active').checked=r.is_active==1;
  document.getElementById('region-title').textContent='Bölge Düzenle: '+r.title;
  document.getElementById('region-form').scrollIntoView({behavior:'smooth'});
}
function resetRegion(){
  ['r-title','r-slug','r-city','r-district','r-neighborhood','r-desc','r-seotitle','r-seodesc'].forEach(function(i){document.getElementById(i).value='';});
  document.getElementById('r-id').value=0;document.getElementById('r-sort').value=0;
  document.getElementById('r-active').checked=true;
  document.getElementById('region-title').textContent='Yeni Bölge';
}
</script>
