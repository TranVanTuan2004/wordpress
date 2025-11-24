jQuery(document).ready(function($) {
    $('.favorite-btn').on('click', function(e) {
        e.preventDefault();
        
        var $btn = $(this);
        var movieId = $btn.data('movie-id');
        
        if (!$btn.data('movie-id') || $btn.prop('disabled')) {
            alert(movieFavorite.login_required);
            return;
        }
        
        // Disable button during request
        $btn.prop('disabled', true);
        
        $.ajax({
            url: movieFavorite.ajaxurl,
            type: 'POST',
            data: {
                action: 'movie_toggle_favorite',
                movie_id: movieId,
                nonce: movieFavorite.nonce
            },
            success: function(response) {
                if (response.success) {
                    var isFavorite = response.data.is_favorite;
                    
                    // Update button state
                    if (isFavorite) {
                        $btn.addClass('is-favorite');
                        $btn.find('i').removeClass('bx-heart').addClass('bxs-heart');
                        $btn.find('.favorite-text').text('Đã yêu thích');
                    } else {
                        $btn.removeClass('is-favorite');
                        $btn.find('i').removeClass('bxs-heart').addClass('bx-heart');
                        $btn.find('.favorite-text').text('Yêu thích');
                    }
                    
                    // Show notification (optional)
                    if (typeof showNotification === 'function') {
                        showNotification(response.data.message);
                    }
                } else {
                    alert(response.data.message || 'Có lỗi xảy ra');
                }
            },
            error: function() {
                alert('Có lỗi xảy ra khi kết nối server');
            },
            complete: function() {
                $btn.prop('disabled', false);
            }
        });
    });
});

