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
import '../JS/size/size.js';


function hasAcceptedCookies() {
    return document.cookie.split(';').some(function(item) {
        return item.trim().startsWith('cookiesAccepted=');
    });
}

function setCookiesAccepted() {
    var d = new Date();
    d.setTime(d.getTime() + (365*24*60*60*1000)); // 1 an
    var expires = "expires=" + d.toUTCString();
    document.cookie = "cookiesAccepted=true;" + expires + ";path=/";
}

document.addEventListener('DOMContentLoaded', function() {
    if (!hasAcceptedCookies()) {
        var iubendaScript = document.createElement('script');
        iubendaScript.src = "https://cdn.iubenda.com/iubenda.js";
        document.body.appendChild(iubendaScript);

        // Attacher l'événement d'acceptation des cookies
        var iubendaPolicyLink = document.querySelector('.iubenda-embed');
        if (iubendaPolicyLink) {
            iubendaPolicyLink.addEventListener('click', function() {
                setCookiesAccepted();
            });
        }
    }
});