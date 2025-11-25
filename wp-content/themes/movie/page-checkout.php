<?php
/**
 * Template Name: Trang Thanh Toán
 * Template for WooCommerce Checkout
 */
get_header();
?>

<main class="checkout-page-wrapper">
    <div class="checkout-container">
        <div class="checkout-header">
            <h1 class="checkout-title">Thanh toán đơn hàng</h1>
            <p class="checkout-subtitle">Hoàn tất thông tin để hoàn thành đơn hàng</p>
        </div>
        
        <div class="woocommerce-checkout-wrapper">
            <?php
            if (class_exists('WooCommerce')) {
                if (WC()->cart->is_empty()) {
                    echo '<div class="woocommerce-info empty-cart">';
                    echo '<p>Giỏ hàng của bạn đang trống. <a href="' . esc_url(wc_get_page_permalink('shop') ?: home_url()) . '">Quay lại trang chủ</a></p>';
                    echo '</div>';
                } else {
                    echo do_shortcode('[woocommerce_checkout]');
                }
            } else {
                echo '<div class="error-message">';
                echo '<p>WooCommerce chưa được kích hoạt. Vui lòng kích hoạt plugin WooCommerce để sử dụng chức năng thanh toán.</p>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
</main>

<style>
/* ============================================
   CHECKOUT PAGE - PREMIUM DARK THEME
   ============================================ */

.checkout-page-wrapper {
    min-height: 100vh;
    padding: 60px 20px 40px;
    background-color: #0f172a; /* Slate 900 */
    background-image: 
        radial-gradient(at 0% 0%, rgba(255, 228, 77, 0.15) 0px, transparent 50%),
        radial-gradient(at 100% 0%, rgba(99, 102, 241, 0.15) 0px, transparent 50%);
    color: #e2e8f0;
    font-family: 'Inter', sans-serif;
}

.checkout-container {
    max-width: 1200px;
    margin: 0 auto;
}

/* Header Section */
.checkout-header {
    text-align: center;
    margin-bottom: 50px;
    position: relative;
}

.checkout-title {
    font-size: 36px;
    font-weight: 800;
    margin: 0 0 16px 0;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
    background: linear-gradient(to right, #fff, #ffe44d);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
}

.checkout-subtitle {
    font-size: 16px;
    color: #94a3b8;
    margin: 0;
}

.woocommerce-checkout-wrapper {
    background: rgba(30, 41, 59, 0.7); /* Slate 800 with opacity */
    backdrop-filter: blur(12px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 24px;
    padding: 40px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
}

/* ============================================
   ALERTS & NOTICES (Coupon, Login)
   ============================================ */
/* ============================================
   ALERTS & NOTICES (Coupon, Login)
   ============================================ */
.woocommerce-info, .woocommerce-message, .woocommerce-error {
    background-color: #1e293b !important;
    color: #e2e8f0 !important;
    border-top: 3px solid #ffe44d !important;
    padding: 16px 24px !important;
    border-radius: 8px !important;
    margin-bottom: 24px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 10px !important;
    line-height: 1.5 !important;
}

.woocommerce-info::before, .woocommerce-message::before {
    color: #ffe44d !important;
    margin-right: 0 !important; /* Remove default margin since we use gap */
}

.woocommerce-info a, .woocommerce-message a {
    color: #ffe44d !important;
    font-weight: 700;
    text-decoration: none;
}

.woocommerce-info a:hover, .woocommerce-message a:hover {
    text-decoration: underline;
}

.woocommerce-form-coupon, .woocommerce-form-login {
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    padding: 24px !important;
    border-radius: 12px !important;
    margin-bottom: 30px !important;
    background: rgba(15, 23, 42, 0.3) !important;
}

/* ============================================
   LAYOUT
   ============================================ */

form.woocommerce-checkout {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
}

@media (min-width: 1024px) {
    form.woocommerce-checkout {
        display: grid;
        grid-template-columns: 1.2fr 0.8fr;
        align-items: start;
    }
}

#customer_details {
    grid-column: 1;
    width: 100%;
}

/* Fix for Woo col-1 and col-2 inside customer_details */
#customer_details .col-1, 
#customer_details .col-2 {
    float: none !important;
    width: 100% !important;
    max-width: 100% !important;
    margin-bottom: 20px !important;
}

#customer_details:after {
    content: "";
    display: table;
    clear: both;
}

/* ============================================
   BILLING & FIELDS
   ============================================ */

.woocommerce-checkout h3 {
    font-size: 20px;
    font-weight: 700;
    margin: 0 0 24px 0;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 10px;
}

.woocommerce-checkout h3::before {
    content: '';
    display: block;
    width: 4px;
    height: 24px;
    background: #ffe44d;
    border-radius: 2px;
}

