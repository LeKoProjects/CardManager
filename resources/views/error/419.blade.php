<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>ERROR - ePRONTUARIO</title>
    <script type="text/javascript">
        // Redireciona automaticamente para a página de login após 3 segundos
        setTimeout(function() {
            window.location.href = '/';
        }, 2000);
    </script>
  </head>
  <body>
    
    <div class="page-error">
        <h1 class="text-danger"><i class="bi bi-exclamation-circle"></i> Error 419: Token Expirado</h1>
        <p>Seu token de sessão expirou. Você será redirecionado para a página de login em breve.</p>
        <p>Se não for redirecionado, clique <a class="btn btn-primary" href='/'>aqui</a>.</p>
    </div>
    <!-- Essential javascripts for application to work-->
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>