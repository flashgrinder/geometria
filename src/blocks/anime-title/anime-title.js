import gsap from "gsap";

function initAnimeTitles() {
    const titles = gsap.utils.toArray(".js-anime-title");

    if (!titles.length) return;

    const animatedTitles = new WeakSet();

    titles.forEach((title) => {
        gsap.set(title, {
            x: -90,
            opacity: 0
        });
    });

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting || animatedTitles.has(entry.target)) return;

            animatedTitles.add(entry.target);

            gsap.to(entry.target, {
                x: 0,
                opacity: 1,
                duration: 0.9,
                ease: "power3.out",
                overwrite: "auto"
            });

            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.2,
        rootMargin: "0px 0px -10% 0px"
    });

    titles.forEach((title) => {
        observer.observe(title);
    });
}

document.addEventListener("DOMContentLoaded", initAnimeTitles);
