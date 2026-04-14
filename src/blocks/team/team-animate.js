import gsap from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

function initTeamCardsAnimation() {
    const cards = gsap.utils.toArray(".team-card");

    if (!cards.length) return;

    cards.forEach((card, index) => {
        gsap.fromTo(card, {
            y: 90,
            opacity: 0
        }, {
            y: 0,
            opacity: 1,
            duration: 1.05,
            delay: 0.18 + index * 0.08,
            ease: "power3.out",
            overwrite: "auto",
            scrollTrigger: {
                trigger: card,
                start: "top 88%",
                toggleActions: "play none none none",
                once: true
            }
        });
    });
}

window.addEventListener("load", initTeamCardsAnimation);
