<?php
$schemaRegions = \App\Models\ServiceRegion::active('sort_order ASC, id ASC');
$schemaAreaServed = array_values(array_map(fn ($r) => (string) $r['title'], $schemaRegions));
$schema = [
    '@context' => 'https://schema.org',
    '@type' => 'LocalBusiness',
    'name' => site_name(),
    'description' => setting('seo_description', ''),
    'telephone' => setting('phone', ''),
    'email' => setting('email', ''),
    'url' => base_url(),
    'image' => setting('og_image') ? upload_url(setting('og_image')) : asset('img/og-default.svg'),
    'address' => [
        '@type' => 'PostalAddress',
        'streetAddress' => setting('address', ''),
        'addressLocality' => 'Alanya',
        'addressRegion' => 'Antalya',
        'addressCountry' => 'TR',
    ],
    'openingHours' => setting('working_hours', ''),
    'areaServed' => $schemaAreaServed,
];
?>
<script type="application/ld+json"><?= json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php if (!empty($jsonLd)): ?>
<script type="application/ld+json"><?= json_encode($jsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endif; ?>
<?php if (!empty($faqJsonLd)): ?>
<script type="application/ld+json"><?= json_encode($faqJsonLd, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endif; ?>
<?php if (!empty($breadcrumb) && is_array($breadcrumb)): ?>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'BreadcrumbList',
    'itemListElement' => array_values(array_map(fn ($c, $i) => [
        '@type' => 'ListItem', 'position' => $i + 1, 'name' => $c[0],
    ] + ($c[1] ? ['item' => $c[1]] : []), array_values($breadcrumb), array_keys(array_values($breadcrumb)))),
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
<?php endif; ?>
