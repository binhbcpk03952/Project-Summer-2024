$(document).ready(function() {
    // Khi nhấn vào nút sản phẩm, tải nội dung chi tiết vào modal và hiển thị modal
    $('.product-button').on('click', function() {
        var productId = $(this).data('product-id');
        $.ajax({
            url: 'table_cart.php',
            method: 'GET',
            data: { id: productId },
            success: function(response) {
                $('#box_cart').html(response).show(); // Chèn nội dung vào modal và hiển thị
            },
            error: function(xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    // Ẩn modal khi nhấn vào nút ẩn hoặc ngoài modal
    $(document).on('click', function(event) {
        if ($(event.target).closest('.content_alert').length === 0 && !$(event.target).hasClass('product-button')) {
            $('#box_cart').hide();
        }
    });

    // Thêm nút để ẩn modal
    $(document).on('click', '#box_cart .close', function() {
        $('#box_cart').hide();
    });
    $(document).on('click', '#box_cart .hidden-box', function() {
        $('#box_cart').hide();
    });
});
