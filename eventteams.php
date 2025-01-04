<?php
    require_once("classevent_teams.php");
    require_once("classteam.php");

    session_start();
    $role = $_SESSION["profile"];
?>
<html>
<head>
    <title>Event Teams</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>Event Teams</h1>
    <?php 
        echo "<a href='home.php'>Back</a>";
        $role = $_SESSION["profile"];
        if ($role == 'admin'){

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
            echo "<thead>";
            echo "<tr>
                    <th>Event Name</th>
                    <th>Event Date</th> 
                    <th>Team Name</th>
                    <th>Game Name</th>
                    <th>Aksi</th>
                </tr>";
            echo "</thead>";

            while($row = $resevent_teams->fetch_assoc()) {
                $idteam = $teamid->getIdTeamByName($row['team_name']);
                $formattgl = strftime("%d %B %Y", strtotime($row['event_date']));
                echo "<tr>
                        <td data-label='Event Name'>" . $row['event_name'] . "</td>
                        <td data-label='Event Date'>" . $formattgl . "</td>
                        <td data-label='Team Name'>" . $row['team_name'] . "</td>
                        <td data-label='Game Name'>" . $row['game_name'] . "</td>
                        <td data-label='Aksi'>
                            <a href='editevent_teams.php?idevent=" . $row['idevent'] . "&idteam=" . $idteam . "'>Ubah</a> 
                            <a href='deleteevent_teams.php?idevent=". $row['idevent'] . "&idteam=" . $idteam . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Event Teams ini?\");'>Hapus</a>
                        </td>
                    </tr>";
            }
        
        echo "</table>";

        
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
        }
        else {
            echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
        }
        if ($role == 'admin') {
            echo "<a href='insertevent_teams.php?'>Insert Event Teams</a>";
        }
    ?>  
</body>
</html>