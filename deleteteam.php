<?php
     require_once 'classteam.php';

     $team = new Team();

    // Cek apakah idteam sudah diberikan (misalnya via GET atau POST)
    if(isset($_GET['idteam'])){
        $idteam = $_GET['idteam']; // ambil idteam dari URL
        $fotoPath = "teams/{$idteam}.jpg";
        // Eksekusi query
        $jumlah = $team->deleteTeam($idteam);

        if ($jumlah > 0) {
            if (file_exists($fotoPath)) {
                unlink($fotoPath); // Hapus file foto
            }
            header("Location: team.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus Team. Mungkin team tidak ditemukan.";
        }
    
    }
?>
