<section class="final-cta">
    <div class="container final-cta__inner">
        <div>
            <h2><?= e($cta_title ?? 'Hafriyat veya Kepçe Hizmeti mi İhtiyacınız Var?') ?></h2>
            <p><?= e($cta_sub ?? 'Hemen bize ulaşın, ücretsiz keşif ve en uygun fiyat teklifini alın.') ?></p>
        </div>
        <div class="final-cta__btns">
            <a href="<?= e(whatsapp_link($cta_wa ?? 'Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--dark"><?= icon('whatsapp', 18) ?> WhatsApp</a>
            <a href="<?= base_url('iletisim') ?>" class="btn btn--dark" style="background:#fff;color:#111"><?= icon('star', 17) ?> Teklif Al</a>
        </div>
    </div>
</section>
