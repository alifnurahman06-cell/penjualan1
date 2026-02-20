<?php
session_start();
include 'koneksi.php';

if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            /* arahkan sesuai role */
            if ($user['role'] === 'admin') {
                header('Location: admin/dashboard.php');
            } else {
                header('Location: user/dashboard.php');   // <── hanya ini yang diganti
            }
            exit;
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login - Pet Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css " rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css ">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css " rel="stylesheet">

    <style>
        :root {
            --primary: #00796b;
            --primary-dark: #004d40;
            --light: #e0f2f1;
        }

        body {
            background: linear-gradient(135deg, var(--light) 0%, #f0f8ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 15px;
        }

        .login-card {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .12);
            overflow: hidden;
        }

        .login-header {
            background: var(--primary);
            color: #fff;
            padding: 30px 25px 20px;
            text-align: center;
        }

        .login-header i {
            font-size: 3rem;
            margin-bottom: 10px;
        }

        .login-body {
            padding: 30px 35px 25px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .20rem rgba(0, 121, 107, .25);
        }

        .btn-login {
            background: var(--primary);
            border: none;
            font-weight: 600;
            letter-spacing: .5px;
            transition: .3s;
        }

        .btn-login:hover {
            background: var(--primary-dark);
        }

        .alert-error {
            font-size: .9rem;
            border-radius: 8px;
        }

        .link-reg {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .link-reg:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="login-wrapper" data-aos="fade-up" data-aos-duration="600">
        <div class="login-card">

            <!-- Header -->
            <div class="login-header">
                <i class="fas fa-paw"></i>
                <h4 class="mb-0 fw-bold">Pet Shop Login</h4>
            </div>

            <!-- Body -->
            <div class="login-body">
                <?php if ($error): ?>
                    <div class="alert alert-danger alert-error text-center"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form method="POST" novalidate>
                    <!-- Username -->
                    <div class="form-group mb-3">
                        <label class="form-label fw-600">Username</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username"
                                required autofocus>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-4">
                        <label class="form-label fw-600">Password</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Masukkan password"
                                required>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-login btn-primary w-100 mb-3">LOGIN</button>

                    <!-- Link Register -->
                    <div class="text-center">
                        Belum punya akun? <a href="register.php" class="link-reg">Daftar di sini</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js "></script>
    <script>
        AOS.init({ once: true });
    </script>
</body>

</html>