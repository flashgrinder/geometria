import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function initProcessTimeline() {
    const section = document.querySelector(".process");

    if (!section) return;

    const steps = Array.from(section.querySelectorAll(".process-step"));

    if (!steps.length) return;

    let activeIndex = -1;
    let queuedIndex = -1;
    let stepTween = null;

    function setActiveStep(nextIndex) {
        if (nextIndex === activeIndex || nextIndex < 0 || nextIndex >= steps.length) return;

        steps.forEach((step, index) => {
            step.classList.toggle("is-active", index === nextIndex);
        });

        activeIndex = nextIndex;
    }

    function playStepSequence(targetIndex) {
        if (targetIndex < 0 || targetIndex >= steps.length) return;
        if (targetIndex === activeIndex && !stepTween) return;

        queuedIndex = targetIndex;

        if (stepTween) return;

        const advance = () => {
            if (queuedIndex === activeIndex) {
                stepTween = null;
                return;
            }

            const direction = queuedIndex > activeIndex ? 1 : -1;
            setActiveStep(activeIndex + direction);

            stepTween = gsap.delayedCall(0.09, advance);
        };

        advance();
    }

    function getClosestStepIndex() {
        const viewportCenter = window.innerHeight * 0.45;
        let closestIndex = 0;
        let minDistance = Number.POSITIVE_INFINITY;

        steps.forEach((step, index) => {
            const rect = step.getBoundingClientRect();
            const body = step.querySelector(".process-step__body");
            const targetTop = body ? body.getBoundingClientRect().top : rect.top;
            const distance = Math.abs(targetTop - viewportCenter);

            if (distance < minDistance) {
                minDistance = distance;
                closestIndex = index;
            }
        });

        return closestIndex;
    }

    setActiveStep(0);

    ScrollTrigger.matchMedia({
        "(min-width: 961px)": function () {
            const trigger = ScrollTrigger.create({
                trigger: section,
                start: "top top",
                end: () => `+=${window.innerHeight * (steps.length - 1)}`,
                pin: true,
                scrub: 0.35,
                anticipatePin: 1,
                invalidateOnRefresh: true,
                onUpdate: (self) => {
                    const nextIndex = Math.min(
                        steps.length - 1,
                        Math.floor(self.progress * steps.length)
                    );

                    setActiveStep(nextIndex);
                },
                onLeaveBack: () => setActiveStep(0)
            });

            return () => {
                trigger.kill();
                setActiveStep(0);
            };
        },

        "(max-width: 960px)": function () {
            const trigger = ScrollTrigger.create({
                trigger: section,
                start: "top bottom",
                end: "bottom top",
                onEnter: () => playStepSequence(0),
                onEnterBack: () => playStepSequence(0),
                onUpdate: () => playStepSequence(getClosestStepIndex()),
                onLeave: () => playStepSequence(steps.length - 1),
                onLeaveBack: () => playStepSequence(0)
            });

            return () => {
                stepTween?.kill();
                stepTween = null;
                queuedIndex = -1;
                trigger.kill();
                setActiveStep(0);
            };
        }
    });

    requestAnimationFrame(() => {
        ScrollTrigger.refresh();
    });
}

document.addEventListener("DOMContentLoaded", initProcessTimeline);
