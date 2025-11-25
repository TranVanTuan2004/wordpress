<?php
/**
 * Debug Script - Check Data Status
 * Access: http://localhost/wordpress/wp-content/plugins/riot-complete-seeder/check-data.php
 */

require_once('../../../wp-load.php');

?>
<!DOCTYPE html>
<html>
<head>
    <title>RIOT Data Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #333; }
        .status {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
        }
        .success {
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        .error {
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #f8f9fa;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            background: #0073aa;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            margin: 10px 5px;
        }
        .button:hover {
            background: #005177;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 RIOT Cinema - Data Status Check</h1>
        
        <?php
        // Check if movie CPT is registered
        $movie_cpt_exists = post_type_exists('movie');
        $cinema_cpt_exists = post_type_exists('rap_phim');
        
        echo '<h2>1. Custom Post Types Status</h2>';
        
        if ($movie_cpt_exists) {
            echo '<div class="status success">✅ Movie CPT is registered</div>';
        } else {
            echo '<div class="status error">❌ Movie CPT is NOT registered - Please activate "Movies CPT" plugin!</div>';
        }
        
        if ($cinema_cpt_exists) {
            echo '<div class="status success">✅ Cinema CPT (rap_phim) is registered</div>';
        } else {
            echo '<div class="status warning">⚠️ Cinema CPT (rap_phim) is NOT registered</div>';
        }
        
        // Count posts
        echo '<h2>2. Data Count</h2>';
        echo '<table>';
        echo '<tr><th>Type</th><th>Count</th><th>Status</th></tr>';
        
        // Movies
        $movies_count = wp_count_posts('movie');
        $total_movies = $movies_count->publish ?? 0;
        echo '<tr>';
        echo '<td>🎬 Movies</td>';
        echo '<td>' . $total_movies . '</td>';
        echo '<td>' . ($total_movies > 0 ? '<span style="color: green;">✅ Has data</span>' : '<span style="color: red;">❌ No data</span>') . '</td>';
        echo '</tr>';
        
        // Cinemas
        $cinemas_count = wp_count_posts('rap_phim');
        $total_cinemas = $cinemas_count->publish ?? 0;
        echo '<tr>';
        echo '<td>🏢 Cinemas</td>';
        echo '<td>' . $total_cinemas . '</td>';
        echo '<td>' . ($total_cinemas > 0 ? '<span style="color: green;">✅ Has data</span>' : '<span style="color: red;">❌ No data</span>') . '</td>';
        echo '</tr>';
        
        // Blog posts
        $posts_count = wp_count_posts('post');
        $total_posts = $posts_count->publish ?? 0;
        echo '<tr>';
        echo '<td>📝 Blog Posts</td>';
        echo '<td>' . $total_posts . '</td>';
        echo '<td>' . ($total_posts > 0 ? '<span style="color: green;">✅ Has data</span>' : '<span style="color: red;">❌ No data</span>') . '</td>';
        echo '</tr>';
        
        echo '</table>';
        
        // Check active plugins
        echo '<h2>3. Required Plugins</h2>';
        $active_plugins = get_option('active_plugins');
        
        $movies_cpt_active = false;
        $seeder_active = false;
        
        foreach ($active_plugins as $plugin) {
            if (strpos($plugin, 'movies-cpt') !== false) {
                $movies_cpt_active = true;
            }
            if (strpos($plugin, 'riot-complete-seeder') !== false) {
                $seeder_active = true;
            }
        }
        
        if ($movies_cpt_active) {
            echo '<div class="status success">✅ Movies CPT Plugin is ACTIVE</div>';
        } else {
            echo '<div class="status error">❌ Movies CPT Plugin is NOT ACTIVE - Please activate it!</div>';
        }
        
        if ($seeder_active) {
            echo '<div class="status success">✅ RIOT Complete Seeder Plugin is ACTIVE</div>';
        } else {
            echo '<div class="status warning">⚠️ RIOT Complete Seeder Plugin is NOT ACTIVE</div>';
        }
        
        // Show recent movies if any
        if ($total_movies > 0) {
            echo '<h2>4. Recent Movies</h2>';
            $movies = get_posts(array(
                'post_type' => 'movie',
                'posts_per_page' => 5,
                'orderby' => 'date',
                'order' => 'DESC'
            ));
            
            echo '<table>';
            echo '<tr><th>Title</th><th>Status</th><th>Date</th></tr>';
            foreach ($movies as $movie) {
                echo '<tr>';
                echo '<td>' . esc_html($movie->post_title) . '</td>';
                echo '<td>' . $movie->post_status . '</td>';
                echo '<td>' . $movie->post_date . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
        
        // Recommendations
        echo '<h2>5. Recommendations</h2>';
        
        if (!$movie_cpt_exists) {
            echo '<div class="status error">';
            echo '<strong>CRITICAL:</strong> Movie CPT is not registered!<br>';
            echo '<strong>Solution:</strong> Go to WordPress Admin → Plugins → Activate "Movies CPT" plugin';
            echo '</div>';
        }
        
        if ($total_movies == 0 && $movie_cpt_exists) {
            echo '<div class="status warning">';
            echo '<strong>No movie data found!</strong><br>';
            echo '<strong>Solution:</strong> Go to WordPress Admin → RIOT Seeder → Click "Seed All Data Now"';
            echo '</div>';
        }
        
        if ($total_movies > 0 && $movie_cpt_exists) {
            echo '<div class="status success">';
            echo '<strong>Everything looks good!</strong> Your data is properly saved.';
            echo '</div>';
        }
        ?>
        
        <h2>6. Quick Actions</h2>
        <a href="<?php echo admin_url('plugins.php'); ?>" class="button">Manage Plugins</a>
        <a href="<?php echo admin_url('admin.php?page=riot-complete-seeder'); ?>" class="button">RIOT Seeder</a>
        <a href="<?php echo admin_url('edit.php?post_type=movie'); ?>" class="button">View Movies</a>
        <a href="<?php echo home_url(); ?>" class="button">Homepage</a>
        <a href="?refresh=1" class="button" style="background: #28a745;">Refresh Check</a>
    </div>
</body>
</html>
