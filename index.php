<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0 text-center">Masuk</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted text-center">Pilih sesi Anda untuk Masuk.</p>
                        <div class="d-flex justify-content-center mb-3">
                            <a href="login.php" class="btn btn-dark mr-3">Admin</a>
                            <a href="pengguna/login_pelanggan.php" class="btn btn-secondary">Pengguna</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
