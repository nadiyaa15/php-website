<?php
include 'koneksi.php'; // Pastikan file koneksi sudah ada
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Sistem Pengarsipan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .header img {
            height: 50px;
        }
        .header h1 {
            font-size: 1.8rem;
            color: #333;
            margin: 0;
        }
        h2 {
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: #fff;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        a {
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
        .action-links {
            margin-top: 20px;
            text-align: center;
        }
        .action-links a {
            margin: 0 10px;
            color: #007bff;
            font-weight: bold;
        }
        .action-links a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="logo_mandiri_taspen.png" alt="Logo Mandiri Taspen">
        </div>
        <h1>Selamat Datang, cs_ivan!</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Dokumen</th>
                    <th>Kategori</th>
                    <th>Tanggal Upload</th>
                </tr>
            </thead>
            <tbody>
                <?php
                try {
                    // Ambil data dari tabel 'dokumen'
                    $stmt = $pdo->query("SELECT * FROM dokumen");
                    $no = 1; // Nomor urut

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($row['nama_dokumen']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['kategori']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['tanggal_upload']) . "</td>";
                        echo "</tr>";
                    }
                } catch (PDOException $e) {
                    echo "<tr><td colspan='4'>Error: " . $e->getMessage() . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="action-links">
            <a href="upload.php">Unggah Dokumen Baru</a> |
            <a href="lihat_semua_dokumen.php">Lihat Semua Dokumen</a> |
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>
