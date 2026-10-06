<?php $ph_title = 'Sık Sorulan Sorular'; $ph_sub = 'Merak edilen soruların cevapları'; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="faq">
            <?php foreach ($faqs as $f): ?>
                <div class="faq__item">
                    <button class="faq__q" type="button"><?= e($f['question']) ?><span class="plus"><?= icon('plus', 16) ?></span></button>
                    <div class="faq__a"><div class="faq__a-inner"><?= e($f['answer']) ?></div></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include VIEW_PATH . '/partials/cta.php'; ?>
