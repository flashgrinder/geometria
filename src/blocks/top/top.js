function initParallax() {

    const wrapper = document.querySelector('.js-parallax-container');
    const parallaxItems = document.querySelectorAll('.js-animation-item');

    if (!wrapper) return;
    
    wrapper.addEventListener('mouseenter', () => {
        // Get the bounding rectangle of the wrapper when the mouse enters
        const rect = wrapper.getBoundingClientRect();
        
        // Center coordinates of the wrapper
        const centerX = rect.left + rect.width / 2;
        const centerY = rect.top + rect.height / 2;
    
        // Store these values as data attributes on the wrapper for use during mousemove
        wrapper.dataset.centerX = centerX;
        wrapper.dataset.centerY = centerY;
    });
    
    wrapper.addEventListener('mousemove', (e) => {
        // Get stored center coordinates
        const centerX = parseFloat(wrapper.dataset.centerX);
        const centerY = parseFloat(wrapper.dataset.centerY);
    
        // Calculate offset from the center of the wrapper to the mouse position
        const offsetX = (e.clientX - centerX) / 95; // Adjust divisor for intensity
        const offsetY = (e.clientY - centerY) / 95;
    
        // Apply the transformation to each item element for a parallax effect
        parallaxItems.forEach((item, index) => {
            const intensity = parseFloat(item.getAttribute('data-intensity')) || 2; // Different intensity for each role
            //const intensity = (index + 1) * 2;; // Different intensity for each role
    
            
            // Если нужно задать разную скорость разным элементам
            // let intensity;
    
            // Set intensity based on the assigned class
            // if (item.classList.contains('intensity-low')) {
            //     intensity = 2;
            // } else if (item.classList.contains('intensity-medium')) {
            //     intensity = 4;
            // } else if (item.classList.contains('intensity-high')) {
            //     intensity = 6;
            // } else {
            //     intensity = 3; // Default intensity if no class is matched
            // }
    
    
            item.style.transform = `translate(${offsetX * intensity}px, ${offsetY * intensity}px)`;
        });
    });
    
    wrapper.addEventListener('mouseleave', () => {
        // Reset transformations when the mouse leaves
        parallaxItems.forEach((item) => {
            item.style.transform = 'translate(0, 0)';
        });
    });

}

document.addEventListener('DOMContentLoaded', initParallax);