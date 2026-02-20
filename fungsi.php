<?php
// fungsi.php
// Tempat fungsi umum digunakan oleh semua halaman

if (!function_exists('clean_input')) {
    function clean_input($data)
    {
        return htmlspecialchars(trim($data));
    }
}

// Fungsi menampilkan pesan flash (jika ada)
function show_flash_message()
{
    if (isset($_SESSION['flash'])) {
        echo '<div class="alert alert-success">' . $_SESSION['flash'] . '</div>';
        unset($_SESSION['flash']);
    }
}

// Fungsi untuk redirect dengan pesan
function redirect_with_message($url, $message)
{
    $_SESSION['flash'] = $message;
    header("Location: $url");
    exit;
}
?>