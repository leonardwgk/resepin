<!doctype html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Resep.in</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  </head>
  <body>

    <nav class="navbar navbar-expand-lg fixed-top py-3">
      <div class="container">
        <a class="navbar-brand fs-4" href="/">
            Resep<span class="oranye">.in</span>
        </a>
      </div>
    </nav>

    <main class="py-5 mt-5">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('image-preview');
                output.src = reader.result;
                output.style.display = 'block';
                document.getElementById('upload-placeholder').style.display = 'none';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
  </body>
</html>