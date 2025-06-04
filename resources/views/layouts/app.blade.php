<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Gestor de jocs</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: #f8fafc;
        }
        .navbar {
            border-radius: .75rem;
        }
        .navbar-brand {
            font-weight: 600;
            letter-spacing: 1px;
        }
        .container {
            max-width: 700px;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.03);
        }
    </style>
</head>
<body class="bg-light text-dark">

    <nav class="navbar navbar-expand-lg navbar-white bg-white shadow-sm my-4 mx-auto" style="max-width: 700px;">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('jocs.index') }}">Jocs</a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
