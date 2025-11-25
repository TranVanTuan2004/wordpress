<?php
// Fallback single template.
$pt = get_post_type();
$cinema_pts = array('rap_phim','rap-phim','cinema','theater','mbs_cinema','rap','rapfilm','rap_phim_cpt');
if ( in_array($pt, $cinema_pts, true) ) {
  $cinema_template = locate_template(array('single-mbs_cinema.php','single-rap_phim.php'));
  if ($cinema_template) {
    require $cinema_template;
    exit;
  }
  require __DIR__ . '/single-mbs_cinema.php';
  exit;
}

// Default minimal single view (keeps site working for other CPTs)
get_header();
?>
<main class="default-single" style="max-width:1200px;margin:0 auto;padding:24px 16px;color:#e5e7eb">
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <h1 style="color:#fff"><?php the_title(); ?></h1>
    <div><?php the_content(); ?></div>
  <?php endwhile; endif; ?>
</main>
<?php
get_footer();
?>

