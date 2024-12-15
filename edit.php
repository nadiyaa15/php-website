<?php
// Pastikan Anda sudah menyertakan koneksi ke database
include 'koneksi.php'; // Sesuaikan dengan path file koneksi Anda

if (isset($_GET['file'])) {
    $old_file = $_GET['file'];
    $target_dir = "uploads/";
    $old_file_path = $target_dir . $old_file;

    $message = ""; // Variabel untuk pesan pengguna

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Jika pengguna mengganti nama file
        if (!empty($_POST['new_name'])) {
            $new_file_name = $_POST['new_name'];
            $new_file_path = $target_dir . $new_file_name;

            // Periksa apakah nama file baru sudah ada
            if (file_exists($new_file_path)) {
                $message = "Nama file baru sudah ada. Pilih nama lain.";
            } elseif (rename($old_file_path, $new_file_path)) {
                // Perbarui nama file di database
                try {
                    $stmt = $pdo->prepare("UPDATE dokumen SET nama_dokumen = :new_name, file_path = :new_file_path WHERE nama_dokumen = :old_file");
                    $stmt->bindParam(':new_name', $new_file_name);
                    $stmt->bindParam(':new_file_path', $new_file_path);
                    $stmt->bindParam(':old_file', $old_file);
                    $stmt->execute();

                    $message = "Nama dokumen berhasil diubah menjadi: " . htmlspecialchars($new_file_name);
                } catch (PDOException $e) {
                    $message = "Dokumen Gagal diubah: " . $e->getMessage();
                }
            } else {
                $message = "Gagal mengubah nama dokumen. Pastikan file lama ada.";
            }
        }

        // Jika pengguna mengunggah file baru
        if (!empty($_FILES['upload_file']['name'])) {
            $upload_file_name = basename($_FILES['upload_file']['name']);
            $upload_file_path = $target_dir . $upload_file_name;

            // Unggah file baru
            if (move_uploaded_file($_FILES['upload_file']['tmp_name'], $upload_file_path)) {
                // Simpan informasi file baru ke database
                try {
                    $stmt = $pdo->prepare("UPDATE dokumen SET nama_dokumen = :new_name, file_path = :new_file_path WHERE nama_dokumen = :old_file");
                    $stmt->bindParam(':new_name', $upload_file_name);
                    $stmt->bindParam(':new_file_path', $upload_file_path);
                    $stmt->bindParam(':old_file', $old_file);
                    $stmt->execute();

                    $message = "File baru berhasil diunggah dan diperbarui: " . htmlspecialchars($upload_file_name);
                } catch (PDOException $e) {
                    $message = "Gagal memperbarui data: " . $e->getMessage();
                }
            } else {
                $message = "Gagal mengunggah file baru.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit & Upload Dokumen</title>
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
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .message {
            margin-bottom: 15px;
            color: #28a745;
            font-size: 16px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!empty($message)) : ?>
            <p class="message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data">
            <label for="new_name">Nama Baru:</label>
            <input type="text" id="new_name" name="new_name" value="<?php echo htmlspecialchars($old_file); ?>" placeholder="Masukkan nama baru" required>

            <label for="upload_file">Unggah File Baru:</label>
            <input type="file" id="upload_file" name="upload_file">

            <button type="submit">Simpan Perubahan</button>
        </form>
        <a href="lihat_semua_dokumen.php">Kembali</a>
    </div>
</body>
</html>
