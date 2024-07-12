function updateQuantity(element, num) {
    const quantityInput = element.parentElement.querySelector('.quantity-cart');
    let quantity = parseInt(quantityInput.value); // Lấy giá trị hiện tại và chuyển đổi sang số nguyên

    if (isNaN(quantity)) {
        quantity = 1; 
    }

    quantity += num;

    if (quantity < 1) {
        quantity = 1; 
    }

    quantityInput.value = quantity;
}
