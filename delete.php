<?php
// Pastikan Anda sudah menyertakan koneksi database
include 'koneksi.php'; // Sesuaikan dengan path file koneksi Anda

if (isset($_GET['file'])) {
    $file_to_delete = "uploads/" . $_GET['file'];
    $message = "";
    $status = "";

    // Mengambil nama file dari URL
    $file_name = $_GET['file'];

    // Pastikan file yang akan dihapus ada di server
    if (file_exists($file_to_delete)) {
        try {
            // Hapus informasi file dari database
            $stmt = $pdo->prepare("DELETE FROM dokumen WHERE nama_dokumen = :file_name");
            $stmt->bindParam(':file_name', $file_name);
            $stmt->execute();

            // Hapus file dari server
            if (unlink($file_to_delete)) {
                $message = "Dokumen berhasil dihapus.";
                $status = "success";
            } else {
                $message = "Gagal menghapus dokumen dari server.";
                $status = "error";
            }
        } catch (PDOException $e) {
            $message = "Terjadi kesalahan saat menghapus data dari database: " . $e->getMessage();
            $status = "error";
        }
    } else {
        $message = "Dokumen tidak ditemukan di server.";
        $status = "error";
    }
} else {
    $message = "File tidak ditentukan.";
    $status = "error";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Penghapusan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            text-align: center;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .message {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .success {
            color: #28a745;
        }
        .error {
            color: #dc3545;
        }
        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <p class="message <?php echo htmlspecialchars($status); ?>">
            <?php echo htmlspecialchars($message); ?>
        </p>
        <a href="lihat_semua_dokumen.php">Kembali</a>
    </div>
</body>
</html>
