<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Padel's Reservasi</title>
    <style>
        :root {
            --primary-color: #333;
            --secondary-color: #f4f4f4;
            --accent-color: #ddd;
            --text-color: #333;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--secondary-color);
            color: var(--text-color);
        }

        .header {
            background-color: #fff;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .header h1 {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .profile-icon {
            width: 40px;
            height: 40px;
            background-color: #e0e0e0;
            /* Placeholder gray circle */
            border-radius: 50%;
        }

        .container {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 2rem;
            border: 1px solid #eee;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            border-bottom: 1px solid #f0f0f0;
            padding-bottom: 1rem;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }

        .btn {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
            transition: background-color 0.2s;
        }

        .btn-primary {
            background-color: #e0e0e0;
            /* Match wireframe gray/light button */
            color: #333;
            font-weight: 500;
        }

        .btn-primary:hover {
            background-color: #d0d0d0;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        th,
        td {
            text-align: left;
            padding: 0.75rem;
            border-bottom: 1px solid #eee;
        }

        th {
            font-weight: 600;
            color: #555;
        }

        /* Form Styles */
        .form-group {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .form-group label {
            width: 150px;
            /* Fixed width labels for alignment */
            font-weight: 500;
        }

        .form-control {
            flex: 1;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: #e0e0e0;
            /* Grey background as in wireframe */
            border: none;
        }

        .form-actions {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
        }

        .alert {
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 4px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Padel's Reservasi</h1>
        <div class="profile-icon"></div>
    </div>

    <div class="container">
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

</body>

</html>