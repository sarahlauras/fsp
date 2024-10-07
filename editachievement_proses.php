<?php
    require_once 'classachievement.php';
    $achievement = new Achievement();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($name, $description, $date,  $idTeam)) {
            $jumlah = $achievement->editAchievement($name, $description, $Date, $idTeam );

            if ($jumlah > 0) {
                header("Location: achievement.php?result=success");
                exit();
            } else {
                echo "Tidak ada perubahan.";
            }
        } else {
            echo "Semua field harus diisi.";
        }
    }  
    
    else {
        echo "Tidak ada data!";
    }
?>