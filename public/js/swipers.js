const plantsThumbs = new Swiper(".swiper-plants-thumbs", {
  direction: "vertical",
  slidesPerView: 4,
  spaceBetween: 20,
  watchSlidesProgress: true,
  speed: 800,

  breakpoints: {
    320: {
      direction: "horizontal",
      spaceBetween: 12,
    },
    768: {},
  },
});

const plantsSwiper = new Swiper(".swiper-plants", {
  slidesPerView: 1,
  speed: 800,
  grabCursor: true,
  thumbs: {
    swiper: plantsThumbs,
  },
});

const specificationsSwiper = new Swiper(".specifications-swiper", {
  slidesPerView: 2,
  spaceBetween: 20,
  speed: 800,
  grabCursor: true,

  breakpoints: {
    320: {
      spaceBetween: 12,
      slidesPerView: 1.1,
      centeredSlides: true,
    },
    768: {},
  },
});
