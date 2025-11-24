jQuery(document).ready(function($) {
    'use strict';

    // Đảm bảo payment box được hiển thị khi chọn payment method
    $(document.body).on('change', 'input[name="payment_method"]', function() {
        var paymentMethod = $(this).val();
        if (paymentMethod === 'credit_card') {
            var paymentBox = $(this).closest('li.wc_payment_method').find('.payment_box');
            if (paymentBox.length && !paymentBox.is(':visible')) {
                paymentBox.slideDown(300);
            }
        }
    });

    // Format card number with spaces
    $(document).on('input', '.wc-credit-card-form-card-number', function() {
        var value = $(this).val().replace(/\s+/g, '').replace(/[^0-9]/gi, '');
        var formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        if (formattedValue.length <= 19) {
            $(this).val(formattedValue);
        }
    });

    // Format expiry date (MM/YY)
    $(document).on('input', '.wc-credit-card-form-card-expiry', function() {
        var value = $(this).val().replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + ' / ' + value.substring(2, 4);
        }
        $(this).val(value);
    });

    // Only allow numbers for CVV
    $(document).on('input', '.wc-credit-card-form-card-cvc', function() {
        $(this).val($(this).val().replace(/\D/g, ''));
    });

    // Only allow numbers and spaces for card number
    $(document).on('keypress', '.wc-credit-card-form-card-number', function(e) {
        var char = String.fromCharCode(e.which);
        if (!/[0-9\s]/.test(char)) {
            e.preventDefault();
        }
    });

    // Validate card number on blur
    $(document).on('blur', '.wc-credit-card-form-card-number', function() {
        var cardNumber = $(this).val().replace(/\s+/g, '');
        if (cardNumber.length > 0 && cardNumber.length < 13) {
            $(this).css('border-color', '#dc3545');
        } else {
            $(this).css('border-color', 'rgba(148,163,184,.25)');
        }
    });

    // Validate expiry date on blur
    $(document).on('blur', '.wc-credit-card-form-card-expiry', function() {
        var expiry = $(this).val().replace(/\s+/g, '');
        var regex = /^(\d{2})\/(\d{2})$/;
        if (expiry && !regex.test(expiry)) {
            $(this).css('border-color', '#dc3545');
        } else {
            $(this).css('border-color', 'rgba(148,163,184,.25)');
        }
    });

    // Validate CVV on blur
    $(document).on('blur', '.wc-credit-card-form-card-cvc', function() {
        var cvv = $(this).val();
        if (cvv && (cvv.length < 3 || cvv.length > 4)) {
            $(this).css('border-color', '#dc3545');
        } else {
            $(this).css('border-color', 'rgba(148,163,184,.25)');
        }
    });
    
    // Đảm bảo payment box được hiển thị khi form được load
    setTimeout(function() {
        var creditCardRadio = $('input[value="credit_card"]:checked');
        if (creditCardRadio.length) {
            var paymentBox = creditCardRadio.closest('li.wc_payment_method').find('.payment_box');
            if (paymentBox.length && !paymentBox.is(':visible')) {
                paymentBox.show();
            }
        }
    }, 500);
});

