/** PAGE ARTICLE - BLOCK QUI SE RETRACTE... permet au click de cacher un block ou pas... **/
const accordionIcons = document.querySelectorAll('.j-accordion__icon');

accordionIcons.forEach(icon => {
    icon.addEventListener('click', (event) => {

        event.preventDefault();
        icon.classList.toggle('active');

        // Trouver le texte d'accordéon associé à l'icône cliquée
        // et pour partir de l'élément de base et retourner à l'ancêtre direct, on utilise la méthode JS, closest() et donc le parent de chaque CAR, c'est('.j-accordion')
        const accordionText = icon.closest('.j-accordion').querySelector('.j-accordion__text');

        // Ajouter ou retirer la classe 'active' pour basculer l'état de visibilité
        accordionText.classList.toggle('active');
    });
});