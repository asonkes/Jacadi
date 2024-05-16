/** PAGE HOME - DEPLACEMENT DE LA COUPDECOEURGRID - permet d'avoir un effet d'opacité de plus en plus grand **/
const coupDeCoeurGrid = document.querySelector('.js-coupDeCoeurGrid');
console.log('js-coupDeCoeurGrid', coupDeCoeurGrid)

if(coupDeCoeurGrid) {
    window.addEventListener('scroll', () => {
        setTimeout(() => {
            let opacity = 0;
     
            const intervalId = setInterval(() => {
                opacity += 0.1; /* Augmentez l'opacité par incréments de 0.1 */
                coupDeCoeurGrid.style.opacity = opacity;
     
                if (opacity >= 1) {
                    clearInterval(intervalId); /* Arrêtez l'animation une fois que l'opacité atteint 1 */
                }
             }, 15); /* Répétez toutes les 100 millisecondes */
         }, 2); /* Démarrer l'animation après un délai de 500 millisecondes */
    })
}
