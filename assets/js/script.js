document.addEventListener("DOMContentLoaded", () => {
    // 🔹 Inisialisasi AOS (jika digunakan)
    if (typeof AOS !== "undefined") {
        AOS.init();
    }

    // Toggle burger menu
const burger = document.querySelector('.burger-menu');
const nav = document.querySelector('.nav-links');

burger.addEventListener('click', () => {
  burger.classList.toggle('open');
  nav.classList.toggle('open');
});

// Sticky header blur on scroll
window.addEventListener('scroll', () => {
  const header = document.querySelector('header');
  if (window.scrollY > 10) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
});

// Dropdown for mobile
document.querySelectorAll('.dropdown > a').forEach(link => {
  link.addEventListener('click', (e) => {
    const parentLi = link.parentElement;
    if (window.innerWidth <= 768) {
      e.preventDefault();
      parentLi.classList.toggle('active');
    }
  });
});


});
