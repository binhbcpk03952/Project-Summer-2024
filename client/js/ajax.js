$(document).ready(function () {
    // Khi nhấn vào nút sản phẩm, tải nội dung chi tiết vào modal và hiển thị modal
    $('.product-button').on('click', function () {
        var productId = $(this).data('product-id');
        $.ajax({
            url: 'table_cart.php',
            method: 'GET',
            data: { id: productId },
            success: function (response) {
                $('#box_cart').html(response).show(); // Chèn nội dung vào modal và hiển thị
            },
            error: function (xhr, status, error) {
                console.log('Error: ' + error);
            }
        });
    });

    // Ẩn modal khi nhấn vào nút ẩn hoặc ngoài modal
    $(document).on('click', function (event) {
        if ($(event.target).closest('.content_alert').length === 0 && !$(event.target).hasClass('product-button')) {
            $('#box_cart').hide();
        }
    });

    // Thêm nút để ẩn modal
    $(document).on('click', '#box_cart .close', function () {
        $('#box_cart').hide();
    });
    $(document).on('click', '#box_cart .hidden-box', function () {
        $('#box_cart').hide();
    });

    // Listen for changes in the "province" select box
    $('#province').on('change', function () {
        var province_id = $(this).val();
        console.log(province_id);
        if (province_id) {
            // If a province is selected, fetch the districts for that province using AJAX
            $.ajax({
                url: '../../../project-summer-2024/client/address/ajax_get_district.php',
                method: 'GET',
                dataType: "json",
                data: {
                    province_id: province_id
                },
                success: function (data) {
                    // Clear the current options in the "district" select box
                    // let datas = JSON.parse(data);
                    console.log(data);

                    $('#district').empty();

                    // Add the new options for the districts for the selected province
                    $.each(data, function (i, district) {
                        // console.log(district);
                        $('#district').append($('<option>', {
                            value: district.id,
                            text: district.name
                        }));
                    });
                    // Clear the options in the "wards" select box
                    $('#wards').empty();
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                    console.log('Status: ' + textStatus);
                    console.log(xhr.responseText);
                }
            });
            $('#wards').empty();
        } else {
            // If no province is selected, clear the options in the "district" and "wards" select boxes
            $('#district').empty();
        }
    });

    // Listen for changes in the "district" select box
    $('#district').on('change', function () {
        var district_id = $(this).val();
        // console.log(district_id);
        if (district_id) {
            // If a district is selected, fetch the awards for that district using AJAX
            $.ajax({
                url: '../../../project-summer-2024/client/address/ajax_get_wards.php',
                method: 'GET',
                dataType: "json",
                data: {
                    district_id: district_id
                },
                success: function (data) {
                    // console.log(data);
                    // let datas = JSON.parse(data);
                    // Clear the current options in the "wards" select box
                    $('#wards').empty();
                    // Add the new options for the awards for the selected district
                    $.each(data, function (i, wards) {
                        $('#wards').append($('<option>', {
                            value: wards.id,
                            text: wards.name
                        }));
                    });
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log('Error: ' + errorThrown);
                }
            });
        } else {
            // If no district is selected, clear the options in the "award" select box
            $('#wards').empty();
        }
    });
});

