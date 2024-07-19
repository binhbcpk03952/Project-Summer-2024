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


