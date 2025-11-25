<?php
/**
 * Template Name: Debug Cinema Data
 * 
 * Temporary debug page to check cinema and movie data
 */

get_header();
?>

<div style="background: #0b1221; color: #e5e7eb; padding: 40px 20px; min-height: 100vh;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <h1 style="color: #ffe44d; margin-bottom: 30px;">🔍 Debug: Cinema & Movie Data</h1>
        
        <?php
        // Check MBS Movies
        $movies = get_posts(array(
            'post_type' => 'mbs_movie',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        echo '<div style="background: rgba(15,23,42,.9); border: 1px solid rgba(148,163,184,.14); border-radius: 14px; padding: 20px; margin-bottom: 20px;">';
        echo '<h2 style="color: #fff; margin-top: 0;">🎬 MBS Movies (' . count($movies) . ')</h2>';
        if (!empty($movies)) {
            echo '<ul style="list-style: none; padding: 0;">';
            foreach ($movies as $movie) {
                echo '<li style="padding: 8px 0; border-bottom: 1px solid rgba(148,163,184,.1);">';
                echo '<strong>' . esc_html($movie->post_title) . '</strong> (ID: ' . $movie->ID . ')';
                $duration = get_post_meta($movie->ID, '_mbs_duration', true);
                $rating = get_post_meta($movie->ID, '_mbs_rating', true);
                echo '<br><small style="color: #94a3b8;">Duration: ' . esc_html($duration) . ' | Rating: ' . esc_html($rating) . '</small>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p style="color: #d63638;">❌ No movies found!</p>';
        }
        echo '</div>';
        
        // Check MBS Cinemas
        $cinemas = get_posts(array(
            'post_type' => 'mbs_cinema',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        echo '<div style="background: rgba(15,23,42,.9); border: 1px solid rgba(148,163,184,.14); border-radius: 14px; padding: 20px; margin-bottom: 20px;">';
        echo '<h2 style="color: #fff; margin-top: 0;">🏢 MBS Cinemas (' . count($cinemas) . ')</h2>';
        if (!empty($cinemas)) {
            echo '<ul style="list-style: none; padding: 0;">';
            foreach ($cinemas as $cinema) {
                echo '<li style="padding: 8px 0; border-bottom: 1px solid rgba(148,163,184,.1);">';
                echo '<strong><a href="' . get_permalink($cinema->ID) . '" style="color: #ffe44d; text-decoration: none;">' . esc_html($cinema->post_title) . '</a></strong> (ID: ' . $cinema->ID . ')';
                $address = get_post_meta($cinema->ID, '_mbs_address', true);
                echo '<br><small style="color: #94a3b8;">Address: ' . esc_html($address) . '</small>';
                echo '</li>';
            }
            echo '</ul>';
        } else {
            echo '<p style="color: #d63638;">❌ No cinemas found!</p>';
        }
        echo '</div>';
        
        // Check MBS Showtimes
        $showtimes = get_posts(array(
            'post_type' => 'mbs_showtime',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        ));
        
        echo '<div style="background: rgba(15,23,42,.9); border: 1px solid rgba(148,163,184,.14); border-radius: 14px; padding: 20px; margin-bottom: 20px;">';
        echo '<h2 style="color: #fff; margin-top: 0;">🎫 MBS Showtimes (' . count($showtimes) . ')</h2>';
        if (!empty($showtimes)) {
            echo '<ul style="list-style: none; padding: 0; max-height: 400px; overflow-y: auto;">';
            foreach (array_slice($showtimes, 0, 10) as $showtime) {
                $movie_id = get_post_meta($showtime->ID, '_mbs_movie_id', true);
                $cinema_id = get_post_meta($showtime->ID, '_mbs_cinema_id', true);
                $datetime = get_post_meta($showtime->ID, '_mbs_showtime', true);
                $format = get_post_meta($showtime->ID, '_mbs_format', true);
                
                echo '<li style="padding: 8px 0; border-bottom: 1px solid rgba(148,163,184,.1);">';
                echo '<strong>' . esc_html($showtime->post_title) . '</strong>';
                echo '<br><small style="color: #94a3b8;">';
                echo 'Movie ID: ' . $movie_id . ' | Cinema ID: ' . $cinema_id . ' | Time: ' . $datetime . ' | Format: ' . $format;
                echo '</small>';
                echo '</li>';
            }
            if (count($showtimes) > 10) {
                echo '<li style="padding: 8px 0; color: #94a3b8;"><em>... and ' . (count($showtimes) - 10) . ' more</em></li>';
            }
            echo '</ul>';
        } else {
            echo '<p style="color: #d63638;">❌ No showtimes found!</p>';
        }
        echo '</div>';
        
        // Check old CPTs
        $old_movies = get_posts(array('post_type' => movie_theme_get_movie_post_type(), 'posts_per_page' => -1));
        $old_cinemas = get_posts(array('post_type' => 'rap_phim', 'posts_per_page' => -1));
        
        echo '<div style="background: rgba(236,72,153,.1); border: 1px solid rgba(236,72,153,.3); border-radius: 14px; padding: 20px;">';
        echo '<h2 style="color: #fff; margin-top: 0;">⚠️ Old CPT Data</h2>';
        echo '<p>Old "movie" CPT: <strong>' . count($old_movies) . '</strong> posts</p>';
        echo '<p>Old "rap_phim" CPT: <strong>' . count($old_cinemas) . '</strong> posts</p>';
        if (count($old_movies) > 0 || count($old_cinemas) > 0) {
            echo '<p style="color: #fbbf24;">⚠️ You have old data! Consider deleting it.</p>';
        }
        echo '</div>';
        ?>
        
        <div style="margin-top: 30px; padding: 20px; background: rgba(79,70,229,.1); border: 1px solid rgba(79,70,229,.3); border-radius: 14px;">
            <h3 style="color: #fff; margin-top: 0;">💡 Quick Actions</h3>
            <p><a href="<?php echo admin_url('admin.php?page=mbs-sample-data'); ?>" style="color: #ffe44d;">→ Go to Sample Data Manager</a></p>
            <p><a href="<?php echo admin_url('options-permalink.php'); ?>" style="color: #ffe44d;">→ Flush Permalinks (Settings → Permalinks → Save)</a></p>
        </div>
    </div>
</div>

<?php
get_footer();
?>
