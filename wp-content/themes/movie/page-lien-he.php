<?php
/*
Template Name: Contact Page
*/

// Handle Form Submission
$msg_success = '';
$msg_error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['contact_email'])) {
    $name = sanitize_text_field($_POST['contact_name']);
    $email = sanitize_email($_POST['contact_email']);
    $phone = sanitize_text_field($_POST['contact_phone']);
    $message = sanitize_textarea_field($_POST['contact_message']);

    $to = get_option('admin_email');
    $subject = "Liên hệ mới từ $name - Cinestar";
    $body = "Họ tên: $name\nEmail: $email\nSĐT: $phone\n\nNội dung:\n$message";
    $headers = array('Content-Type: text/plain; charset=UTF-8');

    if (wp_mail($to, $subject, $body, $headers)) {
        $msg_success = 'Cảm ơn bạn đã liên hệ. Chúng tôi sẽ phản hồi sớm nhất!';
    } else {
        $msg_error = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
    }
}

get_header();
?>

<div class="contact-page-wrapper">
    <div class="contact-header">
        <h1>LIÊN HỆ RIOT</h1>
    </div>

    <div class="contact-container">
        <!-- Contact Form Section -->
        <div class="contact-form-section">
            <h2>LIÊN HỆ VỚI CHÚNG TÔI</h2>
            <?php echo do_shortcode('[contact-form-7 id="e1f3189" title="Liên hệ"]'); ?>
        </div>

        <!-- Branches Section -->
        <div class="branches-section">
            <h2>CÁC CHI NHÁNH CỦA CHÚNG TÔI</h2>
            
            <div class="branch-accordion">
                <!-- Headquarter (Static or Special Post) -->
                <div class="branch-item active">
                    <div class="branch-header" onclick="toggleBranch(this)">
                        <h3>TRỤ SỞ | HEADQUARTER</h3>
                        <span class="icon-toggle"><i class='bx bx-chevron-down'></i></span>
                    </div>
                    <div class="branch-content" style="display: block;">
                        <p>Riot Hai Bà Trưng, nằm tại trung tâm TP.HCM, gần nhiều trường đại học, trung tâm văn hóa và thương mại. Với vị trí đắc địa này, Cinestar Hai Bà Trưng là điểm đến giải trí và thưởng thức điện ảnh giá rẻ, tối ưu cho mọi đối tượng khán giả.</p>
                        <p><i class='bx bxs-map'></i> 135 Hai Bà Trưng, Phường Bến Nghé, Quận 1, TP.HCM</p>
                        <p><i class='bx bxs-envelope'></i> marketing.cinestar@gmail.com</p>
                        <p><i class='bx bxs-phone'></i> 028 7300 8881</p>
                        <div class="branch-socials">
                            <a href="#"><i class='bx bxl-facebook-circle'></i></a>
                            <a href="#"><i class='bx bxl-youtube'></i></a>
                        </div>
                        <a href="#" class="btn-map">Xem bản đồ</a>
                    </div>
                </div>

                <?php
                // Query cinemas
                $cinema_pts = array('mbs_cinema','rap_phim','rap-phim','cinema','theater','rap','rapfilm','rap_phim_cpt');
                $cinema_pt = null;
                foreach($cinema_pts as $pt){ 
                    if ( post_type_exists($pt) ){ 
                        $cinema_pt = $pt; 
                        break; 
                    } 
                }

                if ($cinema_pt) {
                    $args = array(
                        'post_type' => $cinema_pt,
                        'posts_per_page' => -1,
                        'orderby' => 'title',
                        'order' => 'ASC'
                    );
                    $cinemas = new WP_Query($args);

                    if ($cinemas->have_posts()) :
                        while ($cinemas->have_posts()) : $cinemas->the_post();
                            // Updated meta keys based on debug file
                            $address = get_post_meta(get_the_ID(), '_mbs_address', true); 
                            $phone = get_post_meta(get_the_ID(), '_mbs_phone', true); 
                            $email = get_post_meta(get_the_ID(), '_mbs_email', true);
                            ?>
                            <div class="branch-item">
                                <div class="branch-header" onclick="toggleBranch(this)">
                                    <h3><?php the_title(); ?></h3>
                                    <span class="icon-toggle"><i class='bx bx-chevron-down'></i></span>
                                </div>
                                <div class="branch-content">
                                    <?php if($address): ?>
                                        <p><i class='bx bxs-map'></i> <?php echo esc_html($address); ?></p>
                                    <?php endif; ?>
                                    <?php if($phone): ?>
                                        <p><i class='bx bxs-phone'></i> <?php echo esc_html($phone); ?></p>
                                    <?php endif; ?>
                                    <?php if($email): ?>
                                        <p><i class='bx bxs-envelope'></i> <?php echo esc_html($email); ?></p>
                                    <?php endif; ?>
                                    
                                    <!-- Fallback content if meta is missing -->
                                    <?php if(!$address && !$phone): ?>
                                        <p>Thông tin đang cập nhật...</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    endif;
                }
                ?>
            </div>
        </div>
    </div>
</div>

