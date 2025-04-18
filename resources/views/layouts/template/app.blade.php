<!-- filepath: /C:/laragon/www/pengajuan-cuti/resources/views/layouts/template/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Cuti</title>
    <meta name="description" content="Sistem Pengajuan Cuti">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="cuti, pengajuan cuti, sistem cuti">  

    <!-- Favicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="{{ asset('template/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('template/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Inter:wght@300;400;500;600;700&family=Nunito:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('template/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('template/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('template/assets/css/main.css') }}" rel="stylesheet">
    
    @stack('css')
    <style>
        /* Update the dropdown styles */
        .nav-account .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            min-width: 200px;
            padding: 0.5rem 0;
            background: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(1, 41, 112, 0.1);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease-in-out;
        }
    
        .nav-account .dropdown-menu.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }
    
        /* Add z-index to ensure dropdown appears above other elements */
        .nav-account {
            position: relative;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    @include('layouts.template.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Navbar -->
        @include('layouts.template.navbar')

        <!-- Page Content -->
        <div class="content">
            @yield('content')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    
    <!-- Vendor JS Files -->
    <script src="{{ asset('template/assets/js/main.js') }}"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize dropdowns
            const dropdownButton = document.querySelector('.nav-account .dropdown-toggle');
            const dropdownMenu = document.querySelector('.nav-account .dropdown-menu');
        
            if (dropdownButton && dropdownMenu) {
                dropdownButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    dropdownMenu.classList.toggle('show');
                });
        
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                        dropdownMenu.classList.remove('show');
                    }
                });
            }
        });
        </script>
    
    @stack('scripts')
    </body>
</html>