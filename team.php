<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
</head>
<body>
<title>Team</title>
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
<h1>Team</h1>
        <div id="kiri">
            <ul>
            <li><a href="member.php">Daftar Member</a></li>
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
        require_once 'classteam.php';
        $team = new Team();
        $totaldata = 0;
        $perhalaman = 4;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = ($_GET['offset']/$perhalaman)+1;
        } else { $offset = 0; }

        // $res = $event_teams->getAllTeam(null,null);
        $totaldata = $team ->getTotalData();
        $resteams = $team->getAllTeam($offset, $perhalaman);

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        //BUAT TABEL
        echo "<table border = '1'>";
        echo "
        <tr>
            <th>Name</th>
            <th>Game</th>
        </tr>";
        while($row = $resteams->fetch_assoc()){
            echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['game']."</td>
                <td><a href='editteam.php?idteam=".$row['idteam']."'>Ubah Data</a></td>
                <td><a href='deleteteam.php?idteam=".$row['idteam']."'onclick='return confirm(\"Apakah Anda yakin ingin menghapus Team ini?\");'>Hapus Data</a></td>
            </tr>";
        }
        echo "</table>";

        // paging
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='team.php?offset=0'>First</a>";
        
        for($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i-1) * $perhalaman;
            if($currenthalaman == $i) {                
                echo "<strong style='color:red'>$i</strong></a>";
            } else {
                echo "<a href='team.php?offset=".$off."'>".$i."</a> ";
            }
        }
        $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
        echo "<a href='team.php?offset=".$lastOffset."'>Last</a><br><br>";
        ?>
    <a href="insertteam.php">Add New Team</a>
</body>
</html>