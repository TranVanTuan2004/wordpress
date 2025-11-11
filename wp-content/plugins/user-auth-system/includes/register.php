<?php
if (!defined('ABSPATH')) exit;

// Shortcode: Register Form
function uas_register_form() {
    // Nếu đã đăng nhập, hiển thị thông báo
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        return '<div class="uas-auth-container">
            <div class="uas-auth-card">
                <div class="uas-auth-header">
                    <h2>👋 Bạn đã có tài khoản rồi!</h2>
                    <p>Xin chào, <strong>' . esc_html($current_user->display_name) . '</strong></p>
                </div>
                <div class="uas-message success" style="display: block;">
                    Bạn đang đăng nhập với tài khoản: ' . esc_html($current_user->user_login) . '
                </div>
                <a href="' . home_url('/profile') . '" class="uas-button uas-button-primary" style="margin-bottom: 15px;">Xem Profile</a>
                <a href="' . wp_logout_url(home_url('/register')) . '" class="uas-button uas-button-danger">Đăng Xuất</a>
            </div>
        </div>';
    }
    
    ob_start();
    ?>
    <div class="uas-auth-container">
        <div class="uas-auth-card">
            <div class="uas-auth-header">
                <h2>Đăng Ký Tài Khoản</h2>
                <p>Tạo tài khoản mới để trải nghiệm đầy đủ</p>
            </div>
            
            <form id="uas-register-form" class="uas-form">
                <div class="uas-form-group">
                    <label for="reg_username">Tên đăng nhập</label>
                    <input type="text" id="reg_username" name="username" required placeholder="Chọn tên đăng nhập">
                </div>
                
                <div class="uas-form-group">
                    <label for="reg_email">Email</label>
                    <input type="email" id="reg_email" name="email" required placeholder="your@email.com">
                </div>
                
                <div class="uas-form-row">
                    <div class="uas-form-group">
                        <label for="reg_password">Mật khẩu</label>
                        <input type="password" id="reg_password" name="password" required placeholder="Tối thiểu 6 ký tự">
                    </div>
                    
                    <div class="uas-form-group">
                        <label for="reg_confirm_password">Xác nhận mật khẩu</label>
                        <input type="password" id="reg_confirm_password" name="confirm_password" required placeholder="Nhập lại mật khẩu">
                    </div>
                </div>
                
                <div class="uas-form-group">
                    <label class="uas-checkbox">
                        <input type="checkbox" name="agree_terms" required>
                        <span>Tôi đồng ý với <a href="#">Điều khoản dịch vụ</a> và <a href="#">Chính sách bảo mật</a></span>
                    </label>
                </div>
                
                <div id="register-message" class="uas-message"></div>
                
                <button type="submit" class="uas-button uas-button-primary">
                    <span class="button-text">Tạo Tài Khoản</span>
                    <span class="button-loader" style="display: none;">
                        <svg class="spinner" viewBox="0 0 50 50">
                            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                        </svg>
                    </span>
                </button>
            </form>
            
            <div class="uas-auth-footer">
                <p>Đã có tài khoản? <a href="<?php echo home_url('/dang-nhap'); ?>">Đăng nhập ngay</a></p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// AJAX: Xử lý đăng ký
add_action('wp_ajax_nopriv_uas_register', 'uas_handle_register');
function uas_handle_register() {
    check_ajax_referer('uas_nonce', 'nonce');
    
    $username = sanitize_text_field($_POST['username']);
    $email = sanitize_email($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate
    if ($password !== $confirm_password) {
        wp_send_json_error(array('message' => 'Mật khẩu xác nhận không khớp!'));
    }
    
    if (strlen($password) < 6) {
        wp_send_json_error(array('message' => 'Mật khẩu phải có ít nhất 6 ký tự!'));
    }
    
    if (username_exists($username)) {
        wp_send_json_error(array('message' => 'Tên đăng nhập đã tồn tại!'));
    }
    
    if (email_exists($email)) {
        wp_send_json_error(array('message' => 'Email đã được sử dụng!'));
    }
    
    // Tạo user
    $user_id = wp_create_user($username, $password, $email);
    
    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => 'Có lỗi xảy ra, vui lòng thử lại!'));
    } else {
        // Tự động đăng nhập sau khi đăng ký
        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        
        wp_send_json_success(array(
            'message' => 'Đăng ký thành công!',
            'redirect' => home_url('/')
        ));
    }
}

