<?php
/**
 * Template Name: Centered Box - Hộp Giữa Màn Hình
 * Description: Nội dung ở giữa màn hình, phù hợp cho form login/register
 */

// Include header
include plugin_dir_path(dirname(__FILE__)) . 'templates/header.php';
?>

<!-- Main Content -->
<main class="site-content centered-box-page">
    <div class="centered-container">
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
.centered-box-page {
    min-height: calc(100vh - 400px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.centered-container {
    max-width: 600px;
    width: 100%;
    background: white;
    padding: 50px;
    border-radius: 15px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.2);
}

.centered-container h1 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}
</style>

