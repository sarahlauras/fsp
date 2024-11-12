<?php
    require_once("classachievement.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $role = $_SESSION["profile"];
    $member = $_SESSION["idmember"]; 
?>
<html>
    <head>
        <title>Achievement</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Achievement</h1>
            <?php
                echo "<a href='home.php'>Back</a>";
                echo "<br>";
                $achievement = new Achievement();
                $totaldata = 0;
                $perhalaman = 4;       
                $currenthalaman = 1;

                if (isset($_GET['offset'])) { 
                    $offset = $_GET['offset']; 
                    $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
                } else { 
                    $offset = 0; 
                }

                if($role == 'member') {
                    $res = $achievement->getUserTeams($member);
                }
                else {
                    $res = $achievement->getTeam($offset, $perhalaman);
                }
                
                echo "<form method='GET' action='achievement.php'>";
                echo "<label for='team'>Pilih Team: </label>";
                echo "<select name='idteam' id='team'>";
                echo "<option value='' disabled selected>Pilih Team</option>";
                while($row = $res->fetch_assoc()) {
                    $selected = "";
                    if (isset($_GET['idteam']) && $_GET['idteam'] == $row['idteam']) {
                        $selected = "selected";
                    }
                    echo "<option value='".$row['idteam']."' $selected>".$row['name']."</option>";
                }
                echo "</select>";
                echo "<input type='submit' value='Pilih'/>";
                echo "</form>";

                if (isset($_GET["idteam"])) {
                    $selected = $_GET["idteam"];
                    if($role == 'member') {
                        $member= null;
                        $totaldata = $achievement->getTotalData($member, $selected);
                    }
                    else {
                        $totaldata = $achievement->getTotalData($selected);
                    }
                    $achievements = $achievement->getAchievementByTeam($selected, $offset, $perhalaman);
                } else {
                    if ($role == "admin") {
                        $totaldata = $achievement->getTotalData(); 
                        $achievements = $achievement->getAchievement($offset, $perhalaman);
                    } elseif ($role == "member") {
                        $totaldata = $achievement->getTotalData($member);
                        $achievements = $achievement->getAchievementApprovedProposal($member, $offset, $perhalaman);
                    }
                }
                
                echo "<table border ='1'>";
                echo "<table border='1' id='eventTable'>";
                echo "<tr>
                    <th>Name</th>
                    <th>Description</th> 
                    <th>Date</th>
                    <th>Team</th>";
                    if ($role == 'admin') {
                        echo "<th>Aksi</th>";
                    }
                    echo "</tr>";
                        while($row = $achievements->fetch_assoc()) {
                            $formattgl = strftime("%d %B %Y", strtotime($row['date']));
                            echo "<tr>
                                <td>".$row['name']."</td>
                                <td>".$row['description']."</td>
                                <td>".$formattgl."</td>
                                <td>".$row['namateam']."</td>";
                            if ($role == 'admin') {
                                echo "<td>
                                <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah</a> 
                                <a href='deleteachievement.php?idachievement=".$row['idachievement']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Achievement ini?\");' >Hapus</a>
                                </td>";
                            }
                            echo "</tr>";
                        }
                    
                echo "</table>";
            
            ?>

                <?php
                
                // Paging
                $jumlahhalaman = ceil($totaldata / $perhalaman);
                //echo "<div>Total Data: ".$totaldata."</div>";
                echo "<a href='achievement.php?offset=0'>First</a>";
                
                for ($i = 1; $i <= $jumlahhalaman; $i++) {
                    $off = ($i - 1) * $perhalaman;
                    if ($currenthalaman == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        if (isset($_GET["idteam"])) {
                            echo "<a href='achievement.php?offset=".$off."&idteam=".$selected."'>".$i."</a> ";
                        } else {
                            echo "<a href='achievement.php?offset=".$off."'>".$i."</a> ";
                        }
                    }
                }

                $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
                if (isset($_GET["idteam"])) {
                    echo "<a href='achievement.php?offset=".$lastOffset."&idteam=".$selected."'>Last</a><br><br>";
                } else {
                    echo "<a href='achievement.php?offset=".$lastOffset."'>Last</a><br><br>";
                }
                if ($role == 'admin') {
                    echo "<a href='addachievement.php?'>Insert Achievement</a>";
                }
            ?>
            <br>
            <br>
            
    </body>
</html>
