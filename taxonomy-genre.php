<?php
get_header();
$paged = max(1, get_query_var('paged'));
$term = get_queried_object();
global $wp_query;
$wp_query = new WP_Query([
    'post_type' => 'book',
    'posts_per_page' => 5,
    'paged' => $paged,
    'tax_query' => [
        [
            'taxonomy' => 'genre',
            'field' => 'term_id',
            'terms' => $term->term_id,
        ]
    ]
]);
?>

<main>
    <h1><?= $term->name ?></h1>
    <?php if (have_posts()): ?>
        <?php while (have_posts()): the_post(); ?>
            <div>
                <a href="<?= get_permalink() ?>"><strong><?= get_the_title() ?></strong></a><br>
                <span><?= get_the_date() ?></span> | <span><?= get_the_term_list(get_the_ID(), 'genre', '', ', ') ?></span><br>
                <small><?= get_the_excerpt() ?></small>
            </div>
            <hr>
        <?php endwhile; ?>
            <?= paginate_links([
                'total' => $wp_query->max_num_pages,
                'current' => $paged,
                'prev_text' => __('« Previous', 'fooz'),
                'next_text' => __('Next »', 'fooz')]);
            ?>
    <?php else: ?>
        <p><?= __('No books found in this genre.', 'fooz') ?></p>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</main>
<?php
get_footer();