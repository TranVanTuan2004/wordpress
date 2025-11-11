<?php
/**
 * Template Name: Empty Layout - Layout Trống
 * Description: Trang trống hoàn toàn, không có gì cả, chỉ có nội dung trang
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title(); ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<?php
while (have_posts()) {
    the_post();
    the_content();
}
?>

<?php wp_footer(); ?>
</body>
</html>

