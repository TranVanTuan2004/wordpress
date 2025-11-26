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
   CHECKOUT PAGE - PREMIUM PROFESSIONAL DESIGN
   ============================================ */

.checkout-page-wrapper {
    min-height: 100vh;
    padding: 80px 20px 60px;
    background: linear-gradient(135deg, #0a0e1a 0%, #1a1f35 50%, #0f1419 100%);
    background-attachment: fixed;
    position: relative;
    overflow-x: hidden;
}

.checkout-page-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 30%, rgba(255, 228, 77, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 80% 70%, rgba(99, 102, 241, 0.08) 0%, transparent 40%),
        radial-gradient(circle at 50% 50%, rgba(255, 255, 255, 0.02) 0%, transparent 50%);
    pointer-events: none;
}

.checkout-container {
    max-width: 1400px;
    margin: 0 auto;
    position: relative;
    z-index: 1;
}

/* ============================================
   HEADER SECTION - Enhanced
   ============================================ */
.checkout-header {
    text-align: center;
    margin-bottom: 60px;
    position: relative;
    animation: fadeInDown 0.6s ease-out;
}

@keyframes fadeInDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.checkout-title {
    font-size: 42px;
    font-weight: 900;
    margin: 0 0 16px 0;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 2px;
    background: linear-gradient(135deg, #fff 0%, #ffe44d 50%, #ffd700 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
    position: relative;
    text-shadow: 0 0 30px rgba(255, 228, 77, 0.3);
}

.checkout-subtitle {
    font-size: 17px;
    color: #94a3b8;
    margin: 0;
    font-weight: 400;
    letter-spacing: 0.5px;
}

/* ============================================
   MAIN WRAPPER - Glassmorphism
   ============================================ */
.woocommerce-checkout-wrapper {
    background: rgba(20, 28, 46, 0.6);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 28px;
    padding: 50px;
    box-shadow: 
        0 8px 32px rgba(0, 0, 0, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
    position: relative;
    animation: fadeInUp 0.6s ease-out 0.2s both;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.woocommerce-checkout-wrapper::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(255, 228, 77, 0.3), transparent);
}

/* ============================================
   ALERTS & NOTICES
   ============================================ */
.woocommerce-info, .woocommerce-message, .woocommerce-error {
    background: linear-gradient(135deg, rgba(30, 41, 59, 0.9) 0%, rgba(15, 23, 42, 0.9) 100%) !important;
    color: #e2e8f0 !important;
    border: 1px solid rgba(255, 228, 77, 0.3) !important;
    border-left: 4px solid #ffe44d !important;
    padding: 18px 24px !important;
    border-radius: 12px !important;
    margin-bottom: 28px !important;
    display: flex !important;
    flex-wrap: wrap !important;
    align-items: center !important;
    gap: 12px !important;
    line-height: 1.6 !important;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2) !important;
}

.woocommerce-info::before, .woocommerce-message::before {
    color: #ffe44d !important;
    margin-right: 0 !important;
    font-size: 18px !important;
}

.woocommerce-info a, .woocommerce-message a {
    color: #ffe44d !important;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s ease;
}

.woocommerce-info a:hover, .woocommerce-message a:hover {
    color: #ffd700 !important;
    text-decoration: underline;
}

.woocommerce-form-coupon, .woocommerce-form-login {
    border: 1px solid rgba(255, 255, 255, 0.1) !important;
    padding: 28px !important;
    border-radius: 16px !important;
    margin-bottom: 32px !important;
    background: rgba(15, 23, 42, 0.4) !important;
    backdrop-filter: blur(10px) !important;
}

/* ============================================
   LAYOUT - Improved Grid
   ============================================ */
form.woocommerce-checkout {
    display: flex;
    flex-wrap: wrap;
    gap: 40px;
}

@media (min-width: 1024px) {
    form.woocommerce-checkout {
    }
}

#customer_details {
    grid-column: 1;
    width: 100%;
}

#customer_details .col-1, 
#customer_details .col-2 {
    float: none !important;
    width: 100% !important;
    max-width: 100% !important;
    margin-bottom: 32px !important;
    background: rgba(15, 23, 42, 0.3);
    padding: 32px;
    border-radius: 20px;
    border: 1px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s ease;
}

#customer_details .col-1:hover,
#customer_details .col-2:hover {
    background: rgba(15, 23, 42, 0.5);
    border-color: rgba(255, 228, 77, 0.15);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
}

