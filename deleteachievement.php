<?php
    require_once 'classachievement.php';

    $achievement = new Achievement();

    if(isset($_GET['idachievement'])) {
        $idachievement = $_GET['idachievement'];
        $jumlah = $achievement->deleteAchievement($idachievement);

        if ($jumlah > 0) {
            header("Location: achievement.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus achievement.";
        }
    } else {
            echo "ID achievement tidak ditemukan.";
    }
    
?>
