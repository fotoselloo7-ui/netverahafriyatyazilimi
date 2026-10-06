<?php
/** Frontend lisans/bakım ekranı — lisans geçersizken site ön yüzü yerine gösterilir. */
$phone = setting('phone', '');
$mail = setting('email', '');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e(site_name()) ?> — Geçici Olarak Hizmet Dışı</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{font-family:'Poppins',sans-serif;background:linear-gradient(135deg,#141414,#1f1c14);min-height:100vh;display:grid;place-items:center;padding:20px;color:#e5e7eb}
        .box{background:#1d1d1d;border:1px solid rgba(255,255,255,.09);border-radius:18px;max-width:460px;width:100%;padding:38px 30px;text-align:center;box-shadow:0 24px 60px rgba(0,0,0,.5)}
        .ico{width:66px;height:66px;margin:0 auto 18px;display:grid;place-items:center;background:rgba(245,166,35,.14);color:#F5A623;border-radius:16px}
        h1{color:#fff;font-size:21px;margin-bottom:10px}
        p{color:#9aa0a6;font-size:14.5px;line-height:1.7;margin-bottom:22px}
        .brand{color:#F5A623;font-weight:700}
        .c{display:flex;flex-direction:column;gap:10px}
        .c a{display:flex;align-items:center;justify-content:center;gap:8px;min-height:46px;border-radius:11px;text-decoration:none;font-weight:600;font-size:14px}
        .ph{background:#F5A623;color:#111}
        .em{background:rgba(255,255,255,.07);color:#e5e7eb;border:1px solid rgba(255,255,255,.12)}
        .f{margin-top:22px;color:#6b7280;font-size:12px}
    </style>
</head>
<body>
    <div class="box">
        <div class="ico"><svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
        <h1>Geçici Olarak Hizmet Dışıyız</h1>
        <p><span class="brand"><?= e(site_name()) ?></span> web sitesi şu anda teknik doğrulama nedeniyle geçici olarak yayında değil. Kısa süre içinde tekrar hizmetinizdeyiz. Acil talepleriniz için bize ulaşabilirsiniz.</p>
        <div class="c">
            <?php if ($phone): ?><a class="ph" href="tel:<?= e(preg_replace('/[^0-9+]/', '', $phone)) ?>">&#9742; <?= e($phone) ?></a><?php endif; ?>
            <?php if ($mail): ?><a class="em" href="mailto:<?= e($mail) ?>"><?= e($mail) ?></a><?php endif; ?>
        </div>
        <div class="f"><?= e(site_name()) ?> — <?= date('Y') ?></div>
    </div>
</body>
</html>
