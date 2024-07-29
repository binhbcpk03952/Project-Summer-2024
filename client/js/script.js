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

document.addEventListener('load', () => {
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
function selectColor(productId, color, event) {
    var colorGroup = document.getElementById('color-group-' + productId);
    var buttons = colorGroup.getElementsByTagName('button');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('active');
    }
    event.target.classList.add('active');
    document.getElementById('color-' + productId).value = color;
}

function selectSize(productId, size, event) {
    var sizeGroup = document.getElementById('size-group-' + productId);
    var buttons = sizeGroup.getElementsByTagName('button');
    for (var i = 0; i < buttons.length; i++) {
        buttons[i].classList.remove('active');
    }
    event.target.classList.add('active');
    document.getElementById('size-' + productId).value = size;
}

function alertCart(content) {

    let body = document.querySelector('body');
    let alertHtml = `
            <div class="container-fluid position_alert" id="alertCart">
                <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                    <div class="content_alert alert_cart">
                        <div class="icon-warning d-flex justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-circle-check-big icon_cart mt-3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 
                                11 3 3L22 4"/></svg>
                        </div>
                        <h3 class="text-center fs-6 mt-3">Thêm sản phẩm <span class="fw-bold">${content}</span> vào giỏ hàng thành công.</h3>
                    </div>
                </div>
            </div>
        `;
    body.innerHTML += alertHtml;
    setTimeout(() => {
        let alertElement = document.getElementById('alertCart');
        if (alertElement) {
            alertElement.remove();
        }
    }, 2000);
}

function showDropdown() {
    const dropDownMenu = document.querySelector('.dropdown-menu');
    dropDownMenu.classList.toggle('add');
}

document.addEventListener('click', (e) => {
    const dropDownMenu = document.querySelector('.dropdown-menu');
    const btnDrop = document.querySelector('.btn-dropdown');

    if (!dropDownMenu.contains(e.target) && !btnDrop.contains(e.target)) {
        dropDownMenu.classList.remove('add');
    }
});