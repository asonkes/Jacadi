const ballon = document.querySelector(".js-ballon");
console.log('ballon', ballon);

if (ballon) {
    const sections = document.querySelectorAll('.js-section');
    console.log('js-section', sections);

    const ballon1 = document.querySelector('.js-ballon1'); 

    console.log('sections',sections)

    let currentSlide = 0;

    ballon.addEventListener("click", function(event) {
        event.preventDefault();
        scrollToNextSlide();
    });

    ballon1.addEventListener("click", function(event) {
        event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });

        ballon.classList.remove('hidden');
        ballon1.classList.remove('hidden');
        currentSlide = 0;
    });

    function scrollToNextSlide() {
        currentSlide = (currentSlide + 1) % sections.length;

        // Vérifie si on est sur le dernier slide
        if (currentSlide === sections.length - 1) {
            // Cache l'image du ballon normal et affiche celle du ballon1
            ballon.classList.add('hidden');
            ballon1.classList.add('hidden');
        }

        const nextSection = sections[currentSlide];

        if(nextSection) {
            const top = nextSection.offsetTop;

            window.scrollTo({
                top: top,
                behavior: 'smooth'
            });
        }
    }

    window.addEventListener('scroll', () => {
        const scrollPosition = window.scrollY + window.innerHeight;

        // Récupérer la dernière section
        const lastSection = sections[sections.length - 1];
        const secondLastSection = sections[sections.length - 2];

        // Vérifier si on est dans l'avant-dernière section
        if (scrollPosition >= secondLastSection.offsetTop + secondLastSection.offsetHeight) {
            // Cacher le premier ballon et afficher le second
            ballon.classList.add('hidden');
            ballon1.classList.add('hidden');
        } else {
            // Afficher le premier ballon et cacher le second
            ballon.classList.remove('hidden');
            ballon1.classList.remove('hidden');
        }
    });
}