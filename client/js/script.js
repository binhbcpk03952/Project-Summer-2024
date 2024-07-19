function updateQuantity(element, num) {
    const quantityInput = element.parentElement.querySelector('.quantity-cart');
    let quantity = parseInt(quantityInput.value); 

    if (isNaN(quantity)) {
        quantity = 1; 
    }

    quantity += num;

    if (quantity < 1) {
        quantity = 1; 
    }

    quantityInput.value = quantity;
}

function changePassword() {
    const change = document.querySelector('.load-change');
    change.classList.toggle('show');
}

document.body.addEventListener('load', () => {
    const change = document.querySelector('.load-change');
    change.classList.remove('show')
});

function showPassword (element) {
    const valuePass = element.parentElement.querySelector('.password');
    valuePass.type = "text"
}

function endPass (element) {
    const valuePass = element.parentElement.querySelector('.password');  
    valuePass.type = "password"
}

// document.addEventListener('DOMContentLoaded', () => {

//     const passwordFields = document.querySelectorAll('.password')
//     var showPassword = document.querySelector('.show-password')
//     passwordFields.forEach(pass => {
//         pass.addEventListener("input", () => {
//             if (pass.value.trim() !== "") {
//                 showPassword.classList.remove('d-none')
//                 // console.log(12345);
//             }
//             else {
//                 showPassword.classList.add("d-none")
//             }
//         });
//     });
    
// });
function change(element) {
    const pass = element.parentElement.querySelector('.password')
    const showPassword = element.parentElement.querySelector('.show-password')
    if (pass.value.trim() !== "") {
        showPassword.classList.remove('d-none')
        // console.log(12345);
    }
    else {
        showPassword.classList.add("d-none")
    }
}
