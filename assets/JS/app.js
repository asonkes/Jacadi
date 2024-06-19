import '../styles/index.scss';
import '../JS/header/header.js';
import '../JS/burger/burger.js';
import '../JS/ballon/ballon.js';
import '../JS/accordion/accordion.js';
import '../JS/Grid/homegrid.js';
import '../JS/Grid/coupDeCoeur.js';
import '../JS/searchInput/searchInput.js';
import '../JS/flashMessage/flashMessage.js';
import '../JS/cross/cross.js';
import '../JS/previewImage/previewImage.js';

document.addEventListener("DOMContentLoaded", function() {
    // Gestion de la sélection de taille
    document.querySelectorAll('.j-popUp__item2__item').forEach(function(sizeElement) {
        sizeElement.addEventListener('click', function() {
            const selectedSize = sizeElement.getAttribute('data-size');
            document.getElementById('selected-size').textContent = `(${selectedSize})`;
            document.getElementById('popUpSize').classList.remove('open');
        });
    });
});
