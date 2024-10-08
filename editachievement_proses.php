<?php
require_once 'classachievement.php';
$achievement = new Achievement();

if(isset($_POST['btnSubmit'])) { 
    extract($_POST);
    if (isset($idachievement, $name, $description, $date, $idteam)) {
        $jumlah = $achievement->editAchievement($idachievement, $name, $description, $date, $idteam);
        if ($jumlah > 0) {
            header("Location: achievement.php?result=success");
            exit();
        } else {
            echo "Tidak ada perubahan.";
        }
    } else {
        echo "Semua field harus diisi.";
    }
} else {
    echo "Tidak ada data!";
}
?>
