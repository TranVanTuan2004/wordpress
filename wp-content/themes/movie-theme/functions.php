<?php

/**
 * Movie Theme functions and definitions
 */

if (! function_exists('movie_theme_setup')) :
    function movie_theme_setup()
    {
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('custom-logo');
        add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));

        register_nav_menus(array(
            'primary' => __('Primary Menu', 'movie-theme'),
        ));
    }
endif;
add_action('after_setup_theme', 'movie_theme_setup');

// Enqueue styles and scripts
function movie_theme_enqueue_assets()
{
    wp_enqueue_style('movie-theme-style', get_stylesheet_uri());
    wp_enqueue_style('movie-theme-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    wp_enqueue_script('movie-theme-main', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'movie_theme_enqueue_assets');

// Register custom post type: movie
function movie_theme_register_post_type()
{
    $labels = array(
        'name'               => __('Movies', 'movie-theme'),
        'singular_name'      => __('Movie', 'movie-theme'),
        'menu_name'          => __('Movies', 'movie-theme'),
        'name_admin_bar'     => __('Movie', 'movie-theme'),
        'add_new'            => __('Add New', 'movie-theme'),
        'add_new_item'       => __('Add New Movie', 'movie-theme'),
        'new_item'           => __('New Movie', 'movie-theme'),
        'edit_item'          => __('Edit Movie', 'movie-theme'),
        'view_item'          => __('View Movie', 'movie-theme'),
        'all_items'          => __('All Movies', 'movie-theme'),
        'search_items'       => __('Search Movies', 'movie-theme'),
        'not_found'          => __('No movies found.', 'movie-theme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => array('slug' => 'movies'),
        'supports'           => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'show_in_rest'       => true,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-video-alt3',
    );

    register_post_type('movie', $args);

    // Genre taxonomy
    $tax_labels = array(
        'name'              => _x('Genres', 'taxonomy general name', 'movie-theme'),
        'singular_name'     => _x('Genre', 'taxonomy singular name', 'movie-theme'),
        'search_items'      => __('Search Genres', 'movie-theme'),
        'all_items'         => __('All Genres', 'movie-theme'),
        'edit_item'         => __('Edit Genre', 'movie-theme'),
        'update_item'       => __('Update Genre', 'movie-theme'),
        'add_new_item'      => __('Add New Genre', 'movie-theme'),
        'new_item_name'     => __('New Genre Name', 'movie-theme'),
    );

    register_taxonomy('genre', array('movie'), array(
        'hierarchical'      => true,
        'labels'            => $tax_labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'rewrite'           => array('slug' => 'genre'),
    ));
}
add_action('init', 'movie_theme_register_post_type');

// Shortcode to list movies
function movie_theme_movie_list_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'posts_per_page' => 12,
        'genre' => '',
    ), $atts, 'movie_list');

    $args = array(
        'post_type' => 'movie',
        'posts_per_page' => intval($atts['posts_per_page']),
    );

    if (! empty($atts['genre'])) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'genre',
                'field' => 'slug',
                'terms' => sanitize_text_field($atts['genre']),
            ),
        );
    }

    $q = new WP_Query($args);
    ob_start();
    if ($q->have_posts()) {
        echo '<div class="movie-grid">';
        while ($q->have_posts()) {
            $q->the_post();
            echo '<div class="movie-card">';
            if (has_post_thumbnail()) {
                echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail(get_the_ID(), 'medium') . '</a>';
            }
            echo '<div class="movie-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></div>';
            echo '<div class="movie-meta">' . get_the_excerpt() . '</div>';
            echo '</div>';
        }
        echo '</div>';
        wp_reset_postdata();
    } else {
        echo '<p>No movies found.</p>';
    }

    return ob_get_clean();
}
add_shortcode('movie_list', 'movie_theme_movie_list_shortcode');

// Register image sizes
add_action('after_setup_theme', function () {
    add_image_size('movie-thumb', 400, 225, true);
});
