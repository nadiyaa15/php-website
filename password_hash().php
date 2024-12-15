<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'nama_database';
$username = 'root';
$password = ''; // Sesuaikan jika diperlukan
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ambil ID pengguna yang akan diubah
    $userId = 1; // Ganti dengan ID pengguna yang sesuai

    // Username baru
    $newUsername = 'cs_ivan';

    // Password baru
    $newPassword = 'mantap1227';
    
    // Hash password baru menggunakan password_hash()
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    // Query untuk mengupdate username dan password
    $stmt = $pdo->prepare("UPDATE users SET username = :username, password = :password WHERE id = :id");
    $stmt->execute([
        'username' => $newUsername,
        'password' => $hashedPassword,
        'id' => $userId
    ]);

    echo "Username dan password berhasil diperbarui!";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
