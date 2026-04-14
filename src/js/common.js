import "./polyfills.js";
import "./blocks.js";
import HystModal from 'hystmodal';
import { Fancybox } from "@fancyapps/ui/dist/fancybox/";
import lottie from "lottie-web";
import preloaderAnimation from "../img/preloader-geometria.json";
// import "../../node_modules/swiped-events/dist/swiped-events.min.js";

/* Тут можно писать код общий для всего проекта и требующий единого пространства имен */
(() => {

    Fancybox.bind("[data-fancybox]", {
        Video: {
            autoplay: false,
        },
    })


    let wpcf7Elem = document.querySelectorAll( '.wpcf7-form' );
    wpcf7Elem.forEach(function(elem) {
        elem.addEventListener( 'wpcf7mailsent', function( e ) {
            modalsForms.open('.js-modal-success');
        }, false );
    });

    // const hideHeader = document.querySelector('.js-header');

    let modalsForms = new HystModal({
        linkAttributeName: "data-hystmodal",
        catchFocus: true,
        waitTransitions: true,
        backscroll: true,
        // beforeOpen: function(modal){
        //     hideHeader.style.transform = 'translate(0, -100%)';
        // },
        // afterClose: function(modal){
        //     hideHeader.style.transform = 'translate(0, 0)';
        // }
    });
        

})();

function initFirstVisitPreloader() {
    const body = document.body;

    if (!body) return Promise.resolve();
    if (sessionStorage.getItem("geometria-preloader-shown")) return Promise.resolve();

    sessionStorage.setItem("geometria-preloader-shown", "1");

    const preloader = body.querySelector(".site-preloader");
    if (!preloader) return Promise.resolve();

    body.classList.add("is-preloader-active");
    preloader.classList.remove("is-leaving");
    preloader.classList.remove("is-visible");

    const logo = preloader.querySelector(".site-preloader__logo");
    if (!logo) return Promise.resolve();

    const animation = lottie.loadAnimation({
        container: logo,
        renderer: "svg",
        loop: false,
        autoplay: true,
        animationData: preloaderAnimation
    });

    return new Promise((resolve) => {
        let animationDone = false;
        let minDelayDone = false;
        let finished = false;

        const finalize = () => {
            if (finished || !animationDone || !minDelayDone) return;

            finished = true;
            preloader.classList.remove("is-visible");
            preloader.classList.add("is-leaving");

            window.setTimeout(() => {
                animation.destroy();
                preloader.classList.remove("is-leaving");
                body.classList.remove("is-preloader-active");
                resolve();
            }, 600);
        };

        requestAnimationFrame(() => {
            preloader.classList.add("is-visible");
        });

        animation.addEventListener("complete", () => {
            animationDone = true;
            finalize();
        });

        window.setTimeout(() => {
            minDelayDone = true;
            finalize();
        }, 1400);

        window.setTimeout(() => {
            animationDone = true;
            minDelayDone = true;
            finalize();
        }, 5000);
    });
}

function initPageTransitions() {
    const body = document.body;

    if (!body) return;

    const TRANSITION_DURATION = 650;

    const isModifiedEvent = (event) =>
        event.metaKey || event.ctrlKey || event.shiftKey || event.altKey || event.button !== 0;

    const shouldHandleLink = (link) => {
        if (!link) return false;
        if (link.target && link.target !== "_self") return false;
        if (link.hasAttribute("download")) return false;
        if (link.hasAttribute("data-hystmodal")) return false;

        const href = link.getAttribute("href");

        if (!href) return false;
        if (href.startsWith("#")) return false;
        if (href.startsWith("mailto:") || href.startsWith("tel:") || href.startsWith("javascript:")) return false;

        const url = new URL(link.href, window.location.href);

        if (url.origin !== window.location.origin) return false;
        if (url.href === window.location.href) return false;

        return true;
    };

    const revealPage = () => {
        body.classList.remove("is-page-loading", "is-page-leaving");
        requestAnimationFrame(() => {
            body.classList.add("is-page-ready");
        });
    };

    initFirstVisitPreloader().then(() => {
        revealPage();
    });

    window.addEventListener("pageshow", () => {
        revealPage();
    });

    document.addEventListener("click", (event) => {
        const link = event.target.closest("a");

        if (!shouldHandleLink(link) || isModifiedEvent(event)) return;

        event.preventDefault();

        body.classList.remove("is-page-loading", "is-page-ready");
        body.classList.add("is-page-leaving");

        window.setTimeout(() => {
            window.location.href = link.href;
        }, TRANSITION_DURATION);
    });
}

document.addEventListener("DOMContentLoaded", initPageTransitions);

/* Old services scroll logic disabled after GSAP rewrite.
document.addEventListener('DOMContentLoaded', () => {
    const serviceItems = document.querySelectorAll('.js-services-item');
    const firstItem = serviceItems[0];
    
    // Индекс текущего активного элемента (начинаем с 0 - первый элемент)
    let currentActiveIndex = 0;
    
    // Флаг: покинул ли пользователь верхнюю зону (где активен первый элемент)
    let hasLeftTopSection = false;

    function updateActiveClass() {
        const windowHeight = window.innerHeight;
        const centerPoint = windowHeight / 2;
        
        // Зона допуска: ±15% от высоты экрана для плавного переключения
        const tolerance = windowHeight * 0.15; 
        
        let foundIndex = -1;

        // 1. Проверяем, находимся ли мы все еще в верхней секции (для первого элемента)
        // Если скролл меньше половины высоты экрана, считаем, что мы "наверху"
        if (window.scrollY < windowHeight * 0.5) {
            hasLeftTopSection = false;
        } else {
            hasLeftTopSection = true;
        }

        // 2. Ищем элементы со второго по последний
        for (let i = 1; i < serviceItems.length; i++) {
            const item = serviceItems[i];
            const rect = item.getBoundingClientRect();
            const itemMiddle = rect.top + (rect.height / 2);

            // Проверка попадания в центр с допуском
            if (itemMiddle >= (centerPoint - tolerance) && itemMiddle <= (centerPoint + tolerance)) {
                foundIndex = i;
                break; 
            }
        }

        // 3. Логика выбора нового активного индекса
        let newActiveIndex;

        if (foundIndex !== -1) {
            // Если какой-то элемент (со 2-го и далее) попал в центр -> он активен
            newActiveIndex = foundIndex;
        } else if (!hasLeftTopSection) {
            // Если мы все еще наверху и никто другой не активен -> активен первый
            newActiveIndex = 0;
        } else {
            // САМОЕ ВАЖНОЕ ИЗМЕНЕНИЕ:
            // Мы ушли с верха, но сейчас ни один элемент не попал идеально в центр.
            // НЕ возвращаем активность первому элементу!
            // Оставляем текущий активный индекс без изменений.
            // Это предотвращает мигание при быстром скролле.
            return; 
        }

        // 4. Обновляем DOM только если индекс изменился
        if (newActiveIndex !== currentActiveIndex) {
            serviceItems[currentActiveIndex].classList.remove('is-active');
            serviceItems[newActiveIndex].classList.add('is-active');
            currentActiveIndex = newActiveIndex;
        }
    }

    // Оптимизированный слушатель скролла
    let isTicking = false;
    window.addEventListener('scroll', () => {
        if (!isTicking) {
            window.requestAnimationFrame(() => {
                updateActiveClass();
                isTicking = false;
            });
            isTicking = true;
        }
    });

    window.addEventListener('resize', updateActiveClass);
    
    // Запуск при загрузке
    updateActiveClass();
});
*/

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
  
