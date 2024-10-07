<?php
require_once ("classevent_teams.php");
require_once("classevent.php");
require_once("classteam.php");

$event_teams = new EventTeams();
$team = new Team();


if (isset($_POST['btnSubmit'])) {
    $oldIdevent = $_POST["old_idevent"]; 
    $oldIdteam = $_POST["old_idteam"];
    $newIdevent = $_POST["event"]; 
    $newIdteam = $_POST["team"]; 

    $eventData = $event_teams->getEventTeamById($idEvent, $idTeam);

    if ($oldIdevent && $oldIdteam && $newIdevent && $newIdteam) {
        $jumlah = $event_teams->editEventTeam($newIdevent, $newIdteam, $oldIdevent, $oldIdteam);

        if ($jumlah > 0) {
            header("Location: eventteams.php?result=success");
            exit();
        } else {
            echo "Tidak ada perubahan yang dilakukan.";
        }
    } else {
        echo "Data tidak lengkap.";
    }
} else {
    echo "Tidak ada data.";
}
?>