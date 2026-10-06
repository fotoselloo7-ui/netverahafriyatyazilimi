<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Girişi | <?= e(site_name()) ?></title>
    <meta name="robots" content="noindex, nofollow">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--primary:<?= e(theme('primary_color', '#F5A623')) ?>;--dark:<?= e(theme('dark_color', '#111')) ?>}
        *{box-sizing:border-box;margin:0}
        body{font-family:'Poppins',sans-serif;background:var(--dark);min-height:100vh;display:grid;place-items:center;padding:20px;
        background-image:radial-gradient(1000px 400px at 50% -10%,#2a2620 0,transparent 60%)}
        .login{background:#1b1b1b;border:1px solid rgba(255,255,255,.08);border-radius:18px;padding:38px 32px;width:100%;max-width:400px;box-shadow:0 20px 60px rgba(0,0,0,.5)}
        .login__brand{display:flex;align-items:center;gap:10px;justify-content:center;margin-bottom:8px}
        .login__mark{width:46px;height:46px;display:grid;place-items:center;background:var(--primary);color:#111;border-radius:12px}
        .login__brand b{color:#fff;font-size:20px}.login__brand b span{color:var(--primary)}
        .login h1{color:#fff;font-size:18px;text-align:center;margin:16px 0 4px;font-weight:600}
        .login p{color:#9aa0a6;text-align:center;font-size:13px;margin-bottom:22px}
        .login label{display:block;color:#c9ccd1;font-size:13px;margin-bottom:6px;font-weight:500}
        .login .f{margin-bottom:16px}
        .login input{width:100%;padding:12px 14px;border-radius:10px;border:1px solid rgba(255,255,255,.14);background:rgba(255,255,255,.05);color:#fff;font-family:inherit;font-size:14px}
        .login input:focus{outline:none;border-color:var(--primary)}
        .login button{width:100%;padding:13px;border:none;border-radius:10px;background:var(--primary);color:#111;font-weight:700;font-size:15px;cursor:pointer;font-family:inherit;margin-top:4px}
        .login button:hover{filter:brightness(.95)}
        .err{background:rgba(220,60,60,.15);border:1px solid rgba(220,60,60,.4);color:#f1a3a3;padding:11px 14px;border-radius:10px;font-size:13px;margin-bottom:18px}
        .login__foot{text-align:center;margin-top:18px}
        .login__foot a{color:#9aa0a6;font-size:13px;text-decoration:none}
        .login__foot a:hover{color:var(--primary)}
        .hint{margin-top:14px;padding:10px;background:rgba(245,166,35,.08);border-radius:8px;color:#c9a25a;font-size:12px;text-align:center}
    </style>
</head>
<body>
    <div class="login">
        <div class="login__brand">
            <span class="login__mark"><svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20h18"/><path d="M5 20v-4h5v4"/><rect x="5" y="9" width="5" height="4" rx="1"/><path d="M10 11h4l6-4"/></svg></span>
            <b><?= e(explode(' ', site_name())[0]) ?><span><?= e(trim(substr(site_name(), strlen(explode(' ', site_name())[0])))) ?></span></b>
        </div>
        <h1>Yönetim Paneli</h1>
        <p>Devam etmek için giriş yapın</p>
        <?php if (!empty($error)): ?><div class="err"><?= e($error) ?></div><?php endif; ?>
        <form method="post" action="<?= base_url('yonetim/giris') ?>">
            <?= csrf_field() ?>
            <div class="f"><label>E-posta</label><input type="email" name="email" required autofocus value="admin@ersanhafriyat.local"></div>
            <div class="f"><label>Şifre</label><input type="password" name="password" required></div>
            <button type="submit">Giriş Yap</button>
        </form>
        <div class="login__foot"><a href="<?= base_url() ?>">&larr; Siteye Dön</a></div>
    </div>
</body>
</html>
