<?php
$types = ['internal' => 'İç Sayfa', 'page' => 'Sayfa', 'service' => 'Hizmet', 'blog' => 'Blog', 'project' => 'Proje', 'external' => 'Dış Link', 'anchor' => 'Sayfa İçi', 'whatsapp' => 'WhatsApp', 'phone' => 'Telefon'];
$renderList = function (string $loc, array $items) use ($types) {
    $labels = ['header' => 'Header Menüsü', 'footer' => 'Footer Menüsü', 'mobile_bar' => 'Mobil Alt Bar'];
    ?>
    <div class="a-card">
        <div class="a-card__head"><h2><?= e($labels[$loc] ?? $loc) ?></h2></div>
        <?php if ($items): ?>
        <table class="a-table" style="margin-bottom:16px">
            <thead><tr><th>Başlık</th><th>URL</th><th>Tip</th><th>Sıra</th><th>Durum</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($items as $it): ?>
                <tr>
                    <td><strong><?= e($it['title']) ?></strong></td>
                    <td><small><?= e($it['url']) ?></small></td>
                    <td><small><?= e($types[$it['menu_type']] ?? $it['menu_type']) ?></small></td>
                    <td><?= (int) $it['sort_order'] ?></td>
                    <td><span class="tag <?= $it['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $it['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                    <td class="actions">
                        <button type="button" class="btn btn--light btn--sm" onclick='editMenu(<?= json_encode($it, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Düzenle</button>
                        <form method="post" action="<?= base_url('yonetim/menu/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $it['id'] ?>"><button class="btn btn--danger btn--sm"><?= icon('x', 13) ?></button></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?><p class="help">Bu konumda menü öğesi yok.</p><?php endif; ?>
        <button type="button" class="btn btn--dark btn--sm" onclick="newMenu('<?= $loc ?>')"><?= icon('plus', 14) ?> Yeni Öğe</button>
    </div>
    <?php
};
$renderList('header', $header);
$renderList('footer', $footer);
$renderList('mobile_bar', $mobile);
?>

<div class="a-card" id="menu-form-card" style="border:2px solid var(--primary)">
    <div class="a-card__head"><h2 id="menu-form-title">Menü Öğesi</h2></div>
    <form method="post" action="<?= base_url('yonetim/menu/kaydet') ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="id" id="m-id" value="0">
        <div class="a-row">
            <div class="a-field"><label>Başlık</label><input type="text" name="title" id="m-title" required></div>
            <div class="a-field"><label>Konum</label><select name="menu_location" id="m-loc"><option value="header">Header</option><option value="footer">Footer</option><option value="mobile_bar">Mobil Bar</option></select></div>
        </div>
        <div class="a-row">
            <div class="a-field"><label>URL / Mesaj</label><input type="text" name="url" id="m-url"></div>
            <div class="a-field"><label>Tip</label><select name="menu_type" id="m-type"><?php foreach ($types as $k => $vv): ?><option value="<?= $k ?>"><?= $vv ?></option><?php endforeach; ?></select></div>
        </div>
        <div class="a-row">
            <div class="a-field"><label>İkon (opsiyonel)</label><input type="text" name="icon" id="m-icon" placeholder="phone, whatsapp, map-pin, send"></div>
            <div class="a-field"><label>Sıralama</label><input type="number" name="sort_order" id="m-sort" value="0"></div>
        </div>
        <div style="display:flex;gap:20px;margin-bottom:14px">
            <label class="a-check"><input type="checkbox" name="is_active" id="m-active" checked> Aktif</label>
            <label class="a-check"><input type="checkbox" name="target_blank" id="m-blank"> Yeni sekmede aç</label>
        </div>
        <button class="btn btn--primary"><?= icon('check', 15) ?> Kaydet</button>
    </form>
</div>

<script>
function newMenu(loc){document.getElementById('m-id').value=0;document.getElementById('m-title').value='';document.getElementById('m-url').value='';document.getElementById('m-icon').value='';document.getElementById('m-sort').value=0;document.getElementById('m-loc').value=loc;document.getElementById('m-active').checked=true;document.getElementById('m-blank').checked=false;document.getElementById('menu-form-title').textContent='Yeni Menü Öğesi';document.getElementById('menu-form-card').scrollIntoView({behavior:'smooth'})}
function editMenu(it){document.getElementById('m-id').value=it.id;document.getElementById('m-title').value=it.title||'';document.getElementById('m-url').value=it.url||'';document.getElementById('m-icon').value=it.icon||'';document.getElementById('m-sort').value=it.sort_order||0;document.getElementById('m-loc').value=it.menu_location;document.getElementById('m-type').value=it.menu_type;document.getElementById('m-active').checked=it.is_active==1;document.getElementById('m-blank').checked=it.target=='_blank';document.getElementById('menu-form-title').textContent='Menü Öğesi Düzenle';document.getElementById('menu-form-card').scrollIntoView({behavior:'smooth'})}
</script>
