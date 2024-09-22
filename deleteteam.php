<?php
    // Koneksi ke database
    $mysqli = new mysqli("localhost", "root", "", "esport");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: ".$mysqli->connect_error;
        exit();
    }

    // Cek apakah idteam sudah diberikan (misalnya via GET atau POST)
    if(isset($_GET['idteam'])){
        $idteam = $_GET['idteam']; // ambil idteam dari URL

        // Persiapkan query untuk menghapus team berdasarkan idteam
        $stmt = $mysqli->prepare("DELETE FROM team WHERE idteam = ?");
        
        // Bind parameter (i untuk integer)
        $stmt->bind_param("i", $idteam);
        
        // Eksekusi query
        if($stmt->execute()){
            echo "Team berhasil dihapus.";
            // Redirect ke halaman lain atau tampilkan pesan sukses
            header("Location: team.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus team: " . $stmt->error;
        }
        
        // Tutup statement
        $stmt->close();
    }
    // Tutup koneksi
    $mysqli->close();
?>
