<?php
session_start();

// Ganti dengan username dan password admin Anda
$admin_username = 'admin';
$admin_password = 'password'; // Gunakan password hash untuk keamanan yang lebih baik

$username = $_POST['username'];
$password = $_POST['password'];

// Verifikasi kredensial
if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['loggedin'] = true;
    header('Location: admin.php'); // Arahkan ke halaman admin
    exit();
} else {
    echo "<p class='text-danger'>Username atau password salah.</p>";
    echo "<a href='login_admin.php'>Kembali ke halaman login</a>";
}
?>