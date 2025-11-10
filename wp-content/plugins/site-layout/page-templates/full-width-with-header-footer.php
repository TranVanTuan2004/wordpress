<?php
/**
 * Template Name: Full Width - Có Header Footer
 * Description: Trang full width với header và footer tùy chỉnh
 */

// Include header
include plugin_dir_path(dirname(__FILE__)) . 'templates/header.php';
?>

<!-- Main Content -->
<main class="site-content full-width">
    <div class="content-wrapper">
        <?php
        while (have_posts()) {
            the_post();
            the_content();
        }
        ?>
    </div>
</main>

<?php
// Include footer
include plugin_dir_path(dirname(__FILE__)) . 'templates/footer.php';
?>

<style>
.content-wrapper {
    max-width: 1400px;
    margin: 0 auto;
    padding: 60px 20px;
}
</style>

