<?php
/**
 * Header component
 * Hiển thị thanh header như mockup: logo, CTA, tìm kiếm, đăng nhập, ngôn ngữ và menu 2 tầng.
 */
?>
<header class="cns-header">
  <div class="cns-header__top">
    <div class="cns-container cns-header__top-inner">
      <a class="cns-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Cinestar - Trang chủ">
        <span class="cns-logo__icon" aria-hidden="true">
          <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="18" cy="18" r="18" fill="#162033"/>
            <path d="M18 6l2.6 7.9h8.3l-6.7 4.9 2.6 7.9L18 21.8l-6.8 4.9 2.6-7.9-6.7-4.9h8.3L18 6z" fill="#FF3366"/>
          </svg>
        </span>
        <span class="cns-logo__text">CINESTAR</span>
      </a>

      <div class="cns-cta">
        <a class="cns-btn cns-btn--ticket" href="#" aria-label="Đặt vé ngay">
          <span class="cns-btn__icon" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M3 7a2 2 0 012-2h8.8a2 2 0 011.79 1.11l2.41 4.78a2 2 0 01.2.89V17a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" stroke="#0E1220" stroke-width="1.5" fill="none"/>
              <path d="M7 9h6M7 13h8" stroke="#0E1220" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </span>
          <span class="cns-btn__label">ĐẶT VÉ NGAY</span>
        </a>
        <a class="cns-btn cns-btn--combo" href="#" aria-label="Đặt bắp nước">
          <span class="cns-btn__icon" aria-hidden="true">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6 7h12l-1.5 12.5a2 2 0 01-2 1.5H9.5a2 2 0 01-2-1.5L6 7z" stroke="white" stroke-width="1.5"/>
              <path d="M9 4h8" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
              <path d="M13 4l1-2" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </span>
          <span class="cns-btn__label">ĐẶT BẮP NƯỚC</span>
        </a>
      </div>

      <form class="cns-search" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <input class="cns-search__input" type="search" name="s" placeholder="Tìm phim, rạp" value="<?php echo get_search_query(); ?>" />
        <button class="cns-search__btn" type="submit" aria-label="Tìm kiếm">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="1.8"/>
            <path d="M20 20l-3.2-3.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
          </svg>
        </button>
      </form>

      <?php if ( is_user_logged_in() ) : ?>
        <?php $cns_user = wp_get_current_user(); ?>
        <div class="cns-user">
          <button class="cns-user__btn" type="button" aria-haspopup="true" aria-expanded="false">
            <span class="cns-account__icon" aria-hidden="true">
              <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.5"/>
                <path d="M5 19a7 7 0 0114 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
              </svg>
            </span>
            <span class="cns-user__name"><?php echo esc_html( wp_html_excerpt( $cns_user->display_name ?: $cns_user->user_login, 14, '…' ) ); ?></span>
            <svg class="cns-user__chev" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </button>
          <div class="cns-user__menu" role="menu">
            <a class="cns-user__item" role="menuitem" href="<?php echo esc_url( home_url( '/profile' ) ); ?>">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.6"/>
                <path d="M5 20a7 7 0 0114 0" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
              <span>Thông tin cá nhân</span>
            </a>
            <a class="cns-user__item" role="menuitem" href="<?php echo esc_url( wp_logout_url( home_url('/') ) ); ?>">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path d="M15 17l5-5-5-5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M20 12H9" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                <path d="M12 21H6a2 2 0 01-2-2V5a2 2 0 012-2h6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
              </svg>
              <span>Đăng xuất</span>
            </a>
          </div>
        </div>
      <?php else : ?>
        <a class="cns-account" href="<?php echo esc_url( home_url( '/dangnhap' ) ); ?>">
          <span class="cns-account__icon" aria-hidden="true">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <circle cx="12" cy="8" r="3.25" stroke="currentColor" stroke-width="1.5"/>
              <path d="M5 19a7 7 0 0114 0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
          </span>
          <span class="cns-account__label">Đăng nhập</span>
        </a>
      <?php endif; ?>

      <button class="cns-lang" type="button" aria-label="Chọn ngôn ngữ">
        <span class="cns-lang__flag" aria-hidden="true">🇻🇳</span>
        <span class="cns-lang__code">VN</span>
        <svg class="cns-lang__chev" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
          <path d="M6 9l6 6 6-6" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </button>
    </div>
  </div>

  <div class="cns-header__bottom">
    <div class="cns-container cns-header__bottom-inner">
      <nav class="cns-nav" aria-label="Điều hướng chính">
        <ul class="cns-nav__list">
          <li class="cns-nav__item">
            <a href="#" class="cns-nav__link">
              <span class="cns-nav__icon" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M12 2l9 7-1.5 1.2V21a1 1 0 01-1 1h-5v-6H10v6H5a1 1 0 01-1-1v-10.8L2.1 9 12 2z" fill="currentColor" />
                </svg>
              </span>
              Chọn rạp
            </a>
          </li>
          <li class="cns-nav__item">
            <a href="#" class="cns-nav__link">
              <span class="cns-nav__icon" aria-hidden="true">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <rect x="3" y="4" width="18" height="16" rx="2" stroke="currentColor" stroke-width="1.6"/>
                  <path d="M8 2v4M16 2v4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                  <path d="M3 10h18" stroke="currentColor" stroke-width="1.6"/>
                </svg>
              </span>
              Lịch chiếu
            </a>
          </li>
          <li class="cns-nav__item"><a href="#" class="cns-nav__link">Khuyến mãi</a></li>
          <li class="cns-nav__item"><a href="#" class="cns-nav__link">Tổ chức sự kiện</a></li>
          <li class="cns-nav__item"><a href="#" class="cns-nav__link">Dịch vụ giải trí khác</a></li>
          <li class="cns-nav__item"><a href="#" class="cns-nav__link">Giới thiệu</a></li>
        </ul>
      </nav>
    </div>
  </div>

  <style>
    .cns-header{background:#0d1424;color:#e9eef7;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;position:sticky;top:0;z-index:1000;box-shadow:0 2px 12px rgba(0,0,0,.35)}
    .cns-container{max-width:1280px;margin:0 auto;padding:0 16px}
    .cns-header__top{border-bottom:1px solid rgba(255,255,255,.08)}
    .cns-header__top-inner{display:flex;align-items:center;gap:16px;padding:14px 0}
    .cns-logo{display:flex;align-items:center;gap:10px;color:#fff;text-decoration:none}
    .cns-logo__text{font-weight:800;letter-spacing:.08em;font-size:26px}
    .cns-cta{display:flex;gap:12px;margin-left:12px}
    .cns-btn{display:inline-flex;align-items:center;gap:8px;padding:12px 16px;border-radius:10px;font-weight:800;text-decoration:none;white-space:nowrap}
    .cns-btn--ticket{background:#ffe44d;color:#0e1220}
    .cns-btn--combo{background:#6f45c4;color:#fff}
    .cns-btn__icon{display:inline-flex}

    .cns-search{margin-left:auto;position:relative;min-width:380px}
    .cns-search__input{width:100%;background:#0f1b31;border:1px solid rgba(255,255,255,.12);color:#e9eef7;border-radius:22px;padding:12px 40px 12px 18px;outline:none}
    .cns-search__input::placeholder{color:#a8b3c7}
    .cns-search__btn{position:absolute;right:8px;top:50%;transform:translateY(-50%);background:transparent;border:none;color:#c7d2e1;cursor:pointer;padding:6px;border-radius:8px}
    .cns-search__btn:hover{background:rgba(255,255,255,.06)}

    .cns-account{display:flex;align-items:center;gap:8px;color:#e9eef7;text-decoration:none;padding:8px 10px;border-radius:8px}
    .cns-account:hover{background:rgba(255,255,255,.06)}

    .cns-lang{display:flex;align-items:center;gap:6px;margin-left:4px;background:transparent;border:1px solid rgba(255,255,255,.16);color:#e9eef7;padding:8px 10px;border-radius:10px;cursor:pointer}
    .cns-lang__flag{font-size:16px;line-height:1}
    .cns-lang__chev{opacity:.9}

    .cns-user{position:relative;margin-left:4px}
    .cns-user__btn{display:flex;align-items:center;gap:8px;background:transparent;border:1px solid transparent;color:#e9eef7;padding:8px 10px;border-radius:10px;cursor:pointer}
    .cns-user__btn:hover{background:rgba(255,255,255,.06)}
    .cns-user__name{max-width:140px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;font-weight:800;text-transform:uppercase;letter-spacing:.04em}
    .cns-user__menu{position:absolute;right:0;top:42px;min-width:220px;padding:8px;background:#0f1b31;border:1px solid rgba(255,255,255,.12);border-radius:12px;box-shadow:0 12px 28px rgba(0,0,0,.4);opacity:0;visibility:hidden;transform:translateY(-4px);transition:.15s}
    .cns-user.is-open .cns-user__menu{opacity:1;visibility:visible;transform:translateY(0)}
    .cns-user__item{display:flex;align-items:center;gap:10px;color:#e9eef7;text-decoration:none;padding:10px 12px;border-radius:8px}
    .cns-user__item:hover{background:rgba(255,255,255,.08)}

    .cns-header__bottom-inner{display:flex;align-items:center}
    .cns-nav{width:100%}
    .cns-nav__list{display:flex;gap:28px;align-items:center;padding:10px 0;margin:0;list-style:none}
    .cns-nav__item{display:flex}
    .cns-nav__link{display:flex;align-items:center;gap:8px;color:#e9eef7;text-decoration:none;padding:8px 0}
    .cns-nav__icon{color:#c2cbe0}
    .cns-nav__link:hover{color:#fff}

    @media (max-width:1024px){
      .cns-search{min-width:260px}
      .cns-cta{display:none}
      .cns-nav__list{gap:18px}
    }
    @media (max-width:768px){
      .cns-search{display:none}
      .cns-nav__list{flex-wrap:wrap;gap:12px}
      .cns-logo__text{font-size:22px}
    }
  </style>
  <script>
    (function(){
      var u = document.querySelector('.cns-user');
      if(!u) return;
      var b = u.querySelector('.cns-user__btn');
      b.addEventListener('click', function(e){
        e.stopPropagation();
        u.classList.toggle('is-open');
        b.setAttribute('aria-expanded', u.classList.contains('is-open') ? 'true' : 'false');
      });
      document.addEventListener('click', function(e){
        if(!u.contains(e.target)){ u.classList.remove('is-open'); b.setAttribute('aria-expanded','false'); }
      });
    })();
  </script>
</header>


