const linkPopUp = document.querySelector('.js-CardPair__button');
console.log('js-CardPair__button', linkPopUp);

const crossDiv = document.querySelector('.js-crossDiv');
console.log('js-crossDiv', crossDiv);

if(linkPopUp) {
    linkPopUp.addEventListener('click', (event) => {
        event.preventDefault();
        crossDiv.classList.add('active');
    })
}

const cross = document.querySelector('.js-popUp__icon');
console.log('js-popUp__icon', cross);

cross.addEventListener('click', () => {
    const crossDiv = document.querySelector('.js-crossDiv');
    console.log('js-crossDiv', crossDiv);

    crossDiv.classList.remove('active');
});