import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function initServicesTimeline() {
    const section = document.querySelector(".services");

    if (!section) return;

    const items = Array.from(section.querySelectorAll(".js-services-item"));

    if (!items.length) return;

    let activeIndex = -1;
    let queuedIndex = -1;
    let stepTween = null;

    function setActiveItem(nextIndex) {
        if (nextIndex === activeIndex || nextIndex < 0 || nextIndex >= items.length) return;

        items.forEach((item, index) => {
            item.classList.toggle("is-active", index === nextIndex);
        });

        activeIndex = nextIndex;
    }

    function playStepSequence(targetIndex) {
        if (targetIndex < 0 || targetIndex >= items.length) return;
        if (targetIndex === activeIndex && !stepTween) return;

        queuedIndex = targetIndex;

        if (stepTween) return;

        const advance = () => {
            if (queuedIndex === activeIndex) {
                stepTween = null;
                return;
            }

            const direction = queuedIndex > activeIndex ? 1 : -1;
            setActiveItem(activeIndex + direction);

            stepTween = gsap.delayedCall(0.1, advance);
        };

        advance();
    }

    function getClosestItemIndex() {
        const viewportCenter = window.innerHeight / 2;
        let closestIndex = 0;
        let minDistance = Number.POSITIVE_INFINITY;

        items.forEach((item, index) => {
            const rect = item.getBoundingClientRect();
            const itemCenter = rect.top + rect.height / 2;
            const distance = Math.abs(itemCenter - viewportCenter);

            if (distance < minDistance) {
                minDistance = distance;
                closestIndex = index;
            }
        });

        return closestIndex;
    }

    setActiveItem(0);

    ScrollTrigger.matchMedia({
        "(min-width: 961px)": function () {
            const sectionTrigger = ScrollTrigger.create({
                trigger: section,
                start: "top bottom",
                end: "bottom top",
                onEnter: () => playStepSequence(0),
                onEnterBack: () => playStepSequence(0),
                onUpdate: () => playStepSequence(getClosestItemIndex()),
                onLeave: () => playStepSequence(items.length - 1),
                onLeaveBack: () => playStepSequence(0)
            });

            return () => {
                stepTween?.kill();
                stepTween = null;
                queuedIndex = -1;
                sectionTrigger.kill();
                setActiveItem(0);
            };
        },

        "(max-width: 960px)": function () {
            const sectionTrigger = ScrollTrigger.create({
                trigger: section,
                start: "top bottom",
                end: "bottom top",
                onEnter: () => playStepSequence(0),
                onEnterBack: () => playStepSequence(0),
                onUpdate: () => playStepSequence(getClosestItemIndex()),
                onLeave: () => playStepSequence(items.length - 1),
                onLeaveBack: () => playStepSequence(0)
            });

            return () => {
                stepTween?.kill();
                stepTween = null;
                queuedIndex = -1;
                sectionTrigger.kill();
                setActiveItem(0);
            };
        }
    });
}

document.addEventListener("DOMContentLoaded", initServicesTimeline);
