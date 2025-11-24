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
            <h1 class="checkout-title">Thanh toán đặt vé</h1>
            <p class="checkout-subtitle">Hoàn tất thông tin để hoàn thành đặt vé</p>
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
   CHECKOUT PAGE - PREMIUM DESIGN
   ============================================ */

.checkout-page-wrapper {
    min-height: 100vh;
    padding: 60px 20px 40px;
    background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 50%, #00c6ff 100%);
    background-attachment: fixed;
    background-size: cover;
    color: #fff;
}

.checkout-container {
    max-width: 1400px;
    margin: 0 auto;
}

/* Header Section */
.checkout-header {
    text-align: center;
    margin-bottom: 40px;
    padding-bottom: 24px;
    border-bottom: 2px solid rgba(255, 255, 255, 0.15);
}

.checkout-title {
    font-size: 42px;
    font-weight: 900;
    margin: 0 0 12px 0;
    color: #fff;
    letter-spacing: -1px;
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.3);
}

.checkout-subtitle {
    font-size: 18px;
    color: rgba(255, 255, 255, 0.9);
    margin: 0;
    font-weight: 500;
    letter-spacing: 0.3px;
}

.woocommerce-checkout-wrapper {
    background: transparent;
    border: none;
    padding: 0;
    box-shadow: none;
}

/* ============================================
   LAYOUT - FULL WIDTH BILLING
   ============================================ */

.woocommerce-checkout {
    display: grid;
    grid-template-columns: 1fr;
    gap: 24px;
    align-items: start;
}

/* ============================================
   BILLING SECTION - FULL WIDTH
   ============================================ */

/* Ẩn billing và shipping sections vì đã xóa tất cả fields */
.woocommerce-checkout .col2-set,
.woocommerce-checkout .woocommerce-billing-fields,
.woocommerce-checkout .woocommerce-shipping-fields,
.woocommerce-checkout .woocommerce-additional-fields {
    display: none !important;
}

.woocommerce-checkout .col-1,
.woocommerce-checkout .col-2 {
    margin-bottom: 0;
    width: 100%;
    float: none;
    display: block;
}

/* Đảm bảo tất cả form fields trong billing detail full width */
.woocommerce-checkout .col2-set .form-row {
    width: 100%;
    float: none;
    margin-right: 0;
    margin-left: 0;
}

.woocommerce-checkout .col2-set .form-row-first,
.woocommerce-checkout .col2-set .form-row-last {
    width: 100%;
    float: none;
    margin-right: 0;
}

/* ============================================
   PAYMENT SECTION
   ============================================ */

.woocommerce-checkout #payment {
    grid-column: 1;
    position: static;
    background: transparent;
    border: none;
    padding: 0;
    box-shadow: none;
    height: fit-content;
    margin-top: 24px;
}

/* ============================================
   ORDER REVIEW
   ============================================ */

.woocommerce-checkout #order_review_heading {
    display: none;
}

.woocommerce-checkout #order_review {
    grid-column: 1;
    margin-top: 24px;
    background: transparent;
    border: none;
    padding: 0;
    box-shadow: none;
}

/* ============================================
   TYPOGRAPHY
   ============================================ */

.woocommerce-checkout h3 {
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 18px 0;
    padding-bottom: 12px;
    border-bottom: 2px solid rgba(0, 198, 255, 0.4);
    color: #fff;
    letter-spacing: 0.3px;
}

