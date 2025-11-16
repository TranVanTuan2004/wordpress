// single-movie
function toggleCinema(element) {
  // Nếu đang mở thì đóng lại
  if (element.classList.contains('active')) {
    element.classList.remove('active');
  } else {
    // Đóng tất cả
    document.querySelectorAll('.cinema-item').forEach(item => {
      item.classList.remove('active');
    });
    // Mở cái được click
    element.classList.add('active');
  }
}