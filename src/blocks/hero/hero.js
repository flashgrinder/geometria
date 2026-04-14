import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function initHeroScene() {
    const section = document.querySelector(".hero");

    if (!section) return;

    const scene = section.querySelector(".hero__container");
    const container = section.querySelector(".hero__container");
    const leftTitle = section.querySelector(".hero-side__title--blurred");
    const problemItems = gsap.utils.toArray(section.querySelectorAll(".hero__problem-item"));
    const rightTitle = section.querySelector(".hero__right .hero__title");
    const formulaLeft = section.querySelector(".hero__formula-item--left");
    const formulaOperator = section.querySelector(".hero__formula-operator");
    const formulaRight = section.querySelector(".hero__formula-item--right");
    const formulaEquals = section.querySelector(".hero__formula-equals");
    const formulaResult = section.querySelector(".hero__formula-result");

    if (!scene || !container) return;

    const targets = [
        container,
        leftTitle,
        ...problemItems,
        rightTitle,
        formulaLeft,
        formulaOperator,
        formulaRight,
        formulaEquals,
        formulaResult
    ].filter(Boolean);

    gsap.set(targets, { clearProps: "all" });

    let introDelay = null;

    const tl = gsap.timeline({
        paused: true,
        defaults: {
            ease: "power2.out"
        }
    });

    tl.fromTo(container, {
        y: 28,
        autoAlpha: 0.72
    }, {
        y: 0,
        autoAlpha: 1,
        duration: 0.7
    });

    if (rightTitle) {
        tl.fromTo(rightTitle, {
            y: 42,
            autoAlpha: 0
        }, {
            y: 0,
            autoAlpha: 1,
            duration: 0.62
        }, 0.2);
    }

    if (leftTitle) {
        tl.to(leftTitle, {
            y: -18,
            opacity: 0.42,
            filter: "blur(6px)",
            duration: 0.65
        }, 0.28);
    }

    if (problemItems.length) {
        tl.to(problemItems, {
            y: (index) => -20 - index * 8,
            opacity: (index) => 0.82 - index * 0.18,
            stagger: 0.12,
            duration: 0.62
        }, 0.34);
    }

    if (formulaLeft) {
        tl.fromTo(formulaLeft, {
            y: 36,
            autoAlpha: 0
        }, {
            y: 0,
            autoAlpha: 1,
            duration: 0.58
        }, 0.62);
    }

    if (formulaOperator) {
        tl.fromTo(formulaOperator, {
            scaleX: 0.45,
            autoAlpha: 0
        }, {
            scaleX: 1,
            autoAlpha: 1,
            duration: 0.48
        }, 0.82);
    }

    if (formulaRight) {
        tl.fromTo(formulaRight, {
            y: 36,
            autoAlpha: 0
        }, {
            y: 0,
            autoAlpha: 1,
            duration: 0.58
        }, 0.98);
    }

    if (formulaEquals) {
        tl.fromTo(formulaEquals, {
            scaleX: 0.2,
            autoAlpha: 0
        }, {
            scaleX: 1,
            autoAlpha: 1,
            duration: 0.52
        }, 1.18);
    }

    if (formulaResult) {
        tl.fromTo(formulaResult, {
            y: 44,
            autoAlpha: 0
        }, {
            y: 0,
            autoAlpha: 1,
            duration: 0.7
        }, 1.38);
    }

    const trigger = ScrollTrigger.create({
        trigger: scene,
        start: "top 82%",
        once: true,
        onEnter: () => {
            if (introDelay) return;

            introDelay = gsap.delayedCall(0.18, () => {
                tl.play();
                introDelay = null;
            });
        }
    });

    return () => {
        introDelay?.kill();
        trigger.kill();
        tl.kill();
    };
}

document.addEventListener("DOMContentLoaded", initHeroScene);
