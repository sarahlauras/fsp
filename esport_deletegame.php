<?php
    require_once 'classgame.php';

    $game = new Game();

    if(isset($_GET['idgame'])) {
        $idgame = $_GET['idgame'];
        $jumlah = $game->deleteGame($idgame);

        if ($jumlah > 0) {
            header("Location: esport_game.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus game.";
        }
    } else {
            echo "ID game tidak ditemukan.";
    }
    
?>
