<?php
    require_once("classteam.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informatics</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <header>
        <h1>Home</h1>
        <a href="gamedetail_index.php">Game Detail</a>
        <a href="login.php" class="btnactive">Login</a>
    </header>
    <h1>Selamat Datang di</h1>
    <h1>Club Informatics PASLON</h1>
    <p>Di sini Anda dapat melihat daftar tim yang terdaftar bersama dengan game yang mereka mainkan. Setiap tim akan saling berkompetisi dalam berbagai game populer seperti Mobile Legends, PUBG, Valorant, dan lainnya. Bergabunglah dengan salah satu tim dan ikutilah keseruan kompetisinya!</p>
    <h3>Daftar Tim</h3>
    <?php 
        $team = new Team();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = ($_GET['offset']/$perhalaman)+1;
        } else { $offset = 0; }

        $res = $team->getAllTeam($offset, $perhalaman);
        $totaldata = $team ->getTotalData();

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<table border='1'>";
        echo "<tr>
        <th>Profile</th>
        <th>Nama Tim</th>
        <th>Nama Game</th>
        </tr>";

        while($row = $res->fetch_assoc()) {
            $teamId = $row['idteam'];
            echo "<tr>
            <td><img src='teams/" . $teamId . ".jpg' alt='" . $row['name'] . " Poster' width='100' height='100'></td>
            <td>".$row['name']."</td>
            <td>".$row['game']."</td>
            </tr>";
        }

        echo "</table>";
        echo "<div style='width: 80%; margin: 20px auto; text-align: center;'>";
        echo "<a href='index.php?offset=0'>First</a>";

        for ($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i - 1) * $perhalaman;
            if ($currenthalaman == $i) {
                echo "<strong style='color:red'>". " " . $i . "</strong>";
            } else {
                echo "<a href='index.php?offset=" . $off . "'>" . " " . $i . " " . "</a> ";
            }
        }
        $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
        echo "<a href='index.php?offset=" . $lastOffset . "'>Last</a><br><br>";
        
    ?>
</body>
</html>