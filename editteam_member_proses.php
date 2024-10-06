<?php
require_once 'classteammember.php';
$team_member = new TeamMember();

if (isset($_POST['btnSubmit'])) {
    extract($_POST);

    
    if (isset($team, $member, $description)) {
        $idTeam = $_POST["idteam"];
        $idMember = $_POST["idmember"];

        $jumlah = $team_member->editTeamMember($team, $member, $description, $idTeam, $idMember);

        if ($jumlah > 0) {
            header("Location: editteam_member.php?idteam=" . $team . "&idmember=" . $member . "&result=success");
            exit();
        } else {
            echo "Tidak ada perubahan yang dilakukan.";
        }
    } else {
        echo "Semua field harus diisi.";
    }
} else {
    echo "Tidak ada data.";
}
?>