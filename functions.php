<?php
/**
 * Fooz Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package fooz
 */

add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'twentytwentyfive-style', get_template_directory_uri() . '/style.css', array(), '0.1.0' );
	wp_enqueue_style(
		'fooz-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twentytwentyfive-style' ),
		'0.1.0'
	);

	wp_enqueue_script(
		'fooz-script',
		get_stylesheet_directory_uri() . '/assets/js/scripts.js',
		array(),
		'1.0.0',
		true
	);

	if (is_singular('book')) {
		global $post;
		wp_localize_script('fooz-script', 'foozData', [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'currentBookId' => $post->ID,
			'noOtherBooks' => __('No other books.', 'fooz'),
		]);
	} else {
		wp_localize_script('fooz-script', 'foozData', [
			'ajaxUrl' => admin_url('admin-ajax.php'),
			'currentBookId' => 0,
			'noOtherBooks' => __('No other books.', 'fooz'),
		]);
	}
});

add_action('init', function() {
    register_post_type('book', [
        'label' => _x('Books', 'post type general name', 'fooz'),
        'labels' => [
            'name' => _x('Books', 'post type general name', 'fooz'),
            'singular_name' => _x('Book', 'post type singular name', 'fooz'),
            'add_new' => _x('Add New', 'book', 'fooz'),
            'add_new_item' => __('Add New Book', 'fooz'),
            'edit_item' => __('Edit Book', 'fooz'),
            'new_item' => __('New Book', 'fooz'),
            'view_item' => __('View Book', 'fooz'),
            'search_items' => __('Search Books', 'fooz'),
            'not_found' => __('No books found', 'fooz'),
            'not_found_in_trash' => __('No books found in Trash', 'fooz'),
            'all_items' => __('All Books', 'fooz'),
        ],
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'library', 'with_front' => false],
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-book',
    ]);
    register_taxonomy('genre', 'book', [
        'label' => _x('Genres', 'taxonomy general name', 'fooz'),
        'labels' => [
            'name' => _x('Genres', 'taxonomy general name', 'fooz'),
            'singular_name' => _x('Genre', 'taxonomy singular name', 'fooz'),
            'search_items' => __('Search Genres', 'fooz'),
            'all_items' => __('All Genres', 'fooz'),
            'edit_item' => __('Edit Genre', 'fooz'),
            'update_item' => __('Update Genre', 'fooz'),
            'add_new_item' => __('Add New Genre', 'fooz'),
            'new_item_name' => __('New Genre Name', 'fooz'),
            'menu_name' => __('Genre', 'fooz'),
        ],
        'public' => true,
        'hierarchical' => true,
        'rewrite' => ['slug' => 'book-genre', 'with_front' => false, 'hierarchical' => true],
        'show_in_rest' => true,
    ]);

    $blocks_dir = get_stylesheet_directory() . '/blocks/';
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($blocks_dir)
    );
    foreach ($iterator as $file) {
        if ($file->getFilename() === 'block.json') {
            register_block_type($file->getPath());
        }
    }
});

add_action('wp_ajax_nopriv_get_latest_books', 'fooz_get_latest_books');
add_action('wp_ajax_get_latest_books', 'fooz_get_latest_books');

function fooz_get_latest_books() {
    $exclude = isset($_GET['exclude']) ? intval($_GET['exclude']) : 0;
    $args = [
        'post_type' => 'book',
        'posts_per_page' => 20,
        'post__not_in' => [$exclude],
    ];
    $q = new WP_Query($args);
    $books = [];
    foreach ($q->posts as $post) {
        $genre = get_the_terms($post->ID, 'genre');
        $books[] = [
            'title' => get_the_title($post),
            'date' => get_the_date('', $post),
            'genre' => $genre ? $genre[0]->name : '',
            'excerpt' => get_the_excerpt($post),
            'permalink' => get_permalink($post),
        ];
        echo paginate_links([
        'total' => $q->max_num_pages,
        'current' => $paged,
        ]);
    }
    wp_send_json($books);
}
