<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Laravel TDD App' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <x-navigation />

        @yield('header')

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>