.woocommerce-checkout label {
    display: block;
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 6px;
    letter-spacing: 0.2px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.woocommerce-checkout .required {
    color: #ff6b6b;
}

/* ============================================
   FORM FIELDS - PREMIUM STYLE
   ============================================ */

.woocommerce-checkout input[type="text"],
.woocommerce-checkout input[type="email"],
.woocommerce-checkout input[type="tel"],
.woocommerce-checkout input[type="password"],
.woocommerce-checkout select,
.woocommerce-checkout textarea {
    width: 100%;
    padding: 10px 14px;
    background: rgba(255, 255, 255, 0.25);
    backdrop-filter: blur(10px);
    border: 1.5px solid rgba(255, 255, 255, 0.4);
    border-radius: 8px;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-sizing: border-box;
}

.woocommerce-checkout input::placeholder,
.woocommerce-checkout textarea::placeholder {
    color: rgba(255, 255, 255, 0.7);
    opacity: 1;
    font-weight: 500;
}

.woocommerce-checkout input:focus,
.woocommerce-checkout select:focus,
.woocommerce-checkout textarea:focus {
    outline: none;
    background: rgba(255, 255, 255, 0.25);
    border-color: #00c6ff;
    box-shadow: 0 0 0 4px rgba(0, 198, 255, 0.25), 0 4px 12px rgba(0, 198, 255, 0.2);
    transform: translateY(-2px);
}

/* ============================================
   PAYMENT METHODS
   ============================================ */

.woocommerce-checkout .wc_payment_methods {
    list-style: none;
    padding: 0;
    margin: 0 0 24px 0;
}

.woocommerce-checkout .wc_payment_methods li {
    margin-bottom: 16px;
    padding: 16px 0;
    background: transparent;
    border: none;
    border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    border-radius: 0;
    transition: all 0.3s ease;
}

.woocommerce-checkout .wc_payment_methods li:hover {
    background: transparent;
    border-bottom-color: rgba(0, 198, 255, 0.5);
}

.woocommerce-checkout .wc_payment_methods li.wc_payment_method_credit_card {
    background: transparent;
    border-bottom-color: rgba(0, 198, 255, 0.4);
}

.woocommerce-checkout .wc_payment_methods label {
    color: #fff;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    margin: 0;
}

/* ============================================
   PAYMENT BOX (Credit Card Form)
   ============================================ */

.woocommerce-checkout #payment div.payment_box {
    background-color: transparent !important;
    margin-top: 20px;
    padding: 0;
    border: none;
}

.woocommerce-checkout .payment_box {
    margin-top: 20px;
    padding: 0;
    background: transparent;
    border: none;
    display: block !important;
}

.woocommerce-checkout .payment_box p {
    color: #fff;
    margin: 0 0 16px 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.6;
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
}

.woocommerce-checkout .payment_box p:last-child {
    margin-bottom: 0;
}

/* Credit Card Form Fields */
.woocommerce-checkout .payment_box .wc-credit-card-form {
    background: transparent;
    padding: 0;
    margin: 0;
    border: none;
}

.woocommerce-checkout .payment_box .wc-credit-card-form .form-row {
    margin-bottom: 14px;
}

.woocommerce-checkout .payment_box .wc-credit-card-form .form-row:last-child {
    margin-bottom: 0;
}

.woocommerce-checkout .payment_box .wc-credit-card-form label {
    color: #fff;
    font-weight: 600;
    font-size: 13px;
    margin-bottom: 6px;
}

.woocommerce-checkout .payment_box .wc-credit-card-form input[type="text"] {
    background: rgba(255, 255, 255, 0.25);
    border: 1.5px solid rgba(255, 255, 255, 0.4);
    border-radius: 8px;
    padding: 10px 14px;
    color: #fff;
    font-size: 14px;
    font-weight: 500;
}

.woocommerce-checkout .payment_box .wc-credit-card-form input[type="text"]:focus {
    background: rgba(255, 255, 255, 0.25);
    border-color: #00c6ff;
    box-shadow: 0 0 0 4px rgba(0, 198, 255, 0.25), 0 4px 12px rgba(0, 198, 255, 0.2);
    transform: translateY(-2px);
}

.woocommerce-checkout .payment_box .wc-credit-card-form .form-row-first,
.woocommerce-checkout .payment_box .wc-credit-card-form .form-row-last {
    width: 48%;
    float: left;
}

.woocommerce-checkout .payment_box .wc-credit-card-form .form-row-first {
    margin-right: 4%;
}

.woocommerce-checkout .payment_box .wc-credit-card-form .form-row-wide {
    clear: both;
}

.woocommerce-checkout .payment_box .wc-credit-card-form .clear {
    clear: both;
}

.woocommerce-checkout .payment_box .wc-credit-card-form-card-number {
    letter-spacing: 2px;
    font-family: 'Courier New', monospace;
}

.woocommerce-checkout .payment_box .wc-credit-card-form-card-expiry,
.woocommerce-checkout .payment_box .wc-credit-card-form-card-cvc {
    text-align: center;
}

