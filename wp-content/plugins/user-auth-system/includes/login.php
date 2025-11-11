<?php
if (!defined('ABSPATH')) exit;

// Shortcode: Login Form
function uas_login_form() {
    // Nếu đã đăng nhập, hiển thị thông báo
    if (is_user_logged_in()) {
        $current_user = wp_get_current_user();
        return '<div class="uas-auth-container">
            <div class="uas-auth-card">
                <div class="uas-auth-header">
                    <h2>👋 Bạn đã đăng nhập rồi!</h2>
                    <p>Xin chào, <strong>' . esc_html($current_user->display_name) . '</strong></p>
                </div>
                <div class="uas-message success" style="display: block;">
                    Bạn đang đăng nhập với tài khoản: ' . esc_html($current_user->user_login) . '
                </div>
                <a href="' . home_url('/profile') . '" class="uas-button uas-button-primary" style="margin-bottom: 15px;">Xem Profile</a>
                <a href="' . wp_logout_url(home_url('/login')) . '" class="uas-button uas-button-danger">Đăng Xuất</a>
            </div>
        </div>';
    }
    
    ob_start();
    ?>
    <div class="uas-auth-container">
        <div class="uas-auth-card">
            <div class="uas-auth-header">
                <h2>Đăng Nhập</h2>
                <p>Chào mừng bạn quay trở lại!</p>
            </div>
            
            <form id="uas-login-form" class="uas-form">
                <div class="uas-form-group">
                    <label for="login_username">Tên đăng nhập hoặc Email</label>
                    <input type="text" id="login_username" name="username" required placeholder="Nhập tên đăng nhập hoặc email">
                </div>
                
                <div class="uas-form-group">
                    <label for="login_password">Mật khẩu</label>
                    <input type="password" id="login_password" name="password" required placeholder="Nhập mật khẩu">
                </div>
                
                <div class="uas-form-options">
                    <label class="uas-checkbox">
                        <input type="checkbox" name="remember">
                        <span>Ghi nhớ đăng nhập</span>
                    </label>
                    <a href="<?php echo wp_lostpassword_url(); ?>" class="uas-forgot-link">Quên mật khẩu?</a>
                </div>
                
                <div id="login-message" class="uas-message"></div>
                
                <button type="submit" class="uas-button uas-button-primary">
                    <span class="button-text">Đăng Nhập</span>
                    <span class="button-loader" style="display: none;">
                        <svg class="spinner" viewBox="0 0 50 50">
                            <circle class="path" cx="25" cy="25" r="20" fill="none" stroke-width="5"></circle>
                        </svg>
                    </span>
                </button>
            </form>
            
            <div class="uas-auth-footer">
                <p>Chưa có tài khoản? <a href="<?php echo home_url('/dang-ky'); ?>">Đăng ký ngay</a></p>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// AJAX: Xử lý đăng nhập
add_action('wp_ajax_nopriv_uas_login', 'uas_handle_login');
function uas_handle_login() {
    check_ajax_referer('uas_nonce', 'nonce');
    
    $username = sanitize_text_field($_POST['username']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']) ? true : false;
    
    $creds = array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    );
    
    $user = wp_signon($creds, false);
    
    if (is_wp_error($user)) {
        wp_send_json_error(array('message' => 'Tên đăng nhập hoặc mật khẩu không đúng!'));
    } else {
        wp_send_json_success(array(
            'message' => 'Đăng nhập thành công!',
            'redirect' => home_url('/profile')
        ));
    }
}

