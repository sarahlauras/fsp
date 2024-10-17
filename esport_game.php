<?php
    require_once("classgame.php");
    session_start();
    
    $role = $_SESSION["profile"];
?>
<html>
    <head>
        <title>E-Sport Game</title>
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
    </head>
    <body>
    <h1>Game</h1>
        <div id="kiri">
            <ul>
            <li><a href="team.php">Daftar Team</a></li>
            <li><a href="member.php">Daftar Member</a></li>
            <li><a href="join_proposal.php">Daftar Join Proposal</a></li>
            <li><a href="esport_event.php">Daftar Event</a></li>
            <li><a href="eventteams.php">Daftar Event Team</a></li>
            <li><a href="achievement.php">Daftar Achievement</a></li>
            <li><a href="team_member.php">Daftar Team Member</a></li>
            </ul>
        </div>
        <div id="kanan">
            <?php 
            if ($role === 'admin'):
            $mysqli = new mysqli("localhost", "root","","esport");
            if($mysqli -> connect_errno) {
                echo "Koneksi database gagal: " . $mysqli->connect_error;
                exit();
            }

            $stmt = $mysqli->prepare("SELECT * FROM game"); 
            $stmt->execute();
            $res = $stmt->get_result();

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
                    <a href='esport_editgame.php?idgame=".$row['idgame']."'>Ubah Data</a>
                    <a href='esport_deletegame.php?idgame=".$row['idgame']."'>Hapus Data</a>
                </td>
            </tr>";
        }

        echo "</table>";

        $mysqli->close();
            ?>

        <a href='esport_insertgame.php'>Insert Game</a>
        <?php 
            else:
                echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
            endif; 
            ?>
        </body>
</html>