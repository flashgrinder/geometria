import Swiper from "swiper"
import { Navigation, Pagination } from "swiper/modules";

(() => {

    const passesSlider = new Swiper('.js-passes-slider', {
        modules: [Navigation, Pagination],
        slidesPerView: 1,
        spaceBetween: 10,
        pagination: {
            el: '.passes__swiper-pagination',
            clickable: true,
        },
        navigation: {
            prevEl: document.querySelector('.passes__swiper-button-prev'),
            nextEl: document.querySelector('.passes__swiper-button-next')
        },

    });

})();