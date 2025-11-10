<?php
if (!defined('ABSPATH')) exit;

// Shortcode: Profile Page
function uas_profile_page() {
    // Nếu chưa đăng nhập, chuyển về login
    if (!is_user_logged_in()) {
        return '<script>window.location.href="' . home_url('/login') . '";</script>';
    }
    
    $current_user = wp_get_current_user();
    $user_registered = date('d/m/Y', strtotime($current_user->user_registered));
    
    ob_start();
    ?>
    <div class="uas-profile-container">
        <div class="uas-profile-header">
            <div class="profile-avatar">
                <?php echo get_avatar($current_user->ID, 120); ?>
            </div>
            <div class="profile-info">
                <h1><?php echo esc_html($current_user->display_name); ?></h1>
                <p class="profile-username">@<?php echo esc_html($current_user->user_login); ?></p>
                <p class="profile-email">📧 <?php echo esc_html($current_user->user_email); ?></p>
                <p class="profile-joined">📅 Tham gia: <?php echo $user_registered; ?></p>
            </div>
        </div>
        
        <div class="uas-profile-content">
            <div class="profile-card">
                <h3>Thông Tin Cá Nhân</h3>
                <div class="profile-details">
                    <div class="detail-item">
                        <span class="label">Tên đăng nhập:</span>
                        <span class="value"><?php echo esc_html($current_user->user_login); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Email:</span>
                        <span class="value"><?php echo esc_html($current_user->user_email); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Tên hiển thị:</span>
                        <span class="value"><?php echo esc_html($current_user->display_name); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="label">Vai trò:</span>
                        <span class="value">
                            <?php 
                            $roles = $current_user->roles;
                            echo isset($roles[0]) ? ucfirst($roles[0]) : 'User'; 
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="profile-card">
                <h3>Hoạt Động Gần Đây</h3>
                <div class="activity-list">
                    <p style="text-align: center; color: #999; padding: 40px 0;">Chưa có hoạt động nào</p>
                </div>
            </div>
            
            <div class="profile-actions">
                <a href="<?php echo admin_url('profile.php'); ?>" class="uas-button uas-button-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Chỉnh Sửa Hồ Sơ
                </a>
                
                <button id="uas-logout-btn" class="uas-button uas-button-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Đăng Xuất
                </button>
            </div>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// AJAX: Xử lý đăng xuất
add_action('wp_ajax_uas_logout', 'uas_handle_logout');
function uas_handle_logout() {
    check_ajax_referer('uas_nonce', 'nonce');
    
    wp_logout();
    
    wp_send_json_success(array(
        'message' => 'Đã đăng xuất!',
        'redirect' => home_url('/login')
    ));
}

