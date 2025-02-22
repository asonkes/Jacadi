/** MENU BURGER - Transormation burger en croix au 'Click' **/
const burgerIcon = document.querySelector('.j-burger-iconContainer');

/** MENU BURGER - APPARITION CONTENU DU MENU au 'Click' **/
const burgerContent = document.querySelector('.j-burger-nav');
const body = document.querySelector('body');

burgerIcon.addEventListener('click', () => {
    burgerIcon.classList.toggle('active');
    burgerContent.classList.toggle('active');
    body.classList.toggle('active');
});

/** MENU BURGER - POSSIBILITE DE FERMER le menu en cliquant à l'extérieur du menu avec event au 'Click' **/

const pageContent = document.querySelectorAll('.js-page-content');
console.log('contenu page', pageContent);

window.addEventListener('click', (e) => {
    if(!burgerIcon.contains(e.target) && !burgerContent.contains(e.target)) {
        burgerIcon.classList.remove('active');
        burgerContent.classList.remove('active');
    }
})

/** MENU BURGER - EMPECHER LE SCROLL DE L'ECRAN */
