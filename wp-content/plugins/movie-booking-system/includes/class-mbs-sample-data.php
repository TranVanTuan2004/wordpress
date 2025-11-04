<?php
/**
 * Sample Data Class
 * Generate sample data for testing
 */

if (!defined('ABSPATH')) {
    exit;
}

class MBS_Sample_Data {
    
    /**
     * Install sample data
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
     * Create sample genres
     */
    private static function create_genres() {
        $genres = array(
            'Hành Động',
            'Tình Cảm',
            'Hài Hước',
            'Kinh Dị',
            'Khoa Học Viễn Tưởng',
            'Phiêu Lưu',
            'Hoạt Hình',
            'Tâm Lý'
        );
        
        foreach ($genres as $genre) {
            if (!term_exists($genre, 'mbs_genre')) {
                wp_insert_term($genre, 'mbs_genre');
            }
        }
    }
    
    /**
     * Create sample cinemas
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
     * Create sample movies
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
     * Create sample showtimes
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

