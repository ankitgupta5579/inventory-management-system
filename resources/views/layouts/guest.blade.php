<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="auth-wrapper p-3">
        <div class="auth-card">
            <div class="text-center text-white mb-4">
                <i class="bi bi-box-seam fs-1"></i>
                <h3 class="fw-bold">Inventory System</h3>
            </div>
            @yield('content')
        </div>
    </div>
</body>
</html>