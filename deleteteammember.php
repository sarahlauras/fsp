<?php
    require_once 'classteammember.php';

    $team_member = new TeamMember();

    if(isset($_GET['idmember'])&&isset($_GET['idteam'])) {
        $idteam = $_GET['idteam'];
        $idmember = $_GET['idmember'];
        $jumlah = $team_member->deleteTeamMember($idteam, $idmember);

        if ($jumlah > 0) {
            header("Location: team_member.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus join proposal. Mungkin join proposal tidak ditemukan.";
        }
    } else {
            echo "ID join proposal tidak ditemukan.";
    }
?>