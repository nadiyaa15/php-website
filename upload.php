<?php
// Pastikan Anda sudah menyertakan koneksi database
include 'koneksi.php'; // Sesuaikan path ke file koneksi Anda

// Periksa apakah file diunggah
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Direktori tujuan untuk menyimpan file
    $target_dir = "uploads/";

    // Buat folder jika belum ada
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Nama file tujuan
    $filename = preg_replace("/[^a-zA-Z0-9-_\.]/", "", basename($_FILES["file"]["name"])); // Sanitasi nama file
    $target_file = $target_dir . $filename;
    $uploadOk = 1;

    // Ekstensi file
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Validasi tipe MIME file
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $fileMimeType = finfo_file($finfo, $_FILES["file"]["tmp_name"]);
    finfo_close($finfo);

    if ($fileMimeType != "application/pdf") {
        $message = "Hanya file PDF yang diperbolehkan.";
        $uploadOk = 0;
    }

    // Validasi apakah file sudah ada
    if (file_exists($target_file)) {
        $message = "File dengan nama yang sama sudah ada.";
        $uploadOk = 0;
    }

    // Validasi ukuran file (maksimal 5MB)
    if ($_FILES["file"]["size"] > 5000000) {
        $message = "Ukuran file terlalu besar (maksimal 5MB).";
        $uploadOk = 0;
    }

    // Jika semua validasi lolos, unggah file
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Menyimpan informasi file ke database
            try {
                // Masukkan data ke database
                $stmt = $pdo->prepare("INSERT INTO dokumen (nama_dokumen, kategori, tanggal_upload, status) 
                                       VALUES (:nama_dokumen, :kategori, NOW(), 'belum')");
                $stmt->bindParam(':nama_dokumen', $filename);
                $stmt->bindParam(':kategori', $_POST['kategori']);
                $stmt->execute();
                
                $message = "File " . htmlspecialchars($filename) . " berhasil diunggah dan disimpan.";
                $success = true;
            } catch (PDOException $e) {
                $message = "Terjadi kesalahan saat menyimpan data ke database: " . $e->getMessage();
                $success = false;
            }
        } else {
            $message = "Terjadi kesalahan saat mengunggah file.";
            $success = false;
        }
    } else {
        $success = false;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unggah Dokumen Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }
        .message {
            color: <?php echo isset($success) && $success ? '#28a745' : '#dc3545'; ?>;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        input[type="file"], select {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }
        .button {
            background-color: #0275d8;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            width: 100%;
            box-sizing: border-box;
        }
        .button:hover {
            background-color: #025aa5;
        }
        .back-link {
            margin-top: 10px;
            display: inline-block;
            font-size: 14px;
            color: #0275d8;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Unggah Dokumen Baru</h2>
        <?php if (isset($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <select name="kategori" id="kategori" required>
                    <option value="PEMBUKAAN REKENING">PEMBUKAAN REKENING</option>
                    <option value="DEPOSIT">DEPOSIT</option>
                    <option value="KREDIT">KREDIT</option>
                    <option value="AP3K">AP3K</option>
                </select>
            </div>
            <div class="form-group">
                <input type="file" name="file" id="file" required>
            </div>
            <button type="submit" class="button">Unggah</button>
        </form>
        <a href="dashboard.php" class="back-link">Kembali</a>
    </div>
</body>
</html>
