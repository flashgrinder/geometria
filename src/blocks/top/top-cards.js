import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function initTopCardsAnimation() {
    const grid = document.querySelector(".top__grid");

    if (!grid) return;

    const cards = gsap.utils.toArray(".top__card");

    if (!cards.length) return;

    const regularCards = cards.filter((card) => !card.classList.contains("top__card--large"));
    const largeCard = cards.find((card) => card.classList.contains("top__card--large"));

    gsap.set(cards, {
        autoAlpha: 0,
        y: 56,
        willChange: "transform, opacity",
        force3D: true
    });

    if (largeCard) {
        gsap.set(largeCard, {
            autoAlpha: 0,
            y: 72,
            scale: 0.96,
            willChange: "transform, opacity",
            force3D: true
        });
    }

    const tl = gsap.timeline({
        paused: true,
        defaults: {
            ease: "power3.out"
        },
        onComplete: () => {
            gsap.set(cards, { clearProps: "willChange" });
        }
    });

    if (regularCards.length) {
        tl.to(regularCards, {
            autoAlpha: 1,
            y: 0,
            duration: 0.85,
            stagger: {
                each: 0.1,
                from: "start"
            }
        });
    }

    if (largeCard) {
        tl.to(largeCard, {
            autoAlpha: 1,
            y: 0,
            scale: 1,
            duration: 1,
            ease: "power2.out"
        }, regularCards.length ? "-=0.08" : 0);
    }

    ScrollTrigger.create({
        trigger: grid,
        start: "top 82%",
        once: true,
        onEnter: () => tl.play()
    });
}

document.addEventListener("DOMContentLoaded", initTopCardsAnimation);
