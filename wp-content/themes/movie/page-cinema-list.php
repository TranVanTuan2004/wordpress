<?php
/**
 * Template Name: Danh Sách Rạp Phim
 */

get_header();
?>

<main class="cinema-archive">
  <div class="cinema-inner">
    <h1 class="cinema-archive-title">Hệ thống rạp</h1>
    <?php
      // Tự dò post type rạp phổ biến
      $candidates = array('rap_phim','rap-phim','cinema','theater','mbs_cinema','rap','rapfilm','rap_phim_cpt');
      $cinema_pt  = null;
      foreach ($candidates as $cpt) {
        $probe = new WP_Query(array('post_type'=>$cpt, 'posts_per_page'=>1));
        if ($probe->have_posts()) { $cinema_pt = $cpt; wp_reset_postdata(); break; }
        wp_reset_postdata();
      }

      if ($cinema_pt) :
        $cinemas = new WP_Query(array(
          'post_type'      => $cinema_pt,
          'posts_per_page' => -1,
          'orderby'        => 'title',
          'order'          => 'ASC',
        ));
    ?>
      <div class="cinema-list">
        <?php if ($cinemas->have_posts()) : while ($cinemas->have_posts()) : $cinemas->the_post(); ?>
          <a class="cinema-item" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        <?php endwhile; wp_reset_postdata(); else: ?>
          <div class="cinema-empty">Chưa có rạp.</div>
        <?php endif; ?>
      </div>
    <?php else: ?>
      <div class="cinema-empty">Không tìm thấy post type “Rạp Phim”. Hãy cung cấp post type key để mình cấu hình.</div>
    <?php endif; ?>
  </div>

  <style>
    .cinema-inner{max-width:1200px;margin:0 auto;padding:24px 16px}
    .cinema-archive-title{color:#fff;margin:0 0 12px;font-size:28px;font-weight:800}
    .cinema-list{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;background:#0f1b31;border:1px solid rgba(255,255,255,.12);border-radius:12px;padding:18px 22px;margin-bottom:24px;color:#e5e7eb}
    .cinema-item{display:block;color:#e5e7eb;text-decoration:none;font-weight:600;padding:10px 8px;border-radius:10px}
    .cinema-item:hover{background:rgba(255,255,255,.06)}
    .cinema-empty{color:#e5e7eb}
  </style>
</main>

<?php
get_footer();
?>

