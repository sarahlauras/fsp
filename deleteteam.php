<?php
     require_once 'classteam.php';

     $team = new Team();

    // Cek apakah idteam sudah diberikan (misalnya via GET atau POST)
    if(isset($_GET['idteam'])){
        $idteam = $_GET['idteam']; // ambil idteam dari URL
        // Eksekusi query
        $jumlah = $team->deleteTeam($idteam);

        if ($jumlah > 0) {
            header("Location: team.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus Team. Mungkin team tidak ditemukan.";
        }
    
    }
?>