<style>
    .alert-success {
        background: #dcfce7;
        color: #166534;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border: 1px solid #bbf7d0;
    }
    .alert-error {
        background: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 4px;
        margin-bottom: 20px;
        border: 1px solid #fecaca;
    }
    .contact-page-wrapper {
        background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
        min-height: 100vh;
        color: #fff;
        padding-bottom: 60px;
        font-family: 'Arial', sans-serif;
    }

    .contact-header {
        text-align: center;
        padding: 40px 0;
    }

    .contact-header h1 {
        font-size: 32px;
        font-weight: 800;
        text-transform: uppercase;
        margin: 0;
        letter-spacing: 1px;
    }

    .contact-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Form Section */
    .contact-form-section {
        background: linear-gradient(135deg, rgba(15, 23, 42, 0.95) 0%, rgba(30, 27, 75, 0.95) 100%);
        padding: 40px;
        border-radius: 16px;
        color: #fff;
        margin-bottom: 60px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(5px);
    }

    .contact-form-section h2 {
        font-size: 24px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 30px;
        text-align: center;
        background: linear-gradient(to right, #ffe44d, #f59e0b);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        letter-spacing: 1px;
    }

    .contact-form-section .wpcf7-form-control-wrap {
        display: block;
        margin-bottom: 20px;
    }

    .contact-form-section input[type="text"],
    .contact-form-section input[type="email"],
    .contact-form-section input[type="tel"],
    .contact-form-section textarea {
        width: 100%;
        padding: 12px 16px;
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 8px;
        color: #fff;
        font-size: 15px;
        transition: all 0.3s;
        outline: none;
    }

    .contact-form-section input:focus,
    .contact-form-section textarea:focus {
        background: rgba(255, 255, 255, 0.1);
        border-color: #ffe44d;
        box-shadow: 0 0 0 2px rgba(255, 228, 77, 0.2);
    }

    .contact-form-section input::placeholder,
    .contact-form-section textarea::placeholder {
        color: rgba(255, 255, 255, 0.4);
    }

    .contact-form-section input[type="submit"] {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, #ffe44d 0%, #ffd700 100%);
        color: #000;
        font-weight: 800;
        text-transform: uppercase;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 16px;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .contact-form-section input[type="submit"]:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(255, 215, 0, 0.2);
    }

    .contact-form-section label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        font-size: 14px;
        color: #cbd5e1;
    }

    /* CF7 Response Messages */
    .contact-form-section .wpcf7-response-output {
        border-radius: 8px;
        padding: 15px !important;
        margin: 20px 0 !important;
        text-align: center;
        font-weight: 600;
        font-size: 15px;
    }

    .contact-form-section .wpcf7-not-valid-tip {
        color: #ef4444;
        font-size: 13px;
        margin-top: 5px;
    }

    /* Success */
    .contact-form-section form.sent .wpcf7-response-output {
        background: rgba(16, 185, 129, 0.2);
        border: 1px solid #10b981 !important;
        color: #10b981;
    }

    /* Error */
    .contact-form-section form.invalid .wpcf7-response-output,
    .contact-form-section form.failed .wpcf7-response-output {
        background: rgba(239, 68, 68, 0.2);
        border: 1px solid #ef4444 !important;
        color: #ef4444;
    }

    /* Branches Section */
    .branches-section h2 {
        text-align: center;
        font-size: 24px;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 30px;
        color: #fff;
    }

    .branch-item {
        background: rgba(30, 41, 59, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 10px;
        border-radius: 4px;
        overflow: hidden;
    }

    .branch-header {
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        cursor: pointer;
        background: rgba(255, 255, 255, 0.05);
        transition: background 0.3s;
    }

    .branch-header:hover {
        background: rgba(255, 255, 255, 0.1);
    }

    .branch-header h3 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        text-transform: uppercase;
        color: #fff;
    }

    .icon-toggle {
        font-size: 20px;
        transition: transform 0.3s;
    }

    .branch-item.active .icon-toggle {
        transform: rotate(180deg);
    }

    .branch-content {
        display: none;
        padding: 20px;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        font-size: 14px;
        line-height: 1.6;
        color: #cbd5e1;
    }

    .branch-content p {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .branch-content i {
        color: #facc15;
        font-size: 18px;
    }

    .branch-socials {
        margin: 15px 0;
        display: flex;
        gap: 10px;
    }

    .branch-socials a {
        color: #fff;
        font-size: 24px;
        text-decoration: none;
    }

    .btn-map {
        display: inline-block;
        background: #facc15;
        color: #000;
        padding: 8px 16px;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
    }
</style>

<script>
    function toggleBranch(header) {
        const item = header.parentElement;
        const content = item.querySelector('.branch-content');
        const isActive = item.classList.contains('active');

        // Close all others
        document.querySelectorAll('.branch-item').forEach(i => {
            i.classList.remove('active');
            i.querySelector('.branch-content').style.display = 'none';
        });

        // Toggle current
        if (!isActive) {
            item.classList.add('active');
            content.style.display = 'block';
        }
    }
</script>

<?php get_footer(); ?>