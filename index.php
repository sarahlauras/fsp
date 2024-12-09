<?php
    require_once("classgame.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
</head>
<body>
    <?php 
        $game = new Game();
        $totaldata = 0;
        $perhalaman = 4;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = ($_GET['offset']/$perhalaman)+1;
        } else { $offset = 0; }

        $res = $game->getAllGame($offset, $perhalaman);
        $totaldata = $game ->getTotalData();

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<table border='1'>";
        echo "<tr>
        <th>Nama</th>
        <th>Deskripsi</th>
        </tr>";

        while($row = $res->fetch_assoc()) {
            echo "<tr>
            <td>".$row['name']."</td>
            <td>".$row['description']."</td>
            </tr>";
        }

        echo "</table>";
    ?>
</body>
</html>