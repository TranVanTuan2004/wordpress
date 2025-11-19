// script front-page
// change image when click button prev, next in slider class
const mainSlides = document.querySelectorAll(".slides a");
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

document.querySelector(".next").addEventListener("click", () => {
nextMainSlide();
resetMainAuto();
});

document.querySelector(".prev").addEventListener("click", () => {
prevMainSlide();
resetMainAuto();
});

function startMainAuto() {
autoMainInterval = setInterval(nextMainSlide, 3000);
}

function resetMainAuto() {
clearInterval(autoMainInterval);
startMainAuto();
}

showMainSlide(currentMainIndex);
startMainAuto();

// change option in booking class
const select = document.getElementById("cinema");
select.addEventListener("change", function () {
select.classList.toggle("active", select.value !== "");
});

// ===== MOVIE LIST 1 =====
let currentGroup1 = 0;
const movieList1 = document.getElementById("movieList1");
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

// ===== MOVIE LIST 2 =====
let currentGroup2 = 0;
const movieList2 = document.getElementById("movieList2");
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

// promotion slider
const promotionSlides = document.querySelectorAll(
".promotion-slides .promotion-slide"
);
const promotionPrev = document.querySelector(".promotion-prev");
const promotionNext = document.querySelector(".promotion-next");
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


// responsive

// navbar header
  function toggleMenu() {
    document.getElementById("actions").classList.toggle("show");
  }