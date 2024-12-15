<?php
// Tentukan action dari URL
$action = isset($_GET['action']) ? $_GET['action'] : 'index';

require 'config/database.php'; 
require 'views/documents.php';  

// Logika berdasarkan action
if ($action == 'index') {
    // Ambil semua dokumen
    $documents = Document::getAll($pdo);

    require 'views/documents/index.php';  // Tampilkan daftar dokumen
} elseif ($action == 'upload') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $category = $_POST['category'];
        $file = $_FILES['file'];

        // Cek apakah file berhasil diupload
        if ($file['error'] == 0) {
            // Tentukan lokasi penyimpanan file
            $filePath = 'uploads/' . basename($file['name']);
            // Pindahkan file ke folder 'uploads'
            move_uploaded_file($file['tmp_name'], $filePath);

// Mendapatkan semua dokumen dari database
$documents = Document::getAll($pdo);

// Mengirim data ke view documents.php
require 'views/documents.php';

            // Redirect setelah upload
            header("Location: index.php?action=index");  // Redirect ke halaman daftar dokumen
            exit; // Pastikan tidak ada kode yang dijalankan setelah redirect
        }
    }
    // Tampilkan form upload
    require 'views/upload.php';  
}
?>
