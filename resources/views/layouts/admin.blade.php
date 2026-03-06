<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - @yield('title', 'Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f4f6f9;
        }
        .admin-header {
            background: #0d6efd;
            color: white;
            padding: 12px 20px;
            margin-bottom: 20px;
        }
    </style>

</head>
<body>

    {{-- HEADER ADMIN --}}
    <div class="admin-header">
        <h4 class="m-0">Admin Panel Website</h4>
    </div>

    {{-- KONTEN HALAMAN --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
