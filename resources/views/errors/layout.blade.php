<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - PeduliLindungi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <main class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
        <section class="text-center" role="alert">
            <p class="display-1 fw-bold text-success mb-0">@yield('code')</p>
            <h1 class="h2 mb-3">@yield('title')</h1>
            <p class="text-secondary mb-4">@yield('message')</p>
            <a class="btn btn-success" href="{{ route('home') }}">Kembali ke beranda</a>
        </section>
    </main>
</body>
</html>
