<?php
// Lokasi folder tempat dokumen disimpan
$target_dir = "uploads/";

// Membaca semua file di dalam folder uploads
$files = array_diff(scandir($target_dir), array('..', '.'));

// Proses pencarian jika ada input pencarian
$search_query = isset($_GET['search']) ? strtolower($_GET['search']) : '';

if ($search_query) {
    // Filter file yang mengandung kata kunci pencarian
    $files = array_filter($files, function($file) use ($search_query) {
        return strpos(strtolower($file), $search_query) !== false;
    });
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Dokumen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }
        h2 {
            color: #333;
        }
        .search-container {
            margin-bottom: 20px;
        }
        .search-container input[type="text"] {
            padding: 10px;
            font-size: 16px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .search-container button {
            padding: 10px 20px;
            background-color: #0275d8;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-container button:hover {
            background-color: #025aa5;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ccc;
        }
        th {
            background-color: #0275d8;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e0f3ff;
        }
        a {
            color: #0275d8;
            text-decoration: none;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
        .dashboard-link {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>Daftar Dokumen yang Diunggah</h2>

    <!-- Form Pencarian -->
    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="search" placeholder="Cari dokumen..." value="<?php echo htmlspecialchars($search_query); ?>">
            <button type="submit">Cari</button>
        </form>
    </div>

    <?php if (count($files) > 0): ?>
        <table>
            <tr>
                <th>Nama Dokumen</th>
                <th>Link Unduh</th>
                <th>Aksi</th> <!-- Tambahkan kolom ini pada header tabel -->
            </tr>

            <?php
            // Menampilkan daftar file setelah pencarian
            foreach ($files as $file) {
                // Validasi untuk mencegah akses file ilegal
                $filePath = $target_dir . $file;
                if (is_file($filePath)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($file) . "</td>";
                    echo "<td><a href='" . htmlspecialchars($filePath) . "' download>Unduh</a></td>";
                    // Tambahkan kolom Aksi dengan tombol Edit dan Hapus
                    echo "<td>
                            <a href='edit.php?file=" . urlencode($file) . "'>Edit</a> |
                            <a href='delete.php?file=" . urlencode($file) . "' onclick=\"return confirm('Yakin ingin menghapus dokumen ini?')\">Hapus</a>
                          </td>";
                    echo "</tr>";
                }
            }
            ?>
        </table>
    <?php else: ?>
        <p>Tidak ada dokumen yang tersedia.</p>
    <?php endif; ?>
    
    <div class="dashboard-link">
        <a href="dashboard.php">Kembali</a>
    </div>
</body>
</html>
