jQuery(document).ready(function ($) {
    const $cinema = $('#booking-cinema');
    const $movie = $('#booking-movie');
    const $date = $('#booking-date');
    const $showtime = $('#booking-showtime');
    const $bookBtn = $('#btn-booking');

    // Reset dependent dropdowns
    function resetDropdown($dropdown, placeholder) {
        $dropdown.html(`<option value="">${placeholder}</option>`);
        $dropdown.prop('disabled', true);
    }

    // Cinema selection handler
    $cinema.on('change', function () {
        const cinemaId = $(this).val();

        // Reset dependent dropdowns
        resetDropdown($movie, '2. Chọn phim');
        resetDropdown($date, '3. Chọn ngày');
        resetDropdown($showtime, '4. Chọn suất');

        if (!cinemaId) return;

        // Show loading
        $movie.html('<option value="">Đang tải...</option>');

        // Fetch movies for selected cinema
        $.ajax({
            url: bookingAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_movies_by_cinema',
                cinema_id: cinemaId,
                nonce: bookingAjax.nonce
            },
            success: function (response) {
                if (response.success && response.data.movies.length > 0) {
                    let options = '<option value="">2. Chọn phim</option>';
                    response.data.movies.forEach(function (movie) {
                        options += `<option value="${movie.id}">${movie.title}</option>`;
                    });
                    $movie.html(options);
                    $movie.prop('disabled', false);
                } else {
                    $movie.html('<option value="">Không có phim nào</option>');
                }
            },
            error: function () {
                $movie.html('<option value="">Lỗi tải dữ liệu</option>');
            }
        });
    });

    // Movie selection handler
    $movie.on('change', function () {
        const cinemaId = $cinema.val();
        const movieId = $(this).val();

        // Reset dependent dropdowns
        resetDropdown($date, '3. Chọn ngày');
        resetDropdown($showtime, '4. Chọn suất');

        if (!movieId) return;

        // Show loading
        $date.html('<option value="">Đang tải...</option>');

        // Fetch dates for selected cinema + movie
        $.ajax({
            url: bookingAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_dates_by_cinema_movie',
                cinema_id: cinemaId,
                movie_id: movieId,
                nonce: bookingAjax.nonce
            },
            success: function (response) {
                if (response.success && response.data.dates.length > 0) {
                    let options = '<option value="">3. Chọn ngày</option>';
                    response.data.dates.forEach(function (date) {
                        options += `<option value="${date.value}">${date.label}</option>`;
                    });
                    $date.html(options);
                    $date.prop('disabled', false);
                } else {
                    $date.html('<option value="">Không có ngày chiếu</option>');
                }
            },
            error: function () {
                $date.html('<option value="">Lỗi tải dữ liệu</option>');
            }
        });
    });

    // Date selection handler
    $date.on('change', function () {
        const cinemaId = $cinema.val();
        const movieId = $movie.val();
        const date = $(this).val();

        // Reset showtime dropdown
        resetDropdown($showtime, '4. Chọn suất');

        if (!date) return;

        // Show loading
        $showtime.html('<option value="">Đang tải...</option>');

        // Fetch showtimes for selected cinema + movie + date
        $.ajax({
            url: bookingAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'get_showtimes',
                cinema_id: cinemaId,
                movie_id: movieId,
                date: date,
                nonce: bookingAjax.nonce
            },
            success: function (response) {
                if (response.success && response.data.showtimes.length > 0) {
                    let options = '<option value="">4. Chọn suất</option>';
                    response.data.showtimes.forEach(function (showtime) {
                        options += `<option value="${showtime.value}">${showtime.label}</option>`;
                    });
                    $showtime.html(options);
                    $showtime.prop('disabled', false);
                } else {
                    $showtime.html('<option value="">Không có suất chiếu</option>');
                }
            },
            error: function () {
                $showtime.html('<option value="">Lỗi tải dữ liệu</option>');
            }
        });
    });

    // Booking button handler
    $bookBtn.on('click', function (e) {
        e.preventDefault();

        const cinemaId = $cinema.val();
        const movieId = $movie.val();
        const date = $date.val();
        const time = $showtime.val();

        // Validation
        if (!cinemaId) {
            alert('Vui lòng chọn rạp');
            return;
        }
        if (!movieId) {
            alert('Vui lòng chọn phim');
            return;
        }
        if (!date) {
            alert('Vui lòng chọn ngày');
            return;
        }
        if (!time) {
            alert('Vui lòng chọn suất chiếu');
            return;
        }

        // Build booking URL
        const bookingUrl = bookingAjax.bookingPageUrl +
            '?cinema=' + cinemaId +
            '&movie=' + movieId +
            '&date=' + date +
            '&time=' + time;

        // Redirect to booking page
        window.location.href = bookingUrl;
    });
});
