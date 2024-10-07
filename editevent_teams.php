<?php
    require_once ("classevent_teams.php");
    require_once("classevent.php");
    require_once("classteam.php");

    $event_teams = new EventTeams();
    $event = new Event();
    $team = new Team();

    $resEvent = $event->getAllEvent();
    $resTeam = $team->getAllTeam();


    if(isset($_GET["result"])) {
        if($_GET["result"] == "success") {
            echo "Data berhasil ditambahkan.<br><br>";
        }
    }

    if (isset($_GET["idevent"]) && isset($_GET["idteam"])) {
        $idevent = $_GET["idevent"];
        $idteam = $_GET["idteam"];

        echo "ID EVENT: " . $idevent;
        echo "ID TEAM: ". $idteam;
    
        $event_team_data = $event_teams->getEventTeamById($idevent, $idteam);
    
        if ($event_team_data && $event_team_data->num_rows > 0) {
            $row = $event_team_data->fetch_assoc(); 
        } else {
            echo "Event tidak ditemukan.";
        }
        
    } else {
        echo "ID event dan ID Team tidak ditemukan.";
    }
?>

<html>
    <head>
    <title>Event Teams</title>
    </head>
    
    <body>
        <form method="post" action="editevent_teams_proses.php">
            <label for="event">Pilih Event dan Team</label>
            <select name="event" id="event">
                    <option value="">Pilih Event</option>
                    <?php
                        while($row = $resEvent->fetch_assoc()) {
                            $selected="";
                            if ($row['idevent'] == $idevent) {
                                $selected = 'selected';
                            } 
                            echo "<option value='" . $row['idevent'] . "' " . $selected . ">"
                            . $row['name'] . "</option>";
                        }
                    ?>
            </select>
            <select name="team" id="team">
                    <option value="">Pilih Team</option>
                    <?php
                        while($row = $resTeam->fetch_assoc()) {
                            $selected = "";
                            if($row['idteam'] == $idteam) {
                                $selected = 'selected';
                            }
                            echo "<option value='" . $row['idteam'] . "' " . $selected . ">"
                            . $row['name'] . "</option>";
                        }
                    ?>
            </select>
            
        <input type="hidden" name="old_idevent" value="<?php echo $idevent; ?>">
        <input type="hidden" name="old_idteam" value="<?php echo $idteam; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
        
        </form>
    </body>
</html>