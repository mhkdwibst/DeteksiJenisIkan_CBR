<?php
session_start();

// Ganti dengan username dan password admin Anda
$pakar_username = 'pakar';
$pakar_password = 'password'; // Gunakan password hash untuk keamanan yang lebih baik

$username = $_POST['username'];
$password = $_POST['password'];

// Verifikasi kredensial
if ($username === $pakar_username && $password === $pakar_password) {
    $_SESSION['loggedin'] = true;
    header('Location: pakar.php'); // Arahkan ke halaman pakar
    exit();
} else {
    echo "<p class='text-danger'>Username atau password salah.</p>";
    echo "<a href='login_pakar.php'>Kembali ke halaman login</a>";
}
?>