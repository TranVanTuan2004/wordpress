<?php
/**
 * Template Name: Lịch Chiếu (Showtime Schedule)
 */
get_header();

// 1. Get Filter Parameters
$filter_date   = isset($_GET['date']) ? sanitize_text_field($_GET['date']) : date('Y-m-d');
$filter_movie  = isset($_GET['movie']) ? intval($_GET['movie']) : 0;
$filter_cinema = isset($_GET['cinema']) ? intval($_GET['cinema']) : 0;

// 2. Fetch Data for Filters
// Dates: Next 7 days
$dates = array();
for ($i=0; $i<7; $i++) {
    $d = date('Y-m-d', strtotime("+$i days"));
    $dates[$d] = date('d/m', strtotime($d)) . ' (' . date('D', strtotime($d)) . ')';
    if ($i==0) $dates[$d] = 'Hôm nay ' . date('d/m');
}

// 2. Fetch Data for Filters & Display
// Movies: All "Now Showing" movies
$movie_args = array(
    'post_type'      => 'mbs_movie',
    'posts_per_page' => -1,
    'orderby'        => 'title',
    'order'          => 'ASC',
    'meta_query'     => array(
        array(
            'key'     => '_movie_status',
            'value'   => 'dang-chieu',
            'compare' => '='
        )
    )
);
$movies = get_posts($movie_args);

// Cinemas: All published cinemas
$cinemas = get_posts(array('post_type'=>array('mbs_cinema','rap_phim','rap-phim','cinema'), 'posts_per_page'=>-1, 'orderby'=>'title', 'order'=>'ASC'));

// 3. Fetch Real Showtimes
global $wpdb;
$st_table = $wpdb->prefix . 'mbs_showtimes';
$table_exists = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $st_table));

$real_showtimes = array(); // [movie_id][cinema_id] => array(times)

// A. From Custom Table
if ($table_exists === $st_table) {
    $sql = "SELECT * FROM $st_table WHERE show_date = %s";
    $rows = $wpdb->get_results($wpdb->prepare($sql, $filter_date));
    if ($rows) {
        foreach ($rows as $r) {
            $real_showtimes[$r->movie_id][$r->cinema_id][] = substr($r->show_time, 0, 5);
        }
    }
}

// B. From CPT (Fallback/Merge)
if (post_type_exists('mbs_showtime')) {
    $args_cpt = array(
        'post_type' => 'mbs_showtime',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_mbs_showtime',
                'value' => $filter_date,
                'compare' => 'LIKE'
            )
        )
    );
    $q_cpt = new WP_Query($args_cpt);
    if ($q_cpt->have_posts()) {
        while ($q_cpt->have_posts()) {
            $q_cpt->the_post();
            $mid = get_post_meta(get_the_ID(), '_mbs_movie_id', true);
            $cid = get_post_meta(get_the_ID(), '_mbs_cinema_id', true);
            $dt  = get_post_meta(get_the_ID(), '_mbs_showtime', true);
            
            if ($mid && $cid && $dt) {
                $ts = strtotime($dt);
                if ($ts) {
                    $date_part = date('Y-m-d', $ts);
                    $time_part = date('H:i', $ts);
                    if ($date_part === $filter_date) {
                        if (!isset($real_showtimes[$mid][$cid]) || !in_array($time_part, $real_showtimes[$mid][$cid])) {
                            $real_showtimes[$mid][$cid][] = $time_part;
                        }
                    }
                }
            }
        }
        wp_reset_postdata();
    }
}

// 4. Build Grouped Data (Universal Logic)
$grouped = array();

// Filter lists if specific movie/cinema selected
$target_movies = $movies;
if ($filter_movie) {
    $target_movies = array_filter($movies, function($m) use ($filter_movie) { return $m->ID == $filter_movie; });
}

$target_cinemas = $cinemas;
if ($filter_cinema) {
    // Handle duplicates by title if needed, but for now just filter by ID or Title match
    $c_obj = get_post($filter_cinema);
    if ($c_obj) {
        $target_cinemas = array_filter($cinemas, function($c) use ($c_obj) { 
            return $c->ID == $c_obj->ID || $c->post_title === $c_obj->post_title; 
        });
    }
}

