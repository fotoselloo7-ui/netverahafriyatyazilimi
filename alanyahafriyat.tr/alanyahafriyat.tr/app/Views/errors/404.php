<section class="section" style="text-align:center;padding:90px 0">
    <div class="container">
        <div style="color:var(--color-primary);margin-bottom:10px"><?= icon('excavator', 90) ?></div>
        <h1 style="font-size:72px;color:var(--color-primary);line-height:1">404</h1>
        <h2 style="margin:6px 0 12px">Sayfa Bulunamadı</h2>
        <p style="color:var(--muted);max-width:480px;margin:0 auto 26px">Aradığınız sayfa taşınmış ya da kaldırılmış olabilir. Ana sayfaya dönebilir veya bize ulaşabilirsiniz.</p>
        <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap">
            <a href="<?= base_url() ?>" class="btn btn--primary"><?= icon('arrow-right', 17) ?> Ana Sayfaya Dön</a>
            <a href="<?= e(whatsapp_link('Merhaba, bilgi almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa"><?= icon('whatsapp', 17) ?> WhatsApp Teklif Al</a>
        </div>
    </div>
</section>
