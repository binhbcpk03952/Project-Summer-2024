function showAside() {
    const aside = document.querySelector('.aside-content')
    const main = document.querySelector('main')

    aside.classList.toggle('show-aside')

    if (aside.classList.contains('show-aside')) {
        main.classList.add('col-md-10')
    }
    else {
        main.classList.remove('col-md-10')
    }

}

let targetUrl = ""; // Biến toàn cục để lưu trữ URL đích

function alertRemove(event, content) {
    event.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ <a>
    targetUrl = event.target.href; // Lưu trữ URL đích

    let body = document.querySelector('body');
    let alertHtml = `
        <div class="container-fluid position_alert" id="alertBox">
            <div class="bg-alert d-flex justify-content-center align-items-center w-100">
                <div class="content_alert">
                    <h3 class="text-center">Bạn có chắc chắn muốn xóa ${content} này?</h3>
                    <div class="icon-warning d-flex justify-content-center">
                        <i class="fa-solid fa-triangle-exclamation fs-1 text-danger"></i>
                    </div>
                    <div class="btn-option d-flex justify-content-between mx-5 mt-4">
                        <button class="btn color-bg text-white" onclick="abort()">Hủy</button>
                        <button class="btn btn-danger" onclick="remove()">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    `;
    body.innerHTML += alertHtml;
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

let openDropdown = null;

function showChange(event, element) {
    event.preventDefault();

    // Close any currently open dropdowns
    if (openDropdown && openDropdown !== element.nextElementSibling) {
        openDropdown.style.display = 'none';
    }

    // Toggle the clicked dropdown
    let dropdown = element.nextElementSibling;
    if (dropdown.style.display === 'block') {
        dropdown.style.display = 'none';
        openDropdown = null;
    } else {
        dropdown.style.display = 'block';
        openDropdown = dropdown;
    }
}

function addSizeColor() {
    const container = document.getElementById('table');
    const div = document.createElement('tr');
    let select = document.querySelector('#select');
    let color = document.querySelector('#color');
    let quantity = document.querySelector('#quantity');
    const error = document.querySelector('.alert_error');
    let bool = true;
    const quantityValue = parseInt(quantity.value, 10);

    if (quantity.value.trim() == "") {
        error.innerText = "Vui lòng nhập số lượng."
        bool = false;
    }
    else if (quantityValue < 1) {
        error.innerText = "Vui lòng nhập lớn hơn 1.";
        bool = false;
    }
    else if (!Number.isInteger(quantityValue)) {
        error.innerText = "Vui lòng nhập đúng định dạng";
        bool = false;
    }
    if (bool) {
        error.innerText = ""
        div.innerHTML = `
                    <td><input type="text" name="size[]" value="${select.value}" class="btn-tb" readonly></td>
                    <td><input type="text" name="color[]" value="${color.value}" class="btn-tb" readonly></td>
                    <td><input type="text" name="quantity[]" value="${quantity.value}" class="btn-tb" readonly></td>
                    <td onclick="removeSizeColor(this)"><button type="button" class="btn_remove">Remove</button></td>
                `;
        container.appendChild(div);
        update();
    }
}

function update() {
    let select = document.querySelector('#select');
    let color = document.querySelector('#color');
    let quantity = document.querySelector('#quantity');
    // select.value = reset;
    color.value = "";
    quantity.value = "";
}

function removeSizeColor(button) {
    button.parentElement.remove();
}

