<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validasi apakah field username dan password ada
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Contoh validasi login
        if ($username == 'cs_ivan' && $password == 'mantap1227') {
            echo "Login berhasil. Selamat datang, $username!";
        } else {
            echo "Username atau password salah!";
        }
    } else {
        echo "Harap isi username dan password!";
    }
} else {
    echo "Akses tidak valid!";
}
?>
