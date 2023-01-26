<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://kit.fontawesome.com/0dec8d6a33.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tiny.cloud/1/unftqo57k6yahkdadtqq2mam2s8n2ty7ka7yq9buhzuifb8w/tinymce/6/tinymce.min.js"
        referrerpolicy="origin"></script>
</head>

<body class="font-sans antialiased {{ Session::get('darkMode') }}">
    <div class="min-h-screen bg-gray-100 dark:bg-black">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow dark:bg-black">
                <div
                    class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 dark:text-white dark:border-white dark:border-x-2 dark:border-b-2">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
</body>

</html>
