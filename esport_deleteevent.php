<?php
    // Koneksi ke database
    $mysqli = new mysqli("localhost", "root", "", "esport");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: ".$mysqli->connect_error;
        exit();
    }

    if(isset($_GET['idevent'])){
        $idevent = $_GET['idevent'];

        $stmt = $mysqli->prepare("DELETE FROM event WHERE idevent = ?");
        
        // Bind parameter (i untuk integer)
        $stmt->bind_param("i", $idevent);
        
        // Eksekusi query
        if($stmt->execute()){
            echo "Event berhasil dihapus.";
            // Redirect ke halaman lain atau tampilkan pesan sukses
            header("Location: esport_event.php?result=success");
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
