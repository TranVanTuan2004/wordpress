<?php
/**
 * Template Name: Debug Phim Đang Chiếu
 */

// Lấy thông tin về trang hiện tại
$current_page = get_queried_object();
$page_id = get_the_ID();
$page_template = get_page_template_slug();
$assigned_template = get_post_meta($page_id, '_wp_page_template', true);

get_header(); 
?>

<div class="container" style="padding: 40px 20px; color: #fff;">
    <h1 style="text-align: center; margin-bottom: 40px;">DEBUG: Phim Đang Chiếu</h1>
    
    <div style="background: #1a1a2e; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <h2 style="color: #ffe44d;">Thông Tin Trang</h2>
        <table style="width: 100%; color: #fff;">
            <tr>
                <td><strong>Page ID:</strong></td>
                <td><?php echo $page_id; ?></td>
            </tr>
            <tr>
                <td><strong>Page Title:</strong></td>
                <td><?php echo get_the_title(); ?></td>
            </tr>
            <tr>
                <td><strong>Page Slug:</strong></td>
                <td><?php echo $current_page->post_name; ?></td>
            </tr>
            <tr>
                <td><strong>Template đang dùng:</strong></td>
                <td><?php echo $page_template ? $page_template : 'default (index.php)'; ?></td>
            </tr>
            <tr>
                <td><strong>Template được gán:</strong></td>
                <td><?php echo $assigned_template ? $assigned_template : 'không có'; ?></td>
            </tr>
            <tr>
                <td><strong>File template thực tế:</strong></td>
                <td><?php echo basename(get_page_template()); ?></td>
            </tr>
        </table>
    </div>

    <div style="background: #1a1a2e; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <h2 style="color: #ffe44d;">Kiểm Tra Template Files</h2>
        <?php
        $theme_dir = get_template_directory();
        $templates_to_check = array(
            'page-phim-dang-chieu.php',
            'page-phim-sap-chieu.php',
            'index.php'
        );
        
        echo '<ul style="color: #fff;">';
        foreach ($templates_to_check as $template) {
            $file_path = $theme_dir . '/' . $template;
            $exists = file_exists($file_path);
            $color = $exists ? '#4ade80' : '#ef4444';
            echo '<li style="margin: 10px 0;">';
            echo '<span style="color: ' . $color . ';">' . ($exists ? '✓' : '✗') . '</span> ';
            echo '<strong>' . $template . '</strong>: ';
            echo $exists ? 'TỒN TẠI' : 'KHÔNG TỒN TẠI';
            if ($exists) {
                echo ' <span style="color: #999;">(Size: ' . filesize($file_path) . ' bytes)</span>';
            }
            echo '</li>';
        }
        echo '</ul>';
        ?>
    </div>

    <div style="background: #1a1a2e; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <h2 style="color: #ffe44d;">Query Phim</h2>
        <?php
        $args = array(
            'post_type' => 'mbs_movie',
            'posts_per_page' => 5,
            'post_status' => 'publish'
        );
        
        $movies = new WP_Query($args);
        
        echo '<p><strong>Số phim tìm thấy:</strong> ' . $movies->found_posts . '</p>';
        echo '<p><strong>Post type exists:</strong> ' . (post_type_exists('mbs_movie') ? 'CÓ' : 'KHÔNG') . '</p>';
        
        if ($movies->have_posts()) {
            echo '<h3>Danh sách 5 phim đầu tiên:</h3>';
            echo '<ul>';
            while ($movies->have_posts()) {
                $movies->the_post();
                echo '<li>' . get_the_title() . ' (ID: ' . get_the_ID() . ')</li>';
            }
            echo '</ul>';
            wp_reset_postdata();
        } else {
            echo '<p style="color: #ef4444;">KHÔNG TÌM THẤY PHIM NÀO!</p>';
        }
        ?>
    </div>

    <div style="background: #1a1a2e; padding: 20px; border-radius: 10px; margin-bottom: 30px;">
        <h2 style="color: #ffe44d;">Hướng Dẫn Sửa Lỗi</h2>
        <ol style="color: #fff; line-height: 1.8;">
            <li>Nếu "Template được gán" là "không có" hoặc khác "page-phim-dang-chieu.php":
                <ul>
                    <li>Vào WordPress Admin → Pages → Phim Đang Chiếu → Edit</li>
                    <li>Ở sidebar bên phải, tìm "Page Attributes" → "Template"</li>
                    <li>Chọn "Phim Đang Chiếu" từ dropdown</li>
                    <li>Click "Update"</li>
                </ul>
            </li>
            <li>Nếu file template không tồn tại:
                <ul>
                    <li>Kiểm tra lại file đã được tạo đúng vị trí chưa</li>
                    <li>Path: <?php echo $theme_dir; ?>/page-phim-dang-chieu.php</li>
                </ul>
            </li>
            <li>Nếu không tìm thấy phim:
                <ul>
                    <li>Kiểm tra xem đã có phim trong WordPress Admin → Movies chưa</li>
                    <li>Kiểm tra post type 'mbs_movie' có được đăng ký chưa</li>
                </ul>
            </li>
        </ol>
    </div>

    <div style="background: #1a1a2e; padding: 20px; border-radius: 10px;">
        <h2 style="color: #ffe44d;">WordPress Info</h2>
        <table style="width: 100%; color: #fff;">
            <tr>
                <td><strong>WordPress Version:</strong></td>
                <td><?php echo get_bloginfo('version'); ?></td>
            </tr>
            <tr>
                <td><strong>Theme:</strong></td>
                <td><?php echo wp_get_theme()->get('Name'); ?></td>
            </tr>
            <tr>
                <td><strong>Theme Directory:</strong></td>
                <td><?php echo $theme_dir; ?></td>
            </tr>
            <tr>
                <td><strong>Permalink Structure:</strong></td>
                <td><?php echo get_option('permalink_structure'); ?></td>
            </tr>
        </table>
    </div>
</div>

<?php get_footer(); ?>
