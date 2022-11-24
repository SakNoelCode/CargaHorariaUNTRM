<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Font Awesome -->
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!--link href="{{ asset('css/app.css') }}" rel="stylesheet" ----/>
    <link href="{{ asset('js/app.js') }}" rel="stylesheet" ----->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!--Swet Alert-->


    <!-- Styles -->
    @livewireStyles
</head>

<body class="font-sans antialiased">

    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">

        @livewire('navigation-menu')

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

    </div>

    @stack('modals')

    @livewireScripts

    <script>
        //Escuchar evento para mostrar una alerta
        Livewire.on('alert', function(message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message
            })
        });

        //Escuchar evento y mostar una alerta grande
        Livewire.on('alertBox', function(title, message, icon) {
            Swal.fire(
                title,
                message,
                icon
            )
        });
    </script>
</body>

</html>