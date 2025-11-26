// Auto-scroll for movie carousels on front-page
document.addEventListener('DOMContentLoaded', function () {

    // ===== MOVIE LIST 1 AUTO-SCROLL =====
    const movieList1 = document.getElementById("movieList1");
    if (movieList1) {
        let currentGroup1 = 0;
        let direction1 = 1; // 1 = forward, -1 = backward
        const cardsPerGroup1 = 3;
        const totalCards1 = movieList1.children.length;
        const totalGroups1 = Math.ceil(totalCards1 / cardsPerGroup1);
        let autoInterval1;

        // Scroll function - ping-pong between group 0 and 1
        function autoScrollMovies1() {
            currentGroup1 += direction1;

            // Reverse direction when reaching boundaries (only between 0 and 1)
            if (currentGroup1 >= Math.min(2, totalGroups1)) {
                currentGroup1 = Math.min(1, totalGroups1 - 1);
                direction1 = -1;
            } else if (currentGroup1 < 0) {
                currentGroup1 = 0;
                direction1 = 1;
            }

            const offset = currentGroup1 * 100;
            movieList1.style.transform = `translateX(-${offset}%)`;
        }

        // Start auto scroll
        function startAutoScroll1() {
            autoInterval1 = setInterval(autoScrollMovies1, 4000);
        }

        // Reset auto scroll
        function resetAutoScroll1() {
            clearInterval(autoInterval1);
            startAutoScroll1();
        }

        // Pause on hover
        const movieSection1 = movieList1.closest('.movie-section');
        if (movieSection1) {
            movieSection1.addEventListener('mouseenter', () => {
                clearInterval(autoInterval1);
            });
            movieSection1.addEventListener('mouseleave', () => {
                startAutoScroll1();
            });
        }

        // Override global scrollMovies1 to reset auto-scroll
        const originalScrollMovies1 = window.scrollMovies1;
        window.scrollMovies1 = function (direction) {
            if (typeof originalScrollMovies1 === 'function') {
                originalScrollMovies1(direction);
            }
            resetAutoScroll1();
        };

        // Start
        startAutoScroll1();
    }

    // ===== MOVIE LIST 2 AUTO-SCROLL =====
    const movieList2 = document.getElementById("movieList2");
    if (movieList2) {
        let currentGroup2 = 0;
        let direction2 = 1; // 1 = forward, -1 = backward
        const cardsPerGroup2 = 3;
        const totalCards2 = movieList2.children.length;
        const totalGroups2 = Math.ceil(totalCards2 / cardsPerGroup2);
        let autoInterval2;

        // Scroll function - ping-pong between group 0 and 1
        function autoScrollMovies2() {
            currentGroup2 += direction2;

            // Reverse direction when reaching boundaries (only between 0 and 1)
            if (currentGroup2 >= Math.min(2, totalGroups2)) {
                currentGroup2 = Math.min(1, totalGroups2 - 1);
                direction2 = -1;
            } else if (currentGroup2 < 0) {
                currentGroup2 = 0;
                direction2 = 1;
            }

            const offset = currentGroup2 * 100;
            movieList2.style.transform = `translateX(-${offset}%)`;
        }

        // Start auto scroll
        function startAutoScroll2() {
            autoInterval2 = setInterval(autoScrollMovies2, 4000);
        }

        // Reset auto scroll
        function resetAutoScroll2() {
            clearInterval(autoInterval2);
            startAutoScroll2();
        }

        // Pause on hover
        const movieSection2 = movieList2.closest('.movie-section');
        if (movieSection2) {
            movieSection2.addEventListener('mouseenter', () => {
                clearInterval(autoInterval2);
            });
            movieSection2.addEventListener('mouseleave', () => {
                startAutoScroll2();
            });
        }

        // Override global scrollMovies2 to reset auto-scroll
        const originalScrollMovies2 = window.scrollMovies2;
        window.scrollMovies2 = function (direction) {
            if (typeof originalScrollMovies2 === 'function') {
                originalScrollMovies2(direction);
            }
            resetAutoScroll2();
        };

        // Start
        startAutoScroll2();
    }
});
