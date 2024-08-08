<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fetch Data</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <button id="fetchData">Fetch Product Names</button>
    <div id="productNames"></div>

    <script>
        $(document).ready(function() {
            $('#fetchData').click(function() {
                $.ajax({
                    url: 'demo3.php',
                    type: 'GET',
                    success: function(data) {
                        var products = JSON.parse(data);
                        var html = '<ul>';
                        products.forEach(function(product) {
                            html += '<li>' + product + '</li>';
                        });
                        html += '</ul>';
                        $('#productNames').html(html);
                    },
                    error: function(xhr, status, error) {
                        console.error("An error occurred: " + status + " " + error);
                    }
                });
            });
        });
    </script>
</body>
</html>
