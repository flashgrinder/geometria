import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function initCasesAnimation() {
    const section = document.querySelector(".cases--home");

    if (!section) return;

    const items = gsap.utils.toArray(".cases--home .cases__item");

    if (!items.length) return;

    items.forEach((item) => {
        const isStats = item.classList.contains("cases__item--stats");
        const isCta = item.classList.contains("cases__item--cta");

        const fromState = {
            y: 80,
            autoAlpha: 0
        };

        if (isStats) {
            fromState.x = 36;
            fromState.y = 56;
        }

        if (isCta) {
            fromState.x = -36;
            fromState.y = 56;
        }

        gsap.set(item, {
            ...fromState,
            willChange: "transform, opacity",
            force3D: true
        });

        ScrollTrigger.create({
            trigger: item,
            start: "top 88%",
            once: true,
            onEnter: () => {
                gsap.to(item, {
                    x: 0,
                    y: 0,
                    autoAlpha: 1,
                    duration: 0.95,
                    ease: "power3.out",
                    overwrite: "auto",
                    onComplete: () => {
                        gsap.set(item, { clearProps: "willChange" });
                    }
                });
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", initCasesAnimation);
