<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <span class="navbar-brand mb-0 h1">Bakery Expiry Tag Generator</span>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="text-center mt-4">
        <p>&copy; {{ date('Y') }} Bakery Expiry Tag Generator. All rights reserved.</p>
    </footer>
</body>

</html>
