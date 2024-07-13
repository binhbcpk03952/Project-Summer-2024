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
