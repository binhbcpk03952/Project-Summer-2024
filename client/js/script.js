function updateQuantity(element, num, productId, quantityProduct, idCart) {
    const quantityInput = element.parentElement.querySelector('.quantity-cart');
    let quantity = parseInt(quantityInput.value);

    if (isNaN(quantity)) {
        quantity = 1;
    }
    quantity += num;

    if (quantity < 1) {
        quantity = 1;
    } else if (quantity > quantityProduct) {
        quantity = quantityProduct;
    }
    quantityInput.value = quantity;

    $.ajax({
        url: '../../../project-summer-2024/client/carts/updateQuantity.php',
        method: 'GET',
        dataType: 'json',
        data: {
            quantity: quantity,
            productId: productId,
            idCart: idCart,
        },
        success: function(response) {
            try {
                const data = response;
                if (data.status === 'success') {
                    console.log('Quantity:', quantity);
                    console.log('Response:', response);

                    // Cập nhật giá sản phẩm
                    const priceElement = document.querySelector(`#totalPrice-${idCart}`);
                    if (priceElement) {
                        priceElement.innerText = data.newPrice; // Giả sử dữ liệu phản hồi có newPrice
                    }
                    const totalPrice = document.querySelector(`#total_price`);
                    if (totalPrice) {
                        totalPrice.innerText = data.newTotal; // Giả sử dữ liệu phản hồi có newPrice
                    }
                } else {
                    console.log('Error:', data.message);
                }
            } catch (e) {
                console.error('Error parsing JSON:', e);
                console.error('Response:', response);
            }
        },
        error: function(xhr, status, error) {
            console.log('Error: ' + error);
        }
    });
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
function alertSuccessfully(content) {
    let container = document.getElementById('alerts-container');
    let alertHtml = `
            <div class="container-fluid position_alert" id="alertSuccessfully">
                <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                    <div class="content_alert alert_cart">
                        <div class="icon-warning d-flex justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-circle-check-big icon_cart mt-3"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 
                                11 3 3L22 4"/></svg>
                        </div>
                        <h3 class="text-center fs-6 mt-3">${content} Thành công!</h3>
                    </div>
                </div>
            </div>
        `;
    container.innerHTML += alertHtml;
    setTimeout(() => {
        let alertElement = document.getElementById('alertSuccessfully');
        if (alertElement) {
            alertElement.remove();
        }
    }, 2000);
}
<<<<<<< HEAD
function alertRemove(event, content) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
    targetUrl = event.target.href; // Lưu trữ URL đích

    let logout = document.elementById('logout');
    let alertHtml = `
        <div class="container-fluid position_alert" id="alertBox">
            <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                <div class="content_alert">
                    <h3 class="text-center">Bạn có chắc chắn muốn đăng xuất "<b> ${content} </b>"?</h3>
                    <div class="icon-warning d-flex justify-content-center">
                        <i class="fa-solid fa-triangle-exclamation fs-1 text-danger"></i>
                    </div>
                    <div class="btn-option d-flex justify-content-between mx-5 mt-4">
                        <button class="btn color-bg text-white" onclick="abort()">Hủy</button>
                        <button class="btn btn-danger" onclick="remove()">Đăng Xuất</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    logout.innerHTML += alertHtml;
}
function abort() {
    let alertBox = document.getElementById('alertBox');
    if (alertBox) {
        alertBox.remove();
    }
}

function remove() {
    let alertBox = document.getElementById('alertBox');
    if (alertBox) {
        alertBox.remove();
    }
    // Chuyển hướng đến URL đích
    window.location.href = targetUrl;
}
=======

document.addEventListener('DOMContentLoaded', function() {
    const thumbnails = document.querySelectorAll('.image_thumbnail img');
    const showImage = document.querySelector('.show_image');
    
    thumbnails.forEach(thumbnail => {
        thumbnail.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(thumb => thumb.classList.remove('active'));
            
            // Add active class to the clicked thumbnail
            thumbnail.classList.add('active');
            
            // Set the clicked thumbnail image as the main image
            showImage.innerHTML = `<img src="${thumbnail.src}" alt="main image">`;
        });
    });
});
>>>>>>> 998701e3df9136fc557d558782a8273c6713af93
