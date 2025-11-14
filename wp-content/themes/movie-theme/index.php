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