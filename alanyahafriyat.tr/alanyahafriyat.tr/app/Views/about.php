<?php
$heroImg = !empty($page['hero_image']) ? upload_url($page['hero_image']) : null;
$features = ['İşin kapsamına göre makine ve ekip planlama', 'Telefon ve WhatsApp üzerinden kolay teklif', 'Alanya ve çevresinde saha odaklı hizmet', 'Kazı, taşıma ve tesviye işlerini birlikte planlama', 'İş öncesi erişim, zemin ve çalışma kapsamı değerlendirmesi'];
$why = [
    ['search', 'İhtiyaca Uygun Planlama', 'İşin türünü, saha erişimini ve zemin koşullarını değerlendirerek uygun çalışma planını oluştururuz.'],
    ['truck', 'Doğru Makine Seçimi', 'Büyük veya dar alanlı işlerde kullanılacak makineyi işin gereksinimine göre belirleriz.'],
    ['map-pin', 'Yerel Hizmet', 'Mahmutlar başta olmak üzere Alanya ve çevresindeki hizmet bölgelerine odaklanırız.'],
    ['message-circle', 'Açık İletişim', 'Talep, kapsam, süre ve teklif adımlarını telefon veya WhatsApp üzerinden netleştiririz.'],
    ['shield', 'Planlı Saha Uygulaması', 'Kazı ve hafriyat işlerinde saha düzeni ve iş güvenliği gereksinimlerini çalışma planına dahil ederiz.'],
    ['tag', 'Şeffaf Teklif', 'Fiyatı; iş süresi, makine tipi, nakliye, zemin ve çıkan malzeme gibi gerçek iş kalemlerine göre değerlendiririz.'],
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
            <?php $visibleCounters = array_filter([
                ['value' => trim((string) ($counters['experience'] ?? '')), 'label' => 'Yıllık Deneyim'],
                ['value' => trim((string) ($counters['projects'] ?? '')), 'label' => 'Tamamlanan Proje'],
                ['value' => trim((string) ($counters['staff'] ?? '')), 'label' => 'Uzman Personel'],
                ['value' => trim((string) ($counters['support'] ?? '')), 'label' => 'Destek Hizmeti'],
            ], fn ($item) => $item['value'] !== ''); ?>
            <?php if ($visibleCounters): ?>
            <div class="counters">
                <?php foreach ($visibleCounters as $counter): ?>
                    <div class="counter"><b><?= e($counter['value']) ?></b><span><?= e($counter['label']) ?></span></div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
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
        <div><h2>Hafriyat veya Kepçe Hizmeti mi İhtiyacınız Var?</h2><p>İşinizin kapsamını paylaşın; uygun makine ve çalışma planı için teklif isteyin.</p></div>
        <div class="final-cta__btns">
            <a href="<?= e(whatsapp_link('Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--dark"><?= icon('whatsapp', 18) ?> WhatsApp</a>
            <a href="<?= base_url('iletisim') ?>" class="btn btn--dark" style="background:#fff;color:#111"><?= icon('star', 17) ?> Teklif Al</a>
        </div>
    </div>
</section>
