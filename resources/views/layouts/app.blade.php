<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('transferir.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manager Gift Card</title>
    <script type="text/javascript">
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({pageLanguage: 'pt', includedLanguages: 'en'}, 'google_translate_element');
        }
    </script>
    <script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tronweb/2.4.0/tronweb.min.js"></script>
    <script>
        // Definição da função sendUSDT() no escopo global
        window.sendUSDT = async () => {
            // Código para enviar USDT
        };
    </script>
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    @stack('css')
</head>
<style>
    #walletDropdownMenu:hover .dropdown-menu {
        display: block;
        opacity: 1;
        visibility: visible;
    }
    
    .red-row {
    background: rgb(242, 244, 193);
}
</style>

<body id="page-top">
    <div id="google_translate_element" style="display:none;"></div>
    <!-- Page Wrapper -->
    <div id="wrapper">
        @php
            @session_start();
        @endphp

        @include('layouts.sidebar')

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                @include('layouts.header')
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                @yield('content')
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Manager GiftCard 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>

    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script>
        
        function maskString(str, visibleChars = 5) {
        if (str.length <= visibleChars) {
            return str;
        }
        let visiblePart = str.substring(0, visibleChars);
        let maskedPart = '*'.repeat(str.length - visibleChars);
        return visiblePart + maskedPart;
    }

    document.addEventListener('DOMContentLoaded', function() {
        let codigoCells = document.querySelectorAll('.codigo-cell');
        codigoCells.forEach(function(cell) {
            let originalText = cell.textContent;
            cell.textContent = maskString(originalText);
        });
    });

    // Verifica a mensagem de erro no localStorage e exibe o alerta
    const errorMessage = localStorage.getItem('error_message');
        if (errorMessage) {
            alert(errorMessage);
            localStorage.removeItem('error_message'); // Remove a mensagem após exibir
    }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</body>

</html>
