<?php
$p = $post;
$isEdit = $p !== null;
$action = $isEdit ? base_url('yonetim/blog/' . $p['id']) : base_url('yonetim/blog/yeni');
$val = fn ($k, $d = '') => e($p[$k] ?? $d);
$seoScore = (int) ($p['seo_score'] ?? 0);
[$scoreLabel, $scoreColor] = \App\Services\SeoAnalyzer::scoreLabel($seoScore);
$mediaJson = json_encode(array_map(fn ($m) => [
    'url' => upload_url($m['file_path']),
    'name' => $m['title'] ?: $m['file_name'],
    'alt' => $m['alt_text'] ?: '',
], $mediaItems ?? []), JSON_UNESCAPED_UNICODE | JSON_HEX_APOS);
?>
<form method="post" action="<?= $action ?>" enctype="multipart/form-data" id="blog-form">
    <?= csrf_field() ?>
    <div class="a-grid a-grid--2" style="align-items:start">
        <div>
            <div class="a-card">
                <div class="a-card__head"><h2>Yazı İçeriği</h2></div>
                <div class="a-field"><label>Başlık *</label><input type="text" name="title" id="f-title" value="<?= $val('title') ?>" required></div>
                <div class="a-row">
                    <div class="a-field"><label>Slug</label><input type="text" name="slug" id="f-slug" value="<?= $val('slug') ?>" placeholder="boşsa başlıktan üretilir"></div>
                    <div class="a-field"><label>Yazar Adı</label><input type="text" name="author_name" value="<?= $val('author_name') ?>" placeholder="örn: Ersan Hafriyat"></div>
                </div>
                <?php if ($isEdit): ?>
                <label class="a-check" style="margin-bottom:12px;font-weight:400;font-size:13px"><input type="checkbox" name="create_redirect" value="1" checked> Slug değişirse eski URL için otomatik 301 yönlendirme oluştur</label>
                <?php endif; ?>
                <div class="a-field"><label>Özet (excerpt)</label><textarea name="excerpt" id="f-excerpt" style="min-height:64px"><?= $val('excerpt') ?></textarea></div>

                <div class="a-field">
                    <label>İçerik (Markdown)</label>
                    <div class="md-toolbar">
                        <button type="button" data-md="## " data-mode="line" title="H2">H2</button>
                        <button type="button" data-md="### " data-mode="line" title="H3">H3</button>
                        <button type="button" data-md="**" data-mode="wrap" title="Kalın"><b>B</b></button>
                        <button type="button" data-md="*" data-mode="wrap" title="İtalik"><i>I</i></button>
                        <button type="button" data-md="- " data-mode="line" title="Liste">• Liste</button>
                        <button type="button" data-md="> " data-mode="line" title="Alıntı">❝</button>
                        <button type="button" data-md="`" data-mode="wrap" title="Kod">&lt;/&gt;</button>
                        <button type="button" data-mode="table" title="Tablo">▦ Tablo</button>
                        <button type="button" data-mode="link" title="Link">🔗 Link</button>
                        <button type="button" data-mode="media" class="md-media" title="Medya kütüphanesinden görsel ekle">🖼 Medya Ekle</button>
                    </div>
                    <textarea name="content_markdown" id="md-editor" style="min-height:380px;font-family:ui-monospace,monospace;font-size:13.5px;line-height:1.6"><?= $val('content_markdown') ?></textarea>
                    <small># Başlık, ## H2, ### H3, **kalın**, *italik*, - liste, [link](url), ![alt](url "title"), | tablo |</small>
                </div>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>SSS Blokları (FAQ Schema)</h2><button type="button" class="btn btn--light btn--sm" onclick="addBlogFaq()"><?= icon('plus', 14) ?> Soru</button></div>
                <div id="blog-faq-list">
                    <?php foreach (($faqs ?: []) as $f): ?>
                    <div style="margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed var(--line)">
                        <input type="text" name="faq_question[]" placeholder="Soru" value="<?= e($f['question'] ?? '') ?>" style="margin-bottom:6px">
                        <textarea name="faq_answer[]" placeholder="Cevap" style="min-height:56px"><?= e($f['answer'] ?? '') ?></textarea>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (!$faqs): ?><p class="help">SSS eklerseniz yazı için FAQ schema üretilir (Google zengin sonuç).</p><?php endif; ?>
            </div>
        </div>

        <div>
            <div class="a-card" id="seo-score-card">
                <div class="a-card__head"><h2><?= icon('star', 18) ?> SEO Skoru</h2><span class="tag" id="seo-score-badge" style="background:<?= $scoreColor ?>22;color:<?= $scoreColor ?>"><?= $seoScore ?>/100 · <?= $scoreLabel ?></span></div>
                <div class="seo-bar"><div class="seo-bar__fill" id="seo-bar-fill" style="width:<?= $seoScore ?>%;background:<?= $scoreColor ?>"></div></div>
                <div class="a-field" style="margin-top:14px"><label>Odak Anahtar Kelime</label><input type="text" name="focus_keyword" id="f-fk" value="<?= $val('focus_keyword') ?>" placeholder="örn: alanya kepçe kiralama"></div>
                <ul id="seo-suggestions" class="seo-suggestions">
                    <?php foreach (($seoSuggestions ?: []) as $s): ?><li><?= e($s) ?></li><?php endforeach; ?>
                </ul>
                <small style="color:var(--muted)">Skor yazarken canlı hesaplanır; kaydedince sunucu tarafında kesinleşir.</small>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>Yayın</h2></div>
                <div class="a-field"><label>Durum</label><select name="status"><option value="draft" <?= ($p['status'] ?? 'draft') === 'draft' ? 'selected' : '' ?>>Taslak</option><option value="published" <?= ($p['status'] ?? '') === 'published' ? 'selected' : '' ?>>Yayında</option></select></div>
                <div class="a-field"><label>Kategori</label><select name="category_id"><option value="">Kategori seçin</option><?php foreach ($categories as $c): ?><option value="<?= $c['id'] ?>" <?= (int) ($p['category_id'] ?? 0) === (int) $c['id'] ? 'selected' : '' ?>><?= e($c['title']) ?></option><?php endforeach; ?></select></div>
                <div class="a-field"><label>Yayın Tarihi</label><input type="datetime-local" name="published_at" value="<?= $p && $p['published_at'] ? date('Y-m-d\TH:i', strtotime($p['published_at'])) : '' ?>"></div>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>Kapak Görseli</h2></div>
                <?php $if_name='cover_image'; $if_current=$p['cover_image']??''; $if_label='Kapak Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
                <div class="a-row">
                    <div class="a-field"><label>Kapak Alt Etiketi</label><input type="text" name="cover_image_alt" id="f-coveralt" value="<?= $val('cover_image_alt') ?>"></div>
                    <div class="a-field"><label>Kapak Title Etiketi</label><input type="text" name="cover_image_title" value="<?= $val('cover_image_title') ?>"></div>
                </div>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>SEO</h2></div>
                <div class="a-field"><label>SEO Başlık</label><input type="text" name="seo_title" id="f-seotitle" value="<?= $val('seo_title') ?>"><small><span id="seotitle-len">0</span> karakter (ideal 30–65)</small></div>
                <div class="a-field"><label>Meta Açıklama</label><textarea name="seo_description" id="f-metadesc" style="min-height:64px"><?= $val('seo_description') ?></textarea><small><span id="metadesc-len">0</span> karakter (ideal 50–160)</small></div>
                <div class="a-field"><label>Canonical URL</label><input type="url" name="canonical_url" value="<?= $val('canonical_url') ?>" placeholder="boşsa yazı URL'si kullanılır"></div>
                <div class="a-field"><label>Schema Türü</label><select name="schema_type"><?php foreach (['BlogPosting', 'Article', 'NewsArticle'] as $st): ?><option value="<?= $st ?>" <?= ($p['schema_type'] ?? 'BlogPosting') === $st ? 'selected' : '' ?>><?= $st ?></option><?php endforeach; ?></select></div>
                <div style="display:flex;gap:18px;margin-bottom:6px">
                    <label class="a-check"><input type="checkbox" name="robots_index" <?= (int) ($p['robots_index'] ?? 1) === 1 ? 'checked' : '' ?>> Index</label>
                    <label class="a-check"><input type="checkbox" name="robots_follow" <?= (int) ($p['robots_follow'] ?? 1) === 1 ? 'checked' : '' ?>> Follow</label>
                </div>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>Sosyal Paylaşım (OG / Twitter)</h2></div>
                <div class="a-field"><label>OG Başlık</label><input type="text" name="og_title" value="<?= $val('og_title') ?>"></div>
                <div class="a-field"><label>OG Açıklama</label><textarea name="og_description" style="min-height:52px"><?= $val('og_description') ?></textarea></div>
                <?php $if_name='og_image'; $if_current=$p['og_image']??''; $if_label='OG Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
                <div class="a-field"><label>Twitter Başlık</label><input type="text" name="twitter_title" value="<?= $val('twitter_title') ?>"></div>
                <div class="a-field"><label>Twitter Açıklama</label><textarea name="twitter_description" style="min-height:52px"><?= $val('twitter_description') ?></textarea></div>
                <?php $if_name='twitter_image'; $if_current=$p['twitter_image']??''; $if_label='Twitter Görseli'; include VIEW_PATH.'/admin/partials/image-field.php'; ?>
            </div>

            <div class="a-card">
                <div class="a-card__head"><h2>İlişkilendirme</h2></div>
                <div class="a-field"><label>İlgili Hizmet</label>
                    <select name="related_service_id" id="f-relservice">
                        <option value="">Seçilmedi</option>
                        <?php foreach ($services as $s): ?><option value="<?= $s['id'] ?>" <?= (int) ($p['related_service_id'] ?? 0) === (int) $s['id'] ? 'selected' : '' ?>><?= e($s['title']) ?></option><?php endforeach; ?>
                    </select>
                    <small>Yazı sonunda bu hizmete CTA gösterilir + SEO puanına katkı sağlar.</small>
                </div>
                <div class="a-field"><label>İlgili Yazılar</label>
                    <div style="max-height:170px;overflow:auto;border:1px solid var(--line);border-radius:9px;padding:10px">
                        <?php foreach ($allPosts as $ap): ?>
                            <label class="a-check" style="font-weight:400;font-size:13px;margin-bottom:6px"><input type="checkbox" name="related_posts[]" value="<?= $ap['id'] ?>" <?= in_array((int) $ap['id'], array_map('intval', $relatedPosts ?: []), true) ? 'checked' : '' ?>> <?= e(str_excerpt($ap['title'], 46)) ?></label><br>
                        <?php endforeach; ?>
                        <?php if (!$allPosts): ?><small class="help">Başka yazı yok.</small><?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn--primary"><?= icon('check', 16) ?> Kaydet</button>
    <a href="<?= base_url('yonetim/blog') ?>" class="btn btn--light">İptal</a>