/* ============================================
   ORDER REVIEW TABLE
   ============================================ */

.woocommerce-checkout .woocommerce-checkout-review-order-table {
    width: 100%;
    margin-bottom: 0;
    border-collapse: separate;
    border-spacing: 0;
}

.woocommerce-checkout .woocommerce-checkout-review-order-table th,
.woocommerce-checkout .woocommerce-checkout-review-order-table td {
    padding: 20px 0;
    border-bottom: 2px solid rgba(255, 255, 255, 0.25);
    color: #fff;
    font-size: 17px;
    font-weight: 600;
    vertical-align: top;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
}

.woocommerce-checkout .woocommerce-checkout-review-order-table th {
    font-weight: 700;
    color: #fff;
    text-align: left;
    font-size: 18px;
    text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
}

.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total {
    border-top: 3px solid rgba(0, 198, 255, 0.4);
    margin-top: 12px;
    padding-top: 12px;
}

.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total th,
.woocommerce-checkout .woocommerce-checkout-review-order-table .order-total td {
    padding-top: 24px;
    font-size: 22px;
    font-weight: 800;
    color: #00c6ff;
    text-shadow: 0 2px 8px rgba(0, 198, 255, 0.3);
}

/* ============================================
   PLACE ORDER BUTTON - PREMIUM
   ============================================ */

.woocommerce-checkout #place_order {
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #8e2de2 0%, #4a00e0 50%, #00c6ff 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 700;
    letter-spacing: 0.5px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 6px 20px rgba(142, 45, 226, 0.5);
    position: relative;
    overflow: hidden;
    margin-top: 24px;
    text-transform: uppercase;
}

.woocommerce-checkout #place_order::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.6s;
}

.woocommerce-checkout #place_order:hover:not(:disabled)::before {
    left: 100%;
}

.woocommerce-checkout #place_order:hover:not(:disabled) {
    background: linear-gradient(135deg, #a855f7 0%, #6366f1 50%, #06b6d4 100%);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(142, 45, 226, 0.5);
}

.woocommerce-checkout #place_order:active:not(:disabled) {
    transform: translateY(0);
}

.woocommerce-checkout #place_order:disabled {
    background: rgba(255, 255, 255, 0.15);
    color: rgba(255, 255, 255, 0.5);
    cursor: not-allowed;
    opacity: 0.6;
    box-shadow: none;
}

/* ============================================
   MESSAGES & NOTIFICATIONS
   ============================================ */

.woocommerce-info,
.woocommerce-error,
.woocommerce-message {
    padding: 16px 20px;
    border-radius: 14px;
    margin-bottom: 24px;
    font-size: 14px;
    line-height: 1.6;
    border: 1.5px solid;
}

.woocommerce-info {
    background: rgba(142, 45, 226, 0.15);
    border-color: rgba(142, 45, 226, 0.3);
    color: #fff;
}

.woocommerce-error {
    background: rgba(239, 68, 68, 0.15);
    border-color: rgba(239, 68, 68, 0.3);
    color: #fecaca;
}

.woocommerce-message {
    background: rgba(34, 197, 94, 0.15);
    border-color: rgba(34, 197, 94, 0.3);
    color: #bbf7d0;
}

.woocommerce-info.empty-cart {
    text-align: center;
}

.woocommerce-info.empty-cart a {
    color: #00c6ff;
    text-decoration: underline;
    font-weight: 600;
}

.error-message {
    padding: 20px;
    background: rgba(239, 68, 68, 0.15);
    border: 1.5px solid rgba(239, 68, 68, 0.3);
    border-radius: 14px;
    color: #fecaca;
}
.woocommerce-checkout #payment div.payment_box {
    background-color: transparent !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: center !important;
    justify-content: center !important;
    width: 100% !important;
    height: 100% !important;
    padding: 0 !important;
    margin: 0 !important;
    border: none !important;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 1200px) {
    .woocommerce-checkout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .woocommerce-checkout .col2-set {
        grid-column: 1;
        grid-template-columns: 1fr;
        gap: 16px;
    }
    
    .woocommerce-checkout #payment {
        grid-column: 1;
        position: static;
        margin-top: 0;
    }
    
    .woocommerce-checkout #order_review {
        grid-column: 1;
        margin-top: 20px;
    }
}

