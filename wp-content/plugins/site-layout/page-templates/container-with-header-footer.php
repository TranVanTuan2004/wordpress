<?php
/**
 * Template Name: Container - Có Header Footer
 * Description: Trang container 1200px với header và footer
 */

// Include header
include plugin_dir_path(dirname(__FILE__)) . 'templates/header.php';
?>

<!-- Main Content -->
<main class="site-content container-page">
    <div class="container">
        <?php
        while (have_posts()) {
            the_post();
            ?>
            <article class="page-content">
                <h1 class="page-title"><?php the_title(); ?></h1>
                <div class="page-body">
                    <?php the_content(); ?>
                </div>
            </article>
            <?php
        }
        ?>
    </div>
</main>

<?php
// Include footer
include plugin_dir_path(dirname(__FILE__)) . 'templates/footer.php';
?>

<style>
.container-page {
    padding: 60px 20px;
    background: #f8f9fa;
}

.container-page .container {
    max-width: 1200px;
    margin: 0 auto;
    background: white;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.page-title {
    font-size: 36px;
    margin-bottom: 30px;
    color: #333;
}

.page-body {
    line-height: 1.8;
    color: #666;
}
</style>

