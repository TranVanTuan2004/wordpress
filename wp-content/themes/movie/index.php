<h1>This is file index.php </h1>
<?php 
function greeting($name){
    echo "<p>Hi, This page is $name !!!</p>";
    bloginfo('name'); //in dữ liệu được cấu hình trong wp
    echo '<br>';
}
greeting('Truong Tuan Dung');
while (have_posts()){
    the_post();
    the_title();
    the_content();
    ?>
    <a href="<?php the_permalink(); ?>"><?php the_permalink(); //Đường link tới bài viết ?></a>
<?php }?>

<?php
$args = array(
    'post_type' => 'mbs_movie',
    'posts_per_page' => -1 // lấy hết phim
);

$query = new WP_Query($args);

if ($query->have_posts()) {
    echo "<h2>Danh sách phim (mbs_movie)</h2>";
    echo "<ul>";

    while ($query->have_posts()) {
        $query->the_post();
        ?>
        <li>
            <a href="<?php echo get_permalink(); ?>">
                <?php the_title(); ?>
            </a>
        </li>
        <?php
    }

    echo "</ul>";
}

wp_reset_postdata();
?>
