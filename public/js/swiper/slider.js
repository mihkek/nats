this.swiper = new window.Swiper('.swiper-container', {
cssMode: true,
slidesPerView: 4,
spaceBetween: 40,
breakpoints: {
320: {
slidesPerView: 1,
spaceBetween: 20,
},
480: {
slidesPerView: 1,
spaceBetween: 20,
},
640: {
slidesPerView: 4,
spaceBetween: 40,
}
},
navigation: {
nextEl: '.swiper-button-next',
prevEl: '.swiper-button-prev',
},
/*pagination: {
el: '.swiper-pagination'
},*/
mousewheel: false,
keyboard: true,
});
