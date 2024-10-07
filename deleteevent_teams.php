<?php
    require_once 'classevent_teams.php';

    $event_teams = new EventTeams();

    if(isset($_GET['idevent'])&&isset($_GET['idteam'])) {
        $idevent = $_GET['idevent'];
        $idteam = $_GET['idteam'];
        $jumlah = $event_teams->deleteEventTeam($idevent, $idteam);

        if ($jumlah > 0) {
            header("Location: eventteams.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus";
        }
    } else {
            echo "ID event teams tidak ditemukan.";
    }
?>