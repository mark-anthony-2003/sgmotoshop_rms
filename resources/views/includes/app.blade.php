<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SG')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="./node_modules/apexcharts/dist/apexcharts.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./node_modules/lodash/lodash.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://preline.co/assets/js/hs-apexcharts-helpers.js"></script>
    <script src="https://preline.co/assets/js/hs-apexcharts-helpers.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen">
    @include('includes.header')
    
    <div class="flex flex-1">
        @include('includes.sidebar')

        <main class="flex-1 p-6 bg-white shadow-inner">
            <div class="container mx-auto">
                @yield('content')
            </div>
        </main>
    </div>

    @include('includes.footer')

    @stack('scripts')
</body>
</html>
