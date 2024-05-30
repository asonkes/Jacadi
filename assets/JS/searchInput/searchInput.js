const searchInput = document.querySelector('.js-searchInput');

if(searchInput) {
    document.addEventListener('DOMContentLoaded', () => {
        searchInput.value = '';
    });
    
    searchInput.addEventListener('keyup', () => {
        const input = searchInput.value.trim().toLowerCase(); // Supprimer les espaces vides avant et après la recherche
    
        const productContainers = document.querySelectorAll('.j-Card-container'); // Sélectionnez les conteneurs de produits

          // Sélectionnez le bouton de recherche
        const searchButton = document.querySelector('.j-searchBar__button');
    
        productContainers.forEach(container => {
            const productNameElement = container.querySelector('.j-Card__title'); // Sélectionnez l'élément contenant le nom du produit
            const productName = productNameElement.textContent.toLowerCase(); // Obtenez le nom du produit en minuscules
    
            // Vérifiez si le nom du produit contient la chaîne de recherche
            if (productName.includes(input)) {
                container.parentElement.style.display = ''; // Affiche le produit en affichant le conteneur parent
            } else {
                container.parentElement.style.display = 'none'; // Cache le produit en masquant le conteneur parent
            }
        });
    });
}