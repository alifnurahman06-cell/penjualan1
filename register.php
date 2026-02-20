<?php
include 'koneksi.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$message = '';
$showSwal = false; // trigger sweet alert jika sukses

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    /* ---------- validasi sederhana ---------- */
    if ($nama == '' || $username == '' || $email == '' || $password == '') {
        $message = "<div class='alert alert-danger'>Semua kolom wajib diisi!</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-warning'>Format email tidak valid!</div>";
    } elseif (strlen($password) < 5) {
        $message = "<div class='alert alert-warning'>Password minimal 5 karakter!</div>";
    } else {
        /* ---------- deteksi tabel pengguna ---------- */
        $table_found = null;
        foreach (['users', 'user', 'pengguna', 'admin'] as $t) {
            $cek = mysqli_query($conn, "SHOW TABLES LIKE '$t'");
            if ($cek && mysqli_num_rows($cek) > 0) {
                $table_found = $t;
                break;
            }
        }

        if (!$table_found) {
            $message = "<div class='alert alert-danger'>Tabel pengguna tidak ditemukan!</div>";
        } else {
            $table = $table_found;
            /* ---------- cek duplikat ---------- */
            $stmt = mysqli_prepare($conn, "SELECT id FROM `$table` WHERE username = ? OR email = ? LIMIT 1");
            mysqli_stmt_bind_param($stmt, 'ss', $username, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) > 0) {
                $message = "<div class='alert alert-warning'>Username atau email sudah terdaftar!</div>";
            } else {
                /* ---------- insert ---------- */
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $role = 'user'; // default

                $stmt2 = mysqli_prepare($conn, "INSERT INTO `$table` (nama, username, email, password, role) VALUES (?,?,?,?,?)");
                mysqli_stmt_bind_param($stmt2, 'sssss', $nama, $username, $email, $hash, $role);

                if (mysqli_stmt_execute($stmt2)) {
                    $showSwal = true;
                } else {
                    $message = "<div class='alert alert-danger'>Gagal menyimpan data!</div>";
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Daftar Akun - Pet Shop</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <!-- ===== STYLE ===== -->
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

        .card-reg {
            background: #ffffff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .12);
            overflow: hidden;
            width: 100%;
            max-width: 420px;
        }

        .card-header-reg {
            background: var(--primary);
            color: #fff;
            text-align: center;
            padding: 25px 20px 15px;
        }

        .card-header-reg i {
            font-size: 2.8rem;
            margin-bottom: 10px;
        }

        .card-body-reg {
            padding: 30px 35px 25px;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 .20rem rgba(0, 121, 107, .25);
        }

        .btn-reg {
            background: var(--primary);
            border: none;
            font-weight: 600;
            transition: .3s;
        }

        .btn-reg:hover {
            background: var(--primary-dark);
        }

        .input-group-text {
            background: var(--light);
            color: var(--primary-dark);
        }

        .link-login {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        .link-login:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="card-reg" data-aos="fade-up" data-aos-duration="600">
        <!-- Header -->
        <div class="card-header-reg">
            <i class="fas fa-paw"></i>
            <h4 class="mb-0 fw-bold">Daftar Akun Pet Shop</h4>
        </div>

        <!-- Body -->
        <div class="card-body-reg">
            <?= $message ?>

            <form method="POST" novalidate>
                <!-- Nama -->
                <div class="form-group mb-3">
                    <label class="form-label fw-600">Nama Lengkap</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                        <input type="text" name="nama" class="form-control" placeholder="Nama lengkap" required
                            value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                    </div>
                </div>

                <!-- Username -->
                <div class="form-group mb-3">
                    <label class="form-label fw-600">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-id-badge"></i></span>
                        <input type="text" name="username" class="form-control" placeholder="Username" required
                            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group mb-3">
                    <label class="form-label fw-600">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                        <input type="email" name="email" class="form-control" placeholder="Alamat email" required
                            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    </div>
                </div>

                <!-- Password + lihat password -->
                <div class="form-group mb-4">
                    <label class="form-label fw-600">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        <input type="password" name="password" id="pwd" class="form-control"
                            placeholder="Minimal 5 karakter" required minlength="5">
                        <button class="btn btn-outline-secondary" type="button" onclick="togglePwd()"><i
                                class="fa fa-eye" id="eye"></i></button>
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn btn-reg btn-primary w-100 mb-3">DAFTAR</button>

                <!-- Link Login -->
                <div class="text-center">
                    Sudah punya akun? <a href="login.php" class="link-login">Login di sini</a>
                </div>
            </form>
        </div>
    </div>

    <!-- ===== JS ===== -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({ once: true });

        /* ---- toggle lihat password ---- */
        function togglePwd() {
            const input = document.getElementById('pwd');
            const icon = document.getElementById('eye');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        <?php if ($showSwal): ?>
            /* ---- Sweet Alert sukses ---- */
            Swal.fire({
                icon: 'success',
                title: 'Registrasi Berhasil!',
                text: 'Silakan login dengan akun Anda.',
                confirmButtonColor: '#00796b'
            }).then(() => {
                location.href = 'login.php';
            });
        <?php endif; ?>
    </script>

    <!-- Sweet Alert CDN (hanya jika belum ada) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>