/** MENU HEADER - CHANGEMENT DE COULEUR DE background + COULEUR police au 'Scroll' + CHANGEMENT ICONE du compte **/
function updateHeaderStyles() {
    // Permet de sélectionner le background du menu
    const headerBg = document.querySelector('.js-change-background');
    console.log('colorBackground', headerBg);

    // Permet de changer la couleur du background des sous-menus
    const headerSousMenu = document.querySelectorAll('.js-change-background-sousMenus')
    console.log('colorSousMenu', headerSousMenu);

    // Permet de sélectionner la couleur de la police du header(a)
    const headerColor = document.querySelectorAll('.js-change-color-a');
    console.log('colorPoliceMenu', headerColor);

    // Permet de sélectionner les "li" des sous-menus pour enlever le background
    const headerSousMenuLi = document.querySelectorAll('.js-change-background-sousMenusLi');
    console.log('background-sousMenusLi', headerSousMenuLi);

    // Permet de sélectionner l'image de base de l'icone du compte(blanche)
    const accountIconWhite = document.querySelector('.js-change-accountIconWhite');
    console.log('accountIconWhite', accountIconWhite);

    // Permet de sélectionner la 2eme image de l'icone du compte(noire)
    const accountIconBlack = document.querySelector('.js-change-accountIconBlack');
    console.log('accountIconBlack', accountIconBlack);

    if(window.scrollY > 0 ) {
        console.log('scroll', window.scrollY);
        // On change le background du header
        headerBg.classList.add('change-header-background');

        // On change la background des sous-menu (on reprend la même classe que pour le header car même propriété)
        headerSousMenu.forEach(e => {
            e.classList.add('change-navUl-background');
        })
        
        // On sélectionne les différents éléments(a)
        headerColor.forEach(e => {
            e.classList.add('change-color-a');
        })

        // On sélectionne les différents éléments (li) des sous-menus
        headerSousMenuLi.forEach(e => {
            e.classList.add('change-headerSousMenuLI-background');
        })

        // On met l'image de base en display: block
        accountIconWhite.classList.add('change-accountIconWhite');

        // On met la 2eme image du compte en display: none;
        accountIconBlack.classList.add('change-accountIconBlack');
    } else {
        // On enlève la couleur du background
        headerBg.classList.remove('change-header-background');

        // On enlève la couleur aux sous-menu
        headerSousMenu.forEach(e => {
            e.classList.remove('change-navUl-background');
        })

        // On change la couleur de la police mais foreach car plusieurs éléments(a)
        headerColor.forEach(element => {
            element.classList.remove('change-color-a');
        })

        // On enlève le background des ('li') des sous-menus
        headerSousMenuLi.forEach(e => {
            e.classList.remove('change-headerSousMenuLI-background');
        })

        // On met l'image de base de l'icone en display: none
        accountIconWhite.classList.remove('change-accountIconWhite');

        // On met la 2eme icone du compte en display: block
        accountIconBlack.classList.remove('change-accountIconBlack');
    }
}
window.addEventListener('scroll', updateHeaderStyles);