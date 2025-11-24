<?php
/**
 * Component: Auth Tabs (Login/Register) - không include header/footer
 * Biến đầu vào: $active_tab = 'login' | 'register'
 */
if (! isset($active_tab)) {
    $active_tab = 'login';
}
$active_tab = ($active_tab === 'register') ? 'register' : 'login';

// Read error from transient (after redirect)
$cns_login_error = '';
if (isset($_GET['cnsle'])) {
    $key = sanitize_text_field(wp_unslash($_GET['cnsle']));
    $msg = get_transient('cns_login_err_' . $key);
    if ($msg) {
        $cns_login_error = $msg;
        delete_transient('cns_login_err_' . $key);
        $active_tab = 'login';
    }
}

$cns_register_error = '';
if (isset($_GET['cnsre'])) {
    $key = sanitize_text_field(wp_unslash($_GET['cnsre']));
    $msg = get_transient('cns_register_err_' . $key);
    if ($msg) {
        $cns_register_error = $msg;
        delete_transient('cns_register_err_' . $key);
        $active_tab = 'register';
    }
}

$cns_register_success = '';
if (isset($_GET['cnsro'])) {
    $key = sanitize_text_field(wp_unslash($_GET['cnsro']));
    $msg = get_transient('cns_register_ok_' . $key);
    if ($msg) {
        $cns_register_success = $msg;
        delete_transient('cns_register_ok_' . $key);
        $active_tab = 'register';
    }
}
$cns_login_page_url = get_permalink();
if (! $cns_login_page_url) {
    $cns_login_page_url = home_url( '/' );
}
?>
<main class="cns-auth">
  <div class="cns-auth__bg"></div>
  <div class="cns-auth__container">
    <div class="cns-auth__panel">
      <div class="cns-auth__tabs" role="tablist" aria-label="Chuyển đổi đăng nhập/đăng ký">
        <button class="cns-auth__tab <?php echo $active_tab==='login'?'is-active':''; ?>" role="tab" aria-selected="<?php echo $active_tab==='login'?'true':'false'; ?>" data-tab-target="login">
          Đăng nhập
        </button>
        <button class="cns-auth__tab <?php echo $active_tab==='register'?'is-active':''; ?>" role="tab" aria-selected="<?php echo $active_tab==='register'?'true':'false'; ?>" data-tab-target="register">
          Đăng ký
        </button>
      </div>

      <section class="cns-auth__content">
        <form class="cns-form cns-form--login <?php echo $active_tab==='login'?'is-visible':''; ?>" role="form" aria-labelledby="login-title" method="post" action="">
          <h2 id="login-title" class="cns-form__title">Đăng nhập</h2>
          <?php if (! empty($cns_login_error)) : ?>
            <div class="cns-alert cns-alert--error" role="alert"><?php echo wp_kses_post($cns_login_error); ?></div>
          <?php endif; ?>
          <input type="hidden" name="cns_action" value="login" />
          <input type="hidden" name="redirect_to" value="<?php echo esc_attr( isset($_GET['redirect_to']) ? esc_url_raw(wp_unslash($_GET['redirect_to'])) : home_url('/') ); ?>" />
          <input type="hidden" name="form_url" value="<?php echo esc_url($cns_login_page_url); ?>" />
          <?php wp_nonce_field('cns_auth_login', 'cns_auth_nonce'); ?>
          <label class="cns-field">
            <span class="cns-field__label">Tài khoản, Email hoặc số điện thoại <span class="req">*</span></span>
            <input class="cns-input" type="text" name="log" required placeholder="Nhập tài khoản / email / số điện thoại">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Mật khẩu <span class="req">*</span></span>
            <div class="cns-password">
              <input class="cns-input" type="password" name="pwd" required placeholder="Nhập mật khẩu">
              <button class="cns-password__toggle" type="button" aria-label="Hiện/ẩn mật khẩu"></button>
            </div>
          </label>
          <label class="cns-check">
            <input type="checkbox" name="rememberme" value="forever">
            <span>Lưu mật khẩu đăng nhập</span>
          </label>
          <div class="cns-form__row">
            <a class="cns-link" href="<?php echo esc_url( wp_lostpassword_url() ); ?>">Quên mật khẩu?</a>
          </div>
          <button class="cns-btn cns-btn--primary" type="submit">ĐĂNG NHẬP</button>
        </form>

        <form class="cns-form cns-form--register <?php echo $active_tab==='register'?'is-visible':''; ?>" role="form" aria-labelledby="register-title" method="post" action="">
          <h2 id="register-title" class="cns-form__title">Đăng ký</h2>
          <input type="hidden" name="cns_action" value="register" />
          <?php wp_nonce_field('cns_auth_register', 'cns_register_nonce'); ?>
          
          <?php if (! empty($cns_register_error)) : ?>
            <div class="cns-alert cns-alert--error" role="alert"><?php echo wp_kses_post($cns_register_error); ?></div>
          <?php endif; ?>
          
          <?php if (! empty($cns_register_success)) : ?>
            <div class="cns-alert cns-alert--success" role="alert"><?php echo esc_html($cns_register_success); ?></div>
          <?php endif; ?>
          
          <label class="cns-field">
            <span class="cns-field__label">Họ và tên <span class="req">*</span></span>
            <input class="cns-input" type="text" name="full_name" required placeholder="Họ và tên">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Ngày sinh <span class="req">*</span></span>
            <input class="cns-input" type="date" name="birthday" required>
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Số điện thoại <span class="req">*</span></span>
            <input class="cns-input" type="tel" name="phone" required placeholder="Số điện thoại">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Tên đăng nhập <span class="req">*</span></span>
            <input class="cns-input" type="text" name="user_login" required placeholder="Tên đăng nhập">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">CCCD/CMND</span>
            <input class="cns-input" type="text" name="national_id" placeholder="Số CCCD/CMND">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Email <span class="req">*</span></span>
            <input class="cns-input" type="email" name="user_email" required placeholder="Điền email">
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Mật khẩu <span class="req">*</span></span>
            <div class="cns-password">
              <input class="cns-input" type="password" name="user_pass" required placeholder="Mật khẩu">
              <button class="cns-password__toggle" type="button" aria-label="Hiện/ẩn mật khẩu"></button>
            </div>
          </label>
          <label class="cns-field">
            <span class="cns-field__label">Xác thực mật khẩu <span class="req">*</span></span>
            <div class="cns-password">
              <input class="cns-input" type="password" name="user_pass_confirm" required placeholder="Xác thực mật khẩu">
              <button class="cns-password__toggle" type="button" aria-label="Hiện/ẩn mật khẩu"></button>
            </div>
          </label>
          <div class="cns-note">Chính sách bảo mật</div>
          <label class="cns-check">
            <input type="checkbox" name="agree" required>
            <span>Khách hàng đã đồng ý các điều khoản, điều kiện của thành viên Cinestar</span>
          </label>
          <button class="cns-btn cns-btn--primary" type="submit">ĐĂNG KÝ</button>
          <p class="cns-form__switch">Bạn đã có tài khoản? <a class="cns-link" href="?tab=login">Đăng nhập</a></p>
        </form>
      </section>
    </div>
  </div>

  <style>
    .cns-auth{position:relative;min-height:calc(100vh - 120px);background:transparent;color:inherit;--auth-x:24px}
    .cns-auth, .cns-auth *{box-sizing:border-box}

    .cns-auth__container{position:relative;max-width:1200px;margin:0 auto;padding:64px 16px;display:flex;justify-content:center}

    .cns-auth__panel{width:100%;max-width:520px;background:rgba(7, 30, 61, .65);border:1px solid rgba(255,255,255,.12);border-radius:16px;box-shadow:0 24px 80px rgba(0,0,0,.45);overflow:hidden;backdrop-filter:saturate(120%) blur(6px)}

    .cns-auth__tabs{display:flex;gap:10px;align-items:center;justify-content:center;background:transparent;padding:24px var(--auth-x) 12px;color:#fff}
    .cns-auth__tab{flex:1;max-width:200px;padding:12px 10px;color:#e5e7eb;background:rgba(15,27,49,.6);border:1px solid rgba(26,41,72,.7);border-radius:999px;font-weight:800;letter-spacing:.04em;cursor:pointer;transition:.2s}
    .cns-auth__tab:hover{filter:brightness(1.1)}
    .cns-auth__tab.is-active{background:#ffe44d;color:#0e1220;border-color:#ffe44d;box-shadow:0 6px 14px rgba(255,228,77,.3)}

    .cns-auth__content{padding:0 var(--auth-x) 24px}

    .cns-form{display:none}
    .cns-form.is-visible{display:block}
    .cns-form__title{display:none}
    .cns-field{display:flex;flex-direction:column;gap:8px;margin-bottom:16px}
    .cns-field__label{font-weight:700;color:#ffffff}
    .req{color:#ff2a5c}
    .cns-input{width:100%;max-width:100%;border:1px solid rgba(214,220,234,.75);border-radius:10px;padding:12px 12px;background:#ffffff;font-size:15px;transition:border-color .15s, box-shadow .15s;color:#0b1221}
    .cns-input:focus{outline:none;border-color:#9fb3d8;box-shadow:0 0 0 3px rgba(159,179,216,.25)}
    .cns-password{position:relative}
    .cns-password .cns-input{padding-right:52px}
    .cns-password__toggle{position:absolute;right:10px;top:50%;transform:translateY(-50%);width:34px;height:34px;border-radius:8px;border:1px solid #d6dcea;background:#fff;cursor:pointer}

    .cns-check{display:flex;align-items:center;gap:10px;margin:8px 0 16px;color:#d1d5db}
    .cns-form__row{display:flex;justify-content:flex-end;margin:12px 0 16px}
    .cns-link{color:#93c5fd;text-decoration:none}
    .cns-link:hover{text-decoration:underline}

    .cns-btn{display:inline-flex;align-items:center;justify-content:center;border:none;border-radius:12px;padding:14px 18px;font-weight:800;cursor:pointer}
    .cns-btn--primary{background:#ffe44d;color:#0e1220;box-shadow:0 10px 24px rgba(255,228,77,.35)}

    .cns-note{color:#e5e7eb;font-weight:700;margin:10px 0 6px}
    .cns-form__switch{margin-top:12px}

    .cns-alert{padding:12px 14px;border-radius:10px;margin-bottom:12px;font-weight:700}
    .cns-alert--error{background:#ffe6ea;color:#8a1130;border:1px solid #ffb7c6}
    .cns-alert--success{background:#eaffea;color:#0f5f12;border:1px solid #a8e0aa}

    @media (max-width:480px){
      .cns-auth{--auth-x:16px}
      .cns-auth__container{padding:32px 12px}
      .cns-auth__panel{border-radius:12px}
      .cns-auth__tabs{padding:16px var(--auth-x) 10px}
      .cns-auth__content{padding:0 var(--auth-x) 16px}
      .cns-auth__tab{padding:12px 10px}
    }
  </style>

  <script>
    (function(){
      var container=document.currentScript.parentElement;
      var tabs=container.querySelectorAll('.cns-auth__tab');
      var forms={login:container.querySelector('.cns-form--login'),register:container.querySelector('.cns-form--register')};
      function setActive(name){
        tabs.forEach(function(btn){
          var active = btn.getAttribute('data-tab-target')===name;
          btn.classList.toggle('is-active', active);
          btn.setAttribute('aria-selected', active ? 'true':'false');
        });
        forms.login.classList.toggle('is-visible', name==='login');
        forms.register.classList.toggle('is-visible', name==='register');
        var url = new URL(window.location.href);
        url.searchParams.set('tab', name);
        window.history.replaceState({}, '', url);
      }
      tabs.forEach(function(btn){
        btn.addEventListener('click', function(){ setActive(btn.getAttribute('data-tab-target')); });
      });
      // Toggle show/hide password
      container.querySelectorAll('.cns-password__toggle').forEach(function(t){
        t.addEventListener('click', function(){
          var input = t.previousElementSibling;
          input.type = input.type==='password' ? 'text' : 'password';
        });
      });
      
      // Validate registration form
      var registerForm = container.querySelector('.cns-form--register');
      if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
          var userPass = registerForm.querySelector('input[name="user_pass"]').value;
          var userPassConfirm = registerForm.querySelector('input[name="user_pass_confirm"]').value;
          
          if (userPass !== userPassConfirm) {
            e.preventDefault();
            alert('Mật khẩu xác nhận không khớp. Vui lòng kiểm tra lại.');
            return false;
          }
          
          if (userPass.length < 6) {
            e.preventDefault();
            alert('Mật khẩu phải có ít nhất 6 ký tự.');
            return false;
          }
          
          // Validate phone number (Vietnamese format)
          var phone = registerForm.querySelector('input[name="phone"]').value;
          var phoneRegex = /^(\+84|0)[0-9]{9,10}$/;
          if (phone && !phoneRegex.test(phone.replace(/\s+/g, ''))) {
            e.preventDefault();
            alert('Số điện thoại không hợp lệ. Vui lòng nhập số điện thoại Việt Nam (10-11 số).');
            return false;
          }
        });
      }
    })();
  </script>
</main>


