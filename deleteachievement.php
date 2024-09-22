<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete Achievement</title>
</head>
<body>
	<?php
    $mysqli = new mysqli("localhost", "root", "", "esport");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: ".$mysqli->connect_error;
        exit();
    }

    if(isset($_GET['idachievement'])){
        $idachievement = $_GET['idachievement'];

        $stmt_achievement = $mysqli->prepare("DELETE FROM achievement WHERE idachievement = ?");
        
        $stmt_achievement->bind_param("i", $idachievement);
        
        if($stmt_achievement->execute()){
            echo "achievement berhasil dihapus.";
            header("Location: achievement.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus achievement: " . $stmt->error;
        }
        
        // Tutup statement
        $stmt_achievement->close();
    }
    // Tutup koneksi
    $mysqli->close();
?>

</body>
</html>