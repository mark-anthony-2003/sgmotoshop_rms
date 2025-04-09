<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'SG')</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')

    {{-- Raleway Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@100..800&display=swap" rel="stylesheet">
</head>
<body class="flex flex-col min-h-screen">
    @include('includes.header')
    @include('includes.sidebar')

    <main class="flex-1 p-6 sm:p-8 lg:p-10 max-w-full bg-white rounded-lg shadow-md">
        <div class="container mx-auto">
            @yield('content')
        </div>
    </main>

    @include('includes.footer')

    @stack('scripts')
</body>
</html>
