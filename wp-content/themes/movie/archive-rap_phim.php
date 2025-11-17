<?php
get_header();
?>
<main class="cinema-archive">
  <div class="cinema-inner">
    <h1 class="cinema-archive-title">Hệ thống rạp</h1>
    <div class="cinema-list">
      <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <a class="cinema-item" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
      <?php endwhile; else: ?>
        <div class="cinema-empty">Chưa có rạp.</div>
      <?php endif; ?>
    </div>
  </div>
  <style>
    .cinema-inner{max-width:1200px;margin:0 auto;padding:24px 16px}
    .cinema-archive-title{color:#fff;margin:0 0 12px;font-size:28px;font-weight:800}
    .cinema-list{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;background:#0f1b31;border:1px solid rgba(255,255,255,.12);border-radius:12px;padding:18px 22px;margin-bottom:24px;color:#e5e7eb}
    .cinema-item{display:block;color:#e5e7eb;text-decoration:none;font-weight:600;padding:10px 8px;border-radius:10px}
    .cinema-item:hover{background:rgba(255,255,255,.06)}
  </style>
</main>
<?php
get_footer();
?>

