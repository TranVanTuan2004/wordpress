// script front-page - chạy khi DOM ready
document.addEventListener('DOMContentLoaded', function() {
  // change image when click button prev, next in slider class
  const mainSlides = document.querySelectorAll(".slides a");
  if (mainSlides.length > 0) {
    let currentMainIndex = 0;
    let autoMainInterval;

    function showMainSlide(index) {
      mainSlides.forEach((slide) => slide.classList.remove("active"));
      mainSlides[index].classList.add("active");
    }

    function nextMainSlide() {
      currentMainIndex = (currentMainIndex + 1) % mainSlides.length;
      showMainSlide(currentMainIndex);
    }

    function prevMainSlide() {
      currentMainIndex =
          (currentMainIndex - 1 + mainSlides.length) % mainSlides.length;
      showMainSlide(currentMainIndex);
    }

    const nextBtn = document.querySelector(".next");
    const prevBtn = document.querySelector(".prev");

    if (nextBtn) {
      nextBtn.addEventListener("click", () => {
        nextMainSlide();
        resetMainAuto();
      });
    }

    if (prevBtn) {
      prevBtn.addEventListener("click", () => {
        prevMainSlide();
        resetMainAuto();
      });
    }

    function startMainAuto() {
      autoMainInterval = setInterval(nextMainSlide, 3000);
    }

    function resetMainAuto() {
      clearInterval(autoMainInterval);
      startMainAuto();
    }

    showMainSlide(currentMainIndex);
    startMainAuto();
  }

  // change option in booking class
  const select = document.getElementById("cinema");
  if (select) {
    select.addEventListener("change", function () {
      select.classList.toggle("active", select.value !== "");
    });
  }

  // ===== MOVIE LIST 1 =====
  const movieList1 = document.getElementById("movieList1");
  if (movieList1) {
    let currentGroup1 = 0;
    const cardsPerGroup1 = 4;
    const totalCards1 = movieList1.children.length;
    const totalGroups1 = Math.ceil(totalCards1 / cardsPerGroup1);

    function scrollMovies1(direction) {
      currentGroup1 += direction;
      if (currentGroup1 < 0) currentGroup1 = 0;
      if (currentGroup1 >= totalGroups1) currentGroup1 = totalGroups1 - 1;

      const offset = currentGroup1 * 100;
      movieList1.style.transform = `translateX(-${offset}%)`;
    }
  }

  // ===== MOVIE LIST 2 =====
  const movieList2 = document.getElementById("movieList2");
  if (movieList2) {
    let currentGroup2 = 0;
    const cardsPerGroup2 = 4;
    const totalCards2 = movieList2.children.length;
    const totalGroups2 = Math.ceil(totalCards2 / cardsPerGroup2);

    function scrollMovies2(direction) {
      currentGroup2 += direction;
      if (currentGroup2 < 0) currentGroup2 = 0;
      if (currentGroup2 >= totalGroups2) currentGroup2 = totalGroups2 - 1;

      const offset = currentGroup2 * 100;
      movieList2.style.transform = `translateX(-${offset}%)`;
    }
  }

  // promotion slider
  const promotionSlides = document.querySelectorAll(
  ".promotion-slides .promotion-slide"
  );
  const promotionPrev = document.querySelector(".promotion-prev");
  const promotionNext = document.querySelector(".promotion-next");
  
  if (promotionSlides.length > 0 && promotionPrev && promotionNext) {
    let currentPromotionIndex = 0;
    let autoPromotionInterval;

    function showPromotionSlide(index) {
      promotionSlides.forEach((slide, i) => {
        slide.classList.toggle("promotion-active", i === index);
      });
    }

    function nextPromotionSlide() {
      currentPromotionIndex =
          (currentPromotionIndex + 1) % promotionSlides.length;
      showPromotionSlide(currentPromotionIndex);
    }

    function prevPromotionSlide() {
      currentPromotionIndex =
          (currentPromotionIndex - 1 + promotionSlides.length) %
          promotionSlides.length;
      showPromotionSlide(currentPromotionIndex);
    }

    promotionPrev.addEventListener("click", () => {
      prevPromotionSlide();
      resetPromotionAuto();
    });

    promotionNext.addEventListener("click", () => {
      nextPromotionSlide();
      resetPromotionAuto();
    });

    function startPromotionAuto() {
      autoPromotionInterval = setInterval(nextPromotionSlide, 3000);
    }

    function resetPromotionAuto() {
      clearInterval(autoPromotionInterval);
      startPromotionAuto();
    }

    showPromotionSlide(currentPromotionIndex);
    startPromotionAuto();
  }
});


// responsive

// navbar header
function toggleMenu() {
  var actions = document.getElementById("actions");
  if (actions) {
    actions.classList.toggle("show");
  }
}

// Xử lý search form
document.addEventListener('DOMContentLoaded', function() {
  var searchForm = document.querySelector('.action-search');
  var searchInput = document.getElementById('search');
  
  if (searchForm && searchInput) {
    // Xử lý Enter key
    searchInput.addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        searchForm.submit();
      }
    });
    
    // Xử lý submit form
    searchForm.addEventListener('submit', function(e) {
      var query = searchInput.value.trim();
      if (!query) {
        e.preventDefault();
        searchInput.focus();
      }
    });
  }

  // Xử lý user dropdown
  var root = document.querySelector('.action-user');
  if (root) {
    var btn = root.querySelector('.user-btn');
    var dropdown = root.querySelector('.user-dropdown');
    
    if (btn && dropdown) {
      btn.addEventListener('click', function(e) {
        e.stopPropagation();
        var isOpen = root.classList.toggle('is-open');
        btn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      });
      
      // Đóng dropdown khi click bên ngoài
      document.addEventListener('click', function(e) {
        if (!root.contains(e.target)) {
          root.classList.remove('is-open');
          if (btn) btn.setAttribute('aria-expanded', 'false');
        }
      });
      
      // Đóng dropdown khi click vào item
      var items = dropdown.querySelectorAll('.user-dropdown__item');
      items.forEach(function(item) {
        item.addEventListener('click', function() {
          setTimeout(function() {
            root.classList.remove('is-open');
            if (btn) btn.setAttribute('aria-expanded', 'false');
          }, 100);
        });
      });
    }
  }
});