const linkPopUp = document.querySelector('.js-CardPair__button');
console.log('js-CardPair__button', linkPopUp);

const crossDiv = document.querySelector('.js-crossDiv');
console.log('js-crossDiv', crossDiv);

if(linkPopUp) {
    linkPopUp.addEventListener('click', () => {
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

document.addEventListener('click', (e) => {
    if(!linkPopUp.contains(e.target) && !cross.contains(e.target)) {
        crossDiv.classList.remove('active');
    }
})