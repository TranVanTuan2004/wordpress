<?php
/**
 * Profile page component (Front-end)
 * Sử dụng shortcode [cns_profile] để hiển thị
 * - Lưu thông tin cơ bản: họ tên, email, số điện thoại, ngày sinh
 * - Đổi mật khẩu
 */

if (! is_user_logged_in()) {
    return;
}

$user = wp_get_current_user();
$phone = get_user_meta($user->ID, 'phone', true);
$birthday = get_user_meta($user->ID, 'birthday', true);

// Lấy message (sau khi redirect)
$cns_msg_ok = '';
if (isset($_GET['cnspok'])) {
    $key = sanitize_text_field(wp_unslash($_GET['cnspok']));
    $msg = get_transient('cns_profile_ok_' . $key);
    if ($msg) { $cns_msg_ok = $msg; delete_transient('cns_profile_ok_' . $key); }
}
$cns_msg_err = '';
if (isset($_GET['cnspre'])) {
    $key = sanitize_text_field(wp_unslash($_GET['cnspre']));
    $msg = get_transient('cns_profile_err_' . $key);
    if ($msg) { $cns_msg_err = $msg; delete_transient('cns_profile_err_' . $key); }
}
?>
<main class="cns-profile">
  <div class="cns-profile__container">
    <aside class="cns-profile__aside">
      <div class="cns-profile__card">
        <div class="cns-profile__avatar">
          <div class="cns-profile__avatar-circle"><?php echo esc_html( strtoupper( mb_substr( $user->display_name ?: $user->user_login, 0, 1 ) ) ); ?></div>
          <a class="cns-link--sm" href="<?php echo esc_url( get_edit_profile_url( $user->ID ) ); ?>">Thay đổi ảnh đại diện</a>
        </div>
        <div class="cns-profile__name"><?php echo esc_html( $user->display_name ?: $user->user_login ); ?></div>
        <a class="cns-profile__btn-primary" href="#">C'Friends</a>
      </div>

      <div class="cns-profile__menu">
        <a class="is-active" href="<?php echo esc_url( home_url('/profile') ); ?>">Thông tin khách hàng</a>
        <a href="#">Thành viên Cinestar</a>
        <a href="#">Lịch sử mua hàng</a>
        <a href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>">Đăng xuất</a>
      </div>
    </aside>

    <section class="cns-profile__content">
      <h1 class="cns-title">THÔNG TIN KHÁCH HÀNG</h1>

      <?php if ($cns_msg_ok) : ?>
        <div class="cns-alert cns-alert--ok"><?php echo esc_html($cns_msg_ok); ?></div>
      <?php endif; ?>
      <?php if ($cns_msg_err) : ?>
        <div class="cns-alert cns-alert--err"><?php echo wp_kses_post($cns_msg_err); ?></div>
      <?php endif; ?>

      <div class="cns-panel">
        <h2 class="cns-panel__title">Thông tin cá nhân</h2>
        <form method="post" action="">
          <input type="hidden" name="cns_action" value="profile_update" />
          <?php wp_nonce_field('cns_profile_update', 'cns_profile_nonce'); ?>
          <div class="cns-grid">
            <label class="cns-field">
              <span class="cns-field__label">Họ và tên</span>
              <input class="cns-input" type="text" name="display_name" value="<?php echo esc_attr($user->display_name); ?>" placeholder="Họ và tên">
            </label>
            <label class="cns-field">
              <span class="cns-field__label">Ngày sinh</span>
              <input class="cns-input" type="date" name="birthday" value="<?php echo esc_attr($birthday); ?>">
            </label>
          </div>
          <div class="cns-grid">
            <label class="cns-field">
              <span class="cns-field__label">Số điện thoại</span>
              <input class="cns-input" type="text" name="phone" value="<?php echo esc_attr($phone); ?>" placeholder="Số điện thoại">
            </label>
            <label class="cns-field">
              <span class="cns-field__label">Email</span>
              <input class="cns-input" type="email" name="user_email" value="<?php echo esc_attr($user->user_email); ?>" placeholder="Email">
            </label>
          </div>
          <button class="cns-btn cns-btn--primary" type="submit">LƯU THÔNG TIN</button>
        </form>
      </div>

      <div class="cns-panel">
        <h2 class="cns-panel__title">Đổi mật khẩu</h2>
        <form method="post" action="">
          <input type="hidden" name="cns_action" value="change_password" />
          <?php wp_nonce_field('cns_profile_password', 'cns_password_nonce'); ?>
          <label class="cns-field">
            <span class="cns-field__label">Mật khẩu cũ <span class="req">*</span></span>
            <input class="cns-input" type="password" name="old_pass" required placeholder="Mật khẩu cũ">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Mật khẩu mới <span class="req">*</span></span>
            <input class="cns-input" type="password" name="new_pass" required placeholder="Mật khẩu mới">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Xác thực mật khẩu <span class="req">*</span></span>
            <input class="cns-input" type="password" name="confirm_pass" required placeholder="Xác thực mật khẩu">
          </label>
          <button class="cns-btn cns-btn--primary" type="submit">ĐỔI MẬT KHẨU</button>
        </form>
      </div>
    </section>
  </div>

  <style>
    .cns-profile{background:linear-gradient(180deg, rgba(10,10,40,0.00) 0%, rgba(7,30,61,0.25) 100%);color:inherit;min-height:calc(100vh - 120px)}
    .cns-profile__container{max-width:1200px;margin:0 auto;padding:24px 16px;display:grid;grid-template-columns:280px 1fr;gap:20px}

    .cns-profile__aside{position:static;top:auto;height:auto}
    .cns-profile__card{background:rgba(7,30,61,.65);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.14);border-radius:12px;padding:16px;display:grid;gap:10px}
    .cns-profile__avatar{display:flex;align-items:center;gap:10px}
    .cns-profile__avatar-circle{width:44px;height:44px;border-radius:50%;background:#6f45c4;display:flex;align-items:center;justify-content:center;font-weight:900}
    .cns-profile__name{font-weight:800}
    .cns-profile__btn-primary{display:inline-block;text-align:center;background:#ffe44d;color:#0e1220;font-weight:800;border-radius:10px;padding:10px 12px;text-decoration:none}

    .cns-profile__menu{margin-top:12px;background:rgba(7,30,61,.65);backdrop-filter:blur(6px);border:1px solid rgba(255,255,255,.14);border-radius:12px;display:grid}
    .cns-profile__menu a{padding:12px 14px;text-decoration:none;color:#e9eef7;border-bottom:1px solid rgba(255,255,255,.06)}
    .cns-profile__menu a:last-child{border-bottom:none}
    .cns-profile__menu a.is-active{background:rgba(255,255,255,.06);font-weight:800;border-left:3px solid #ffe44d;padding-left:11px}

    .cns-title{font-size:26px;font-weight:900;letter-spacing:.04em;margin:4px 0 14px;color:#ffffff}
    .cns-panel{background:rgba(7,30,61,.65);color:#e9eef7;border-radius:12px;border:1px solid rgba(255,255,255,.14);box-shadow:0 10px 28px rgba(0,0,0,.25);padding:16px;margin-bottom:18px;backdrop-filter:blur(6px);overflow:hidden}
    .cns-panel__title{font-size:18px;margin:4px 0 14px;color:#ffffff}

    .cns-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .cns-grid > .cns-field{min-width:0}
    .cns-field{display:flex;flex-direction:column;gap:8px;margin-bottom:12px}
    .cns-field__label{font-weight:700}
    .req{color:#ff2a5c}
    .cns-input{width:100%;max-width:100%;border:1px solid #d6dcea;border-radius:10px;padding:12px 12px;background:#fff;box-sizing:border-box}
    .cns-input:focus{outline:none;border-color:#9fb3d8;box-shadow:0 0 0 3px rgba(159,179,216,.25)}
    input[type="date"].cns-input{padding-right:44px}

    .cns-btn{display:inline-flex;align-items:center;justify-content:center;border:none;border-radius:12px;padding:12px 16px;font-weight:800;cursor:pointer}
    .cns-btn--primary{background:#ffe44d;color:#0e1220;box-shadow:0 10px 24px rgba(255,228,77,.35)}

    .cns-alert{padding:12px 14px;border-radius:10px;margin:10px 0;font-weight:700}
    .cns-alert--ok{background:#eaffea;color:#0f5f12;border:1px solid #a8e0aa}
    .cns-alert--err{background:#ffe6ea;color:#8a1130;border:1px solid #ffb7c6}

    @media (max-width:960px){
      .cns-profile__container{grid-template-columns:1fr}
      .cns-profile__aside{position:static}
      .cns-grid{grid-template-columns:1fr}
    }
  </style>
</main>


