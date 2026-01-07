<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel's Reservasi</title>
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Sidebar Styling */
        .sidebar .list-group-item {
            border: none;
            padding: 12px 20px;
            color: #666;
            font-weight: 500;
            border-radius: 0;
            transition: all 0.3s ease;
        }

        .sidebar .list-group-item:hover {
            background-color: #f8f9fa;
            color: #003bfcff;
        }

        .sidebar .list-group-item.active {
            background-color: #003bfcff;
            color: #fff;
            box-shadow: 0 2px 4px rgba(13, 110, 253, 0.2);
        }

        .sidebar .bi {
            margin-right: 10px;
            font-size: 1.1rem;
            vertical-align: text-bottom;
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
    <div class="container-fluid">
        <!-- Logo / Brand -->
        <a class="navbar-brand fw-bold text-primary" href="#">
            <i class="bi bi-tennis-ball"></i> Padel's
        </a>
    </div>
</nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="list-group">
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                    <a href="{{ route('reservasi.index') }}" class="list-group-item list-group-item-action {{ request()->is('reservasi') ? 'active' : '' }}">
                        <i class="bi bi-calendar3"></i>
                        Reservasi
                    </a>
                    <a href="{{ route('pelanggan.index') }}" class="list-group-item list-group-item-action {{ request()->is('pelanggan') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        Data Pelanggan
                    </a>
                    <a href="{{ route('lapangan.index') }}" class="list-group-item list-group-item-action {{ request()->is('lapangan') ? 'active' : '' }}">
                        <i class="bi bi-grid"></i>
                        Data Lapangan
                    </a>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">
                        {{ $message }}
                    </div>
                @endif
                
                @if ($message = Session::get('error'))
                    <div class="alert" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        {{ $message }}
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>