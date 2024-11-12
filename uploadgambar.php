<?php  

$target_dir = "teams/"; // Pastikan folder teams berada satu tingkat di atas file uploadgambar.php



// Pastikan idteam ada dalam POST data
if (isset($_POST['idteam'])) {
    $nama_file = $_POST['idteam']; // Mengambil idteam yang dikirim dari form
} else {
    echo "ID team tidak ditemukan!";
    exit;
}

$photo = $_FILES['photo'];

// Periksa apakah file berhasil di-upload
if ($photo['error'] === UPLOAD_ERR_OK) {
    // Nama file baru dengan format idteam.jpg
    $file_path = $target_dir . $nama_file . ".jpg";
    
    // Periksa jika file lama sudah ada, dan hapus dulu jika ada
    if (file_exists($file_path)) {
        unlink($file_path); // Menghapus file lama
    }

    // Memindahkan file baru ke folder tujuan dengan nama file berdasarkan idteam
    move_uploaded_file($photo['tmp_name'], $file_path);
    echo "Gambar berhasil terupload dan digantikan";
} else {
    echo "Terjadi kesalahan saat mengupload gambar.";
}

?>
