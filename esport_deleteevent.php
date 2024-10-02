<?php
    require_once 'classevent.php';

    $event = new Event();

    if(isset($_GET['idevent'])) {
        $idevent = $_GET['idevent'];
        $jumlah = $event->deleteEvent($idevent);

        if ($jumlah > 0) {
            header("Location: esport_event.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus event. Mungkin event tidak ditemukan.";
        }
    } else {
            echo "ID event tidak ditemukan.";
    }
    
?>