#customer_details:after {
    content: "";
    display: table;
    clear: both;
}
#customer_details {
    display: none;
}

/* ============================================
   SECTION HEADINGS - Enhanced
   ============================================ */
.woocommerce-checkout h3 {
    font-size: 22px;
    font-weight: 800;
    margin: 0 0 28px 0;
    color: #fff;
    display: flex;
    align-items: center;
    gap: 12px;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.woocommerce-checkout h3::before {
    content: '';
    display: block;
    width: 5px;
    height: 28px;
    background: linear-gradient(180deg, #ffe44d 0%, #ffd700 100%);
    border-radius: 3px;
    box-shadow: 0 0 12px rgba(255, 228, 77, 0.4);
}

/* ============================================
   FORM FIELDS - Professional Styling
   ============================================ */
.woocommerce-checkout label {
    color: #cbd5e1;
    font-weight: 600;
    font-size: 14px;
    margin-bottom: 10px;
    display: block;
    letter-spacing: 0.3px;
}

.woocommerce-checkout .required {
    color: #ef4444;
    text-decoration: none;
    margin-left: 3px;
}

.woocommerce-checkout input[type="text"],
.woocommerce-checkout input[type="email"],
.woocommerce-checkout input[type="tel"],
.woocommerce-checkout input[type="password"],
.woocommerce-checkout select,
.woocommerce-checkout textarea {
    width: 100%;
    padding: 14px 18px;
    background: rgba(15, 23, 42, 0.8);
    border: 2px solid rgba(148, 163, 184, 0.15);
    border-radius: 14px;
    color: #fff;
    font-size: 15px;
    font-weight: 400;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-sizing: border-box;
}

.woocommerce-checkout input:focus,
.woocommerce-checkout select:focus,
.woocommerce-checkout textarea:focus {
 
}

.woocommerce-checkout input::placeholder {
    color: #64748b;
}

.woocommerce-checkout .form-row {
    margin-bottom: 24px;
}

/* Select2 Enhanced Styling */
.select2-container--default .select2-selection--single {
    background: rgba(15, 23, 42, 0.8) !important;
    border: 2px solid rgba(148, 163, 184, 0.15) !important;
    border-radius: 14px !important;
    height: 52px !important;
    display: flex !important;
    align-items: center !important;
    transition: all 0.3s ease !important;
}



.select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #fff !important;
    padding-left: 18px !important;
    line-height: 48px !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 48px !important;
    right: 12px !important;
}

.select2-dropdown {
    background: rgba(30, 41, 59, 0.98) !important;
    backdrop-filter: blur(10px) !important;
    border: 1px solid rgba(148, 163, 184, 0.2) !important;
    border-radius: 12px !important;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3) !important;
}

.select2-container--default .select2-results__option {
    color: #e2e8f0 !important;
    padding: 12px 18px !important;
}

.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background: linear-gradient(135deg, #ffe44d 0%, #ffd700 100%) !important;
    color: #0f172a !important;
}

.select2-container--default .select2-results__option[aria-selected=true] {
    background: rgba(51, 65, 85, 0.8) !important;
}

/* ============================================
   ORDER REVIEW - Sticky Card Design
   ============================================ */
.woocommerce-checkout #order_review_heading {
    grid-column: 2;
    width: 100%;
    margin-bottom: 20px;
}

.woocommerce-checkout #order_review {
    grid-column: 2;
    width: 100%;
    background: linear-gradient(135deg, rgba(15, 23, 42, 0.9) 0%, rgba(30, 41, 59, 0.9) 100%);
    backdrop-filter: blur(15px);
    padding: 36px;
    border-radius: 24px;
    border: 2px solid rgba(255, 228, 77, 0.2);
    box-shadow: 
        0 12px 40px rgba(0, 0, 0, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.05);
    position: sticky;
    top: 100px;
}

@media (min-width: 1024px) {
    .woocommerce-checkout #order_review {
        position: sticky;
        top: 100px;
    }
}

/* Order Table - Enhanced */
.woocommerce-checkout-review-order-table {
    width: 100%;
    margin-bottom: 28px;
    border-collapse: separate;
    border-spacing: 0;
}

.woocommerce-checkout-review-order-table thead {
    background: rgba(255, 228, 77, 0.05);
    border-radius: 12px;
}

.woocommerce-checkout-review-order-table th {
    padding: 16px 0;
    color: #ffe44d;
    font-size: 13px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-bottom: 2px solid rgba(255, 228, 77, 0.2);
}

