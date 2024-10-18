<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body> 
    <h1>Team</h1>
    <?php
        session_start();
        $role = $_SESSION["profile"];
        if ($role == 'admin'){
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
                <th>Aksi</th>
            </tr>";
            while($row = $resteams->fetch_assoc()){
                echo "<tr>
                    <td>".$row['name']."</td>
                    <td>".$row['game']."</td>
                    <td>
                    <a href='editteam.php?idteam=".$row['idteam']."'>Ubah</a>
                    <a href='deleteteam.php?idteam=".$row['idteam']."'onclick='return confirm(\"Apakah Anda yakin ingin menghapus Team ini?\");'>Hapus</a></td>
                </tr>";
            }
            echo "</table>";

            // paging
            //echo "<div>Total Data: ".$totaldata."</div>";
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
        }
    ?>
        <?php 
        if ($role == 'member'){
            echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
         }
         else {
            echo "<a href='insertteam.php'>Insert New Team</a>";
         } 
        ?>
</body>
</html>