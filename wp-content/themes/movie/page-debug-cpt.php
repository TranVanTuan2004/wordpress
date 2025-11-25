<?php
/**
 * Template Name: Debug CPT
 */
get_header();
?>
<div style="padding: 100px 20px; background: #fff; color: #000;">
    <h1>Debug Post ID: 378</h1>
    <?php
    $post_id = 378;
    $p = get_post($post_id);
    if ($p) {
        echo '<ul>';
        echo '<li><strong>ID:</strong> ' . $p->ID . '</li>';
        echo '<li><strong>Title:</strong> ' . $p->post_title . '</li>';
        echo '<li><strong>Type:</strong> ' . $p->post_type . '</li>';
        echo '<li><strong>Status:</strong> ' . $p->post_status . '</li>';
        echo '<li><strong>GUID:</strong> ' . $p->guid . '</li>';
        echo '</ul>';

        // Check Post Type Object
        $pt_obj = get_post_type_object($p->post_type);
        echo '<h2>Post Type Object (' . $p->post_type . ')</h2>';
        if ($pt_obj) {
            echo '<ul>';
            echo '<li><strong>Public:</strong> ' . ($pt_obj->public ? 'Yes' : 'No') . '</li>';
            echo '<li><strong>Publicly Queryable:</strong> ' . ($pt_obj->publicly_queryable ? 'Yes' : 'No') . '</li>';
            echo '<li><strong>Exclude From Search:</strong> ' . ($pt_obj->exclude_from_search ? 'Yes' : 'No') . '</li>';
            echo '<li><strong>Show UI:</strong> ' . ($pt_obj->show_ui ? 'Yes' : 'No') . '</li>';
            echo '<li><strong>Has Archive:</strong> ' . ($pt_obj->has_archive ? 'Yes' : 'No') . '</li>';
            echo '<li><strong>Rewrite:</strong> <pre>' . print_r($pt_obj->rewrite, true) . '</pre></li>';
            echo '</ul>';
        } else {
            echo '<p style="color:red;">Post type object not found!</p>';
        }

    } else {
        echo '<p style="color:red;">Post 378 not found!</p>';
    }
    ?>
    
    <hr>
    
    <h1>All Cinemas</h1>
    <?php
    $candidates = array('rap_phim','rap-phim','cinema','theater','mbs_cinema','rap','rapfilm','rap_phim_cpt');
    foreach ($candidates as $cpt) {
        $q = new WP_Query(array('post_type' => $cpt, 'posts_per_page' => -1, 'post_status' => 'any'));
        if ($q->have_posts()) {
            echo '<h2>Type: ' . $cpt . '</h2>';
            echo '<ul>';
            while ($q->have_posts()) {
                $q->the_post();
                echo '<li>ID: ' . get_the_ID() . ' | Title: ' . get_the_title() . ' | Status: '. get_post_status() .' | <a href="' . get_permalink() . '">Link</a></li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        }
    }
    ?>
</div>
<?php get_footer(); ?>
