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
    $nonce = wp_create_nonce('uas_nonce');
    
    ob_start();
    ?>
    <style>
        /* Profile (client) modern UI */
        .uas-profile-container{margin:0 auto 0px;padding:40px 16px;width:100%}
        .uas-profile-header{display:flex;gap:18px;align-items:center;padding:24px;border-radius:16px;background:linear-gradient(135deg,#6a11cb 0%,#2575fc 100%);color:#fff;box-shadow:0 20px 50px rgba(76,29,149,.35);position:relative;overflow:hidden;background-size:200% 200%;animation:uas-gradient-header 12s ease infinite}
        .uas-profile-header .profile-avatar img{border-radius:50%;border:3px solid rgba(255,255,255,.45)}
        .uas-profile-header .profile-info h1{margin:0 0 6px;font-size:22px;font-weight:700}
        .uas-profile-header .profile-username{font-size:13px;opacity:.9;margin:0 0 4px}
        .uas-profile-header .profile-email,.uas-profile-header .profile-joined{font-size:12px;opacity:.95;margin:0}
        .uas-profile-content{background:rgba(255,255,255,.66);border:1px solid rgba(255,255,255,.45);backdrop-filter:blur(10px) saturate(120%);border-radius:16px;box-shadow:0 10px 40px rgba(31,41,55,.08);margin-top:-10px;padding:18px 18px 8px;margin-bottom:40px}
        .profile-card{border:1px solid rgba(255,255,255,.45);border-radius:16px;padding:16px 16px 10px;margin:10px 0;background:rgba(255,255,255,.66);backdrop-filter:blur(8px)}
        .profile-card h3{font-size:14px;font-weight:700;margin:0 0 10px;color:#1f2937}
        .profile-details{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px 16px}
        .profile-details .detail-item{display:flex;justify-content:space-between;gap:12px;background:#fff;border:1px solid #eef2f7;border-radius:10px;padding:10px 12px}
        .profile-details .label{color:#6b7280;font-size:12px}
        .profile-details .value{color:#111827;font-weight:600;font-size:13px}
        @media(max-width:640px){.profile-details{grid-template-columns:1fr}}
        .profile-actions{display:flex;gap:12px;justify-content:space-between;padding:8px 2px 4px}
        .uas-button{display:inline-flex;align-items:center;gap:8px;border-radius:10px;padding:10px 14px;font-weight:600;border:1px solid transparent;transition:all .2s;box-shadow:0 10px 25px rgba(17,24,39,.08), inset 0 1px 0 rgba(255,255,255,.35)}
        .uas-button-secondary{background:linear-gradient(180deg,#eef2ff 0%,#e0e7ff 100%);color:#3730a3;border-color:rgba(99,102,241,.25)}
        .uas-button-secondary:hover{transform:translateY(-2px);box-shadow:0 14px 28px rgba(99,102,241,.25)}
        .uas-button-danger{background:#fee2e2;color:#991b1b;border-color:#fecaca}
        .uas-button-danger:hover{background:#fecaca}
        @keyframes uas-gradient-header{0%,100%{background-position:0% 50%}50%{background-position:100% 50%}}
    </style>
    <div class="uas-profile-container" id="uas-profile-root">
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
                <form id="uas-profile-form" class="profile-details" novalidate>
                    <div class="detail-item">
                        <span class="label">Tên đăng nhập:</span>
                        <span class="value"><?php echo esc_html($current_user->user_login); ?></span>
                    </div>
                    <div class="detail-item">
                        <label class="label" for="uas_email">Email:</label>
                        <div class="value">
                            <input id="uas_email" name="user_email" type="email" class="uas-input" value="<?php echo esc_attr($current_user->user_email); ?>" disabled>
                        </div>
                    </div>
                    <div class="detail-item">
                        <label class="label" for="uas_display_name">Tên hiển thị:</label>
                        <div class="value">
                            <input id="uas_display_name" name="display_name" type="text" class="uas-input" value="<?php echo esc_attr($current_user->display_name); ?>" disabled>
                        </div>
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
                </form>
            </div>
  
            <div class="profile-actions">
                <button id="uas-edit-toggle" class="uas-button uas-button-secondary" type="button">Chỉnh sửa</button>
                <button id="uas-save-profile" class="uas-button uas-button-primary" type="button" style="display:none;">Lưu thay đổi</button>
                <button id="uas-cancel-edit" class="uas-button" type="button" style="display:none;border:2px solid #E5E7EB;background:#fff;">Hủy</button>
                
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
    <script>
        (function(){
            var btn = document.getElementById('uas-logout-btn');
            if(!btn) return;
            btn.addEventListener('click', function(){
                btn.disabled = true;
                btn.style.opacity = '0.7';
                var params = new URLSearchParams();
                params.append('action', 'uas_logout');
                params.append('nonce', '<?php echo esc_js($nonce); ?>');
                fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                    method: 'POST',
                    headers: {'Content-Type':'application/x-www-form-urlencoded'},
                    body: params.toString()
                }).then(function(r){return r.json();}).then(function(res){
                    if (res && res.success && res.data && res.data.redirect) {
                        window.location.href = res.data.redirect;
                    } else {
                        window.location.reload();
                    }
                }).catch(function(){
                    window.location.reload();
                });
            });

            // Edit mode toggle
            var editBtn = document.getElementById('uas-edit-toggle');
            var saveBtn = document.getElementById('uas-save-profile');
            var cancelBtn = document.getElementById('uas-cancel-edit');
            var form = document.getElementById('uas-profile-form');
            if (editBtn && form) {
                var inputs = form.querySelectorAll('input.uas-input');
                var pristine = {};
                inputs.forEach(function(i){ pristine[i.name] = i.value; });

                function setEditing(editing){
                    inputs.forEach(function(i){ i.disabled = !editing; });
                    saveBtn.style.display = editing ? '' : 'none';
                    cancelBtn.style.display = editing ? '' : 'none';
                    editBtn.style.display = editing ? 'none' : '';
                }

                editBtn.addEventListener('click', function(){ setEditing(true); });
                cancelBtn.addEventListener('click', function(){
                    inputs.forEach(function(i){ i.value = pristine[i.name]; });
                    setEditing(false);
                });

                saveBtn.addEventListener('click', function(){
                    saveBtn.disabled = true;
                    var params = new URLSearchParams();
                    params.append('action', 'uas_update_profile');
                    params.append('nonce', '<?php echo esc_js($nonce); ?>');
                    inputs.forEach(function(i){ params.append(i.name, i.value); });
                    fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                        method: 'POST',
                        headers: {'Content-Type':'application/x-www-form-urlencoded'},
                        body: params.toString()
                    }).then(function(r){ return r.json(); }).then(function(res){
                        saveBtn.disabled = false;
                        if (res && res.success) {
                            pristine = {};
                            inputs.forEach(function(i){ pristine[i.name] = i.value; });
                            setEditing(false);
                            // Cập nhật header hiển thị nhanh
                            var nameEl = document.querySelector('.profile-info h1');
                            var emailEl = document.querySelector('.profile-email');
                            if (nameEl) nameEl.textContent = document.getElementById('uas_display_name').value;
                            if (emailEl) emailEl.textContent = '📧 ' + document.getElementById('uas_email').value;
                        } else {
                            alert((res && res.data && res.data.message) ? res.data.message : 'Có lỗi xảy ra, vui lòng thử lại!');
                        }
                    }).catch(function(){
                        saveBtn.disabled = false;
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                    });
                });
            }
        })();
    </script>
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

// AJAX: Cập nhật thông tin hồ sơ
add_action('wp_ajax_uas_update_profile', 'uas_update_profile');
function uas_update_profile() {
    check_ajax_referer('uas_nonce', 'nonce');

    if (!is_user_logged_in()) {
        wp_send_json_error(array('message' => 'Bạn chưa đăng nhập.'));
    }

    $user_id = get_current_user_id();

    $display_name = isset($_POST['display_name']) ? sanitize_text_field($_POST['display_name']) : '';
    $user_email   = isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '';

    if (!$display_name) {
        wp_send_json_error(array('message' => 'Tên hiển thị không được để trống.'));
    }
    if ($user_email && !is_email($user_email)) {
        wp_send_json_error(array('message' => 'Email không hợp lệ.'));
    }

    // Nếu đổi email, kiểm tra trùng
    if ($user_email) {
        $existing = get_user_by('email', $user_email);
        if ($existing && intval($existing->ID) !== intval($user_id)) {
            wp_send_json_error(array('message' => 'Email đã được sử dụng bởi tài khoản khác.'));
        }
    }

    $userdata = array(
        'ID'           => $user_id,
        'display_name' => $display_name,
    );
    if ($user_email) {
        $userdata['user_email'] = $user_email;
    }

    $result = wp_update_user($userdata);
    if (is_wp_error($result)) {
        wp_send_json_error(array('message' => $result->get_error_message()));
    }

    wp_send_json_success(array('message' => 'Cập nhật hồ sơ thành công.'));
}

