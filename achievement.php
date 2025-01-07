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
                echo "<a class='btnPagination' href='home.php'>Back</a>";
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
                echo "<label for='team'>Choose Team: </label>";
                echo "<select name='idteam' id='team'>";
                echo "<option value='' disabled selected>Choose Team</option>";
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
                    if($role == 'admin') {
                        $member= null;
                        $totaldata = $achievement->getTotalData($member, $selected);
                    }
                    else {
                        $totaldata = $achievement->getTotalData($member, $selected);
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
                
                echo "<table border='1' id='eventTable'>";
                echo "<thead>";
                    echo "<tr>
                        <th>Achievement Name</th>
                        <th>Description</th> 
                        <th>Date</th>
                        <th>Team</th>";
                        if ($role == 'admin') {
                            echo "<th>Action</th>";
                        }
                    echo "</tr>";
                echo "</thead>";
                    while($row = $achievements->fetch_assoc()) {
                        $formattgl = strftime("%d %B %Y", strtotime($row['date']));
                        echo "<tr>
                            <td><span class='label'>Achievement Name: </span>" .$row['name']."</td>
                            <td><span class='label'>Description: </span>" .$row['description']."</td>
                            <td><span class='label'>Date:</span>" .$formattgl."</td>
                            <td><span class='label'>Team: </span>" .$row['namateam']."</td>";
                        if ($role == 'admin') {
                            echo "<td><span class='label'>Action:</span> 
                            <div class='action'>
                            <a href='editachievement.php?idachievement=".$row['idachievement']."'>Change</a> 
                            <a href='deleteachievement.php?idachievement=".$row['idachievement']."' onclick='return confirm(\"Are you sure you want to delete?\");' >Delete</a>
                            </div>
                            </td>";
                        }
                        echo "</tr>";
                    }
                    
                echo "</table>";
            
                // Paging
                echo "<div class='pagination'>";
                $jumlahhalaman = ceil($totaldata / $perhalaman);
                // echo "<div>Total Data: ".$totaldata."</div>";
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
                echo "</div>";
            ?>
            <br>
            <br>
            
    </body>
</html>
