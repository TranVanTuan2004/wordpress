<?php
/**
 * Template for displaying search results
 */

get_header();
?>

<main class="search-results-page">
  <div class="search-results-container">
    <h1 class="search-results-title">
      <?php
      $search_query = get_search_query();
      if ($search_query) {
        printf('Kết quả tìm kiếm: "%s"', esc_html($search_query));
      } else {
        echo 'Tìm kiếm';
      }
      ?>
    </h1>

    <?php if (have_posts()) : ?>
      <div class="search-results-grid">
        <?php
        while (have_posts()) :
          the_post();
          $post_type = get_post_type();
          $is_movie = ($post_type === 'mbs_movie');
          $is_cinema = ($post_type === 'mbs_cinema');
        ?>
          <article class="search-result-item <?php echo esc_attr($post_type); ?>">
            <a href="<?php the_permalink(); ?>" class="search-result-link">
              <?php if (has_post_thumbnail()) : ?>
                <div class="search-result-thumbnail">
                  <?php the_post_thumbnail('medium'); ?>
                </div>
              <?php endif; ?>
              
              <div class="search-result-content">
                <div class="search-result-type">
                  <?php
                  if ($is_movie) {
                    echo '<span class="type-badge type-movie">🎬 Phim</span>';
                  } elseif ($is_cinema) {
                    echo '<span class="type-badge type-cinema">🏢 Rạp</span>';
                  } else {
                    echo '<span class="type-badge">📄 ' . get_post_type_object($post_type)->labels->singular_name . '</span>';
                  }
                  ?>
                </div>
                
                <h2 class="search-result-title"><?php the_title(); ?></h2>
                
                <?php if (has_excerpt() || $is_movie || $is_cinema) : ?>
                  <div class="search-result-excerpt">
                    <?php
                    if ($is_movie) {
                      $excerpt = get_the_excerpt();
                      if (empty($excerpt)) {
                        $excerpt = wp_trim_words(get_the_content(), 30);
                      }
                      echo esc_html($excerpt);
                    } elseif ($is_cinema) {
                      $excerpt = get_the_excerpt();
                      if (empty($excerpt)) {
                        $excerpt = wp_trim_words(get_the_content(), 30);
                      }
                      echo esc_html($excerpt);
                    } else {
                      the_excerpt();
                    }
                    ?>
                  </div>
                <?php endif; ?>
                
                <div class="search-result-meta">
                  <span class="search-result-date"><?php echo get_the_date('d/m/Y'); ?></span>
                </div>
              </div>
            </a>
          </article>
        <?php endwhile; ?>
      </div>

      <div class="search-pagination">
        <?php
        the_posts_pagination(array(
          'mid_size' => 2,
          'prev_text' => '‹ Trước',
          'next_text' => 'Sau ›',
        ));
        ?>
      </div>
    <?php else : ?>
      <div class="search-no-results">
        <div class="no-results-icon">🔍</div>
        <h2>Không tìm thấy kết quả</h2>
        <p>Không có phim hoặc rạp nào khớp với từ khóa "<strong><?php echo esc_html($search_query); ?></strong>"</p>
        <div class="search-suggestions">
          <p>Gợi ý:</p>
          <ul>
            <li>Kiểm tra lại chính tả</li>
            <li>Thử dùng từ khóa khác</li>
            <li>Sử dụng từ khóa ngắn gọn hơn</li>
          </ul>
        </div>
        <a href="<?php echo esc_url(home_url('/')); ?>" class="back-home-btn">Về trang chủ</a>
      </div>
    <?php endif; ?>
  </div>
</main>

