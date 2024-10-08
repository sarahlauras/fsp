<?php
require_once 'classachievement.php';
$achievement = new Achievement();
echo "<pre>";
print_r($_POST);
echo "</pre>";
if(isset($_POST['btnSubmit'])) { 
    extract($_POST);
    if (isset($idachievement, $name, $description, $date, $idteam)) {
        $jumlah = $achievement->editAchievement($name, $description,$date, $idteam, $idachievement);
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
