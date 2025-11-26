<?php
/**
 * Plugin Name: RIOT Cinema Complete Data Seeder
 * Description: Comprehensive data seeder for RIOT Cinema theme - Movies, Cinemas, Blogs, Showtimes
 * Version: 1.1
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
            <h1>🎬 RIOT Cinema Complete Data Seeder (Fixed)</h1>
            <p>Seed comprehensive test data for your cinema website.</p>
            
            <?php
            if (isset($_POST['seed_all']) && check_admin_referer('seed_all_action', 'seed_all_nonce')) {
                $this->seed_all_data();
            }
            
            if (isset($_POST['delete_all']) && check_admin_referer('delete_all_action', 'delete_all_nonce')) {
                $this->delete_all_data();
            }
            
            // Check existing data
            $movies_count = wp_count_posts('mbs_movie');
            $cinemas_count = wp_count_posts('mbs_cinema');
            $total_movies = $movies_count->publish ?? 0;
            $total_cinemas = $cinemas_count->publish ?? 0;
            
            if ($total_movies > 0 || $total_cinemas > 0) {
                echo '<div class="notice notice-warning" style="padding: 15px; margin: 20px 0;">';
                echo '<h3 style="margin-top: 0;">⚠️ Existing Data Detected!</h3>';
                echo '<p><strong>Current data:</strong></p>';
                echo '<ul>';
                echo '<li>🎬 Movies (mbs_movie): ' . $total_movies . '</li>';
                echo '<li>🏢 Cinemas (mbs_cinema): ' . $total_cinemas . '</li>';
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
            // 1. The Dark Knight
            array(
                'title' => 'The Dark Knight',
                'content' => 'When the menace known as the Joker wreaks havoc and chaos on the people of Gotham, Batman must accept one of the greatest psychological and physical tests of his ability to fight injustice.',
                'genre' => 'Action',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '152',
                'release_date' => '2024-01-15',
                'trailer_url' => 'https://www.youtube.com/watch?v=EXeTwQWrcwY',
                'imdb_rating' => '9.0',
                'image_url' => 'https://image.tmdb.org/t/p/w500/qJ2tW6WMUDux911r6m7haRef0WH.jpg',
                'director' => 'Christopher Nolan',
                'actors' => 'Christian Bale, Heath Ledger, Aaron Eckhart'
            ),
            // 2. Inception
            array(
                'title' => 'Inception',
                'content' => 'A thief who steals corporate secrets through the use of dream-sharing technology is given the inverse task of planting an idea into the mind of a C.E.O.',
                'genre' => 'Sci-Fi',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '148',
                'release_date' => '2024-02-01',
                'trailer_url' => 'https://www.youtube.com/watch?v=YoHD9XEInc0',
                'imdb_rating' => '8.8',
                'image_url' => 'https://image.tmdb.org/t/p/w500/9gk7adHYeDvHkCSEqAvQNLV5Uge.jpg',
                'director' => 'Christopher Nolan',
                'actors' => 'Leonardo DiCaprio, Joseph Gordon-Levitt, Elliot Page'
            ),
            // 3. Interstellar
            array(
                'title' => 'Interstellar',
                'content' => 'A team of explorers travel through a wormhole in space in an attempt to ensure humanity\'s survival.',
                'genre' => 'Sci-Fi',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '169',
                'release_date' => '2024-02-15',
                'trailer_url' => 'https://www.youtube.com/watch?v=zSWdZVtXT7E',
                'imdb_rating' => '8.7',
                'image_url' => 'https://image.tmdb.org/t/p/w500/gEU2QniE6E77NI6lCU6MxlNBvIx.jpg',
                'director' => 'Christopher Nolan',
                'actors' => 'Matthew McConaughey, Anne Hathaway, Jessica Chastain'
            ),
            // 4. Parasite
            array(
                'title' => 'Parasite',
                'content' => 'Greed and class discrimination threaten the newly formed symbiotic relationship between the wealthy Park family and the destitute Kim clan.',
                'genre' => 'Thriller',
                'status' => 'sap-chieu',
                'rating' => '16+',
                'duration' => '132',
                'release_date' => '2024-03-01',
                'trailer_url' => 'https://www.youtube.com/watch?v=5xH0HfJHsaY',
                'imdb_rating' => '8.5',
                'image_url' => 'https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg',
                'director' => 'Bong Joon Ho',
                'actors' => 'Song Kang-ho, Lee Sun-kyun, Cho Yeo-jeong'
            ),
            // 5. Avengers: Endgame
            array(
                'title' => 'Avengers: Endgame',
                'content' => 'After the devastating events of Avengers: Infinity War, the universe is in ruins. With the help of remaining allies, the Avengers assemble once more.',
                'genre' => 'Action',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '181',
                'release_date' => '2024-01-20',
                'trailer_url' => 'https://www.youtube.com/watch?v=TcMBFSGVi1c',
                'imdb_rating' => '8.4',
                'image_url' => 'https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg',
                'director' => 'Anthony Russo, Joe Russo',
                'actors' => 'Robert Downey Jr., Chris Evans, Mark Ruffalo'
            ),
            // 6. Joker
            array(
                'title' => 'Joker',
                'content' => 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime.',
                'genre' => 'Drama',
                'status' => 'dang-chieu',
                'rating' => '18+',
                'duration' => '122',
                'release_date' => '2024-02-10',
                'trailer_url' => 'https://www.youtube.com/watch?v=zAGVQLHvwOY',
                'imdb_rating' => '8.4',
                'image_url' => 'https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg',
                'director' => 'Todd Phillips',
                'actors' => 'Joaquin Phoenix, Robert De Niro, Zazie Beetz'
            ),
            // 7. Spider-Man: No Way Home
            array(
                'title' => 'Spider-Man: No Way Home',
                'content' => 'With Spider-Man\'s identity now revealed, Peter asks Doctor Strange for help. When a spell goes wrong, dangerous foes from other worlds start to appear.',
                'genre' => 'Action',
                'status' => 'sap-chieu',
                'rating' => '13+',
                'duration' => '148',
                'release_date' => '2024-03-15',
                'trailer_url' => 'https://www.youtube.com/watch?v=JfVOs4VSpmA',
                'imdb_rating' => '8.2',
                'image_url' => 'https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4GY0d.jpg',
                'director' => 'Jon Watts',
                'actors' => 'Tom Holland, Zendaya, Benedict Cumberbatch'
            ),
            // 8. The Shawshank Redemption
            array(
                'title' => 'The Shawshank Redemption',
                'content' => 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.',
                'genre' => 'Drama',
                'status' => 'dang-chieu',
                'rating' => '16+',
                'duration' => '142',
                'release_date' => '2024-01-25',
                'trailer_url' => 'https://www.youtube.com/watch?v=6hB3S9bIaco',
                'imdb_rating' => '9.3',
                'image_url' => 'https://image.tmdb.org/t/p/w500/q6y0Go1tsGEsmtFryDOJo3dEmqu.jpg',
                'director' => 'Frank Darabont',
                'actors' => 'Tim Robbins, Morgan Freeman, Bob Gunton'
            ),
            // 9. Pulp Fiction
            array(
                'title' => 'Pulp Fiction',
                'content' => 'The lives of two mob hitmen, a boxer, a gangster and his wife intertwine in four tales of violence and redemption.',
                'genre' => 'Crime',
                'status' => 'sap-chieu',
                'rating' => '18+',
                'duration' => '154',
                'release_date' => '2024-03-20',
                'trailer_url' => 'https://www.youtube.com/watch?v=s7EdQ4FqbhY',
                'imdb_rating' => '8.9',
                'image_url' => 'https://image.tmdb.org/t/p/w500/d5iIlFn5s0ImszYzBPb8JPIfbXD.jpg',
                'director' => 'Quentin Tarantino',
                'actors' => 'John Travolta, Uma Thurman, Samuel L. Jackson'
            ),
            // 10. The Matrix
            array(
                'title' => 'The Matrix',
                'content' => 'A computer hacker learns from mysterious rebels about the true nature of his reality and his role in the war against its controllers.',
                'genre' => 'Sci-Fi',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '136',
                'release_date' => '2024-02-05',
                'trailer_url' => 'https://www.youtube.com/watch?v=vKQi3bBA1y8',
                'imdb_rating' => '8.7',
                'image_url' => 'https://image.tmdb.org/t/p/w500/f89U3ADr1oiB1s9GkdPOEpXUk5H.jpg',
                'director' => 'Lana Wachowski, Lilly Wachowski',
                'actors' => 'Keanu Reeves, Laurence Fishburne, Carrie-Anne Moss'
            ),
            // 11. Dune: Part Two
            array(
                'title' => 'Dune: Part Two',
                'content' => 'Paul Atreides unites with Chani and the Fremen while on a warpath of revenge against the conspirators who destroyed his family.',
                'genre' => 'Sci-Fi',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '166',
                'release_date' => '2024-03-01',
                'trailer_url' => 'https://www.youtube.com/watch?v=Way9Dexny3w',
                'imdb_rating' => '8.8',
                'image_url' => 'https://image.tmdb.org/t/p/w500/1pdfLvkbY9ohJlCjQH2CZjjYVvJ.jpg',
                'director' => 'Denis Villeneuve',
                'actors' => 'Timothée Chalamet, Zendaya, Rebecca Ferguson'
            ),
            // 12. Oppenheimer
            array(
                'title' => 'Oppenheimer',
                'content' => 'The story of American scientist J. Robert Oppenheimer and his role in the development of the atomic bomb.',
                'genre' => 'Drama',
                'status' => 'dang-chieu',
                'rating' => '16+',
                'duration' => '180',
                'release_date' => '2023-07-21',
                'trailer_url' => 'https://www.youtube.com/watch?v=uYPbbksJxIg',
                'imdb_rating' => '8.4',
                'image_url' => 'https://image.tmdb.org/t/p/w500/8Gxv8gSFCU0XGDykEGv7zR1n2ua.jpg',
                'director' => 'Christopher Nolan',
                'actors' => 'Cillian Murphy, Emily Blunt, Matt Damon'
            ),
            // 13. Barbie
            array(
                'title' => 'Barbie',
                'content' => 'Barbie and Ken are having the time of their lives in the colorful and seemingly perfect world of Barbie Land. However, when they get a chance to go to the real world, they soon discover the joys and perils of living among humans.',
                'genre' => 'Comedy',
                'status' => 'dang-chieu',
                'rating' => '13+',
                'duration' => '114',
                'release_date' => '2023-07-21',
                'trailer_url' => 'https://www.youtube.com/watch?v=pBk4NYhWNMM',
                'imdb_rating' => '7.0',
                'image_url' => 'https://image.tmdb.org/t/p/w500/iuFNMS8U5cb6xf8gc2484GyAHW8.jpg',
                'director' => 'Greta Gerwig',
                'actors' => 'Margot Robbie, Ryan Gosling, Issa Rae'
            ),
            // 14. Godzilla x Kong: The New Empire
            array(
                'title' => 'Godzilla x Kong: The New Empire',
                'content' => 'Two ancient titans, Godzilla and Kong, clash in an epic battle as humans unravel their intertwined origins and connection to Skull Island\'s mysteries.',
                'genre' => 'Action',
                'status' => 'sap-chieu',
                'rating' => '13+',
                'duration' => '115',
                'release_date' => '2024-03-29',
                'trailer_url' => 'https://www.youtube.com/watch?v=lV1OOlGwExM',
                'imdb_rating' => '6.5',
                'image_url' => 'https://image.tmdb.org/t/p/w500/tMefBSflR6PGQLv7WvFPpKLZkyk.jpg',
                'director' => 'Adam Wingard',
                'actors' => 'Rebecca Hall, Brian Tyree Henry, Dan Stevens'
            ),
            // 15. Kung Fu Panda 4
            array(
                'title' => 'Kung Fu Panda 4',
                'content' => 'Po is gearing up to become the spiritual leader of his Valley of Peace, but also needs someone to take his place as Dragon Warrior.',
                'genre' => 'Animation',
                'status' => 'dang-chieu',
                'rating' => 'P',
                'duration' => '94',
                'release_date' => '2024-03-08',
                'trailer_url' => 'https://www.youtube.com/watch?v=_inKs4eeHiI',
                'imdb_rating' => '6.4',
                'image_url' => 'https://image.tmdb.org/t/p/w500/kDp1vUBnMpe8ak4rjgl3cLELqjU.jpg',
                'director' => 'Mike Mitchell',
                'actors' => 'Jack Black, Awkwafina, Viola Davis'
            ),
            // 16. Civil War
            array(
                'title' => 'Civil War',
                'content' => 'A journey across a dystopian future America, following a team of military-embedded journalists as they race against time to reach DC before rebel factions descend upon the White House.',
                'genre' => 'Action',
                'status' => 'sap-chieu',
                'rating' => '16+',
                'duration' => '109',
                'release_date' => '2024-04-12',
                'trailer_url' => 'https://www.youtube.com/watch?v=aDyQxtgKWbs',
                'imdb_rating' => '7.4',
                'image_url' => 'https://image.tmdb.org/t/p/w500/sh7Rg8Er3tFcN9BpKIPOMvALgZd.jpg',
                'director' => 'Alex Garland',
                'actors' => 'Kirsten Dunst, Wagner Moura, Cailee Spaeny'
            ),
            // 17. The Fall Guy
            array(
                'title' => 'The Fall Guy',
                'content' => 'A down-and-out stuntman must find the missing star of his ex-girlfriend\'s blockbuster film.',
                'genre' => 'Action',
                'status' => 'sap-chieu',
                'rating' => '13+',
                'duration' => '126',
                'release_date' => '2024-05-03',
                'trailer_url' => 'https://www.youtube.com/watch?v=j7jPnwVGdZ8',
                'imdb_rating' => '7.3',
                'image_url' => 'https://image.tmdb.org/t/p/w500/tSz1qsmSJon0rqjHBxXZmrotuse.jpg',
                'director' => 'David Leitch',
                'actors' => 'Ryan Gosling, Emily Blunt, Aaron Taylor-Johnson'
            ),
            // 18. Kingdom of the Planet of the Apes
            array(
                'title' => 'Kingdom of the Planet of the Apes',
                'content' => 'Many years after the reign of Caesar, a young ape goes on a journey that will lead him to question everything he\'s been taught about the past and make choices that will define a future for apes and humans alike.',
                'genre' => 'Sci-Fi',
                'status' => 'sap-chieu',
                'rating' => '13+',
                'duration' => '145',
                'release_date' => '2024-05-10',
                'trailer_url' => 'https://www.youtube.com/watch?v=XtFI7SNtVpY',
                'imdb_rating' => '7.2',
                'image_url' => 'https://image.tmdb.org/t/p/w500/gKkl37BQuKTanygYQG1pyYgLVgf.jpg',
                'director' => 'Wes Ball',
                'actors' => 'Owen Teague, Freya Allan, Kevin Durand'
            ),
            // 19. Furiosa: A Mad Max Saga
            array(
                'title' => 'Furiosa: A Mad Max Saga',
                'content' => 'The origin story of renegade warrior Furiosa before her encounter and teamup with Mad Max.',
                'genre' => 'Action',
                'status' => 'sap-chieu',
                'rating' => '16+',
                'duration' => '148',
                'release_date' => '2024-05-24',
                'trailer_url' => 'https://www.youtube.com/watch?v=XJMuhwVlca4',
                'imdb_rating' => '7.8',
                'image_url' => 'https://image.tmdb.org/t/p/w500/iADOJ8Zymht2JPMoy3R7xceZprc.jpg',
                'director' => 'George Miller',
                'actors' => 'Anya Taylor-Joy, Chris Hemsworth, Tom Burke'
            ),
            // 20. Inside Out 2
            array(
                'title' => 'Inside Out 2',
                'content' => 'Follow Riley, in her teenage years, encountering new emotions.',
                'genre' => 'Animation',
                'status' => 'sap-chieu',
                'rating' => 'P',
                'duration' => '100',
                'release_date' => '2024-06-14',
                'trailer_url' => 'https://www.youtube.com/watch?v=LEjhY15eCx0',
                'imdb_rating' => '8.0',
                'image_url' => 'https://image.tmdb.org/t/p/w500/vpnVM9B6NMmQpWeZvzLvDESb2QY.jpg',
                'director' => 'Kelsey Mann',
                'actors' => 'Amy Poehler, Phyllis Smith, Lewis Black'
            )
        );

        $created = 0;
        foreach ($movies as $movie_data) {
            $post_id = wp_insert_post(array(
                'post_title'   => $movie_data['title'],
                'post_content' => $movie_data['content'],
                'post_status'  => 'publish',
                'post_type'    => 'mbs_movie', // Correct Post Type
                'post_author'  => 1
            ));

            if ($post_id && !is_wp_error($post_id)) {
                // Update Meta Keys with _mbs_ prefix
                update_post_meta($post_id, '_mbs_rating', $movie_data['rating']);
                update_post_meta($post_id, '_mbs_duration', $movie_data['duration']);
                update_post_meta($post_id, '_mbs_release_date', $movie_data['release_date']);
                update_post_meta($post_id, '_mbs_trailer_url', $movie_data['trailer_url']);
                update_post_meta($post_id, '_mbs_imdb_rating', $movie_data['imdb_rating']);
                
                // Add Director and Actors
                if (isset($movie_data['director'])) {
                    update_post_meta($post_id, '_mbs_director', $movie_data['director']);
                }
                if (isset($movie_data['actors'])) {
                    update_post_meta($post_id, '_mbs_actors', $movie_data['actors']);
                }
                
                // Status is a meta field in this theme
                update_post_meta($post_id, '_movie_status', $movie_data['status']);

                // Set genre (Taxonomy: mbs_genre)
                $genre_term = term_exists($movie_data['genre'], 'mbs_genre');
                if (!$genre_term) {
                    $genre_term = wp_insert_term($movie_data['genre'], 'mbs_genre');
                }
                if (!is_wp_error($genre_term)) {
                    wp_set_post_terms($post_id, array($genre_term['term_id']), 'mbs_genre');
                }

                // Handle Image
                if (isset($movie_data['image_url'])) {
                    $this->upload_image_from_url($movie_data['image_url'], $post_id);
                }

                $created++;
            }
        }

        return $created;
    }

    private function upload_image_from_url($url, $post_id) {
        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            return false;
        }

        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        $tmp = download_url($url);

        if (is_wp_error($tmp)) {
            return false;
        }

        $file_array = array(
            'name' => basename($url),
            'tmp_name' => $tmp
        );

        // Check for file extension
        $file_type = wp_check_filetype($file_array['name'], null);
        if (!$file_type['type']) {
            // Default to jpg if no extension found
            $file_array['name'] = $file_array['name'] . '.jpg';
        }

        $id = media_handle_sideload($file_array, $post_id);

        if (is_wp_error($id)) {
            @unlink($file_array['tmp_name']);
            return false;
        }

        set_post_thumbnail($post_id, $id);
        return $id;
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
                'post_type'    => 'mbs_cinema', // Correct Post Type
                'post_author'  => 1
            ));

            if ($post_id && !is_wp_error($post_id)) {
                // Update Meta Keys with _mbs_ prefix
                update_post_meta($post_id, '_mbs_address', $cinema_data['address']);
                update_post_meta($post_id, '_mbs_phone', $cinema_data['phone']);
                update_post_meta($post_id, '_mbs_total_rooms', $cinema_data['screens']);
                update_post_meta($post_id, '_mbs_seats', $cinema_data['seats']);
                $created++;
            }
        }

        return $created;
    }
    
    private function seed_blogs() {
        $blogs = array(
            array(
                'title' => 'Top 10 Phim Bom Tấn Không Thể Bỏ Lỡ Năm 2024',
                'content' => 'Năm 2024 hứa hẹn sẽ là một năm bùng nổ của điện ảnh thế giới với hàng loạt bom tấn đình đám. Từ các siêu anh hùng Marvel, DC cho đến những tác phẩm nghệ thuật độc lập, khán giả sẽ có vô vàn lựa chọn để thưởng thức.',
                'image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=800&q=80'
            ),
            array(
                'title' => '5 Lý Do Bạn Nên Xem Phim Tại Rạp Thay Vì Ở Nhà',
                'content' => 'Trải nghiệm xem phim tại rạp mang lại những cảm giác khác biệt hoàn toàn so với xem tại nhà. Từ màn hình lớn, âm thanh sống động cho đến không khí đặc biệt, rạp chiếu phim vẫn là lựa chọn số một cho người yêu điện ảnh.',
                'image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?w=800&q=80'
            ),
            array(
                'title' => 'Hướng Dẫn Đặt Vé Xem Phim Online Nhanh Chóng',
                'content' => 'Đặt vé xem phim online giúp bạn tiết kiệm thời gian và đảm bảo có chỗ ngồi ưng ý. Bài viết này sẽ hướng dẫn chi tiết cách đặt vé qua website và app di động một cách đơn giản nhất.',
                'image_url' => 'https://images.unsplash.com/photo-1517604931442-71053644388d?w=800&q=80'
            ),
            array(
                'title' => 'Review: The Dark Knight - Kiệt Tác Điện Ảnh Siêu Anh Hùng',
                'content' => 'The Dark Knight không chỉ là một bộ phim siêu anh hùng thông thường mà còn là một tác phẩm nghệ thuật đỉnh cao. Với diễn xuất xuất sắc của Heath Ledger và đạo diễn tài ba Christopher Nolan, phim đã để lại dấu ấn sâu đậm trong lòng khán giả.',
                'image_url' => 'https://images.unsplash.com/photo-1509347528160-9a9e33742cd4?w=800&q=80'
            ),
            array(
                'title' => 'Khám Phá Công Nghệ IMAX - Trải Nghiệm Điện Ảnh Đỉnh Cao',
                'content' => 'IMAX mang đến trải nghiệm xem phim hoàn toàn khác biệt với màn hình khổng lồ và âm thanh vòm đa chiều. Tìm hiểu về công nghệ này và tại sao bạn nên thử ít nhất một lần trong đời.',
                'image_url' => 'https://images.unsplash.com/photo-1595769816263-9b910be24d5f?w=800&q=80'
            ),
            array(
                'title' => 'Lịch Sử Phát Triển Của Điện Ảnh Việt Nam',
                'content' => 'Điện ảnh Việt Nam đã trải qua hành trình phát triển dài với nhiều thăng trầm. Từ những bộ phim đầu tiên cho đến các tác phẩm hiện đại, ngành công nghiệp phim Việt đang ngày càng khẳng định vị thế của mình.',
                'image_url' => 'https://images.unsplash.com/photo-1478720568477-152d9b164e63?w=800&q=80'
            ),
            array(
                'title' => 'Top 5 Rạp Chiếu Phim Đẹp Nhất Việt Nam',
                'content' => 'Việt Nam hiện có rất nhiều rạp chiếu phim hiện đại với thiết kế đẹp mắt và trang thiết bị tiên tiến. Cùng khám phá 5 rạp chiếu phim đẹp nhất và đáng để bạn ghé thăm.',
                'image_url' => 'https://images.unsplash.com/photo-1517604931442-71053644388d?w=800&q=80'
            ),
            array(
                'title' => 'Bí Quyết Chọn Ghế Ngồi Tốt Nhất Trong Rạp Chiếu Phim',
                'content' => 'Vị trí ghế ngồi ảnh hưởng rất lớn đến trải nghiệm xem phim của bạn. Bài viết này sẽ chia sẻ những bí quyết để chọn được ghế ngồi tốt nhất, đảm bảo góc nhìn và âm thanh hoàn hảo.',
                'image_url' => 'https://images.unsplash.com/photo-1513106580091-1d82408b8638?w=800&q=80'
            ),
            array(
                'title' => 'Combo Bắp Nước - Món Ăn Không Thể Thiếu Khi Xem Phim',
                'content' => 'Bắp rang bơ và nước ngọt đã trở thành biểu tượng của văn hóa xem phim. Tìm hiểu về lịch sử của combo này và tại sao nó lại gắn liền với trải nghiệm rạp chiếu phim.',
                'image_url' => 'https://images.unsplash.com/photo-1572177191856-3cde618dee1f?w=800&q=80'
            ),
            array(
                'title' => 'Phim 3D vs 2D: Nên Chọn Loại Nào?',
                'content' => 'Công nghệ 3D mang lại trải nghiệm sống động nhưng không phải lúc nào cũng là lựa chọn tốt nhất. So sánh ưu nhược điểm của cả hai định dạng để bạn có thể đưa ra quyết định phù hợp.',
                'image_url' => 'https://images.unsplash.com/photo-1535016120720-40c6874c3b1c?w=800&q=80'
            ),
            array(
                'title' => 'Những Bộ Phim Kinh Dị Đáng Xem Nhất Mọi Thời Đại',
                'content' => 'Thể loại kinh dị luôn thu hút một lượng lớn khán giả yêu thích cảm giác hồi hộp, sợ hãi. Cùng điểm qua những tác phẩm kinh dị kinh điển mà mọi fan của thể loại này không nên bỏ lỡ.',
                'image_url' => 'https://images.unsplash.com/photo-1505686994434-e3cc5abf1330?w=800&q=80'
            ),
            array(
                'title' => 'Tại Sao Phim Hoạt Hình Không Chỉ Dành Cho Trẻ Em?',
                'content' => 'Phim hoạt hình hiện đại đã phát triển xa hơn nhiều so với chỉ là giải trí cho trẻ em. Nhiều tác phẩm hoạt hình mang thông điệp sâu sắc và kỹ thuật làm phim tinh tế, thu hút cả khán giả trưởng thành.',
                'image_url' => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=800&q=80'
            ),
            array(
                'title' => 'Hậu Trường Làm Phim: Những Điều Bạn Chưa Biết',
                'content' => 'Đằng sau mỗi bộ phim là công sức của hàng trăm người với nhiều công đoạn phức tạp. Khám phá hậu trường sản xuất phim để hiểu rõ hơn về quá trình tạo ra những tác phẩm điện ảnh.',
                'image_url' => 'https://images.unsplash.com/photo-1492691527719-9d1e07e534b4?w=800&q=80'
            ),
            array(
                'title' => 'Xu Hướng Điện Ảnh 2024: Những Gì Đang Hot',
                'content' => 'Ngành công nghiệp điện ảnh không ngừng thay đổi và phát triển. Năm 2024 chứng kiến nhiều xu hướng mới từ công nghệ CGI cho đến cách kể chuyện sáng tạo.',
                'image_url' => 'https://images.unsplash.com/photo-1536440136628-849c177e76a1?w=800&q=80'
            ),
            array(
                'title' => 'Cách Tận Hưởng Trọn Vẹn Trải Nghiệm Xem Phim',
                'content' => 'Xem phim không chỉ đơn giản là ngồi và theo dõi màn hình. Có rất nhiều cách để nâng cao trải nghiệm của bạn, từ việc chọn thời điểm phù hợp, chuẩn bị tinh thần cho đến cách thưởng thức từng khung hình.',
                'image_url' => 'https://images.unsplash.com/photo-1517604931442-71053644388d?w=800&q=80'
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
                // Handle Image
                if (isset($blog_data['image_url'])) {
                    $this->upload_image_from_url($blog_data['image_url'], $post_id);
                }
                $created++;
            }
        }

        return $created;
    }
    
    private function seed_showtimes() {
        // Get all movies and cinemas
        $movies = get_posts(array('post_type' => 'mbs_movie', 'posts_per_page' => -1));
        $cinemas = get_posts(array('post_type' => 'mbs_cinema', 'posts_per_page' => -1));
        
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
                $date = date('Y-m-d', strtotime('+' . rand(0, 7) . ' days'));
                $datetime = $date . 'T' . $time;
                
                // Create Showtime Post (mbs_showtime)
                $post_id = wp_insert_post(array(
                    'post_title'   => $movie->post_title . ' - ' . $cinema->post_title . ' - ' . $datetime,
                    'post_status'  => 'publish',
                    'post_type'    => 'mbs_showtime',
                    'post_author'  => 1
                ));
                
                if ($post_id && !is_wp_error($post_id)) {
                    update_post_meta($post_id, '_mbs_movie_id', $movie->ID);
                    update_post_meta($post_id, '_mbs_cinema_id', $cinema->ID);
                    update_post_meta($post_id, '_mbs_showtime', $datetime);
                    update_post_meta($post_id, '_mbs_price', rand(80, 150) . '000');
                    update_post_meta($post_id, '_mbs_room', 'Phòng ' . rand(1, 10));
                    update_post_meta($post_id, '_mbs_format', '2D');
                    $created++;
                }
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
        
        // Delete all movies (both mbs_movie and legacy movie)
        $movies = get_posts(array(
            'post_type' => array('mbs_movie', 'movie'),
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        $deleted_movies = 0;
        foreach ($movies as $movie) {
            wp_delete_post($movie->ID, true);
            $deleted_movies++;
        }
        echo '<li>🎬 Deleted ' . $deleted_movies . ' movies (mbs_movie & movie)</li>';
        
        // Delete all cinemas (both mbs_cinema and legacy rap_phim)
        $cinemas = get_posts(array(
            'post_type' => array('mbs_cinema', 'rap_phim'),
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        $deleted_cinemas = 0;
        foreach ($cinemas as $cinema) {
            wp_delete_post($cinema->ID, true);
            $deleted_cinemas++;
        }
        echo '<li>🏢 Deleted ' . $deleted_cinemas . ' cinemas (mbs_cinema & rap_phim)</li>';
        
        // Delete all showtimes
        $showtimes = get_posts(array(
            'post_type' => 'mbs_showtime',
            'posts_per_page' => -1,
            'post_status' => 'any'
        ));
        $deleted_showtimes = 0;
        foreach ($showtimes as $showtime) {
            wp_delete_post($showtime->ID, true);
            $deleted_showtimes++;
        }
        echo '<li>🎫 Deleted ' . $deleted_showtimes . ' showtimes</li>';
        
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
