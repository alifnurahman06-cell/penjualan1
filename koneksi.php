<?php
// =========================
// KONFIGURASI DATABASE
// =========================
$host = "localhost";
$username = "root";
$password = "";
$database = "petshop_db";

// Membuat koneksi ke MySQL (gunakan @include_once agar tidak ganda)
$conn = @mysqli_connect($host, $username, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Set charset agar mendukung karakter spesial
mysqli_set_charset($conn, "utf8mb4");

// =========================
// START SESSION
// =========================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// =========================
// FUNGSI BANTUAN
// =========================

// Membersihkan input dari karakter berbahaya
if (!function_exists('clean_input')) {
    function clean_input($data)
    {
        global $conn;
        $data = trim($data);
        $data = stripslashes($data);
        $data = mysqli_real_escape_string($conn, $data);
        return $data;
    }
}

// Menampilkan pesan alert Bootstrap
if (!function_exists('show_message')) {
    function show_message($message, $type = 'success')
    {
        $alert_class = ($type == 'success') ? 'alert-success' : 'alert-danger';
        return "
            <div class='alert $alert_class alert-dismissible fade show mt-3' role='alert'>
                $message
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }
}

// Mengecek apakah user sudah login
if (!function_exists('check_login')) {
    function check_login()
    {
        if (!isset($_SESSION['user_id'])) {
            header("Location: ../login.php");
            exit();
        }
    }
}

// Mengecek apakah yang login adalah admin
if (!function_exists('check_admin')) {
    function check_admin()
    {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
            header("Location: ../login.php");
            exit();
        }
    }
}
?>