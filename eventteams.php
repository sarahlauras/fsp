<?php
    require_once("classevent_teams.php");
    require_once("classteam.php");
?>
<html>
<head>
<title>Event Teams/title>
        <style>
            .text_merah {
                color: red;
            }

            #kiri {
                display: inline-block;
                width: 200px;
            }

            #kanan {
                display: inline-block;
                min-width: 800px;
            }

            body {
                margin-left:auto;
                margin-right:auto;
                width: 1200px;
            }
        </style>
    <title>Event Teams</title>
</head>
<body>
<h1>Event Teams</h1>
        <div id="kiri">
            <ul>
            <li><a href="team.php">Daftar Team</a></li>
            <li><a href="esport_game.php">Daftar Game</a></li>
            <li><a href="join_proposal.php">Daftar Join Proposal</a></li>
            <li><a href="esport_event.php">Daftar Event</a></li>
            <li><a href="eventteams.php">Daftar Event Team</a></li>
            <li><a href="achievement.php">Daftar Achievement</a></li>
            <li><a href="team_member.php">Daftar Team Member</a></li>
            </ul>
        </div>
        <div id="kanan">
<?php 
    $event_teams = new EventTeams();
        $totaldata = 0;
        $perhalaman = 4;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = ($_GET['offset']/$perhalaman)+1;
        } else { $offset = 0; }

        $res = $event_teams->getAllEventTeams(null,null);
        $totaldata = $event_teams ->getTotalData();
        $resevent_teams = $event_teams->getAllEventTeams($offset, $perhalaman);
        $teamid = new Team();

        $jumlahhalaman = ceil($totaldata/$perhalaman);

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
                        <a href='deleteevent_teams.php?idevent=". $row['idevent'] . "&idteam=" . $idteam . "'>Delete</a>
                    </td>
                </tr>";
        }
    
    echo "</table>";

    // paging
    echo "<div>Total Data: ".$totaldata."</div>";
    echo "<a href='eventteams.php?offset=0'>First</a>";
    
    for($i = 1; $i <= $jumlahhalaman; $i++) {
        $off = ($i-1) * $perhalaman;
        if($currenthalaman == $i) {                
            echo "<strong style='color:red'>$i</strong></a>";
        } else {
            echo "<a href='eventteams.php?offset=".$off."'>".$i."</a> ";
        }
    }
    $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
    echo "<a href='eventteams.php?offset=".$lastOffset."'>Last</a><br><br>";
?>  
<a href='insertevent_teams.php?'>Insert Data</a>
</body>
</html>