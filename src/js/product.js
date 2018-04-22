const add = document.querySelector('#plus');
const remove = document.querySelector('#minus');
const quantity = document.querySelector('#quantity');
const form = document.querySelector('.product-form');

add.addEventListener('click', e => {
    e.preventDefault();
    quantity.value = parseInt(quantity.value) + 1;
    console.log(quantity.value);
});
remove.addEventListener('click', e => {
    e.preventDefault();
    quantity.value = parseInt(quantity.value) - 1;
    if (parseInt(quantity.value) <= -1) {
        // console.log(`Value can't be less than 0`)
        alert(`Value can't be less than 0`);
        quantity.value = 0
        return;
    }
    console.log(quantity.value);
});

form.addEventListener('submit', e => {
    if (parseInt(quantity.value) < 0) {
        e.preventDefault();
        alert('Please enter a value large than 0');
    }
});
