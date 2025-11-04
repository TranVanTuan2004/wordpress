/**
 * Movie Booking System - Frontend Scripts
 */

(function($) {
    'use strict';
    
    // Initialize on document ready
    $(document).ready(function() {
        initMovieFilters();
        initSeatSelection();
        initBookingModal();
    });
    
    /**
     * Movie genre filters
     */
    function initMovieFilters() {
        $('.mbs-genre-btn').on('click', function() {
            const genre = $(this).data('genre');
            
            // Update active state
            $('.mbs-genre-btn').removeClass('active');
            $(this).addClass('active');
            
            // Filter movies
            if (genre === 'all') {
                $('.mbs-movie-card').fadeIn(300);
            } else {
                $('.mbs-movie-card').each(function() {
                    const movieGenres = $(this).data('genres');
                    if (movieGenres && movieGenres.includes(genre)) {
                        $(this).fadeIn(300);
                    } else {
                        $(this).fadeOut(300);
                    }
                });
            }
        });
    }
    
    /**
     * Seat selection functionality
     */
    function initSeatSelection() {
        if (!$('.mbs-seat-selection').length) return;
        
        const selectedSeats = [];
        const showtimeId = $('input[name="showtime_id"]').val();
        
        // Seat click handler
        $(document).on('click', '.mbs-seat:not(.mbs-seat-booked):not(:disabled)', function() {
            const $seat = $(this);
            const seatData = {
                seat_number: $seat.data('seat'),
                seat_type: $seat.data('type'),
                seat_price: parseFloat($seat.data('price'))
            };
            
            if ($seat.hasClass('mbs-seat-selected')) {
                // Deselect seat
                $seat.removeClass('mbs-seat-selected');
                const index = selectedSeats.findIndex(s => s.seat_number === seatData.seat_number);
                if (index > -1) {
                    selectedSeats.splice(index, 1);
                }
            } else {
                // Select seat
                $seat.addClass('mbs-seat-selected');
                selectedSeats.push(seatData);
            }
            
            updateBookingSummary(selectedSeats);
        });
        
        // Continue button
        $('#mbs-continue-btn').on('click', function() {
            if (selectedSeats.length === 0) return;
            
            // Prepare seats data
            $('#mbs-seats-input').val(JSON.stringify(selectedSeats));
            
            // Update modal summary
            updateModalSummary(selectedSeats);
            
            // Show modal
            $('#mbs-customer-modal').fadeIn(300);
        });
        
        // Auto-refresh booked seats
        if (showtimeId) {
            setInterval(function() {
                refreshBookedSeats(showtimeId, selectedSeats);
            }, 30000); // Every 30 seconds
        }
    }
    
    /**
     * Update booking summary
     */
    function updateBookingSummary(seats) {
        if (seats.length === 0) {
            $('#mbs-selected-seats-list').html('<span class="mbs-no-seats">Chưa chọn ghế</span>');
            $('#mbs-total-price').text('0đ');
            $('#mbs-continue-btn').prop('disabled', true);
            return;
        }
        
        // Update seat list
        const seatsList = seats.map(s => 
            `<span class="mbs-seat-tag">${s.seat_number}</span>`
        ).join('');
        $('#mbs-selected-seats-list').html(seatsList);
        
        // Calculate and update total
        const total = seats.reduce((sum, s) => sum + s.seat_price, 0);
        $('#mbs-total-price').text(formatPrice(total));
        
        // Enable continue button
        $('#mbs-continue-btn').prop('disabled', false);
    }
    
    /**
     * Update modal summary
     */
    function updateModalSummary(seats) {
        $('#mbs-modal-seats-count').text(seats.length);
        $('#mbs-modal-seats-list').text(seats.map(s => s.seat_number).join(', '));
        
        const total = seats.reduce((sum, s) => sum + s.seat_price, 0);
        $('#mbs-modal-total-price').text(formatPrice(total));
    }
    
    /**
     * Refresh booked seats
     */
    function refreshBookedSeats(showtimeId, selectedSeats) {
        $.ajax({
            url: mbs_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'mbs_get_booked_seats',
                nonce: mbs_ajax.nonce,
                showtime_id: showtimeId
            },
            success: function(response) {
                if (response.success && response.data.booked_seats) {
                    const bookedSeats = response.data.booked_seats;
                    
                    $('.mbs-seat').each(function() {
                        const $seat = $(this);
                        const seatNumber = $seat.data('seat');
                        const isSelected = selectedSeats.some(s => s.seat_number === seatNumber);
                        
                        // Mark as booked if not selected by current user
                        if (bookedSeats.includes(seatNumber) && !isSelected) {
                            $seat.addClass('mbs-seat-booked').prop('disabled', true);
                        }
                    });
                }
            }
        });
    }
    
    /**
     * Booking modal functionality
     */
    function initBookingModal() {
        // Close modal
        $('.mbs-modal-close').on('click', function() {
            $('#mbs-customer-modal').fadeOut(300);
        });
        
        // Close on outside click
        $(document).on('click', '.mbs-modal', function(e) {
            if ($(e.target).hasClass('mbs-modal')) {
                $(this).fadeOut(300);
            }
        });
        
        // Form submission
        $('#mbs-booking-form').on('submit', function(e) {
            e.preventDefault();
            submitBooking($(this));
        });
    }
    
    /**
     * Submit booking
     */
    function submitBooking($form) {
        const $submitBtn = $form.find('button[type="submit"]');
        const originalText = $submitBtn.text();
        
        // Disable button and show loading
        $submitBtn.prop('disabled', true).text('Đang xử lý...');
        
        const formData = {
            action: 'mbs_create_booking',
            nonce: mbs_ajax.nonce,
            showtime_id: $form.find('input[name="showtime_id"]').val(),
            customer_name: $form.find('#customer_name').val(),
            customer_email: $form.find('#customer_email').val(),
            customer_phone: $form.find('#customer_phone').val(),
            seats: $form.find('#mbs-seats-input').val()
        };
        
        $.ajax({
            url: mbs_ajax.ajax_url,
            type: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    // Show success message
                    $form.hide();
                    $('#mbs-booking-code').text(response.data.booking_code);
                    $('#mbs-booking-result').fadeIn(300);
                    
                    // Optional: Track conversion for analytics
                    if (typeof gtag !== 'undefined') {
                        gtag('event', 'purchase', {
                            transaction_id: response.data.booking_code,
                            value: calculateTotal(),
                            currency: 'VND'
                        });
                    }
                } else {
                    // Show error
                    showNotification(response.data.message || 'Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                    $submitBtn.prop('disabled', false).text(originalText);
                }
            },
            error: function(xhr, status, error) {
                console.error('Booking error:', error);
                showNotification('Có lỗi xảy ra. Vui lòng thử lại.', 'error');
                $submitBtn.prop('disabled', false).text(originalText);
            }
        });
    }
    
    /**
     * Calculate total from selected seats
     */
    function calculateTotal() {
        try {
            const seats = JSON.parse($('#mbs-seats-input').val());
            return seats.reduce((sum, s) => sum + parseFloat(s.seat_price), 0);
        } catch (e) {
            return 0;
        }
    }
    
    /**
     * Show notification
     */
    function showNotification(message, type = 'info') {
        const $notification = $('<div class="mbs-notification mbs-notification-' + type + '">')
            .text(message)
            .appendTo('body');
        
        setTimeout(function() {
            $notification.addClass('mbs-notification-show');
        }, 100);
        
        setTimeout(function() {
            $notification.removeClass('mbs-notification-show');
            setTimeout(function() {
                $notification.remove();
            }, 300);
        }, 3000);
    }
    
    /**
     * Format price
     */
    function formatPrice(price) {
        return new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        }).format(price).replace('₫', 'đ');
    }
    
})(jQuery);

