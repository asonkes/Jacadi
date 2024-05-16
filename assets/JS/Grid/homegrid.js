/** PAGE HOME - DEPLACEMENT DE LA HOMEGRID - permet d'avoir un effet d'opacité de plus en plus grand **/
window.onload = function() {
    const homeGrid = document.querySelector('.js-homeGrid');
    console.log('js-homeGrid', homeGrid)
    
    if(homeGrid) {
        setTimeout(() => {
            let opacity = 0;
     
            const intervalId = setInterval(() => {
                opacity += 0.1; /* Augmentez l'opacité par incréments de 0.1 */
                homeGrid.style.opacity = opacity;
     
                if (opacity >= 1) {
                    clearInterval(intervalId); /* Arrêtez l'animation une fois que l'opacité atteint 1 */
                }
             }, 75); /* Répétez toutes les 75 millisecondes */
         }, 30); /* Démarrer l'animation après un délai de 30 millisecondes */
    }
}