.woocommerce-checkout label {
    color: #cbd5e1;
    font-weight: 500;
    font-size: 14px;
    margin-bottom: 8px;
    display: block;
}

.woocommerce-checkout .required {
    color: #ef4444;
    text-decoration: none;
}

.woocommerce-checkout input[type="text"],
.woocommerce-checkout input[type="email"],
.woocommerce-checkout input[type="tel"],
.woocommerce-checkout input[type="password"],
.woocommerce-checkout select,
.woocommerce-checkout textarea {
    width: 100%;
    padding: 12px 16px;
    background: #0f172a;
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-radius: 12px;
    color: #fff;
    font-size: 15px;
    transition: all 0.2s ease;
    box-sizing: border-box;
}

.woocommerce-checkout input:focus,
.woocommerce-checkout select:focus,
.woocommerce-checkout textarea:focus {
    outline: none;
    border-color: #ffe44d;
    box-shadow: 0 0 0 3px rgba(255, 228, 77, 0.15);
    background: #1e293b;
}

.woocommerce-checkout input::placeholder {
    color: #475569;
}

/* Select2 Styling */
.select2-container--default .select2-selection--single {
    background-color: #0f172a !important;
    border: 1px solid rgba(148, 163, 184, 0.2) !important;
    border-radius: 12px !important;
    height: 48px !important;
    display: flex !important;
    align-items: center !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fff !important;
    padding-left: 16px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 46px !important;
    right: 10px !important;
}

.select2-dropdown {
    background-color: #1e293b !important;
    border: 1px solid rgba(148, 163, 184, 0.2) !important;
    color: #fff !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #ffe44d !important;
    color: #0f172a !important;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #334155 !important;
}

/* ============================================
   ORDER REVIEW & PAYMENT (Right Column)
   ============================================ */

.woocommerce-checkout #order_review_heading,
.woocommerce-checkout #order_review {
    grid-column: 2;
    width: 100%;
}

.woocommerce-checkout #order_review {
    background: #0f172a;
    padding: 30px;
    border-radius: 16px;
    border: 1px solid rgba(255, 228, 77, 0.2);
}

/* Order Table */
.woocommerce-checkout-review-order-table {
    width: 100%;
    margin-bottom: 24px;
    border-collapse: collapse;
}

.woocommerce-checkout-review-order-table th,
.woocommerce-checkout-review-order-table td {
    padding: 16px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    color: #e2e8f0;
    font-size: 14px;
}

.woocommerce-checkout-review-order-table .product-name {
    color: #fff;
    font-weight: 500;
}

.woocommerce-checkout-review-order-table .product-total {
    text-align: right;
    font-weight: 600;
    color: #ffe44d;
}

.woocommerce-checkout-review-order-table .order-total th,
.woocommerce-checkout-review-order-table .order-total td {
    border-bottom: none;
    padding-top: 20px;
    font-size: 20px;
    font-weight: 800;
    color: #ffe44d;
}

/* Payment Methods */
.wc_payment_methods {
    list-style: none;
    padding: 0;
    margin: 24px 0;
    border-top: 1px dashed rgba(255, 255, 255, 0.2);
    padding-top: 24px;
}

.wc_payment_methods li {
    margin-bottom: 16px;
    background: #1e293b;
    padding: 16px;
    border-radius: 12px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.2s;
}

.wc_payment_methods li:hover {
    border-color: rgba(255, 228, 77, 0.3);
}

.wc_payment_methods label {
    cursor: pointer;
    margin: 0;
    color: #fff;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.payment_box {
    margin-top: 12px;
    padding: 12px;
    background: rgba(15, 23, 42, 0.5);
    border-radius: 8px;
    font-size: 13px;
    color: #94a3b8;
    line-height: 1.5;
}

/* Place Order Button */
#place_order {
    width: 100%;
    padding: 16px;
    background: #ffe44d;
    color: #0f172a;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 800;
    text-transform: uppercase;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 12px rgba(255, 228, 77, 0.2);
}

#place_order:hover {
    background: #ffd700;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(255, 228, 77, 0.3);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 1024px) {
    .woocommerce-checkout {
        grid-template-columns: 1fr;
    }
    
    #customer_details,
    .woocommerce-checkout #order_review_heading,
    .woocommerce-checkout #order_review {
        grid-column: 1;
    }
}

@media (max-width: 768px) {
    .checkout-page-wrapper {
        padding: 40px 16px;
    }
    
    .woocommerce-checkout-wrapper {
        padding: 24px;
    }
    
    .checkout-title {
        font-size: 28px;
    }
}

/* ============================================
   CREDIT CARD PREVIEW (Hidden for now to simplify)
   ============================================ */
.credit-card-preview {
    display: none !important;
}
</style>

