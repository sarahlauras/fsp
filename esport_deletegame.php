<?php
    // Koneksi ke database
    $mysqli = new mysqli("localhost", "root", "", "esport");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: ".$mysqli->connect_error;
        exit();
    }

    if(isset($_GET['idgame'])){
        $idgame = $_GET['idgame'];

        $stmt = $mysqli->prepare("DELETE FROM game WHERE idgame = ?");
        
        // Bind parameter (i untuk integer)
        $stmt->bind_param("i", $idgame);
        
        // Eksekusi query
        if($stmt->execute()){
            echo "Event berhasil dihapus.";
            // Redirect ke halaman lain atau tampilkan pesan sukses
            header("Location: esport_game.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus: " . $stmt->error;
        }
        
        // Tutup statement
        $stmt->close();
    }
    // Tutup koneksi
    $mysqli->close();
?>
