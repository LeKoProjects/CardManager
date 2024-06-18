<!-- resources/views/errors/419.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>419 - Page Expired</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
        }
        .container {
            text-align: center;
        }
        h1 {
            font-size: 48px;
            margin-bottom: 20px;
        }
        p {
            font-size: 24px;
            margin-bottom: 40px;
        }
        a {
            display: inline-block;
            padding: 10px 20px;
            font-size: 18px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>419 - Página Expirada</h1>
        <p>A sessão expirou. Você será redirecionado para a página inicial em alguns segundos.</p>
        <a href="{{ url('/') }}">Faça o login novamente</a>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = "{{ url('/') }}";
        }, 5000); // Redireciona após 5 segundos
    </script>
</body>
</html>
