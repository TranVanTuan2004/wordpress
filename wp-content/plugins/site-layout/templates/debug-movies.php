<!-- DEBUG: Kiểm tra Movies -->
<div style="background: white; padding: 40px; margin: 40px; border: 3px solid red;">
    <h2>🔍 DEBUG - Kiểm Tra Movies</h2>
    
    <hr>
    <h3>1. Kiểm tra tất cả Movies:</h3>
    <?php
    $all_movies = new WP_Query(array(
        'post_type' => 'movie',
        'posts_per_page' => -1
    ));
    
    echo '<p><strong>Tổng số phim:</strong> ' . $all_movies->found_posts . '</p>';
    
    if ($all_movies->have_posts()) {
        echo '<ul>';
        while ($all_movies->have_posts()) {
            $all_movies->the_post();
            $movie_id = get_the_ID();
            $statuses = wp_get_post_terms($movie_id, 'movie_status');
            $status_names = array();
            foreach ($statuses as $status) {
                $status_names[] = $status->name . ' (slug: ' . $status->slug . ')';
            }
            echo '<li>';
            echo '<strong>' . get_the_title() . '</strong><br>';
            echo 'ID: ' . $movie_id . '<br>';
            echo 'Trạng thái: ' . implode(', ', $status_names) . '<br>';
            echo 'Rating: ' . get_post_meta($movie_id, 'movie_rating', true) . '<br>';
            echo 'Has thumbnail: ' . (has_post_thumbnail($movie_id) ? 'YES' : 'NO') . '<br>';
            echo '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p style="color: red;">❌ Không có phim nào!</p>';
    }
    ?>
    
    <hr>
    <h3>2. Kiểm tra Taxonomy "movie_status":</h3>
    <?php
    $all_statuses = get_terms(array(
        'taxonomy' => 'movie_status',
        'hide_empty' => false
    ));
    
    if (!empty($all_statuses) && !is_wp_error($all_statuses)) {
        echo '<p><strong>Có ' . count($all_statuses) . ' trạng thái:</strong></p>';
        echo '<ul>';
        foreach ($all_statuses as $status) {
            echo '<li>';
            echo '<strong>' . $status->name . '</strong>';
            echo ' (Slug: <code>' . $status->slug . '</code>)';
            echo ' - Count: ' . $status->count;
            echo '</li>';
        }
        echo '</ul>';
    } else {
        echo '<p style="color: red;">❌ Chưa có taxonomy "movie_status"!</p>';
        echo '<p>👉 Vào <strong>Phim → Trạng Thái</strong> và tạo 2 terms:</p>';
        echo '<ul>';
        echo '<li>Name: <strong>Đang chiếu</strong>, Slug: <code>dang-chieu</code></li>';
        echo '<li>Name: <strong>Sắp chiếu</strong>, Slug: <code>sap-chieu</code></li>';
        echo '</ul>';
    }
    ?>
    
    <hr>
    <h3>3. Query phim "Đang chiếu" (slug: dang-chieu):</h3>
    <?php
    $now_showing = new WP_Query(array(
        'post_type' => 'movie',
        'posts_per_page' => 10,
        'tax_query' => array(
            array(
                'taxonomy' => 'movie_status',
                'field' => 'slug',
                'terms' => 'dang-chieu'
            )
        )
    ));
    
    echo '<p><strong>Số phim tìm thấy:</strong> ' . $now_showing->found_posts . '</p>';
    
    if ($now_showing->have_posts()) {
        echo '<ul>';
        while ($now_showing->have_posts()) {
            $now_showing->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p style="color: red;">❌ Không tìm thấy phim "Đang chiếu"</p>';
        echo '<p>Nguyên nhân có thể:</p>';
        echo '<ul>';
        echo '<li>Chưa có phim nào có taxonomy "Đang chiếu" với slug "dang-chieu"</li>';
        echo '<li>Slug không đúng (phải là <code>dang-chieu</code>, không có dấu)</li>';
        echo '</ul>';
    }
    ?>
    
    <hr>
    <h3>4. Query phim "Sắp chiếu" (slug: sap-chieu):</h3>
    <?php
    $coming_soon = new WP_Query(array(
        'post_type' => 'movie',
        'posts_per_page' => 10,
        'tax_query' => array(
            array(
                'taxonomy' => 'movie_status',
                'field' => 'slug',
                'terms' => 'sap-chieu'
            )
        )
    ));
    
    echo '<p><strong>Số phim tìm thấy:</strong> ' . $coming_soon->found_posts . '</p>';
    
    if ($coming_soon->have_posts()) {
        echo '<ul>';
        while ($coming_soon->have_posts()) {
            $coming_soon->the_post();
            echo '<li>' . get_the_title() . '</li>';
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<p style="color: red;">❌ Không tìm thấy phim "Sắp chiếu"</p>';
    }
    ?>
    
    <hr>
    <h3>5. Kiểm tra Thể Loại (movie_genre):</h3>
    <?php
    $all_genres = get_terms(array(
        'taxonomy' => 'movie_genre',
        'hide_empty' => false
    ));
    
    if (!empty($all_genres) && !is_wp_error($all_genres)) {
        echo '<p><strong>Có ' . count($all_genres) . ' thể loại:</strong></p>';
        echo '<ul>';
        foreach ($all_genres as $genre) {
            echo '<li>' . $genre->name . ' (' . $genre->count . ' phim)</li>';
        }
        echo '</ul>';
    } else {
        echo '<p style="color: orange;">⚠️ Chưa có thể loại nào</p>';
    }
    ?>
    
    <hr>
    <h3>✅ GIẢ PHÁP:</h3>
    <ol>
        <li><strong>Vào Phim → Trạng Thái</strong></li>
        <li>Kiểm tra có 2 terms với slug chính xác:
            <ul>
                <li><code>dang-chieu</code> (không dấu, không viết hoa)</li>
                <li><code>sap-chieu</code> (không dấu, không viết hoa)</li>
            </ul>
        </li>
        <li><strong>Chỉnh sửa các phim</strong> và chọn đúng Trạng thái</li>
        <li><strong>Refresh lại trang Home</strong></li>
    </ol>
    
    <hr>
    <p style="background: #ffeb3b; padding: 10px; border-radius: 5px;">
        <strong>📍 Shortcode Debug:</strong> <code>[debug_movies]</code>
    </p>
</div>

