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
            document.getElementById('selected-size').setAttribute('data-size', selectedSize);
            const sizeProduct = document.getElementById('selected-size').getAttribute('data-size');
            console.log(sizeProduct);  // Affiche la taille sélectionnée dans la console
            document.getElementById('popUpSize').classList.remove('open');
        });
    });

    // Ajout d'un écouteur d'événements au formulaire "Ajouter au panier"
    const addToCartForm = document.getElementById('add-to-cart-form');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(event) {
            const selectedSize = document.getElementById('selected-size').getAttribute('data-size');
            if (!selectedSize) {
                alert('Veuillez choisir une taille.');
                event.preventDefault(); // Empêche la soumission du formulaire
            } else {
                document.getElementById('size-input').value = selectedSize;
            }
        });
    }
});

