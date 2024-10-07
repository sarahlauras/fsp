<?php
    require_once 'classgame.php';
    $game = new Game();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($name, $description)) {
            $jumlah = $game->editGame($name, $description, $idgame);

            if ($jumlah > 0) {
                header("Location: esport_game.php?result=success");
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