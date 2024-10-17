<?php
    require_once("classachievement.php");
    session_start();

    $role = $_SESSION["profile"];
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

                if(isset($_GET['offset'])) { 
                    $offset = $_GET['offset']; 
                    $currenthalaman = ($_GET['offset']/$perhalaman)+1;
                } else { $offset = 0; }
                
                $res = $achievement->getAchievement($offset, $perhalaman);
                $totaldata = $achievement->getTotalData();

                $jumlahhalaman = ceil($totaldata/$perhalaman);

                echo "<table border='1'>";
                if ($role =='member') {
                    echo "<tr>
                        <th>Name</th>
                        <th>Description</th> 
                        <th>Date</th>
                        <th>Team</th>
                    </tr>";
                } else {
                    echo "<tr>
                        <th>Name</th>
                        <th>Description</th> 
                        <th>Date</th>
                        <th>Team</th>
                        <th colspan ='4'>Aksi</th>
                     </tr>";
                }

                while($row = $res->fetch_assoc()) {
                    $formatrilis = strftime("%d %B %Y", strtotime($row['date']));
                    $format_serial = "";
                    $tanggal = new DateTime($row['date']);

                    if ($role === 'member') {
                        echo "<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['description']."</td>
                            <td>".$tanggal->format('d/m/Y')."</td>
                            <td>".$row['namateam']."</td>
                        </tr>";
                    }
                    else {
                        echo "<tr>
                            <td>".$row['name']."</td>
                            <td>".$row['description']."</td>
                            <td>".$tanggal->format('d/m/Y')."</td>
                            <td>".$row['namateam']."</td>
                            <td>
                                <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah Data</a> 
                                <a href='deleteachievement.php?idachievement=".$row['idachievement']."'>Hapus Data</a>
                            </td>
                        </tr>";
                    }
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
                
                if($role == 'admin') {
                    echo "<a href='addachievement.php?'>Insert Data</a>";
                }
            ?> 
    </body>
</html>