</form>

<!-- Medya seçici modal -->
<div class="media-modal" id="media-modal">
    <div class="media-modal__box">
        <div class="media-modal__head"><strong>Medya Kütüphanesi</strong><button type="button" onclick="closeMediaModal()" class="btn btn--light btn--sm">✕</button></div>
        <div class="media-modal__grid" id="media-modal-grid"></div>
        <div class="media-modal__fields">
            <input type="text" id="mm-alt" placeholder="Alt metin (SEO için önemli)">
            <input type="text" id="mm-title" placeholder="Title etiketi (opsiyonel)">
            <input type="text" id="mm-caption" placeholder="Görsel altı açıklama / caption (opsiyonel)">
            <button type="button" class="btn btn--primary btn--sm" onclick="insertMedia()"><?= icon('plus', 14) ?> Makaleye Ekle</button>
        </div>
        <p class="help" style="margin:8px 14px 12px">Yeni görsel yüklemek için <a href="<?= base_url('yonetim/medya') ?>" target="_blank">Medya Kütüphanesi</a>'ni kullanın, sonra bu pencereyi yeniden açın.</p>
    </div>
</div>

<style>
.md-toolbar{display:flex;gap:5px;flex-wrap:wrap;margin-bottom:8px}
.md-toolbar button{border:1px solid var(--line);background:#fff;border-radius:7px;padding:6px 10px;font-size:12.5px;cursor:pointer;font-family:inherit}
.md-toolbar button:hover{border-color:var(--primary);color:var(--primary)}
.md-toolbar .md-media{background:var(--primary);color:#111;border-color:var(--primary);font-weight:600}
.seo-bar{height:10px;background:#eef0f3;border-radius:6px;overflow:hidden}
.seo-bar__fill{height:100%;border-radius:6px;transition:width .4s,background .4s}
.seo-suggestions{margin-top:12px}
.seo-suggestions li{font-size:12.5px;color:#b45309;padding:5px 0 5px 18px;position:relative;border-bottom:1px dashed var(--line)}
.seo-suggestions li::before{content:"!";position:absolute;left:0;top:5px;width:14px;height:14px;background:#fef3c7;color:#b45309;border-radius:50%;display:grid;place-items:center;font-size:10px;font-weight:700}
.media-modal{display:none;position:fixed;inset:0;z-index:200;background:rgba(0,0,0,.55);align-items:center;justify-content:center;padding:20px}
.media-modal.is-open{display:flex}
.media-modal__box{background:#fff;border-radius:14px;max-width:640px;width:100%;max-height:84vh;overflow:auto}
.media-modal__head{display:flex;justify-content:space-between;align-items:center;padding:14px 16px;border-bottom:1px solid var(--line);position:sticky;top:0;background:#fff}
.media-modal__grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(96px,1fr));gap:10px;padding:14px}
.media-modal__grid img{width:100%;aspect-ratio:1;object-fit:cover;border-radius:8px;cursor:pointer;border:3px solid transparent}
.media-modal__grid img.selected{border-color:var(--primary)}
.media-modal__fields{display:grid;gap:8px;padding:0 14px 6px}
.media-modal__fields input{padding:9px 12px;border:1px solid var(--line);border-radius:8px;font-family:inherit}
</style>

<script>
var MEDIA_ITEMS = <?= $mediaJson ?>;
var editor = document.getElementById('md-editor');

/* ---- Markdown toolbar ---- */
function insertAtCursor(before, after, placeholder){
  var s = editor.selectionStart, e = editor.selectionEnd, v = editor.value;
  var sel = v.substring(s, e) || placeholder || '';
  editor.value = v.substring(0, s) + before + sel + (after || '') + v.substring(e);
  editor.focus();
  editor.selectionStart = editor.selectionEnd = s + before.length + sel.length + (after || '').length;
  calcSeo();
}
document.querySelectorAll('.md-toolbar button').forEach(function(btn){
  btn.addEventListener('click', function(){
    var mode = btn.getAttribute('data-mode'), md = btn.getAttribute('data-md') || '';
    if (mode === 'line') { insertAtCursor('\n' + md, '', 'Başlık'); }
    else if (mode === 'wrap') { insertAtCursor(md, md, 'metin'); }
    else if (mode === 'link') {
      var url = prompt('Bağlantı URL:', 'https://'); if (!url) return;
      insertAtCursor('[', '](' + url + ')', 'bağlantı metni');
    }
    else if (mode === 'table') {
      insertAtCursor('\n| Başlık 1 | Başlık 2 |\n|---|---|\n| Hücre | Hücre |\n', '', '');
    }
    else if (mode === 'media') { openMediaModal(); }
  });
});

/* ---- Medya modal ---- */
var selectedMedia = null;
function openMediaModal(){
  var grid = document.getElementById('media-modal-grid');
  grid.innerHTML = '';
  if (!MEDIA_ITEMS.length) { grid.innerHTML = '<p style="grid-column:1/-1;color:#6b7280;font-size:13px">Medya kütüphanesi boş.</p>'; }
  MEDIA_ITEMS.forEach(function(m, i){
    var img = document.createElement('img');
    img.src = m.url; img.title = m.name;
    img.addEventListener('click', function(){
      grid.querySelectorAll('img').forEach(function(x){x.classList.remove('selected');});
      img.classList.add('selected');
      selectedMedia = m;
      document.getElementById('mm-alt').value = m.alt || '';
    });
    grid.appendChild(img);
  });
  document.getElementById('media-modal').classList.add('is-open');
}
function closeMediaModal(){ document.getElementById('media-modal').classList.remove('is-open'); }
function insertMedia(){
  if (!selectedMedia) { alert('Önce bir görsel seçin.'); return; }
  var alt = document.getElementById('mm-alt').value.trim();
  var ttl = document.getElementById('mm-title').value.trim();
  var cap = document.getElementById('mm-caption').value.trim();
  var md = '\n![' + alt + '](' + selectedMedia.url + (ttl ? ' "' + ttl + '"' : '') + ')\n';
  if (cap) md += '*' + cap + '*\n';
  insertAtCursor(md, '', '');
  closeMediaModal();
}

/* ---- Canlı SEO skoru (sunucu tarafındaki kriterlerin aynası) ---- */
function slugifyTr(t){
  var map = {'ç':'c','ğ':'g','ı':'i','ö':'o','ş':'s','ü':'u','Ç':'c','Ğ':'g','İ':'i','Ö':'o','Ş':'s','Ü':'u'};
  return t.replace(/[çğıöşüÇĞİÖŞÜ]/g, function(c){return map[c];}).toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-+|-+$/g,'');
}
function calcSeo(){
  var fk = (document.getElementById('f-fk').value || '').toLowerCase().trim();
  var title = (document.getElementById('f-title').value || '').toLowerCase();
  var slug = document.getElementById('f-slug').value || slugifyTr(document.getElementById('f-title').value || '');
  var md = editor.value;
  var meta = document.getElementById('f-metadesc').value;
  var seoTitle = document.getElementById('f-seotitle').value || document.getElementById('f-title').value;
  var coverAlt = document.getElementById('f-coveralt').value;
  var relService = document.getElementById('f-relservice').value;
  var words = md.trim() ? md.trim().split(/\s+/) : [];
  var first100 = words.slice(0, 100).join(' ').toLowerCase();
  var headings = (md.match(/^#{2,3}\s+.+$/gm) || []).map(function(h){return h.toLowerCase();});
  var images = md.match(/!\[(.*?)\]\((\S+?)(\s+".*?")?\)/g) || [];
  var imagesNoAlt = (md.match(/!\[\]\(/g) || []).length;
  var links = (md.match(/(^|[^!])\[.+?\]\((.+?)\)/g) || []);
  var internal = links.filter(function(l){return /\]\(\//.test(l) || l.indexOf(location.host) > -1;});
  var external = links.filter(function(l){return /\]\(https?:\/\//.test(l) && l.indexOf(location.host) === -1;});
  var faqCount = document.querySelectorAll('#blog-faq-list input[name="faq_question[]"]').length &&
                 Array.prototype.some.call(document.querySelectorAll('#blog-faq-list input[name="faq_question[]"]'), function(i){return i.value.trim() !== '';});
  var paras = md.split(/\n\s*\n/).filter(function(p){return p.trim() && p.trim()[0] !== '#';});
  var longParas = paras.filter(function(p){return p.length > 900;});

  var score = 0, sug = [];
  function chk(pts, ok, msg){ if (ok) score += pts; else sug.push(msg); }
  if (!fk) sug.push('Odak anahtar kelime belirleyin.');
  chk(8, fk && title.indexOf(fk) > -1, 'Odak anahtar kelime başlıkta geçmiyor.');
  chk(6, fk && slug.indexOf(slugifyTr(fk)) > -1, 'Odak anahtar kelime slug içinde geçmiyor.');
  chk(8, fk && first100.indexOf(fk) > -1, 'Odak anahtar kelime ilk paragrafta geçmiyor.');
  chk(6, fk && headings.some(function(h){return h.indexOf(fk) > -1;}), 'Odak anahtar kelime H2/H3 başlıkta geçmiyor.');
  chk(6, fk && meta.toLowerCase().indexOf(fk) > -1, 'Odak anahtar kelime meta açıklamada geçmiyor.');
  chk(7, meta.length >= 50 && meta.length <= 160, 'Meta açıklama 50–160 karakter olmalı (' + meta.length + ').');
  chk(6, seoTitle.length >= 30 && seoTitle.length <= 65, 'SEO başlığı 30–65 karakter olmalı (' + seoTitle.length + ').');
  if (words.length >= 600) score += 10; else if (words.length >= 300) { score += 5; sug.push('İçerik ' + words.length + ' kelime — 600+ hedefleyin.'); } else sug.push('İçerik çok kısa (' + words.length + ' kelime).');
  chk(6, headings.length >= 2, 'En az iki H2/H3 alt başlık kullanın.');
  chk(4, longParas.length === 0, 'Bazı paragraflar çok uzun.');
  if (images.length === 0) sug.push('Makale içine görsel ekleyin.'); else { chk(5, imagesNoAlt === 0, 'Bazı görsellerde alt etiketi eksik.'); score += 2; }
  chk(2, coverAlt.trim() !== '' || !<?= $p && $p['cover_image'] ? 'true' : 'false' ?>, 'Kapak görseli alt etiketi eksik.');
  chk(5, internal.length > 0, 'En az bir iç bağlantı ekleyin.');
  chk(4, external.length > 0, 'Güvenilir bir dış kaynağa bağlantı ekleyin.');
  chk(4, relService !== '', 'İlgili hizmet seçilmemiş.');
  score += 3; // canonical otomatik
  chk(4, true, ''); // og/kapak görseli — sunucu tarafında kesinleşir
  chk(4, slug !== '' && slug.length <= 75 && /^[a-z0-9-]+$/.test(slug), 'Slug kısa ve temiz olmalı.');
  chk(4, faqCount, 'SSS bloğu ekleyin (FAQ schema).');

  score = Math.max(0, Math.min(100, score));
  var color = score >= 90 ? '#16a34a' : score >= 75 ? '#65a30d' : score >= 50 ? '#d97706' : '#dc2626';
  var label = score >= 90 ? 'Çok İyi' : score >= 75 ? 'İyi' : score >= 50 ? 'Geliştirilmeli' : 'Zayıf';
  var badge = document.getElementById('seo-score-badge');
  badge.textContent = score + '/100 · ' + label;
  badge.style.background = color + '22'; badge.style.color = color;
  var fill = document.getElementById('seo-bar-fill');
  fill.style.width = score + '%'; fill.style.background = color;
  var ul = document.getElementById('seo-suggestions');
  ul.innerHTML = sug.map(function(s){return '<li>' + s.replace(/</g,'&lt;') + '</li>';}).join('');
  document.getElementById('seotitle-len').textContent = seoTitle.length;
  document.getElementById('metadesc-len').textContent = meta.length;
}
['f-title','f-slug','f-fk','f-metadesc','f-seotitle','f-coveralt','f-relservice','md-editor'].forEach(function(id){
  var el = document.getElementById(id);
  if (el) { el.addEventListener('input', debounceSeo); el.addEventListener('change', debounceSeo); }
});
var seoTimer;
function debounceSeo(){ clearTimeout(seoTimer); seoTimer = setTimeout(calcSeo, 350); }
calcSeo();

function addBlogFaq(){
  var d = document.createElement('div');
  d.style.cssText = 'margin-bottom:12px;padding-bottom:12px;border-bottom:1px dashed #e5e7eb';
  d.innerHTML = '<input type="text" name="faq_question[]" placeholder="Soru" style="margin-bottom:6px"><textarea name="faq_answer[]" placeholder="Cevap" style="min-height:56px"></textarea>';
  document.getElementById('blog-faq-list').appendChild(d);
}
</script>