@media (max-width: 768px) {
    .checkout-page-wrapper {
        padding: 40px 16px 32px;
    }
    
    .checkout-title {
        font-size: 28px;
    }
    
    .checkout-subtitle {
        font-size: 14px;
    }
    
    .woocommerce-checkout-wrapper {
        padding: 20px;
        border-radius: 20px;
    }
    
    .woocommerce-checkout .col2-set {
        grid-template-columns: 1fr;
        gap: 16px;
        padding: 18px;
        border-radius: 16px;
    }
    
    .woocommerce-checkout #payment,
    .woocommerce-checkout #order_review {
        padding: 18px;
        border-radius: 16px;
    }
    
    .woocommerce-checkout h3 {
        font-size: 18px;
        margin-bottom: 18px;
    }
    
    .woocommerce-checkout .payment_box .wc-credit-card-form .form-row-first,
    .woocommerce-checkout .payment_box .wc-credit-card-form .form-row-last {
        width: 100%;
        float: none;
        margin-right: 0;
    }
}

@media (max-width: 480px) {
    .checkout-page-wrapper {
        padding: 32px 12px 24px;
    }
    
    .checkout-title {
        font-size: 24px;
    }
    
    .woocommerce-checkout-wrapper {
        padding: 16px;
    }
    
    .woocommerce-checkout .col2-set {
        grid-template-columns: 1fr;
        padding: 16px;
    }
    
    .woocommerce-checkout #payment,
    .woocommerce-checkout #order_review {
        padding: 16px;
    }
}

/* ============================================
   CREDIT CARD PREVIEW - GÓC MÀN HÌNH
   ============================================ */

.credit-card-preview {
    position: fixed;
    top: 20px;
    right: 20px;
    width: 340px;
    height: 210px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
    z-index: 9999;
    transform: perspective(1000px) rotateY(0deg);
    transition: all 0.3s ease;
    display: none;
}

.credit-card-preview.active {
    display: block;
    animation: cardSlideIn 0.5s ease-out;
}

@keyframes cardSlideIn {
    from {
        opacity: 0;
        transform: translateX(100px) perspective(1000px) rotateY(-15deg);
    }
    to {
        opacity: 1;
        transform: translateX(0) perspective(1000px) rotateY(0deg);
    }
}

.credit-card-preview::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
    border-radius: 16px;
    pointer-events: none;
}

.credit-card-preview .card-chip {
    width: 40px;
    height: 32px;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 6px;
    margin-bottom: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
}

.credit-card-preview .card-number {
    font-size: 22px;
    font-weight: 600;
    letter-spacing: 3px;
    color: #fff;
    margin-bottom: 24px;
    font-family: 'Courier New', monospace;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    min-height: 28px;
}

.credit-card-preview .card-number.empty {
    color: rgba(255, 255, 255, 0.5);
}

.credit-card-preview .card-info {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-top: auto;
}

.credit-card-preview .card-holder {
    flex: 1;
}

.credit-card-preview .card-holder-label {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}

.credit-card-preview .card-holder-name {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    text-transform: uppercase;
    letter-spacing: 1px;
    min-height: 18px;
}

.credit-card-preview .card-holder-name.empty {
    color: rgba(255, 255, 255, 0.5);
}

.credit-card-preview .card-expiry {
    text-align: right;
}

.credit-card-preview .card-expiry-label {
    font-size: 10px;
    color: rgba(255, 255, 255, 0.7);
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 4px;
}

.credit-card-preview .card-expiry-date {
    font-size: 14px;
    font-weight: 600;
    color: #fff;
    letter-spacing: 1px;
    min-height: 18px;
}

.credit-card-preview .card-expiry-date.empty {
    color: rgba(255, 255, 255, 0.5);
}

@media (max-width: 768px) {
    .credit-card-preview {
        width: 280px;
        height: 175px;
        padding: 20px;
        top: 10px;
        right: 10px;
    }
    
    .credit-card-preview .card-number {
        font-size: 18px;
        letter-spacing: 2px;
        margin-bottom: 20px;
    }
    
    .credit-card-preview .card-chip {
        width: 35px;
        height: 28px;
        margin-bottom: 15px;
    }
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

