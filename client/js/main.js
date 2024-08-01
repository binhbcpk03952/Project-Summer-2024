

function showPassword () {
    const valuePass = document.querySelector('#password');
    valuePass.type = "text"
}

function endPass () {
    const valuePass = document.querySelector('#password');  
    valuePass.type = "password"
}

function showDropdown() {
    const dropDownMenu = document.querySelector('.dropdown-menu');
    dropDownMenu.classList.toggle('add');
}

document.body.addEventListener('click', (e) => {
    const dropDownMenu = document.querySelector('.dropdown-menu');
    const btnDrop = document.querySelector('.btn-dropdown');

    if (!dropDownMenu.contains(e.target) && !btnDrop.contains(e.target)) {
        dropDownMenu.classList.remove('add');
    }
});

// document.querySelector('.btn-dropdown').addEventListener('click', (e) => {
//     e.stopPropagation();
//     showDropdown();
// });

function updateQuantity(num) {
    const quantityCart = document.querySelector('#quantity-cart') 

    if (quantityCart.value < 1) {
        quantityCart.value = 1;
    }
    quantityCart.value += num;
}