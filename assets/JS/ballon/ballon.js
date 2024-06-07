document.addEventListener('DOMContentLoaded', () => {
    const ballon = document.querySelector('.js-ballon');
    const ballon1 = document.querySelector('.js-ballon1');
    const sections = document.querySelectorAll('.js-section');
    let currentSectionIndex = 0;

    // Show the first ballon and hide the second one initially
    ballon.style.display = 'block';
    ballon1.style.display = 'none';

    // Function to scroll to the next section
    function scrollToNextSection() {
        currentSectionIndex++;
        if (currentSectionIndex >= sections.length) {
            currentSectionIndex = sections.length - 1;
        }
        sections[currentSectionIndex].scrollIntoView({ behavior: 'smooth' });
        toggleBallons();
    }

    // Function to scroll to the top
    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
        currentSectionIndex = 0;
        toggleBallons();
    }

    // Function to toggle the display of the ballons
    function toggleBallons() {
        if (currentSectionIndex === sections.length - 1) {
            ballon.style.display = 'none';
            ballon1.style.display = 'block';
        } else {
            ballon.style.display = 'block';
            ballon1.style.display = 'none';
        }
    }

    // Add event listener to the first ballon
    ballon.addEventListener('click', (event) => {
        event.preventDefault();
        scrollToNextSection();
    });

    // Add event listener to the second ballon
    ballon1.addEventListener('click', (event) => {
        event.preventDefault();
        scrollToTop();
    });

    // Add scroll event listener to the window to update ballon visibility based on scroll position
    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY;
        const windowHeight = window.innerHeight;

        sections.forEach((section, index) => {
            if (scrollPosition >= section.offsetTop - windowHeight / 2 &&
                scrollPosition < section.offsetTop + section.offsetHeight - windowHeight / 2) {
                currentSectionIndex = index;
                toggleBallons();
            }
        });

        // Check if we are at the bottom of the page
        if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
            currentSectionIndex = sections.length - 1;
            toggleBallons();
        }
    });
});