<div class="credit-card-preview" id="creditCardPreview">
    <div class="card-chip"></div>
    <div class="card-number empty" id="previewCardNumber">•••• •••• •••• ••••</div>
    <div class="card-info">
        <div class="card-holder">
            <div class="card-holder-label">Tên chủ thẻ</div>
            <div class="card-holder-name empty" id="previewCardName">NGUYEN VAN A</div>
        </div>
        <div class="card-expiry">
            <div class="card-expiry-label">Hết hạn</div>
            <div class="card-expiry-date empty" id="previewCardExpiry">MM/YY</div>
        </div>
    </div>
</div>

<script>
jQuery(document).ready(function($) {
    'use strict';
    
    // Force show payment box
    function forceShowPaymentBox($paymentBox) {
        if ($paymentBox.length) {
            $paymentBox.css({
                'display': 'block',
                'visibility': 'visible',
                'opacity': '1'
            }).show();
        }
    }
    
    // Show payment box for selected method
    function showPaymentBox() {
        $('.wc_payment_methods input[type="radio"]:checked').each(function() {
            var $paymentBox = $(this).closest('li').find('.payment_box');
            forceShowPaymentBox($paymentBox);
        });
    }
    
    // Handle payment method selection
    $(document.body).on('change click', '.wc_payment_methods input[type="radio"]', function() {
        $('.payment_box').hide();
        var $paymentBox = $(this).closest('li').find('.payment_box');
        forceShowPaymentBox($paymentBox);
        
        if ($(this).val() === 'credit_card') {
            setTimeout(function() {
                forceShowPaymentBox($paymentBox);
                $('#creditCardPreview').addClass('active');
                updateCardPreview();
            }, 100);
        } else {
            $('#creditCardPreview').removeClass('active');
        }
    });
    
    // Show payment box on page load
    setTimeout(function() {
        showPaymentBox();
    }, 100);
    
    // Auto-select credit card if in URL
    if (window.location.search.indexOf('payment_method=credit_card') > -1) {
        setTimeout(function() {
            var $creditCardRadio = $('input[value="credit_card"]');
            if ($creditCardRadio.length) {
                $creditCardRadio.prop('checked', true).trigger('change').trigger('click');
                var $paymentBox = $creditCardRadio.closest('li').find('.payment_box');
                forceShowPaymentBox($paymentBox);
                $('html, body').animate({
                    scrollTop: $creditCardRadio.closest('.wc_payment_methods').offset().top - 100
                }, 500);
            }
        }, 800);
    }
    
    // Handle WooCommerce checkout update
    $(document.body).on('updated_checkout', function() {
        setTimeout(function() {
            showPaymentBox();
        }, 100);
    });
    
    // Format card number
    $(document.body).on('input', '.wc-credit-card-form-card-number', function() {
        var value = $(this).val().replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        var formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        if (formattedValue.length <= 19) {
            $(this).val(formattedValue);
        }
        updateCardPreview();
    });
    
    // Format expiry date
    $(document.body).on('input', '.wc-credit-card-form-card-expiry', function() {
        var value = $(this).val().replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
        }
        $(this).val(value);
        updateCardPreview();
    });
    
    // CVV - numbers only
    $(document.body).on('input', '.wc-credit-card-form-card-cvc', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });
    
    // Update card name
    $(document.body).on('input', '.wc-credit-card-form input[name*="card-name"], input[id*="card-name"]', function() {
        updateCardPreview();
    });
    
    
    // Kiểm tra khi page load
    setTimeout(function() {
        if ($('input[value="credit_card"]:checked').length > 0) {
            $('#creditCardPreview').addClass('active');
            updateCardPreview();
        }
    }, 500);
    
    // Hàm cập nhật card preview
    function updateCardPreview() {
        var cardNumber = $('.wc-credit-card-form-card-number').val() || '';
        var cardExpiry = $('.wc-credit-card-form-card-expiry').val() || '';
        var cardName = $('.wc-credit-card-form input[name*="card-name"], input[id*="card-name"]').val() || '';
        
        // Cập nhật số thẻ
        if (cardNumber) {
            $('#previewCardNumber').text(cardNumber).removeClass('empty');
        } else {
            $('#previewCardNumber').text('•••• •••• •••• ••••').addClass('empty');
        }
        
        // Cập nhật ngày hết hạn
        if (cardExpiry) {
            $('#previewCardExpiry').text(cardExpiry).removeClass('empty');
        } else {
            $('#previewCardExpiry').text('MM/YY').addClass('empty');
        }
        
        // Cập nhật tên chủ thẻ
        if (cardName) {
            $('#previewCardName').text(cardName.toUpperCase()).removeClass('empty');
        } else {
            $('#previewCardName').text('NGUYEN VAN A').addClass('empty');
        }
    }
});
</script>

<?php get_footer(); ?>

