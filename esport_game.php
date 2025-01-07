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
        echo "<a class='btnPagination' href='home.php'>Back</a>";
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
            echo "<thead>";
                echo "<tr>
                    <th>Game Name</th>
                    <th>Description</th>
                    <th colspan='2'>Action</th>
                </tr>";
            echo "</thead>";

        while($row = $res->fetch_assoc()) {
            echo "<tr>
                <td><span class='label'>Game Name: </span>". $row['name']."</td>
                <td><span class='label'>Description: </span>". $row['description']."</td>
                <td><span class='label'>Action: </span>
                <div class='action'>
                    <a href='esport_editgame.php?idgame=". $row['idgame']."'>Change</a>
                    <a href='esport_deletegame.php?idgame=". $row['idgame']."' onclick='return confirm(\"Are you sure you want to delete?\");' >Delete</a>
                </div>
                </td>
            </tr>";
        }

        echo "</table>";
        echo "<div class='pagination'>";
        echo "<a href='esport_game.php?offset=0'>First</a>";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong style='color:red'>$i</strong></a>";
                } else {
                    echo "<a href='esport_game.php?offset=" . $off . "'>" . $i . "</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='esport_game.php?offset=" . $lastOffset . "'>Last</a><br><br>";
            echo "<a href='esport_insertgame.php'>Insert Game</a>";
            echo "</div>";
            ?>
            <?php 
        else:
            echo "<p class='text_merah'>You not have an access</p>";
        endif; 
        
        ?>
    </body>
</html>