<?php
$heroImg = !empty($page['hero_image']) ? upload_url($page['hero_image']) : null;
$features = ['Deneyimli ve Uzman Ekip', 'Modern Makine Parkuru', 'Zamanında ve Güvenli Çalışma', 'Uygun Fiyat Politikası', 'Yerinde Keşif ve Doğru Planlama'];
$why = [
    ['zap', 'Hızlı Dönüş', 'İhtiyaçlarınıza hızlı cevap verir, zaman kaybınızı minimuma indiririz.'],
    ['truck', 'Doğru Makine', 'İşinize en uygun makine seçimi ile verimli ve ekonomik çözümler sunarız.'],
    ['shield', 'Güvenli Çalışma', 'İş güvenliği standartlarına uygun çalışır, risksiz süreç yönetiriz.'],
    ['award', 'Kaliteli Hizmet', 'Kaliteyi ön planda tutar, her işi kendi işimiz gibi sahipleniriz.'],
    ['tag', 'Uygun Fiyat', 'Piyasa koşullarına uygun, rekabetçi ve şeffaf fiyatlandırma yaparız.'],
    ['users', 'Müşteri Memnuniyeti', 'Müşteri memnuniyetini her zaman önceliğimiz olarak belirleriz.'],
];
?>
<section class="page-hero"<?= $heroImg ? ' style="background-image:linear-gradient(rgba(10,10,12,.7),rgba(10,10,12,.65)),url(\''.e($heroImg).'\')"' : '' ?>>
    <div class="container">
        <h1><?= e($page['hero_title'] ?: $page['title']) ?></h1>
        <?php if ($page['hero_subtitle']): ?><p style="color:#d7d9dd;max-width:620px"><?= e($page['hero_subtitle']) ?></p><?php endif; ?>
        <div class="breadcrumb" style="margin-top:12px">
            <a href="<?= base_url() ?>">Ana Sayfa</a> <?= icon('chevron-right', 14) ?> <span class="cur"><?= e($page['title']) ?></span>
        </div>
    </div>
</section>

<section class="section">
    <div class="container about-intro">
        <div>
            <span class="eyebrow">Biz Kimiz?</span>
            <h2><?= e(site_name()) ?> Hakkında</h2>
            <div class="prose" style="margin:0"><?= $page['content'] ?></div>
            <ul class="about-feats">
                <?php foreach ($features as $f): ?>
                    <li><span class="fico"><?= icon('check', 18) ?></span> <?= e($f) ?></li>
                <?php endforeach; ?>
            </ul>
            <a href="<?= base_url('iletisim') ?>" class="btn btn--primary"><?= icon('send', 17) ?> Bize Ulaşın</a>
        </div>
        <div>
            <div class="about-media">
                <?php if ($heroImg): ?><img src="<?= e($heroImg) ?>" alt="<?= e(site_name()) ?>">
                <?php else: ?><div class="ph-media"><?= icon('excavator', 90) ?></div><?php endif; ?>
            </div>
            <div class="counters">
                <div class="counter"><b><?= e($counters['experience']) ?></b><span>Yıllık Deneyim</span></div>
                <div class="counter"><b><?= e($counters['projects']) ?></b><span>Tamamlanan Proje</span></div>
                <div class="counter"><b><?= e($counters['staff']) ?></b><span>Uzman Personel</span></div>
                <div class="counter"><b><?= e($counters['support']) ?></b><span>Destek Hizmeti</span></div>
            </div>
        </div>
    </div>
</section>

<section class="section section--dark">
    <div class="container">
        <div class="sec-head"><span class="eyebrow">Neden Biz?</span><h2>Neden <?= e(site_name()) ?>?</h2></div>
        <div class="why-grid">
            <?php foreach ($why as [$ic, $t, $d]): ?>
                <div class="why-card">
                    <div class="wico"><?= icon($ic, 28) ?></div>
                    <h4><?= e($t) ?></h4>
                    <p><?= e($d) ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php if (!empty($testimonials)): ?>
<section class="section section--soft">
    <div class="container">
        <div class="sec-head"><span class="eyebrow">Referanslar</span><h2>Müşterilerimiz Ne Diyor?</h2></div>
        <div class="grid grid--3">
            <?php foreach ($testimonials as $t): ?>
                <div class="scard" style="padding:26px 22px;text-align:left">
                    <div style="color:var(--color-primary);display:flex;gap:2px;margin-bottom:10px">
                        <?php for ($i = 0; $i < (int) $t['rating']; $i++) echo icon('star', 16); ?>
                    </div>
                    <p style="color:var(--color-text);opacity:.85;font-size:15px;margin-bottom:14px">"<?= e($t['comment']) ?>"</p>
                    <div style="display:flex;align-items:center;gap:10px">
                        <?php if (!empty($t['image'])): ?>
                            <img src="<?= e(upload_url($t['image'])) ?>" alt="<?= e($t['name']) ?>" style="width:40px;height:40px;object-fit:cover;border-radius:50%">
                        <?php else: ?>
                            <span style="width:40px;height:40px;flex:none;display:grid;place-items:center;background:var(--color-primary);color:var(--color-primary-text);border-radius:50%;font-weight:700"><?= e(mb_substr($t['name'], 0, 1)) ?></span>
                        <?php endif; ?>
                        <div>
                            <b style="display:block;line-height:1.2"><?= e($t['name']) ?></b>
                            <span style="color:var(--muted);font-size:13px"><?= e(trim(($t['company'] ?? '') !== '' ? $t['company'] . ($t['location'] ? ' · ' . $t['location'] : '') : (string) $t['location'])) ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<section class="final-cta">
    <div class="container final-cta__inner">
        <div><h2>Hafriyat veya Kepçe Hizmeti mi İhtiyacınız Var?</h2><p>Hemen bizimle iletişime geçin, hızlı ve ücretsiz teklif alın.</p></div>
        <div class="final-cta__btns">
            <a href="<?= e(whatsapp_link('Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--dark"><?= icon('whatsapp', 18) ?> WhatsApp</a>
            <a href="<?= base_url('iletisim') ?>" class="btn btn--dark" style="background:#fff;color:#111"><?= icon('star', 17) ?> Teklif Al</a>
        </div>
    </div>
</section>
