<?php
    require_once 'classevent.php';
    $event = new Event();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($name, $date, $description)) {
            $jumlah = $event->editEvent($name, $date, $description, $idevent);

            if ($jumlah > 0) {
                header("Location: esport_event.php?result=success");
                exit();
            } else {
                echo "Tidak ada perubahan yang dilakukan.";
            }
        } else {
            echo "Semua field harus diisi.";
        }
    }  
    
    else {
        echo "Tidak ada data";
    }
?>