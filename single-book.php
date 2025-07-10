<?php
get_header();
global $post;
?>
<main>
    <h1><?= get_the_title() ?></h1>
    <?php if (has_post_thumbnail()): ?>
        <?= get_the_post_thumbnail(null, 'large') ?>
    <?php endif; ?>
    <div>
        <strong><?= __('Genre:', 'fooz') ?></strong> <?= get_the_term_list($post->ID, 'genre', '', ', ') ?: '—' ?>
    </div>
    <div>
        <strong><?= __('Published:', 'fooz') ?></strong> <?= get_the_date() ?>
    </div>
    <article>
        <?= apply_filters('the_content', get_the_content()) ?>
    </article>
    <hr>
    <h2><?= __('Other Books', 'fooz') ?></h2>
    <div id="latest-books"></div>
</main>
<?php
get_footer();