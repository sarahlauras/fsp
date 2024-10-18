<?php
    require_once("classgame.php");
    session_start();
    
    $role = $_SESSION["profile"];
?>
<html>
    <head>
        <title>E-Sport Game</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <h1>Game</h1>
    <?php 
        if ($role == 'admin'):
            require_once 'classgame.php';
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
                <th colspan='2'>Aksi</th>
            </tr>";

        while($row = $res->fetch_assoc()) {
            echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['description']."</td>
                <td>
                    <a href='esport_editgame.php?idgame=".$row['idgame']."'>Ubah</a>
                    <a href='esport_deletegame.php?idgame=".$row['idgame']."'>Hapus</a>
                </td>
            </tr>";
        }

        echo "</table>";
        echo "<a href='esport_game.php?offset=0'>First</a>";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong style='color:#DDA0DD'>$i</strong></a>";
                } else {
                    echo "<a href='esport_game.php?offset=" . $off . "'>" . $i . "</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='esport_game.php?offset=" . $lastOffset . "'>Last</a><br><br>";
            ?>
            <a href='esport_insertgame.php'>Insert Game</a>
            <?php 
        else:
            echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
        endif; 
        ?>
    </body>
</html>