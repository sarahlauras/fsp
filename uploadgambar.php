<?php  
$target_dir = "teams/"; // Pastikan folder teams berada satu tingkat di atas file uploadgambar.php

// Pastikan idteam ada dalam POST data
if (isset($_POST['idteam'])) {
    $nama_file = $_POST['idteam']; // Mengambil idteam yang dikirim dari form
} else {
    echo "ID team tidak ditemukan!";
    exit;
}

if (!isset($_FILES['photo'])) {
    echo "File tidak ditemukan. Pastikan Anda telah memilih file.";
    exit;
}

$photo = $_FILES['photo'];

// Validasi ekstensi file
$fileType = strtolower(pathinfo($photo['name'], PATHINFO_EXTENSION));
if ($fileType !== 'jpg') {
    echo "Hanya file dengan ekstensi .jpg yang diperbolehkan.";
    exit;
}

// Nama file baru dengan format idteam.jpg
$file_path = $target_dir . $nama_file . ".jpg";

// Periksa apakah file berhasil di-upload
if ($photo['error'] === UPLOAD_ERR_OK) {
    // Periksa jika file lama sudah ada, dan hapus dulu jika ada
    if (file_exists($file_path)) {
        unlink($file_path); // Menghapus file lama
    }

    // Memindahkan file baru ke folder tujuan dengan nama file berdasarkan idteam
    if (move_uploaded_file($photo['tmp_name'], $file_path)) {
        echo "Gambar berhasil terupload.";
    } else {
        echo "Gagal memindahkan file ke folder tujuan.";
    }
} else {
    echo "Terjadi kesalahan saat mengupload gambar. Error code: " . $photo['error'];
}
?>
