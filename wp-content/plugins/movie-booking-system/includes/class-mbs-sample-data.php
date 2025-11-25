<?php
/**
 * Sample Data Class
 * Generate comprehensive sample data for testing
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Sample_Data {
    
    /**
     * Install comprehensive sample data
     */
    public static function install_comprehensive() {
        // Create sample genres
        self::create_genres();
        
        // Create comprehensive cinemas (8 cinemas across Vietnam)
        $cinemas = self::create_vietnam_cinemas();
        
        // Create comprehensive movies (10 popular movies)
        $movies = self::create_comprehensive_movies();
        
        // Create comprehensive showtimes
        if (!empty($movies) && !empty($cinemas)) {
            self::create_comprehensive_showtimes($movies, $cinemas);
        }
        
        return array(
            'success' => true,
            'movies' => count($movies),
            'cinemas' => count($cinemas),
            'message' => 'Đã tạo dữ liệu mẫu đầy đủ thành công!'
        );
    }
    
    /**
     * Install basic sample data (original method)
     */
    public static function install() {
        // Create sample genres
        self::create_genres();
        
        // Create sample cinemas
        $cinemas = self::create_cinemas();
        
        // Create sample movies
        $movies = self::create_movies();
        
        // Create sample showtimes
        if (!empty($movies) && !empty($cinemas)) {
            self::create_showtimes($movies, $cinemas);
        }
        
        return array(
            'success' => true,
            'message' => 'Đã tạo dữ liệu mẫu thành công!'
        );
    }
    
    /**
     * Delete all sample data
     */
    public static function delete_all_data() {
        $deleted = array(
            'movies' => 0,
            'cinemas' => 0,
            'showtimes' => 0
        );
        
        // Delete all movies - use while loop to handle large numbers
        while (true) {
            $movies = get_posts(array(
                'post_type' => 'mbs_movie',
                'posts_per_page' => 100, // Delete 100 at a time
                'post_status' => 'any'
            ));
            
            if (empty($movies)) {
                break;
            }
            
            foreach ($movies as $movie) {
                wp_delete_post($movie->ID, true);
                $deleted['movies']++;
            }
        }
        
        // Delete all cinemas
        while (true) {
            $cinemas = get_posts(array(
                'post_type' => 'mbs_cinema',
                'posts_per_page' => 100,
                'post_status' => 'any'
            ));
            
            if (empty($cinemas)) {
                break;
            }
            
            foreach ($cinemas as $cinema) {
                wp_delete_post($cinema->ID, true);
                $deleted['cinemas']++;
            }
        }
        
        // Delete all showtimes - IMPORTANT: Use while loop for large numbers
        while (true) {
            $showtimes = get_posts(array(
                'post_type' => 'mbs_showtime',
                'posts_per_page' => 100, // Delete 100 at a time
                'post_status' => 'any'
            ));
            
            if (empty($showtimes)) {
                break; // No more showtimes, exit loop
            }
            
            foreach ($showtimes as $showtime) {
                wp_delete_post($showtime->ID, true);
                $deleted['showtimes']++;
            }
        }
        
        return array(
            'success' => true,
            'deleted' => $deleted,
            'message' => 'Đã xóa tất cả dữ liệu mẫu!'
        );
    }
    
    /**
     * Get current data count
     */
    public static function get_data_count() {
        $movies_count = wp_count_posts('mbs_movie');
        $cinemas_count = wp_count_posts('mbs_cinema');
        $showtimes_count = wp_count_posts('mbs_showtime');
        
        return array(
            'movies' => $movies_count->publish ?? 0,
            'cinemas' => $cinemas_count->publish ?? 0,
            'showtimes' => $showtimes_count->publish ?? 0
        );
    }
    
    /**
     * Create sample genres
     */
    private static function create_genres() {
        $genres = array(
            'Action' => 'Hành Động',
            'Sci-Fi' => 'Khoa Học Viễn Tưởng',
            'Thriller' => 'Kinh Dị',
            'Drama' => 'Tâm Lý',
            'Crime' => 'Hình Sự',
            'Romance' => 'Tình Cảm',
            'Comedy' => 'Hài Hước',
            'Adventure' => 'Phiêu Lưu',
            'Animation' => 'Hoạt Hình'
        );
        
        foreach ($genres as $slug => $name) {
            if (!term_exists($name, 'mbs_genre')) {
                wp_insert_term($name, 'mbs_genre', array('slug' => strtolower($slug)));
            }
        }
    }
    
    /**
     * Create 8 comprehensive cinemas across Vietnam
     */
    private static function create_vietnam_cinemas() {
        $cinemas_data = array(
            array(
                'title' => 'RIOT Cinema Hà Nội',
                'content' => 'Rạp chiếu phim hiện đại nhất tại trung tâm Hà Nội với hệ thống âm thanh Dolby Atmos và màn hình IMAX.',
                'address' => '123 Đường Láng, Đống Đa, Hà Nội',
                'phone' => '024-1234-5678',
                'rooms' => 8
            ),
            array(
                'title' => 'RIOT Cinema Sài Gòn',
                'content' => 'Cụm rạp cao cấp tại TP.HCM với 10 phòng chiếu, bao gồm 2 phòng IMAX và 1 phòng 4DX.',
                'address' => '456 Nguyễn Huệ, Quận 1, TP.HCM',
                'phone' => '028-9876-5432',
                'rooms' => 10
            ),
            array(
                'title' => 'RIOT Cinema Đà Nẵng',
                'content' => 'Rạp chiếu phim sang trọng tại trung tâm Đà Nẵng với view biển tuyệt đẹp.',
                'address' => '789 Trần Phú, Hải Châu, Đà Nẵng',
                'phone' => '0236-111-2233',
                'rooms' => 6
            ),
            array(
                'title' => 'RIOT Cinema Cần Thơ',
                'content' => 'Rạp chiếu phim đầu tiên tại miền Tây với đầy đủ tiện nghi hiện đại.',
                'address' => '321 Mậu Thân, Ninh Kiều, Cần Thơ',
                'phone' => '0292-333-4444',
                'rooms' => 5
            ),
            array(
                'title' => 'RIOT Cinema Hải Phòng',
                'content' => 'Cụm rạp hiện đại tại thành phố cảng với hệ thống ghế VIP cao cấp.',
                'address' => '555 Lạch Tray, Ngô Quyền, Hải Phòng',
                'phone' => '0225-555-6666',
                'rooms' => 7
            ),
            array(
                'title' => 'RIOT Cinema Nha Trang',
                'content' => 'Rạp chiếu phim view biển độc đáo tại Nha Trang.',
                'address' => '888 Trần Phú, Nha Trang, Khánh Hòa',
                'phone' => '0258-777-8888',
                'rooms' => 5
            ),
            array(
                'title' => 'RIOT Cinema Huế',
                'content' => 'Rạp chiếu phim mang phong cách cổ kính kết hợp hiện đại tại cố đô Huế.',
                'address' => '234 Lê Lợi, TP Huế, Thừa Thiên Huế',
                'phone' => '0234-999-0000',
                'rooms' => 4
            ),
            array(
                'title' => 'RIOT Cinema Vũng Tàu',
                'content' => 'Rạp chiếu phim nghỉ dưỡng tại thành phố biển Vũng Tàu.',
                'address' => '678 Thùy Vân, Vũng Tàu, Bà Rịa - Vũng Tàu',
                'phone' => '0254-123-4567',
                'rooms' => 4
            )
        );
        
        $cinema_ids = array();
        
        foreach ($cinemas_data as $cinema) {
            $cinema_id = wp_insert_post(array(
                'post_title' => $cinema['title'],
                'post_type' => 'mbs_cinema',
                'post_status' => 'publish',
                'post_content' => $cinema['content']
            ));
            
            if ($cinema_id) {
                update_post_meta($cinema_id, '_mbs_address', $cinema['address']);
                update_post_meta($cinema_id, '_mbs_phone', $cinema['phone']);
                update_post_meta($cinema_id, '_mbs_total_rooms', $cinema['rooms']);
                
                $cinema_ids[] = $cinema_id;
            }
        }
        
        return $cinema_ids;
    }
    
    /**
     * Create 10 comprehensive popular movies
     */
    private static function create_comprehensive_movies() {
        $movies_data = array(
            array(
                'title' => 'The Dark Knight',
                'content' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'duration' => 152,
                'director' => 'Christopher Nolan',
                'actors' => 'Christian Bale, Heath Ledger, Aaron Eckhart',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
                'genre' => 'Hành Động',
                'release_date' => '2024-01-15'
            ),
            array(
                'title' => 'Inception',
                'content' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'duration' => 148,
                'director' => 'Christopher Nolan',
                'actors' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Ellen Page',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'genre' => 'Khoa Học Viễn Tưởng',
                'release_date' => '2024-02-01'
            ),
            array(
                'title' => 'Interstellar',
                'content' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'duration' => 169,
                'director' => 'Christopher Nolan',
                'actors' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
                'genre' => 'Khoa Học Viễn Tưởng',
                'release_date' => '2024-02-15'
            ),
            array(
                'title' => 'Parasite',
                'content' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.',
                'duration' => 132,
                'director' => 'Bong Joon-ho',
                'actors' => 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong',
                'rating' => 'C16',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
                'genre' => 'Kinh Dị',
                'release_date' => '2024-03-01'
            ),
            array(
                'title' => 'Avengers: Endgame',
                'content' => 'After the devastating events of Avengers: Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more.',
                'duration' => 181,
                'director' => 'Anthony Russo, Joe Russo',
                'actors' => 'Robert Downey Jr., Chris Evans, Mark Ruffalo',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
                'genre' => 'Hành Động',
                'release_date' => '2024-01-20'
            ),
            array(
                'title' => 'Joker',
                'content' => 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime.',
                'duration' => 122,
                'director' => 'Todd Phillips',
                'actors' => 'Joaquin Phoenix, Robert De Niro, Zazie Beetz',
                'rating' => 'C18',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=zAGVQLHvwOY',
                'genre' => 'Tâm Lý',
                'release_date' => '2024-02-10'
            ),
            array(
                'title' => 'Spider-Man: No Way Home',
                'content' => 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help. When a spell goes wrong, dangerous foes from other worlds start to appear.',
                'duration' => 148,
                'director' => 'Jon Watts',
                'actors' => 'Tom Holland, Zendaya, Benedict Cumberbatch',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=JfVOs4VSpmA',
                'genre' => 'Hành Động',
                'release_date' => '2024-03-15'
            ),
            array(
                'title' => 'The Shawshank Redemption',
                'content' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'duration' => 142,
                'director' => 'Frank Darabont',
                'actors' => 'Tim Robbins, Morgan Freeman, Bob Gunton',
                'rating' => 'C16',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=6hB3S9bIaco',
                'genre' => 'Tâm Lý',
                'release_date' => '2024-01-25'
            ),
            array(
                'title' => 'Pulp Fiction',
                'content' => 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.',
                'duration' => 154,
                'director' => 'Quentin Tarantino',
                'actors' => 'John Travolta, Uma Thurman, Samuel L. Jackson',
                'rating' => 'C18',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=s7EdQ4FqbhY',
                'genre' => 'Hình Sự',
                'release_date' => '2024-03-20'
            ),
            array(
                'title' => 'The Matrix',
                'content' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
                'duration' => 136,
                'director' => 'Lana Wachowski, Lilly Wachowski',
                'actors' => 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'trailer_url' => 'https://www.youtube.com/watch?v=vKQi3bBA1y8',
                'genre' => 'Khoa Học Viễn Tưởng',
                'release_date' => '2024-02-05'
            )
        );
        
        $movie_ids = array();
        
        foreach ($movies_data as $index => $movie) {
            $movie_id = wp_insert_post(array(
                'post_title' => $movie['title'],
                'post_type' => 'mbs_movie',
                'post_status' => 'publish',
                'post_content' => $movie['content'],
                'post_excerpt' => wp_trim_words($movie['content'], 20)
            ));
            
            if ($movie_id) {
                update_post_meta($movie_id, '_mbs_duration', $movie['duration']);
                update_post_meta($movie_id, '_mbs_director', $movie['director']);
                update_post_meta($movie_id, '_mbs_actors', $movie['actors']);
                update_post_meta($movie_id, '_mbs_rating', $movie['rating']);
                update_post_meta($movie_id, '_mbs_language', $movie['language']);
                update_post_meta($movie_id, '_mbs_trailer_url', $movie['trailer_url']);
                update_post_meta($movie_id, '_mbs_release_date', $movie['release_date']);
                
                // Add genre
                $genre_term = get_term_by('name', $movie['genre'], 'mbs_genre');
                if ($genre_term) {
                    wp_set_object_terms($movie_id, $genre_term->term_id, 'mbs_genre');
                }
                
                // Create placeholder featured image
                self::create_placeholder_image($movie_id, $movie['title'], $index);
                
                $movie_ids[] = $movie_id;
            }
        }
        
        return $movie_ids;
    }
    
    /**
     * Create placeholder image for a movie
     */
    private static function create_placeholder_image($post_id, $title, $index) {
        // Use different colored placeholders for variety
        $colors = array(
            '1a1a2e/ffffff', // Dark blue
            '16213e/ffffff', // Navy
            '0f3460/ffffff', // Deep blue
            '533483/ffffff', // Purple
            '2d4059/ffffff', // Dark slate
            '112d4e/ffffff', // Midnight blue
            '3f72af/ffffff', // Steel blue
            '1b262c/ffffff', // Charcoal
            '0b0c10/ffffff', // Almost black
            '1f4068/ffffff'  // Ocean blue
        );
        
        $color = $colors[$index % count($colors)];
        $image_url = 'https://via.placeholder.com/400x600/' . $color . '?text=' . urlencode($title);
        
        // Download image
        $tmp = download_url($image_url);
        
        if (is_wp_error($tmp)) {
            return false;
        }
        
        // Set up file array
        $file_array = array(
            'name' => sanitize_file_name($title) . '.png',
            'tmp_name' => $tmp
        );
        
        // Upload to media library
        $attachment_id = media_handle_sideload($file_array, $post_id);
        
        // Clean up temp file
        @unlink($tmp);
        
        if (is_wp_error($attachment_id)) {
            return false;
        }
        
        // Set as featured image
        set_post_thumbnail($post_id, $attachment_id);
        
        return $attachment_id;
    }
    
    /**
     * Create comprehensive showtimes (30+ showtimes)
     */
    private static function create_comprehensive_showtimes($movies, $cinemas) {
        $formats = array('2D', '3D', 'IMAX', '4DX');
        $times = array('10:00', '13:00', '16:00', '19:00', '22:00');
        $prices = array(70000, 85000, 100000, 120000, 150000);
        
        $showtime_ids = array();
        
        // Select only 3 random movies to create showtimes for (to keep total around 30)
        $selected_movies = array_rand(array_flip($movies), min(3, count($movies)));
        if (!is_array($selected_movies)) {
            $selected_movies = array($selected_movies);
        }
        
        // Create showtimes for next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = date('Y-m-d', strtotime("+$day days"));
            
            foreach ($selected_movies as $movie_id) {
                // Random cinema
                $cinema_id = $cinemas[array_rand($cinemas)];
                
                // Create 1-2 showtimes per day per movie (reduced from 3-4)
                $num_showtimes = rand(1, 2);
                $selected_times = array_rand(array_flip($times), $num_showtimes);
                
                if (!is_array($selected_times)) {
                    $selected_times = array($selected_times);
                }
                
                foreach ($selected_times as $time) {
                    $format = $formats[array_rand($formats)];
                    $price = $prices[array_rand($prices)];
                    
                    $showtime_datetime = $date . 'T' . $time . ':00';
                    
                    $movie_title = get_the_title($movie_id);
                    $cinema_title = get_the_title($cinema_id);
                    
                    $showtime_id = wp_insert_post(array(
                        'post_title' => $movie_title . ' - ' . $cinema_title . ' - ' . $time,
                        'post_type' => 'mbs_showtime',
                        'post_status' => 'publish'
                    ));
                    
                    if ($showtime_id) {
                        update_post_meta($showtime_id, '_mbs_movie_id', $movie_id);
                        update_post_meta($showtime_id, '_mbs_cinema_id', $cinema_id);
                        update_post_meta($showtime_id, '_mbs_showtime', $showtime_datetime);
                        update_post_meta($showtime_id, '_mbs_room', 'Phòng ' . rand(1, 8));
                        update_post_meta($showtime_id, '_mbs_format', $format);
                        update_post_meta($showtime_id, '_mbs_price', $price);
                        
                        $showtime_ids[] = $showtime_id;
                    }
                }
            }
        }
        
        return $showtime_ids;
    }
    
    // ============================================
    // ORIGINAL METHODS (kept for backward compatibility)
    // ============================================
    
    /**
     * Create sample cinemas (original - 3 cinemas)
     */
    private static function create_cinemas() {
        $cinemas_data = array(
            array(
                'title' => 'CGV Vincom Mega Mall Grand Park',
                'address' => 'Lô L5-01, Tầng L5, Trung Tâm Thương Mại Vincom Mega Mall Grand Park, Dự án Khu dân cư và Công viên Sài Gòn',
                'phone' => '1900 6017',
                'rooms' => 8
            ),
            array(
                'title' => 'CGV Aeon Bình Tân',
                'address' => 'Tầng 3, TTTM Aeon Mall Bình Tân, Số 1 đường số 17A, Bình Trị Đông B, Bình Tân',
                'phone' => '1900 6017',
                'rooms' => 6
            ),
            array(
                'title' => 'CGV Giga Mall Thủ Đức',
                'address' => 'Tầng 2, TTTM Giga Mall, 240-242 Phạm Văn Đồng, Hiệp Bình Chánh, Thủ Đức',
                'phone' => '1900 6017',
                'rooms' => 5
            )
        );
        
        $cinema_ids = array();
        
        foreach ($cinemas_data as $cinema) {
            $cinema_id = wp_insert_post(array(
                'post_title' => $cinema['title'],
                'post_type' => 'mbs_cinema',
                'post_status' => 'publish',
                'post_content' => 'Rạp chiếu phim hiện đại với hệ thống âm thanh và hình ảnh chất lượng cao.'
            ));
            
            if ($cinema_id) {
                update_post_meta($cinema_id, '_mbs_address', $cinema['address']);
                update_post_meta($cinema_id, '_mbs_phone', $cinema['phone']);
                update_post_meta($cinema_id, '_mbs_total_rooms', $cinema['rooms']);
                
                $cinema_ids[] = $cinema_id;
            }
        }
        
        return $cinema_ids;
    }
    
    /**
     * Create sample movies (original - 3 movies)
     */
    private static function create_movies() {
        $movies_data = array(
            array(
                'title' => 'Phá Đảm: Sinh Nhật Mẹ',
                'content' => 'Phá Đảm: Sinh Nhật Mẹ là bộ phim hài tình cảm gia đình xoay quanh câu chuyện của một gia đình đa thế hệ đang chuẩn bị cho sinh nhật của người mẹ.',
                'duration' => 120,
                'director' => 'Nguyễn Văn A',
                'actors' => 'Trấn Thành, Hari Won, Lê Giang',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'genre' => 'Hài Hước'
            ),
            array(
                'title' => 'Avengers: Secret Wars',
                'content' => 'Biệt đội Avengers tập hợp một lần nữa để đối mặt với mối đe dọa lớn nhất từng có trong vũ trụ Marvel.',
                'duration' => 150,
                'director' => 'Russo Brothers',
                'actors' => 'Robert Downey Jr., Chris Evans, Scarlett Johansson',
                'rating' => 'C13',
                'language' => 'Phụ đề',
                'genre' => 'Hành Động'
            ),
            array(
                'title' => 'Cô Dâu Hào Môn',
                'content' => 'Câu chuyện tình yêu đầy kịch tính giữa một cô gái bình thường và chàng trai giàu có.',
                'duration' => 110,
                'director' => 'Vũ Ngọc Đãng',
                'actors' => 'Uyển Ân, Samuel An',
                'rating' => 'C16',
                'language' => 'Phụ đề',
                'genre' => 'Tình Cảm'
            )
        );
        
        $movie_ids = array();
        
        foreach ($movies_data as $movie) {
            $movie_id = wp_insert_post(array(
                'post_title' => $movie['title'],
                'post_type' => 'mbs_movie',
                'post_status' => 'publish',
                'post_content' => $movie['content'],
                'post_excerpt' => wp_trim_words($movie['content'], 20)
            ));
            
            if ($movie_id) {
                update_post_meta($movie_id, '_mbs_duration', $movie['duration']);
                update_post_meta($movie_id, '_mbs_director', $movie['director']);
                update_post_meta($movie_id, '_mbs_actors', $movie['actors']);
                update_post_meta($movie_id, '_mbs_rating', $movie['rating']);
                update_post_meta($movie_id, '_mbs_language', $movie['language']);
                update_post_meta($movie_id, '_mbs_release_date', date('Y-m-d'));
                
                // Add genre
                $genre_term = get_term_by('name', $movie['genre'], 'mbs_genre');
                if ($genre_term) {
                    wp_set_object_terms($movie_id, $genre_term->term_id, 'mbs_genre');
                }
                
                $movie_ids[] = $movie_id;
            }
        }
        
        return $movie_ids;
    }
    
    /**
     * Create sample showtimes (original)
     */
    private static function create_showtimes($movies, $cinemas) {
        $formats = array('2D', '3D', 'IMAX');
        $times = array('10:00', '13:30', '16:00', '18:30', '21:00', '23:35');
        $prices = array(70000, 85000, 100000);
        
        $showtime_ids = array();
        
        // Create showtimes for next 7 days
        for ($day = 0; $day < 7; $day++) {
            $date = date('Y-m-d', strtotime("+$day days"));
            
            foreach ($movies as $movie_id) {
                // Random cinema
                $cinema_id = $cinemas[array_rand($cinemas)];
                
                // Create 3-4 showtimes per day per movie
                $num_showtimes = rand(3, 4);
                $selected_times = array_rand(array_flip($times), $num_showtimes);
                
                if (!is_array($selected_times)) {
                    $selected_times = array($selected_times);
                }
                
                foreach ($selected_times as $time) {
                    $format = $formats[array_rand($formats)];
                    $price = $prices[array_rand($prices)];
                    
                    $showtime_datetime = $date . ' ' . $time . ':00';
                    
                    $showtime_id = wp_insert_post(array(
                        'post_title' => 'Suất chiếu ' . $time . ' - ' . $date,
                        'post_type' => 'mbs_showtime',
                        'post_status' => 'publish'
                    ));
                    
                    if ($showtime_id) {
                        update_post_meta($showtime_id, '_mbs_movie_id', $movie_id);
                        update_post_meta($showtime_id, '_mbs_cinema_id', $cinema_id);
                        update_post_meta($showtime_id, '_mbs_showtime', $showtime_datetime);
                        update_post_meta($showtime_id, '_mbs_room', 'Phòng ' . rand(1, 5));
                        update_post_meta($showtime_id, '_mbs_format', $format);
                        update_post_meta($showtime_id, '_mbs_price', $price);
                        
                        $showtime_ids[] = $showtime_id;
                    }
                }
            }
        }
        
        return $showtime_ids;
    }
}

