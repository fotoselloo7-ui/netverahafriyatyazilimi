<aside class="blog-sidebar">
    <div class="scard" style="padding:22px;text-align:left;margin-bottom:22px">
        <h3 style="font-size:17px;margin-bottom:14px">Kategoriler</h3>
        <ul>
            <?php foreach (($categories ?? []) as $c): ?>
                <li style="padding:8px 0;border-bottom:1px solid var(--line)">
                    <a href="<?= base_url('blog/kategori/' . $c['slug']) ?>" style="display:flex;justify-content:space-between;font-size:14px">
                        <span><?= icon('chevron-right', 14) ?> <?= e($c['title']) ?></span>
                        <span style="color:var(--muted)"><?= (int) ($c['post_count'] ?? 0) ?></span>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="scard" style="padding:22px;text-align:left;margin-bottom:22px">
        <h3 style="font-size:17px;margin-bottom:14px">Son Yazılar</h3>
        <ul>
            <?php foreach (($recent ?? []) as $r): ?>
                <li style="display:flex;gap:12px;padding:10px 0;border-bottom:1px solid var(--line)">
                    <a href="<?= base_url('blog/' . $r['slug']) ?>" style="width:60px;height:52px;flex:none;border-radius:8px;overflow:hidden;background:linear-gradient(135deg,#2b2b2b,#151515)">
                        <?php if ($r['cover_image']): ?><img src="<?= e(upload_url($r['cover_image'])) ?>" alt="" style="width:100%;height:100%;object-fit:cover"><?php else: ?><span style="display:grid;place-items:center;height:100%;color:rgba(245,166,35,.5)"><?= icon('excavator', 22) ?></span><?php endif; ?>
                    </a>
                    <a href="<?= base_url('blog/' . $r['slug']) ?>" style="font-size:13.5px;font-weight:500;line-height:1.4"><?= e(str_excerpt($r['title'], 55)) ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="scard" style="padding:24px;text-align:center;background:var(--color-dark);color:#fff">
        <div style="color:var(--color-primary);margin-bottom:10px"><?= icon('whatsapp', 40) ?></div>
        <h3 style="color:#fff;font-size:17px;margin-bottom:8px">Teklif mi Almak İstiyorsunuz?</h3>
        <p style="color:#adb2b9;font-size:14px;margin-bottom:16px">Hafriyat veya kepçe kiralama için WhatsApp’tan hemen teklif alın.</p>
        <a href="<?= e(whatsapp_link('Merhaba, teklif almak istiyorum.')) ?>" target="_blank" rel="noopener" data-wa-event class="btn btn--wa btn--block"><?= icon('whatsapp', 17) ?> WhatsApp’tan Teklif Al</a>
    </div>
</aside>
