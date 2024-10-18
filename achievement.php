<?php
    require_once("classachievement.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $role = $_SESSION["profile"];
    $userid = $_SESSION["userid"]; 
?>
<html>
    <head>
        <title>Achievement</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Achievement</h1>
            <?php
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
                
                if ($role == 'admin') {
                    $res = $achievement->getAchievement($offset, $perhalaman);
                    $totaldata = $achievement->getTotalData();
                } else {
                    $res = $achievement->getAchievement($offset, $perhalaman, $userid);
                    $totaldata = $achievement->getTotalData($userid);
                }

                $jumlahhalaman = ceil($totaldata / $perhalaman);

                echo "<table border='1'>";
                if ($role == 'admin') {
                    echo "<tr>
                        <th>Name</th>
                        <th>Description</th> 
                        <th>Date</th>
                        <th>Team</th>
                        <th colspan='4'>Aksi</th>
                    </tr>";
                } else {
                    echo "<tr>
                        <th>Name</th>
                        <th>Description</th> 
                        <th>Date</th>
                        <th>Team</th>
                    </tr>";
                }

                while($row = $res->fetch_assoc()) {
                    $formattgl = strftime("%d %B %Y", strtotime($row['date']));

                    if ($role === 'admin') {
                        echo "<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['description']."</td>
                            <td>".$formattgl."</td>
                            <td>".$row['namateam']."</td>
                            <td>
                                <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah Data</a> 
                                <a href='deleteachievement.php?idachievement=".$row['idachievement']."'>Hapus Data</a>
                            </td>
                        </tr>";
                    } else {
                        echo "<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['description']."</td>
                            <td>".$formattgl."</td>
                            <td>".$row['namateam']."</td>
                        </tr>";
                    }
                }

                echo "</table>";

                // Paging
                echo "<div>Total Data: ".$totaldata."</div>";
                echo "<a href='achievement.php?offset=0'>First</a>";
                
                for ($i = 1; $i <= $jumlahhalaman; $i++) {
                    $off = ($i - 1) * $perhalaman;
                    if ($currenthalaman == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='achievement.php?offset=".$off."'>".$i."</a> ";
                    }
                }

                $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
                echo "<a href='achievement.php?offset=".$lastOffset."'>Last</a><br><br>";
                
                if ($role == 'admin') {
                    echo "<a href='addachievement.php?'>Insert Data</a>";
                }
            ?> 
    </body>
</html>
