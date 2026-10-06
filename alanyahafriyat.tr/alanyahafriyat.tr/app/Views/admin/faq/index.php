<div class="a-grid a-grid--2" style="align-items:start">
    <div class="a-card">
        <div class="a-card__head"><h2>Sorular (<?= count($faqs) ?>)</h2></div>
        <?php if (!$faqs): ?><div class="empty">Henüz soru yok.</div><?php else: ?>
        <table class="a-table">
            <thead><tr><th>Soru</th><th>Durum</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($faqs as $f): ?>
                <tr>
                    <td><strong><?= e(str_excerpt($f['question'], 50)) ?></strong></td>
                    <td><span class="tag <?= $f['is_active'] ? 'tag--ok' : 'tag--off' ?>"><?= $f['is_active'] ? 'Aktif' : 'Pasif' ?></span></td>
                    <td class="actions">
                        <button type="button" class="btn btn--light btn--sm" onclick='editFaq(<?= json_encode($f, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'>Düzenle</button>
                        <form method="post" action="<?= base_url('yonetim/sss/sil') ?>" onsubmit="return confirm('Silinsin mi?')" style="display:inline"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $f['id'] ?>"><button class="btn btn--danger btn--sm"><?= icon('x', 13) ?></button></form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
    <div class="a-card" id="faq-form" style="border:2px solid var(--primary)">
        <div class="a-card__head"><h2 id="faq-title">Yeni Soru</h2></div>
        <form method="post" action="<?= base_url('yonetim/sss/kaydet') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="id" id="f-id" value="0">
            <div class="a-field"><label>Soru</label><input type="text" name="question" id="f-q" required></div>
            <div class="a-field"><label>Cevap</label><textarea name="answer" id="f-a"></textarea></div>
            <div class="a-row">
                <div class="a-field"><label>Sıra</label><input type="number" name="sort_order" id="f-sort" value="0"></div>
                <div class="a-field" style="display:flex;align-items:flex-end"><label class="a-check"><input type="checkbox" name="is_active" id="f-active" checked> Aktif</label></div>
            </div>
            <button class="btn btn--primary"><?= icon('check', 15) ?> Kaydet</button>
            <button type="button" class="btn btn--light" onclick="resetFaq()">Temizle</button>
        </form>
    </div>
</div>
<script>
function editFaq(f){document.getElementById('f-id').value=f.id;document.getElementById('f-q').value=f.question;document.getElementById('f-a').value=f.answer||'';document.getElementById('f-sort').value=f.sort_order||0;document.getElementById('f-active').checked=f.is_active==1;document.getElementById('faq-title').textContent='Soru Düzenle';document.getElementById('faq-form').scrollIntoView({behavior:'smooth'})}
function resetFaq(){document.getElementById('f-id').value=0;document.getElementById('f-q').value='';document.getElementById('f-a').value='';document.getElementById('f-sort').value=0;document.getElementById('f-active').checked=true;document.getElementById('faq-title').textContent='Yeni Soru'}
</script>
