<?php $ph_title = $page['hero_title'] ?: $page['title']; $ph_sub = $page['hero_subtitle'] ?: ''; $ph_img = $page['hero_image'] ?: $page['cover_image']; include VIEW_PATH . '/partials/page-hero.php'; ?>

<section class="section">
    <div class="container">
        <div class="prose"><?= $page['content'] ?></div>
    </div>
</section>
