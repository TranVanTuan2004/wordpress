<?php
/*
Template Name: User Profile
Description: Giao diện trang hồ sơ người dùng hiện đại ở frontend.
*/

defined('ABSPATH') || exit;

// Chỉ cho phép người dùng đã đăng nhập
if (!is_user_logged_in()) {
	wp_safe_redirect(wp_login_url(get_permalink()));
	exit;
}

get_header();

$current_user = wp_get_current_user();
$user_roles   = implode(', ', (array) $current_user->roles);
$register_date = get_user_meta($current_user->ID, 'register_date', true);
if (!$register_date && isset($current_user->user_registered)) {
	$register_date = date_i18n(get_option('date_format'), strtotime($current_user->user_registered));
}

$avatar = get_avatar_url($current_user->ID, ['size' => 160]);

// Liên kết hành động
$edit_profile_url = admin_url('profile.php');
$logout_url       = wp_logout_url(get_permalink());
?>

<main id="main" class="profile-page-wrapper" role="main">
	<div class="container profile-container">
		<h1 class="profile-title">Profile</h1>

		<div class="profile-card">
			<div class="profile-card__header">
				<div class="profile-avatar">
					<img src="<?php echo esc_url($avatar); ?>" alt="<?php echo esc_attr($current_user->display_name); ?>" />
				</div>
				<div class="profile-basic">
					<div class="profile-name"><?php echo esc_html($current_user->display_name ?: $current_user->user_login); ?></div>
					<div class="profile-username">@<?php echo esc_html($current_user->user_login); ?></div>
					<div class="profile-meta">
						<span class="meta-item email"><?php echo esc_html($current_user->user_email); ?></span>
						<?php if ($register_date) : ?>
							<span class="meta-item joined">Tham gia: <?php echo esc_html($register_date); ?></span>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="profile-sections">
				<section class="profile-section">
					<h3 class="section-title">Thông Tin Cá Nhân</h3>
					<div class="profile-grid">
						<div class="profile-field">
							<label>Tên đăng nhập</label>
							<input type="text" value="<?php echo esc_attr($current_user->user_login); ?>" readonly />
						</div>
						<div class="profile-field">
							<label>Email</label>
							<input type="text" value="<?php echo esc_attr($current_user->user_email); ?>" readonly />
						</div>
						<div class="profile-field">
							<label>Tên hiển thị</label>
							<input type="text" value="<?php echo esc_attr($current_user->display_name); ?>" readonly />
						</div>
						<div class="profile-field">
							<label>Vai trò</label>
							<input type="text" value="<?php echo esc_attr($user_roles); ?>" readonly />
						</div>
					</div>
				</section>

				<section class="profile-section">
					<h3 class="section-title">Hoạt Động Gần Đây</h3>
					<div class="profile-activity">
						<p>Chưa có hoạt động nào.</p>
					</div>
				</section>
			</div>

			<div class="profile-actions">
				<a class="btn btn-secondary" href="<?php echo esc_url($edit_profile_url); ?>">Cập nhật</a>
				<a class="btn btn-danger" href="<?php echo esc_url($logout_url); ?>">Đăng xuất</a>
			</div>
		</div>
	</div>
</main>

<?php get_footer(); ?>


