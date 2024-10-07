<?php
    require_once("classachievement.php");
?>
<html>
    <head>
        <title>Achievement</title>
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
        <h1>Achievement</h1>
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
                $achievement = new Achievement();
                $totaldata = 0;
                $perhalaman = 4;       
                $currenthalaman = 1;

                if(isset($_GET['offset'])) { 
                    $offset = $_GET['offset']; 
                    $currenthalaman = ($_GET['offset']/$perhalaman)+1;
                } else { $offset = 0; }
                
                $res = $achievement->getAchievement($offset, $perhalaman);
                $totaldata = $achievement->getTotalData();

                $jumlahhalaman = ceil($totaldata/$perhalaman);

                echo "<table border='1'>";
                echo "<tr>
                        <th>Name</th>
                        <th>Description</th> 
                        <th>Date</th>
                        <th>Team</th>
                    </tr>";

                while($row = $res->fetch_assoc()) {
                    echo "<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['description']."</td>
                            <td>".$row['date']."</td>
                            <td>".$row['team']."</td>
                            <td>
                                <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah Data</a> 
                                <a href='deleteachievement.php?idachievement=".$row['idachievement']."'>Hapus Data</a>
                            </td>
                        </tr>";
                }

                echo "</table>";

                // paging
                echo "<div>Total Data: ".$totaldata."</div>";
                echo "<a href='achievement.php?offset=0'>First</a>";
                
                for($i = 1; $i <= $jumlahhalaman; $i++) {
                    $off = ($i-1) * $perhalaman;
                    if($currenthalaman == $i) {                
                        echo "<strong style='color:red'>$i</strong></a>";
                    } else {
                        echo "<a href='achievement.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
                echo "<a href='achievement.php?offset=".$lastOffset."'>Last</a><br><br>";
            ?>
            <a href='addachievement.php'>Insert Achievement</a>
        </div>    
    </body>
</html>