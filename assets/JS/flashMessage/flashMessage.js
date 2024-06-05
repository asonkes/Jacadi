const flashIcon = document.querySelector('.js-flashIcon');
console.log('js-flashIcon', flashIcon);

if(flashIcon) {
    flashIcon.addEventListener('click', () => {

        const flashMessage = document.querySelector('.js-flashMessage');
        console.log('js-flashMessage', flashMessage);

        flashMessage.classList.toggle('active');
    });
}