<style>
  .search-results-page {
    min-height: calc(100vh - 120px);
    background: linear-gradient(180deg, rgba(10,10,40,0.00) 0%, rgba(7,30,61,0.25) 100%);
    color: #ffffff;
    padding: 40px 0;
  }

  .search-results-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 16px;
  }

  .search-results-title {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 30px;
    color: #ffffff;
    letter-spacing: 0.04em;
  }

  .search-results-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
    margin-bottom: 40px;
  }

  .search-result-item {
    background: rgba(7, 30, 61, 0.65);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 12px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
  }

  .search-result-item:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 28px rgba(0, 0, 0, 0.35);
  }

  .search-result-link {
    display: block;
    text-decoration: none;
    color: inherit;
  }

  .search-result-thumbnail {
    width: 100%;
    height: 200px;
    overflow: hidden;
    background: rgba(255, 255, 255, 0.05);
  }

  .search-result-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .search-result-content {
    padding: 20px;
  }

  .search-result-type {
    margin-bottom: 12px;
  }

  .type-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    background: rgba(255, 228, 77, 0.2);
    color: #ffe44d;
    border: 1px solid rgba(255, 228, 77, 0.3);
  }

  .type-badge.type-movie {
    background: rgba(111, 69, 196, 0.2);
    color: #b794f6;
    border-color: rgba(111, 69, 196, 0.3);
  }

  .type-badge.type-cinema {
    background: rgba(34, 197, 94, 0.2);
    color: #4ade80;
    border-color: rgba(34, 197, 94, 0.3);
  }

  .search-result-title {
    font-size: 20px;
    font-weight: 800;
    margin: 0 0 12px 0;
    color: #ffffff;
    line-height: 1.3;
  }

  .search-result-excerpt {
    font-size: 14px;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 12px;
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  .search-result-meta {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.5);
  }

  .search-pagination {
    margin-top: 40px;
    display: flex;
    justify-content: center;
  }

  .search-pagination .page-numbers {
    display: flex;
    gap: 8px;
    align-items: center;
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .search-pagination .page-numbers li {
    margin: 0;
  }

  .search-pagination .page-numbers a,
  .search-pagination .page-numbers span {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 12px;
    border-radius: 10px;
    text-decoration: none;
    color: #e9eef7;
    background: rgba(7, 30, 61, 0.65);
    border: 1px solid rgba(255, 255, 255, 0.14);
    transition: all 0.2s ease;
  }

  .search-pagination .page-numbers a:hover {
    background: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.3);
  }

  .search-pagination .page-numbers .current {
    background: #ffe44d;
    color: #0e1220;
    font-weight: 800;
    border-color: #ffe44d;
  }

  .search-no-results {
    text-align: center;
    padding: 60px 20px;
    background: rgba(7, 30, 61, 0.65);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255, 255, 255, 0.14);
    border-radius: 12px;
  }

  .no-results-icon {
    font-size: 64px;
    margin-bottom: 20px;
  }

  .search-no-results h2 {
    font-size: 24px;
    font-weight: 800;
    margin: 0 0 16px 0;
    color: #ffffff;
  }

  .search-no-results p {
    font-size: 16px;
    color: rgba(255, 255, 255, 0.7);
    margin-bottom: 24px;
  }

  .search-suggestions {
    text-align: left;
    max-width: 400px;
    margin: 0 auto 30px;
    background: rgba(255, 255, 255, 0.05);
    padding: 20px;
    border-radius: 8px;
  }

  .search-suggestions p {
    font-weight: 700;
    margin-bottom: 12px;
    color: #ffffff;
  }

  .search-suggestions ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .search-suggestions li {
    padding: 8px 0;
    color: rgba(255, 255, 255, 0.7);
    position: relative;
    padding-left: 20px;
  }

  .search-suggestions li:before {
    content: "•";
    position: absolute;
    left: 0;
    color: #ffe44d;
  }

  .back-home-btn {
    display: inline-block;
    padding: 12px 24px;
    background: #ffe44d;
    color: #0e1220;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 800;
    transition: all 0.2s ease;
  }

  .back-home-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 24px rgba(255, 228, 77, 0.35);
  }

  @media (max-width: 768px) {
    .search-results-grid {
      grid-template-columns: 1fr;
    }

    .search-results-title {
      font-size: 24px;
    }
  }
</style>

<?php
get_footer();
?>

