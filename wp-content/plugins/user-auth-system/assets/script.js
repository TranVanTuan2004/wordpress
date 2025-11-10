jQuery(document).ready(function($) {
    
    // ==========================================
    // LOGIN FORM
    // ==========================================
    $('#uas-login-form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $button = $form.find('button[type="submit"]');
        const $buttonText = $button.find('.button-text');
        const $buttonLoader = $button.find('.button-loader');
        const $message = $('#login-message');
        
        // Show loading
        $button.prop('disabled', true);
        $buttonText.hide();
        $buttonLoader.show();
        $message.removeClass('success error').hide();
        
        // Get form data
        const formData = {
            action: 'uas_login',
            nonce: uasAjax.nonce,
            username: $form.find('input[name="username"]').val(),
            password: $form.find('input[name="password"]').val(),
            remember: $form.find('input[name="remember"]').is(':checked')
        };
        
        // AJAX request
        $.ajax({
            url: uasAjax.ajaxurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $message.addClass('success').text(response.data.message).fadeIn();
                    
                    // Redirect after 1 second
                    setTimeout(function() {
                        window.location.href = response.data.redirect;
                    }, 1000);
                } else {
                    $message.addClass('error').text(response.data.message).fadeIn();
                    $button.prop('disabled', false);
                    $buttonText.show();
                    $buttonLoader.hide();
                }
            },
            error: function() {
                $message.addClass('error').text('Có lỗi xảy ra, vui lòng thử lại!').fadeIn();
                $button.prop('disabled', false);
                $buttonText.show();
                $buttonLoader.hide();
            }
        });
    });
    
    // ==========================================
    // REGISTER FORM
    // ==========================================
    $('#uas-register-form').on('submit', function(e) {
        e.preventDefault();
        
        const $form = $(this);
        const $button = $form.find('button[type="submit"]');
        const $buttonText = $button.find('.button-text');
        const $buttonLoader = $button.find('.button-loader');
        const $message = $('#register-message');
        
        // Show loading
        $button.prop('disabled', true);
        $buttonText.hide();
        $buttonLoader.show();
        $message.removeClass('success error').hide();
        
        // Get form data
        const formData = {
            action: 'uas_register',
            nonce: uasAjax.nonce,
            username: $form.find('input[name="username"]').val(),
            email: $form.find('input[name="email"]').val(),
            password: $form.find('input[name="password"]').val(),
            confirm_password: $form.find('input[name="confirm_password"]').val()
        };
        
        // AJAX request
        $.ajax({
            url: uasAjax.ajaxurl,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    $message.addClass('success').text(response.data.message).fadeIn();
                    
                    // Redirect after 1 second
                    setTimeout(function() {
                        window.location.href = response.data.redirect;
                    }, 1000);
                } else {
                    $message.addClass('error').text(response.data.message).fadeIn();
                    $button.prop('disabled', false);
                    $buttonText.show();
                    $buttonLoader.hide();
                }
            },
            error: function() {
                $message.addClass('error').text('Có lỗi xảy ra, vui lòng thử lại!').fadeIn();
                $button.prop('disabled', false);
                $buttonText.show();
                $buttonLoader.hide();
            }
        });
    });
    
    // ==========================================
    // LOGOUT
    // ==========================================
    $('#uas-logout-btn').on('click', function(e) {
        e.preventDefault();
        
        const $button = $(this);
        
        if (!confirm('Bạn có chắc muốn đăng xuất?')) {
            return;
        }
        
        // Show loading
        $button.prop('disabled', true).text('Đang đăng xuất...');
        
        // AJAX request
        $.ajax({
            url: uasAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'uas_logout',
                nonce: uasAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    window.location.href = response.data.redirect;
                }
            },
            error: function() {
                alert('Có lỗi xảy ra!');
                $button.prop('disabled', false).text('Đăng Xuất');
            }
        });
    });
    
    // ==========================================
    // INPUT ANIMATIONS
    // ==========================================
    $('.uas-form-group input').on('focus', function() {
        $(this).parent().addClass('focused');
    });
    
    $('.uas-form-group input').on('blur', function() {
        if ($(this).val() === '') {
            $(this).parent().removeClass('focused');
        }
    });
    
});

