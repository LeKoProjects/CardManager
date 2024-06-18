<!-- resources/views/errors/error_exception.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erro Exceção</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #343a40;
        }
        .container {
            text-align: center;
            padding: 20px;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        p {
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }
        .home-link {
            display: inline-block;
            margin-top: 1rem;
            padding: 0.5rem 1rem;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }
        .home-link:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                window.location.href = '/';
            }, 2000); // Redireciona após 5 segundos
        });
    </script>
</head>
<body>
    <div class="container">
        <h1>Ocorreu um erro</h1>
        <p>Desculpe, algo deu errado. Por favor, tente novamente mais tarde.</p>
        <a href="/home" class="home-link">Ir para a Home</a>
    </div>
</body>
</html>