$default_times = array('09:00', '11:30', '14:00', '16:30', '19:00', '21:30');

foreach ($target_movies as $movie) {
    $mid = $movie->ID;
    
    $grouped[$mid] = array(
        'title' => $movie->post_title,
        'poster' => get_the_post_thumbnail_url($mid, 'medium'),
        'cinemas' => array()
    );
    
    foreach ($target_cinemas as $cinema) {
        $cid = $cinema->ID;
        $c_name = $cinema->post_title;
        
        // Check for real showtimes
        $times = array();
        if (isset($real_showtimes[$mid][$cid])) {
            $times = $real_showtimes[$mid][$cid];
        } else {
            // Use defaults
            $times = $default_times;
        }
        
        // Group by Cinema Name to merge duplicates visually
        if (!isset($grouped[$mid]['cinemas'][$c_name])) {
            $grouped[$mid]['cinemas'][$c_name] = array(
                'id' => $cid,
                'name' => $c_name,
                'times' => array()
            );
        }
        
        // Merge times
        foreach ($times as $t) {
            if (!in_array($t, $grouped[$mid]['cinemas'][$c_name]['times'])) {
                $grouped[$mid]['cinemas'][$c_name]['times'][] = $t;
            }
        }
    }
}
?>

<div class="lc-page">
    <div class="lc-container">
        <!-- FILTERS -->
        <form class="lc-filters" method="GET" action="">
            <div class="lc-filter-group">
                <label>1. Ngày</label>
                <div class="lc-select-wrapper">
                    <select name="date">
                        <?php foreach ($dates as $d => $label): ?>
                            <option value="<?php echo $d; ?>" <?php selected($filter_date, $d); ?>><?php echo $label; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-calendar-alt"></i>
                </div>
            </div>
            
            <div class="lc-filter-group">
                <label>2. Phim</label>
                <div class="lc-select-wrapper">
                    <select name="movie">
                        <option value="0">Tất cả phim</option>
                        <?php foreach ($movies as $m): ?>
                            <option value="<?php echo $m->ID; ?>" <?php selected($filter_movie, $m->ID); ?>><?php echo $m->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-film"></i>
                </div>
            </div>
            
            <div class="lc-filter-group">
                <label>3. Rạp</label>
                <div class="lc-select-wrapper">
                    <select name="cinema">
                        <option value="0">Tất cả rạp</option>
                        <?php foreach ($cinemas as $c): ?>
                            <option value="<?php echo $c->ID; ?>" <?php selected($filter_cinema, $c->ID); ?>><?php echo $c->post_title; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-map-marker-alt"></i>
                </div>
            </div>
            
            <div class="lc-filter-group lc-filter-submit">
                <label>&nbsp;</label>
                <button type="submit" class="lc-search-btn">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
        
        <!-- RESULTS -->
        <div class="lc-results">
            <?php if (empty($grouped)): ?>
                <div class="lc-empty">Không tìm thấy suất chiếu nào phù hợp.</div>
            <?php else: ?>
                <?php foreach ($grouped as $mid => $movie): ?>
                    <div class="lc-movie-card">
                        <div class="lc-movie-poster">
                            <img src="<?php echo $movie['poster'] ?: 'https://via.placeholder.com/300x450'; ?>" alt="<?php echo esc_attr($movie['title']); ?>">
                        </div>
                        <div class="lc-movie-info">
                            <h2 class="lc-movie-title"><a href="<?php echo get_permalink($mid); ?>"><?php echo $movie['title']; ?></a></h2>
                            <div class="lc-movie-meta">
                                <?php 
                                    $genres = wp_get_post_terms($mid, 'mbs_genre', array('fields'=>'names'));
                                    echo implode(', ', $genres);
                                ?>
                            </div>
                            
                            <div class="lc-cinemas-list">
                                <?php foreach ($movie['cinemas'] as $c_name => $cinema): ?>
                                    <div class="lc-cinema-row">
                                        <h3 class="lc-cinema-name"><?php echo $c_name; ?></h3>
                                        <div class="lc-times">
                                            <?php 
                                            sort($cinema['times']);
                                            foreach ($cinema['times'] as $time): 
                                                $book_link = home_url('/datve/');
                                                $book_link = add_query_arg(array(
                                                    'cinema' => $cinema['id'],
                                                    'movie'  => $mid,
                                                    'date'   => $filter_date,
                                                    'time'   => $time
                                                ), $book_link);
                                            ?>
                                                <a href="<?php echo esc_url($book_link); ?>" class="lc-time-chip"><?php echo $time; ?></a>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<style>
    .lc-page {
        background-color: #0b1221;
        min-height: 100vh;
        color: #fff;
        padding: 40px 0;
        font-family: 'Inter', sans-serif;
    }
    .lc-container {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    /* Filters */
    .lc-filters {
        display: flex;
        gap: 20px;
        background: #0f1b31;
        padding: 20px;
        border-radius: 12px;
        border: 1px solid rgba(148,163,184,0.15);
        margin-bottom: 40px;
    }
    .lc-filter-group {
        flex: 1;
    }
    .lc-filter-submit {
        flex: 0 0 auto;
        min-width: 140px;
    }
    .lc-search-btn {
        width: 100%;
        padding: 12px 20px;
        background: #ffe44d;
        color: #000;
        border: none;
        border-radius: 6px;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .lc-search-btn:hover {
        background: #ffd700;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255,228,77,0.4);
    }
    .lc-filter-group label {
        display: block;
        margin-bottom: 8px;
        color: #ffe44d;
        font-weight: 700;
        font-size: 16px;
    }
    .lc-select-wrapper {
        position: relative;
    }
    .lc-select-wrapper select {
        width: 100%;
        padding: 12px 40px 12px 16px;
        background: #fff;
        color: #333;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        /* Remove appearance to use native dropdown */
        -webkit-appearance: menulist;
        -moz-appearance: menulist;
        appearance: menulist;
    }
    .lc-select-wrapper select option {
        padding: 8px;
        background: #fff;
        color: #333;
    }
    .lc-select-wrapper i {
        position: absolute;
        right: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        pointer-events: none;
    }
    
    /* Results */
    .lc-movie-card {
        display: flex;
        background: rgba(15,23,42,0.6);
        border: 1px solid rgba(148,163,184,0.15);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
    }
    .lc-movie-poster {
        width: 200px;
        flex-shrink: 0;
    }
    .lc-movie-poster img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .lc-movie-info {
        padding: 24px;
        flex: 1;
    }
    .lc-movie-title {
        margin: 0 0 8px;
        font-size: 24px;
    }
    .lc-movie-title a {
        color: #fff;
        text-decoration: none;
    }
    .lc-movie-title a:hover {
        color: #ffe44d;
    }
    .lc-movie-meta {
        color: #94a3b8;
        margin-bottom: 20px;
        font-size: 14px;
    }
    
    .lc-cinema-row {
        border-top: 1px solid rgba(255,255,255,0.1);
        padding: 16px 0;
    }
    .lc-cinema-row:first-child {
        border-top: none;
        padding-top: 0;
    }
    .lc-cinema-name {
        font-size: 16px;
        color: #fff;
        margin: 0 0 12px;
        font-weight: 600;
    }
    .lc-times {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }
    .lc-time-chip {
        display: inline-block;
        padding: 8px 16px;
        background: transparent;
        border: 1px solid #6b7280;
        color: #e5e7eb;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 600;
        font-size: 14px;
        transition: all 0.2s;
    }
    .lc-time-chip:hover {
        background: #ffe44d;
        color: #000;
        border-color: #ffe44d;
    }
    
    .lc-empty {
        text-align: center;
        padding: 40px;
        color: #94a3b8;
        font-size: 18px;
    }
    
    @media (max-width: 768px) {
        .lc-filters {
            flex-direction: column;
        }
        .lc-movie-card {
            flex-direction: column;
        }
        .lc-movie-poster {
            width: 100%;
            height: 300px;
        }
    }
</style>

<?php get_footer(); ?>
