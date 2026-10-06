<?php
/** @var string $content */
$seo = $seo ?? [];
$seoTitle = $seo['title'] ?? ($pageTitle ?? site_name());
$seoDesc  = $seo['description'] ?? setting('seo_description', '');
$ogTitle  = $seo['og_title'] ?? $seoTitle;
$ogDesc   = $seo['og_description'] ?? $seoDesc;
$ogImage  = $seo['og_image'] ?? setting('og_image', '');
$twTitle  = $seo['twitter_title'] ?? $ogTitle;
$twDesc   = $seo['twitter_description'] ?? $ogDesc;
$twImage  = $seo['twitter_image'] ?? $ogImage;
$canonical = $seo['canonical'] ?? base_url(ltrim(current_path(), '/'));
$robots = (($seo['robots'] ?? true) ? 'index' : 'noindex') . ', ' . (($seo['robots_follow'] ?? true) ? 'follow' : 'nofollow');
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($seoTitle) ?></title>
    <meta name="description" content="<?= e($seoDesc) ?>">
    <meta name="robots" content="<?= e($robots) ?>">
    <link rel="canonical" href="<?= e($canonical) ?>">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="<?= e(site_name()) ?>">
    <meta property="og:title" content="<?= e($ogTitle) ?>">
    <meta property="og:description" content="<?= e($ogDesc) ?>">
    <meta property="og:url" content="<?= e($canonical) ?>">
    <?php if ($ogImage): ?><meta property="og:image" content="<?= e(upload_url($ogImage)) ?>"><?php endif; ?>
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($twTitle) ?>">
    <meta name="twitter:description" content="<?= e($twDesc) ?>">
    <?php if ($twImage): ?><meta name="twitter:image" content="<?= e(upload_url($twImage)) ?>"><?php endif; ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/svg+xml" href="<?= asset('img/favicon.svg') ?>">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>?v=19">
    <?php include VIEW_PATH . '/partials/schema.php'; ?>

    <?php
    // Tema tokenları — eksik/otomatik alanlar kontrast helper'ı ile hesaplanır.
    $tPrimary   = theme('primary_color', '#F5A400');
    $tSecondary = theme('secondary_color', '#111827');
    $tSecondaryText = theme('secondary_text_color') ?: get_contrast_text($tSecondary);
    $tDark      = theme('dark_color', '#080B0F');
    $tAccent    = theme('accent_color', '#FFB703');
    $tAccentText = get_contrast_text($tAccent);
    $tBg        = theme('background_color', '#F7F4EF');
    $tText      = theme('text_color', '#111827');
    $tWa        = theme('whatsapp_color', '#25D366');
    $tSurface   = theme('surface_color') ?: '#FFFFFF';
    $tMuted     = theme('muted_text_color') ?: '#64748B';
    $tBorder    = theme('border_color') ?: '#E5E7EB';
    $tPrimaryHover = theme('primary_hover_color') ?: contrast_darken($tPrimary);
    $tPrimaryText  = theme('primary_text_color') ?: get_contrast_text($tPrimary);
    $tBtnPrimaryBg = theme('button_primary_bg') ?: $tPrimary;
    $tBtnPrimaryText = theme('button_primary_text') ?: get_contrast_text($tBtnPrimaryBg);
    $tBtnDarkBg    = theme('button_dark_bg') ?: $tDark;
    $tBtnDarkText  = theme('button_dark_text') ?: get_contrast_text($tBtnDarkBg);
    ?>
    <style>
        :root {
            --color-primary: <?= e($tPrimary) ?>;
            --color-primary-hover: <?= e($tPrimaryHover) ?>;
            --color-primary-text: <?= e($tPrimaryText) ?>;
            --color-secondary: <?= e($tSecondary) ?>;
            --color-secondary-text: <?= e($tSecondaryText) ?>;
            --color-dark: <?= e($tDark) ?>;
            --color-accent: <?= e($tAccent) ?>;
            --color-accent-text: <?= e($tAccentText) ?>;
            --color-bg: <?= e($tBg) ?>;
            --color-surface: <?= e($tSurface) ?>;
            --color-text: <?= e($tText) ?>;
            --color-muted: <?= e($tMuted) ?>;
            --color-border: <?= e($tBorder) ?>;
            --color-whatsapp: <?= e($tWa) ?>;
            --button-primary-bg: <?= e($tBtnPrimaryBg) ?>;
            --button-primary-text: <?= e($tBtnPrimaryText) ?>;
            --button-dark-bg: <?= e($tBtnDarkBg) ?>;
            --button-dark-text: <?= e($tBtnDarkText) ?>;
            --radius-button: <?= e(theme('border_radius', '10px')) ?>;
            --radius-card: <?= e(theme('card_radius', '14px')) ?>;
            --shadow-strength: <?= e(theme('shadow_strength', '0.10')) ?>;
        }
    </style>
</head>
<body>
<?php include VIEW_PATH . '/partials/topbar.php'; ?>
<?php include VIEW_PATH . '/partials/header.php'; ?>

<main id="main">
    <?= $content ?>
</main>

<?php include VIEW_PATH . '/partials/footer.php'; ?>
<?php if ((string) setting('floating_whatsapp_enabled', '0') === '1') { include VIEW_PATH . '/partials/floating.php'; } ?>
<?php include VIEW_PATH . '/partials/mobile-bar.php'; ?>
<?php if (!empty($popup) && (int) ($popup['is_active'] ?? 0) === 1) { include VIEW_PATH . '/partials/popup.php'; } ?>

<script>window.__CSRF="<?= e(csrf_token()) ?>";</script>
<script src="<?= asset('js/app.js') ?>?v=8" defer></script>
</body>
</html>
