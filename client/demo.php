<!DOCTYPE html>
<html>
<head>
    <title>Upload and Preview Multiple Images</title>
    <style>
        #imagePreview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 20px;
        }
        #imagePreview img {
            max-width: 150px;
            height: auto;
            display: none;
        }
    </style>
</head>
<body>
    <h1>Upload and Preview Multiple Images</h1>
    <form>
        <input type="file" id="imageUpload" accept="image/*" multiple>
        <div id="imagePreview"></div>
    </form>
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            var imagePreview = document.getElementById('imagePreview');
            imagePreview.innerHTML = ''; // Xóa nội dung cũ trước khi hiển thị ảnh mới
            
            var files = event.target.files;
            
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                
                if (file) {
                    var reader = new FileReader();
                    reader.onload = (function(file) {
                        return function(e) {
                            var img = document.createElement('img');
                            img.src = e.target.result;
                            img.style.display = 'block';
                            imagePreview.appendChild(img);
                        };
                    })(file);
                    reader.readAsDataURL(file);
                }
            }
        });
    </script>
</body>
</html>
