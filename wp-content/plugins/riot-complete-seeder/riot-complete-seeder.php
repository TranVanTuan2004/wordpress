<?php
/**
 * Plugin Name: RIOT Cinema Complete Data Seeder
 * Description: Comprehensive data seeder for RIOT Cinema theme - Movies, Cinemas, Blogs, Showtimes
 * Version: 1.0
 * Author: RIOT Cinema
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class RIOT_Complete_Seeder {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
    }
    
    public function add_admin_menu() {
        add_menu_page(
            'RIOT Data Seeder',
            'RIOT Seeder',
            'manage_options',
            'riot-complete-seeder',
            array($this, 'admin_page'),
            'dashicons-database-import',
            100
        );
    }
    
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>🎬 RIOT Cinema Complete Data Seeder</h1>
            <p>Seed comprehensive test data for your cinema website.</p>
            
            <?php
            if (isset($_POST['seed_all']) && check_admin_referer('seed_all_action', 'seed_all_nonce')) {
                $this->seed_all_data();
            }
            
            if (isset($_POST['delete_all']) && check_admin_referer('delete_all_action', 'delete_all_nonce')) {
                $this->delete_all_data();
            }
            
            // Check existing data
            $movies_count = wp_count_posts('movie');
            $cinemas_count = wp_count_posts('rap_phim');
            $total_movies = $movies_count->publish ?? 0;
            $total_cinemas = $cinemas_count->publish ?? 0;
            
            if ($total_movies > 0 || $total_cinemas > 0) {
                echo '<div class="notice notice-warning" style="padding: 15px; margin: 20px 0;">';
                echo '<h3 style="margin-top: 0;">⚠️ Existing Data Detected!</h3>';
                echo '<p><strong>Current data:</strong></p>';
                echo '<ul>';
                echo '<li>🎬 Movies: ' . $total_movies . '</li>';
                echo '<li>🏢 Cinemas: ' . $total_cinemas . '</li>';
                echo '</ul>';
                echo '<p><strong style="color: #d63638;">Warning:</strong> Running the seeder again will CREATE MORE data (duplicates). If you want to start fresh, please delete existing data first.</p>';
                echo '</div>';
            }
            ?>
            
            <div class="card" style="max-width: 800px;">
                <h2>What will be seeded:</h2>
                <ul style="line-height: 2;">
                    <li>✅ <strong>10 Movies</strong> - Complete with genres, ratings, trailers, IMDb scores</li>
                    <li>✅ <strong>8 Cinemas</strong> - Across Vietnam with addresses and contact info</li>
                    <li>✅ <strong>15 Blog Posts</strong> - Movie news and reviews</li>
                    <li>✅ <strong>30 Showtimes</strong> - Movie schedules across cinemas</li>
                    <li>✅ <strong>5 Users</strong> - Test accounts for different roles</li>
                </ul>
                
                <form method="post" style="margin-top: 20px;">
                    <?php wp_nonce_field('seed_all_action', 'seed_all_nonce'); ?>
                    <button type="submit" name="seed_all" class="button button-primary button-hero">
                        🚀 Seed All Data Now
                    </button>
                </form>
                
                <?php if ($total_movies > 0 || $total_cinemas > 0): ?>
                <form method="post" style="margin-top: 20px;" onsubmit="return confirm('⚠️ This will DELETE all seeded Movies, Cinemas, and Blog posts! Are you sure?');">
                    <?php wp_nonce_field('delete_all_action', 'delete_all_nonce'); ?>
                    <button type="submit" name="delete_all" class="button button-secondary button-hero" style="background: #d63638; border-color: #d63638; color: white;">
                        🗑️ Delete All Seeded Data
                    </button>
                    <p style="color: #666; font-size: 12px; margin-top: 10px;">This will delete all Movies, Cinemas, and Blog posts created by the seeder.</p>
                </form>
                <?php endif; ?>
            </div>
        </div>
        
        <style>
            .seed-result {
                margin-top: 20px;
                padding: 20px;
                background: #fff;
                border-left: 4px solid #00a32a;
            }
            .seed-result h3 {
                margin-top: 0;
                color: #00a32a;
            }
            .seed-result ul {
                list-style: none;
                padding: 0;
            }
            .seed-result li {
                padding: 5px 0;
            }
            .delete-result {
                margin-top: 20px;
                padding: 20px;
                background: #fff;
                border-left: 4px solid #d63638;
            }
            .delete-result h3 {
                margin-top: 0;
                color: #d63638;
            }
        </style>
        <?php
    }
    
    public function seed_all_data() {
        echo '<div class="seed-result">';
        echo '<h3>✅ Seeding Complete!</h3>';
        echo '<ul>';
        
        // Seed Movies
        $movies_count = $this->seed_movies();
        echo '<li>🎬 Created ' . $movies_count . ' movies</li>';
        
        // Seed Cinemas
        $cinemas_count = $this->seed_cinemas();
        echo '<li>🏢 Created ' . $cinemas_count . ' cinemas</li>';
        
        // Seed Blogs
        $blogs_count = $this->seed_blogs();
        echo '<li>📝 Created ' . $blogs_count . ' blog posts</li>';
        
        // Seed Showtimes
        $showtimes_count = $this->seed_showtimes();
        echo '<li>🎫 Created ' . $showtimes_count . ' showtimes</li>';
        
        // Seed Users
        $users_count = $this->seed_users();
        echo '<li>👥 Created ' . $users_count . ' test users</li>';
        
        echo '</ul>';
        echo '<p><strong>All data has been seeded successfully!</strong></p>';
        echo '<p><a href="' . home_url() . '" class="button">View Homepage</a></p>';
        echo '</div>';
    }
    
    private function seed_movies() {
        $movies = array(
            array(
                'title' => 'The Dark Knight',
                'content' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'genre' => 'Action',
                'status' => 'Đang chiếu',
                'rating' => '13+',
                'duration' => '152',
                'release_date' => '2024-01-15',
                'trailer_url' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
                'imdb_rating' => '9.0'
            ),
            array(
                'title' => 'Inception',
                'content' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'genre' => 'Sci-Fi',
                'status' => 'Đang chiếu',
                'rating' => '13+',
                'duration' => '148',
                'release_date' => '2024-02-01',
                'trailer_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'imdb_rating' => '8.8'
            ),
            array(
                'title' => 'Interstellar',
                'content' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'genre' => 'Sci-Fi',
                'status' => 'Đang chiếu',
                'rating' => '13+',
                'duration' => '169',
                'release_date' => '2024-02-15',
                'trailer_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
                'imdb_rating' => '8.7'
            ),
            array(
                'title' => 'Parasite',
                'content' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.',
                'genre' => 'Thriller',
                'status' => 'Sắp chiếu',
                'rating' => '16+',
                'duration' => '132',
                'release_date' => '2024-03-01',
                'trailer_url' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
                'imdb_rating' => '8.5'
            ),
            array(
                'title' => 'Avengers: Endgame',
                'content' => 'After the devastating events of Avengers: Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more.',
                'genre' => 'Action',
                'status' => 'Đang chiếu',
                'rating' => '13+',
                'duration' => '181',
                'release_date' => '2024-01-20',
                'trailer_url' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
                'imdb_rating' => '8.4'
            ),
            array(
                'title' => 'Joker',
                'content' => 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime.',
                'genre' => 'Drama',
                'status' => 'Đang chiếu',
                'rating' => '18+',
                'duration' => '122',
                'release_date' => '2024-02-10',
                'trailer_url' => 'https://www.youtube.com/watch?v=zAGVQLHvwOY',
                'imdb_rating' => '8.4'
            ),
            array(
                'title' => 'Spider-Man: No Way Home',
                'content' => 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help. When a spell goes wrong, dangerous foes from other worlds start to appear.',
                'genre' => 'Action',
                'status' => 'Sắp chiếu',
                'rating' => '13+',
                'duration' => '148',
                'release_date' => '2024-03-15',
                'trailer_url' => 'https://www.youtube.com/watch?v=JfVOs4VSpmA',
                'imdb_rating' => '8.2'
            ),
            array(
                'title' => 'The Shawshank Redemption',
                'content' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'genre' => 'Drama',
                'status' => 'Đang chiếu',
                'rating' => '16+',
                'duration' => '142',
                'release_date' => '2024-01-25',
                'trailer_url' => 'https://www.youtube.com/watch?v=6hB3S9bIaco',
                'imdb_rating' => '9.3'
            ),
            array(
                'title' => 'Pulp Fiction',
                'content' => 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.',
                'genre' => 'Crime',
                'status' => 'Sắp chiếu',
                'rating' => '18+',
                'duration' => '154',
                'release_date' => '2024-03-20',
                'trailer_url' => 'https://www.youtube.com/watch?v=s7EdQ4FqbhY',
                'imdb_rating' => '8.9'
            ),
            array(
                'title' => 'The Matrix',
                'content' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
                'genre' => 'Sci-Fi',
                'status' => 'Đang chiếu',
                'rating' => '13+',
                'duration' => '136',
                'release_date' => '2024-02-05',
                'trailer_url' => 'https://www.youtube.com/watch?v=vKQi3bBA1y8',
                'imdb_rating' => '8.7'
            )
        );

        $created = 0;
        foreach ($movies as $movie_data) {
            $post_id = wp_insert_post(array(
                'post_title'   => $movie_data['title'],
                'post_content' => $movie_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'movie',
                'post_author'  => 1
            ));

            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, 'movie_rating', $movie_data['rating']);
                update_post_meta($post_id, 'movie_duration', $movie_data['duration']);
                update_post_meta($post_id, 'movie_release_date', $movie_data['release_date']);
                update_post_meta($post_id, 'movie_trailer_url', $movie_data['trailer_url']);
                update_post_meta($post_id, 'movie_imdb_rating', $movie_data['imdb_rating']);

                // Set genre
                $genre_term = term_exists($movie_data['genre'], 'movie_genre');
                if (!$genre_term) {
                    $genre_term = wp_insert_term($movie_data['genre'], 'movie_genre');
                }
                if (!is_wp_error($genre_term)) {
                    wp_set_post_terms($post_id, array($genre_term['term_id']), 'movie_genre');
                }

                // Set status
                $status_term = term_exists($movie_data['status'], 'movie_status');
                if (!$status_term) {
                    $status_term = wp_insert_term($movie_data['status'], 'movie_status');
                }
                if (!is_wp_error($status_term)) {
                    wp_set_post_terms($post_id, array($status_term['term_id']), 'movie_status');
                }

                $created++;
            }
        }

        return $created;
    }
    
    private function seed_cinemas() {
        $cinemas = array(
            array(
                'title' => 'RIOT Cinema Hà Nội',
                'content' => 'Rạp chiếu phim hiện đại nhất tại trung tâm Hà Nội với hệ thống âm thanh Dolby Atmos và màn hình IMAX.',
                'address' => '123 Đường Láng, Đống Đa, Hà Nội',
                'phone' => '024-1234-5678',
                'screens' => '8',
                'seats' => '1200'
            ),
            array(
                'title' => 'RIOT Cinema Sài Gòn',
                'content' => 'Cụm rạp cao cấp tại TP.HCM với 10 phòng chiếu, bao gồm 2 phòng IMAX và 1 phòng 4DX.',
                'address' => '456 Nguyễn Huệ, Quận 1, TP.HCM',
                'phone' => '028-9876-5432',
                'screens' => '10',
                'seats' => '1500'
            ),
            array(
                'title' => 'RIOT Cinema Đà Nẵng',
                'content' => 'Rạp chiếu phim sang trọng tại trung tâm Đà Nẵng với view biển tuyệt đẹp.',
                'address' => '789 Trần Phú, Hải Châu, Đà Nẵng',
                'phone' => '0236-111-2233',
                'screens' => '6',
                'seats' => '900'
            ),
            array(
                'title' => 'RIOT Cinema Cần Thơ',
                'content' => 'Rạp chiếu phim đầu tiên tại miền Tây với đầy đủ tiện nghi hiện đại.',
                'address' => '321 Mậu Thân, Ninh Kiều, Cần Thơ',
                'phone' => '0292-333-4444',
                'screens' => '5',
                'seats' => '750'
            ),
            array(
                'title' => 'RIOT Cinema Hải Phòng',
                'content' => 'Cụm rạp hiện đại tại thành phố cảng với hệ thống ghế VIP cao cấp.',
                'address' => '555 Lạch Tray, Ngô Quyền, Hải Phòng',
                'phone' => '0225-555-6666',
                'screens' => '7',
                'seats' => '1050'
            ),
            array(
                'title' => 'RIOT Cinema Nha Trang',
                'content' => 'Rạp chiếu phim view biển độc đáo tại Nha Trang.',
                'address' => '888 Trần Phú, Nha Trang, Khánh Hòa',
                'phone' => '0258-777-8888',
                'screens' => '5',
                'seats' => '800'
            ),
            array(
                'title' => 'RIOT Cinema Huế',
                'content' => 'Rạp chiếu phim mang phong cách cổ kính kết hợp hiện đại tại cố đô Huế.',
                'address' => '234 Lê Lợi, TP Huế, Thừa Thiên Huế',
                'phone' => '0234-999-0000',
                'screens' => '4',
                'seats' => '600'
            ),
            array(
                'title' => 'RIOT Cinema Vũng Tàu',
                'content' => 'Rạp chiếu phim nghỉ dưỡng tại thành phố biển Vũng Tàu.',
                'address' => '678 Thùy Vân, Vũng Tàu, Bà Rịa - Vũng Tàu',
                'phone' => '0254-123-4567',
                'screens' => '4',
                'seats' => '650'
            )
        );

        $created = 0;
        foreach ($cinemas as $cinema_data) {
            $post_id = wp_insert_post(array(
                'post_title'   => $cinema_data['title'],
                'post_content' => $cinema_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'rap_phim',
                'post_author'  => 1
            ));

            if ($post_id && !is_wp_error($post_id)) {
                update_post_meta($post_id, 'cinema_address', $cinema_data['address']);
                update_post_meta($post_id, 'cinema_phone', $cinema_data['phone']);
                update_post_meta($post_id, 'cinema_screens', $cinema_data['screens']);
                update_post_meta($post_id, 'cinema_seats', $cinema_data['seats']);
                $created++;
            }
        }

        return $created;
    }
    
    private function seed_blogs() {
        $blogs = array(
            array(
                'title' => 'Top 10 Phim Bom Tấn Không Thể Bỏ Lỡ Năm 2024',
                'content' => 'Năm 2024 hứa hẹn sẽ là một năm bùng nổ của điện ảnh thế giới với hàng loạt bom tấn đình đám. Từ các siêu anh hùng Marvel, DC cho đến những tác phẩm nghệ thuật độc lập, khán giả sẽ có vô vàn lựa chọn để thưởng thức.'
            ),
            array(
                'title' => '5 Lý Do Bạn Nên Xem Phim Tại Rạp Thay Vì Ở Nhà',
                'content' => 'Trải nghiệm xem phim tại rạp mang lại những cảm giác khác biệt hoàn toàn so với xem tại nhà. Từ màn hình lớn, âm thanh sống động cho đến không khí đặc biệt, rạp chiếu phim vẫn là lựa chọn số một cho người yêu điện ảnh.'
            ),
            array(
                'title' => 'Hướng Dẫn Đặt Vé Xem Phim Online Nhanh Chóng',
                'content' => 'Đặt vé xem phim online giúp bạn tiết kiệm thời gian và đảm bảo có chỗ ngồi ưng ý. Bài viết này sẽ hướng dẫn chi tiết cách đặt vé qua website và app di động một cách đơn giản nhất.'
            ),
            array(
                'title' => 'Review: The Dark Knight - Kiệt Tác Điện Ảnh Siêu Anh Hùng',
                'content' => 'The Dark Knight không chỉ là một bộ phim siêu anh hùng thông thường mà còn là một tác phẩm nghệ thuật đỉnh cao. Với diễn xuất xuất sắc của Heath Ledger và đạo diễn tài ba Christopher Nolan, phim đã để lại dấu ấn sâu đậm trong lòng khán giả.'
            ),
            array(
                'title' => 'Khám Phá Công Nghệ IMAX - Trải Nghiệm Điện Ảnh Đỉnh Cao',
                'content' => 'IMAX mang đến trải nghiệm xem phim hoàn toàn khác biệt với màn hình khổng lồ và âm thanh vòm đa chiều. Tìm hiểu về công nghệ này và tại sao bạn nên thử ít nhất một lần trong đời.'
            ),
            array(
                'title' => 'Lịch Sử Phát Triển Của Điện Ảnh Việt Nam',
                'content' => 'Điện ảnh Việt Nam đã trải qua hành trình phát triển dài với nhiều thăng trầm. Từ những bộ phim đầu tiên cho đến các tác phẩm hiện đại, ngành công nghiệp phim Việt đang ngày càng khẳng định vị thế của mình.'
            ),
            array(
                'title' => 'Top 5 Rạp Chiếu Phim Đẹp Nhất Việt Nam',
                'content' => 'Việt Nam hiện có rất nhiều rạp chiếu phim hiện đại với thiết kế đẹp mắt và trang thiết bị tiên tiến. Cùng khám phá 5 rạp chiếu phim đẹp nhất và đáng để bạn ghé thăm.'
            ),
            array(
                'title' => 'Bí Quyết Chọn Ghế Ngồi Tốt Nhất Trong Rạp Chiếu Phim',
                'content' => 'Vị trí ghế ngồi ảnh hưởng rất lớn đến trải nghiệm xem phim của bạn. Bài viết này sẽ chia sẻ những bí quyết để chọn được ghế ngồi tốt nhất, đảm bảo góc nhìn và âm thanh hoàn hảo.'
            ),
            array(
                'title' => 'Combo Bắp Nước - Món Ăn Không Thể Thiếu Khi Xem Phim',
                'content' => 'Bắp rang bơ và nước ngọt đã trở thành biểu tượng của văn hóa xem phim. Tìm hiểu về lịch sử của combo này và tại sao nó lại gắn liền với trải nghiệm rạp chiếu phim.'
            ),
            array(
                'title' => 'Phim 3D vs 2D: Nên Chọn Loại Nào?',
                'content' => 'Công nghệ 3D mang lại trải nghiệm sống động nhưng không phải lúc nào cũng là lựa chọn tốt nhất. So sánh ưu nhược điểm của cả hai định dạng để bạn có thể đưa ra quyết định phù hợp.'
            ),
            array(
                'title' => 'Những Bộ Phim Kinh Dị Đáng Xem Nhất Mọi Thời Đại',
                'content' => 'Thể loại kinh dị luôn thu hút một lượng lớn khán giả yêu thích cảm giác hồi hộp, sợ hãi. Cùng điểm qua những tác phẩm kinh dị kinh điển mà mọi fan của thể loại này không nên bỏ lỡ.'
            ),
            array(
                'title' => 'Tại Sao Phim Hoạt Hình Không Chỉ Dành Cho Trẻ Em?',
                'content' => 'Phim hoạt hình hiện đại đã phát triển xa hơn nhiều so với chỉ là giải trí cho trẻ em. Nhiều tác phẩm hoạt hình mang thông điệp sâu sắc và kỹ thuật làm phim tinh tế, thu hút cả khán giả trưởng thành.'
            ),
            array(
                'title' => 'Hậu Trường Làm Phim: Những Điều Bạn Chưa Biết',
                'content' => 'Đằng sau mỗi bộ phim là công sức của hàng trăm người với nhiều công đoạn phức tạp. Khám phá hậu trường sản xuất phim để hiểu rõ hơn về quá trình tạo ra những tác phẩm điện ảnh.'
            ),
            array(
                'title' => 'Xu Hướng Điện Ảnh 2024: Những Gì Đang Hot',
                'content' => 'Ngành công nghiệp điện ảnh không ngừng thay đổi và phát triển. Năm 2024 chứng kiến nhiều xu hướng mới từ công nghệ CGI cho đến cách kể chuyện sáng tạo.'
            ),
            array(
                'title' => 'Cách Tận Hưởng Trọn Vẹn Trải Nghiệm Xem Phim',
                'content' => 'Xem phim không chỉ đơn giản là ngồi và theo dõi màn hình. Có rất nhiều cách để nâng cao trải nghiệm của bạn, từ việc chọn thời điểm phù hợp, chuẩn bị tinh thần cho đến cách thưởng thức từng khung hình.'
            )
        );

        $created = 0;
        foreach ($blogs as $blog_data) {
            $post_id = wp_insert_post(array(
                'post_title'   => $blog_data['title'],
                'post_content' => $blog_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'post',
                'post_author'  => 1,
                'post_category' => array(1)
            ));

            if ($post_id && !is_wp_error($post_id)) {
                $created++;
            }
        }

        return $created;
    }
    
    private function seed_showtimes() {
        // Get all movies and cinemas
        $movies = get_posts(array('post_type' => 'movie', 'posts_per_page' => -1));
        $cinemas = get_posts(array('post_type' => 'rap_phim', 'posts_per_page' => -1));
        
        if (empty($movies) || empty($cinemas)) {
            return 0;
        }
        
        $created = 0;
        $times = array('10:00', '13:00', '16:00', '19:00', '22:00');
        
        // Create showtimes for each movie at random cinemas
        foreach ($movies as $movie) {
            // Each movie gets 3-4 random showtimes
            $num_showtimes = rand(3, 4);
            $selected_cinemas = array_rand(array_flip(array_keys($cinemas)), min($num_showtimes, count($cinemas)));
            
            if (!is_array($selected_cinemas)) {
                $selected_cinemas = array($selected_cinemas);
            }
            
            foreach ($selected_cinemas as $cinema_index) {
                $cinema = $cinemas[$cinema_index];
                $time = $times[array_rand($times)];
                
                // Store showtime as post meta
                $showtime_data = array(
                    'cinema_id' => $cinema->ID,
                    'time' => $time,
                    'date' => date('Y-m-d', strtotime('+' . rand(0, 7) . ' days')),
                    'price' => rand(80, 150) . '000',
                    'available_seats' => rand(50, 200)
                );
                
                add_post_meta($movie->ID, 'showtime_' . $cinema->ID . '_' . $time, $showtime_data);
                $created++;
            }
        }
        
        return $created;
    }
    
    private function seed_users() {
        $users = array(
            array(
                'username' => 'testuser1',
                'email' => 'user1@riot.cinema',
                'password' => 'Test@123',
                'role' => 'subscriber',
                'display_name' => 'Nguyễn Văn A'
            ),
            array(
                'username' => 'testuser2',
                'email' => 'user2@riot.cinema',
                'password' => 'Test@123',
                'role' => 'subscriber',
                'display_name' => 'Trần Thị B'
            ),
            array(
                'username' => 'testuser3',
                'email' => 'user3@riot.cinema',
                'password' => 'Test@123',
                'role' => 'subscriber',
                'display_name' => 'Lê Văn C'
            ),
            array(
                'username' => 'testeditor',
                'email' => 'editor@riot.cinema',
                'password' => 'Test@123',
                'role' => 'editor',
                'display_name' => 'Editor Test'
            ),
            array(
                'username' => 'testauthor',
                'email' => 'author@riot.cinema',
                'password' => 'Test@123',
                'role' => 'author',
                'display_name' => 'Author Test'
            )
        );

        $created = 0;
        foreach ($users as $user_data) {
            if (!username_exists($user_data['username']) && !email_exists($user_data['email'])) {
                $user_id = wp_create_user(
                    $user_data['username'],
                    $user_data['password'],
                    $user_data['email']
                );
                
                if ($user_id && !is_wp_error($user_id)) {
                    wp_update_user(array(
                        'ID' => $user_id,
                        'display_name' => $user_data['display_name'],
                        'role' => $user_data['role']
                    ));
                    $created++;
                }
            }
        }

        return $created;
    }
    
    public function delete_all_data() {
        echo '<div class="delete-result">';
        echo '<h3>🗑️ Deleting Data...</h3>';
        echo '<ul>';
        
        // Delete all movies
        $movies = get_posts(array(
            'post_type' => 'movie',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        $deleted_movies = 0;
        foreach ($movies as $movie) {
            wp_delete_post($movie->ID, true);
            $deleted_movies++;
        }
        echo '<li>🎬 Deleted ' . $deleted_movies . ' movies</li>';
        
        // Delete all cinemas
        $cinemas = get_posts(array(
            'post_type' => 'rap_phim',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        $deleted_cinemas = 0;
        foreach ($cinemas as $cinema) {
            wp_delete_post($cinema->ID, true);
            $deleted_cinemas++;
        }
        echo '<li>🏢 Deleted ' . $deleted_cinemas . ' cinemas</li>';
        
        // Delete blog posts (only those created by seeder)
        $posts = get_posts(array(
            'post_type' => 'post',
            'posts_per_page' => -1,
            'post_status' => 'any',
            'author' => 1
        ));
        $deleted_posts = 0;
        foreach ($posts as $post) {
            // Only delete if it looks like a seeded post
            if (strpos($post->post_title, 'Top 10') !== false || 
                strpos($post->post_title, 'Lý Do') !== false ||
                strpos($post->post_title, 'Hướng Dẫn') !== false ||
                strpos($post->post_title, 'Review:') !== false) {
                wp_delete_post($post->ID, true);
                $deleted_posts++;
            }
        }
        echo '<li>📝 Deleted ' . $deleted_posts . ' blog posts</li>';
        
        echo '</ul>';
        echo '<p><strong>All seeded data has been deleted!</strong></p>';
        echo '<p>You can now run the seeder again to create fresh data.</p>';
        echo '</div>';
    }
}

// Initialize the plugin
new RIOT_Complete_Seeder();

