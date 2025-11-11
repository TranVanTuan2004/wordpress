<?php
/**
 * Template Name: Auth Minimal - Không Header Footer
 * Description: Bố cục nhẹ nhàng cho trang đăng nhập / đăng ký, không dùng header & footer.
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo get_the_title(); ?> | <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        body.slp-auth-page {
            margin: 0;
            padding: 0;
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg, #9fa8ff 0%, #eff2ff 55%, #ffffff 100%);
            min-height: 100vh;
            color: #0f172a;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slp-auth-wrapper {
            width: 100%;
            max-width: 380px;
            padding: 36px 28px;
            background: rgba(255, 255, 255, 0.97);
            border-radius: 20px;
            box-shadow: 0 32px 68px rgba(99, 102, 241, 0.18);
            border: 1px solid rgba(226, 232, 240, 0.65);
        }

        .slp-auth-wrapper h1,
        .slp-auth-wrapper h2 {
            text-align: center;
            margin-top: 0;
            margin-bottom: 8px;
            font-weight: 700;
            letter-spacing: -0.01em;
            color: #111827;
            font-size: 22px;
        }

        .slp-auth-wrapper p {
            text-align: center;
            margin-bottom: 20px;
            color: #6b7280;
            font-size: 12px;
        }

        .slp-auth-wrapper label {
            font-size: 12px;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 4px;
            display: block;
        }

        .slp-auth-wrapper form {
            display: grid;
            gap: 12px;
        }

        .slp-auth-wrapper input[type="text"],
        .slp-auth-wrapper input[type="email"],
        .slp-auth-wrapper input[type="password"],
        .slp-auth-wrapper input[type="tel"],
        .slp-auth-wrapper input[type="number"] {
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid rgba(203, 213, 225, 0.9);
            font-size: 13px;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: rgba(248, 250, 252, 0.9);
            color: #0f172a;
        }

        .slp-auth-wrapper input::placeholder {
            color: #9ca3af;
        }

        .slp-auth-wrapper input:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.2);
            outline: none;
        }

        .slp-auth-wrapper button,
        .slp-auth-wrapper input[type="submit"] {
            padding: 10px 14px;
            border-radius: 10px;
            border: none;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
            letter-spacing: 0.02em;
        }

        .slp-auth-wrapper button:hover,
        .slp-auth-wrapper input[type="submit"]:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(99, 102, 241, 0.25);
        }

        .slp-auth-wrapper .slp-auth-link {
            display: block;
            margin-top: 12px;
            text-align: center;
            font-size: 12px;
            color: #4f46e5;
        }

        .slp-auth-wrapper .slp-auth-link:hover {
            color: #4338ca;
        }

        .slp-auth-wrapper a {
            color: #4f46e5;
        }

        .slp-auth-wrapper a:hover {
            color: #4338ca;
        }

        @media (max-width: 540px) {
            body.slp-auth-page {
                padding: 16px;
            }

            .slp-auth-wrapper {
                padding: 28px 20px;
                border-radius: 16px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body <?php body_class('slp-auth-page'); ?>>
    <div class="slp-auth-wrapper">
        <?php
        while (have_posts()) {
            the_post();
            the_content();
        }
        ?>
    </div>
    <?php wp_footer(); ?>
</body>
</html>

