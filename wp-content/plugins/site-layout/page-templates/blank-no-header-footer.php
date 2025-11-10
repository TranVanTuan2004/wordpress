<?php
/**
 * Template Name: Blank - Không Header Footer
 * Description: Trang trắng hoàn toàn, không có header footer
 */
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title(); ?> | <?php bloginfo('name'); ?></title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php
while (have_posts()) {
    the_post();
    the_content();
}
?>

</body>
</html>