.woocommerce-checkout-review-order-table td {
    padding: 18px 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    color: #e2e8f0;
    font-size: 15px;
}

.woocommerce-checkout-review-order-table .product-name {
    color: #fff;
    font-weight: 600;
}

.woocommerce-checkout-review-order-table .product-total {
    text-align: right;
    font-weight: 700;
    color: #ffe44d;
    font-size: 16px;
}

.woocommerce-checkout-review-order-table .cart-subtotal th,
.woocommerce-checkout-review-order-table .cart-subtotal td {
    padding-top: 20px;
    font-weight: 600;
}

.woocommerce-checkout-review-order-table .order-total {
    background: linear-gradient(135deg, rgba(255, 228, 77, 0.08) 0%, rgba(255, 215, 0, 0.08) 100%);
}

.woocommerce-checkout-review-order-table .order-total th,
.woocommerce-checkout-review-order-table .order-total td {
    border-bottom: none;
    padding: 24px 0;
    font-size: 24px;
    font-weight: 900;
    color: #ffe44d;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* ============================================
   PAYMENT METHODS - Card Design
   ============================================ */
.wc_payment_methods {
    list-style: none;
    padding: 0;
    margin: 28px 0;
    border-top: 2px dashed rgba(255, 255, 255, 0.1);
    padding-top: 28px;
}

.wc_payment_methods li {
    margin-bottom: 16px;
    background: rgba(30, 41, 59, 0.6);
    backdrop-filter: blur(10px);
    padding: 20px;
    border-radius: 16px;
    border: 2px solid rgba(255, 255, 255, 0.05);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.wc_payment_methods li:hover {
    background: rgba(30, 41, 59, 0.8);
    border-color: rgba(255, 228, 77, 0.3);
    transform: translateX(4px);
    box-shadow: 0 4px 16px rgba(255, 228, 77, 0.1);
}

.wc_payment_methods input[type="radio"]:checked + label {
    color: #ffe44d;
}

.wc_payment_methods input[type="radio"]:checked ~ * {
    border-color: #ffe44d;
}

.wc_payment_methods li.wc_payment_method input[type="radio"]:checked {
    accent-color: #ffe44d;
}

.wc_payment_methods label {
    cursor: pointer;
    margin: 0;
    color: #fff;
    font-weight: 700;
    font-size: 15px;
    display: flex;
    align-items: center;
    gap: 12px;
    transition: color 0.2s ease;
}

.payment_box {
    margin-top: 16px;
    padding: 24px;
    background: linear-gradient(135deg, rgba(139, 92, 246, 0.08) 0%, rgba(59, 130, 246, 0.08) 100%);
    border-radius: 16px;
    border: 1px solid rgba(139, 92, 246, 0.2);
    font-size: 14px;
    color: #94a3b8;
    line-height: 1.7;
    box-shadow: 0 4px 12px rgba(139, 92, 246, 0.1);
}

/* ============================================
   CREDIT CARD FORM - Premium Design
   ============================================ */
.wc-credit-card-form {
    margin-top: 20px;
}

.wc-credit-card-form .form-row {
    background-color: transparent !important;
}

.wc-credit-card-form label {
    color: #e2e8f0;
    font-weight: 700;
    font-size: 13px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.wc-credit-card-form label .required {
    color: #f87171;
}

/* Card Number Input with Icons */
.wc-credit-card-form-card-number {
    width: 100%;
    padding: 16px 50px 16px 18px;
    background: rgba(30, 41, 59, 0.8);
    border: 2px solid rgba(139, 92, 246, 0.2);
    border-radius: 14px;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.wc-credit-card-form-card-number:focus {
    outline: none;
    transform: translateY(-2px);
}

/* Expiry and CVV Row */
.wc-credit-card-form .form-row-first,
.wc-credit-card-form .form-row-last {
    width: 48%;
    float: left;
}

.wc-credit-card-form .form-row-first {
    margin-right: 4%;
}

.wc-credit-card-form-card-expiry,
.wc-credit-card-form-card-cvc {
    width: 100%;
    padding: 16px 18px;
    background: rgba(30, 41, 59, 0.8);
    border: 2px solid rgba(139, 92, 246, 0.2);
    border-radius: 14px;
    color: #fff;
    font-size: 16px;
    font-weight: 600;
    font-family: 'Courier New', monospace;
    transition: all 0.3s ease;
    box-sizing: border-box;
}

.wc-credit-card-form-card-expiry {
    letter-spacing: 2px;
}

.wc-credit-card-form-card-cvc {
    letter-spacing: 3px;
}

.wc-credit-card-form-card-expiry:focus,
.wc-credit-card-form-card-cvc:focus {

}

/* Card Name Input */
.wc-credit-card-form input[name*="card-name"],
.wc-credit-card-form input[id*="card-name"] {
    width: 100%;
    padding: 16px 18px;
    background: rgba(30, 41, 59, 0.8);
    border: 2px solid rgba(139, 92, 246, 0.2);
    border-radius: 14px;
    color: #fff;
    font-size: 15px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-sizing: border-box;
}


/* Placeholder Styling */
.wc-credit-card-form input::placeholder {
    color: #64748b;
    font-weight: 400;
    letter-spacing: normal;
}

/* Test Card Info Box */
.payment_box p {
    margin: 0 0 16px 0;
    padding: 16px;
    background: linear-gradient(135deg, rgba(168, 85, 247, 0.15) 0%, rgba(124, 58, 237, 0.15) 100%);
    border-left: 4px solid #a855f7;
    border-radius: 10px;
    color: #e0e7ff;
    font-size: 13px;
    line-height: 1.8;
}

.payment_box strong {
    color: #c4b5fd;
    font-weight: 700;
}

/* Card Icons (Visa, Mastercard, JCB) */
.wc-credit-card-form-card-number-wrapper {
    position: relative;
}

.wc-credit-card-form-card-number-wrapper::after {
    content: '💳';
    position: absolute;
    right: 16px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 24px;
    opacity: 0.6;
    pointer-events: none;
}

/* Clear Fix */
.wc-credit-card-form .form-row::after {
    content: "";
    display: table;
    clear: both;
}

/* Responsive */
@media (max-width: 600px) {
    .wc-credit-card-form .form-row-first,
    .wc-credit-card-form .form-row-last {
        width: 100%;
        float: none;
        margin-right: 0;
    }
    
    .wc-credit-card-form-card-number,
    .wc-credit-card-form-card-expiry,
    .wc-credit-card-form-card-cvc,
    .wc-credit-card-form input[name*="card-name"],
    .wc-credit-card-form input[id*="card-name"] {
        padding: 14px 16px;
        font-size: 15px;
    }
}


/* ============================================
   PLACE ORDER BUTTON - Premium
   ============================================ */
#place_order {
    width: 100%;
    padding: 20px;
    background: linear-gradient(135deg, #ffe44d 0%, #ffd700 100%);
    color: #0f172a;
    border: none;
    border-radius: 16px;
    font-size: 17px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 
        0 8px 20px rgba(255, 228, 77, 0.3),
        inset 0 1px 0 rgba(255, 255, 255, 0.3);
    position: relative;
    overflow: hidden;
}

#place_order::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
    transition: left 0.5s ease;
}

#place_order:hover::before {
    left: 100%;
}

#place_order:hover {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    transform: translateY(-3px);
    box-shadow: 
        0 12px 28px rgba(255, 228, 77, 0.4),
        inset 0 1px 0 rgba(255, 255, 255, 0.4);
}

#place_order:active {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(255, 228, 77, 0.3);
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */
@media (max-width: 1024px) {
    form.woocommerce-checkout {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    
    #customer_details,
    .woocommerce-checkout #order_review_heading,
    .woocommerce-checkout #order_review {
        grid-column: 1;
    }
    
    .woocommerce-checkout #order_review {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .checkout-page-wrapper {
        padding: 60px 16px 40px;
    }
    
    .woocommerce-checkout-wrapper {
        padding: 28px 20px;
        border-radius: 20px;
    }
    
    .checkout-title {
        font-size: 32px;
    }
    
    .checkout-header {
        margin-bottom: 40px;
    }
    
    #customer_details .col-1,
    #customer_details .col-2 {
        padding: 24px;
    }
    
    .woocommerce-checkout #order_review {
        padding: 28px;
    }
    
    .woocommerce-checkout h3 {
        font-size: 18px;
    }
}

@media (max-width: 480px) {
    .checkout-title {
        font-size: 26px;
    }
    
    .woocommerce-checkout-wrapper {
        padding: 20px 16px;
    }
    
    #customer_details .col-1,
    #customer_details .col-2 {
        padding: 20px;
    }
}

/* ============================================
   CREDIT CARD PREVIEW (Hidden)
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

