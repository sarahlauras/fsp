<?php
    echo "Sukses";
    require_once("classevent_teams.php");
    require_once("classteam.php");
?>
<html>
<head>
    <title>Event Teams</title>
</head>
<body>

<?php 

    $event_teams = new EventTeams();
    $resevent_teams = $event_teams->getAllEventTeams();
    $teamid = new Team();

    if ($resevent_teams->num_rows > 0) {

        echo "<table border='1'>";
        echo "<tr>
                <th>Event Name</th>
                <th>Event Date</th> 
                <th>Team Name</th>
                <th>Game Name</th>
                <th>Aksi</th>
            </tr>";
        

        while($row = $resevent_teams->fetch_assoc()) {
            $idteam = $teamid->getIdTeamByName($row['team_name']);
            echo "<tr>
                    <td>" . $row['event_name'] . "</td>
                    <td>" . $row['event_date'] . "</td>
                    <td>" . $row['team_name'] . "</td>
                    <td>" . $row['game_name'] . "</td>
                    <td>
                        <a href='editevent_teams.php?idevent=" . $row['idevent'] . "&idteam=" . $idteam . "'>Edit</a> 
                        <a href='deleteevent_teams.php?id=" . $row['idevent'] . "'>Delete</a>
                    </td>
                </tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Tidak ada data tersedia</td></tr>";
    }
    
    echo "</table>";
?>  
<a href='insertevent_teams.php?'>Insert Data</a>
</body>
</html>