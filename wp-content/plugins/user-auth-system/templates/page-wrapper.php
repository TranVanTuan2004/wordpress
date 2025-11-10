<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title(); ?> | <?php bloginfo('name'); ?></title>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Plugin CSS & JS -->
    <link rel="stylesheet" href="<?php echo UAS_URL; ?>assets/style.css?v=2.0">
    <script src="<?php echo UAS_URL; ?>assets/script.js?v=2.0"></script>
    
    <!-- Localize script -->
    <script>
        var uasAjax = {
            ajaxurl: '<?php echo admin_url('admin-ajax.php'); ?>',
            nonce: '<?php echo wp_create_nonce('uas_nonce'); ?>'
        };
    </script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
    </style>
</head>
<body>

<?php
// Render nội dung trang
global $post;
echo do_shortcode($post->post_content);
?>

</body>
</html>

