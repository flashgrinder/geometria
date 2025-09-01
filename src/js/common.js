import "./polyfills.js";
import "./blocks.js";
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
// import "../../node_modules/swiped-events/dist/swiped-events.min.js";

/* Тут можно писать код общий для всего проекта и требующий единого пространства имен */
(() => {

    Fancybox.bind("[data-fancybox]", {
        Video: {
            autoplay: false,
        },
    })

})();

// --- Плавный скролл до блока --- //
// document.querySelectorAll('[data-scroll]').forEach(link => {
//     link.addEventListener('click', function(e) {
//       e.preventDefault();
//       const targetId = this.getAttribute('href').substring(1);
//       const offsetTop = 160;
//       const targetElement = document.getElementById(targetId);
  
//       if (targetElement) {
//         const elementPosition = targetElement.getBoundingClientRect().top;
//         const offsetPosition = elementPosition + window.pageYOffset - offsetTop;
  
//         window.scrollTo({
//           top: offsetPosition,
//           behavior: 'smooth'
//         });
//       }
//     });
//   });
  
