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
                
                if ($role == 'admin') {
                    $res = $achievement->getAchievement($offset, $perhalaman);
                    $totaldata = $achievement->getTotalData();
                } else {
                    $res = $achievement->getAchievement($offset, $perhalaman, $member);
                    $totaldata = $achievement->getTotalData($member);
                }
                if ($role == 'member') {
                    $res = $achievement->getUserTeams($member);
                }
                
                echo "<label for='team'>Pilih Team: </label>";
                echo "<select name='team' id='team'>";
                echo "<option value='' disabled selected>Pilih Team</option>";
                while($row = $res->fetch_assoc()) {
                    echo "<option value=".$row['idteam'].">"
                    .$row['name']."</option>";
                }
                echo "</select>";
                echo "<input type='button' id='btnsubmit' value='Pilih'/>";

                echo "<div id='eventData'></div>";
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
            
    
                        // <!-- while($row = $res->fetch_assoc()) {
                        //     $formattgl = strftime("%d %B %Y", strtotime($row['date']));
                        //     echo "<tr>
                        //         <td>".$row['name']."</td>
                        //         <td>".$row['description']."</td>
                        //         <td>".$formattgl."</td>
                        //         <td>".$row['namateam']."</td>";
                        //     if ($role == 'admin') {
                        //         echo "<td>
                        //         <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah</a> 
                        //         <a href='deleteachievement.php?idachievement=".$row['idachievement']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Achievement ini?\");' >Hapus</a>
                        //         </td>";
                        //     }
                        //     echo "</tr>";
                        // } -->
                    
                    echo "</table>";
            ?>

                <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
                    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
                    crossorigin="anonymous"></script>

            <?php
                if($role == 'member') {
                    echo "
                        <script>
                        $(document).ready(function() {
                        $('#btnsubmit').click(function(){
                            var selected_team = $('#team').val();
                            if(selected_team) {
                                $.post('backend_achievement.php', {idteam: selected_team})
                                .done(function(data) {
                                    $('#eventData').html(data);
                                    $('#eventTable').show();
                                })
                            } else {
                                alert('Pilih team dulu');
                            }
                        });
                    });
                </script>
                ";
            }
            ?>

                <?php
                // if($role == 'admin') {
                //     echo "<table border='1' id='eventTable'>";
                //     echo "<tr>
                //         <th>Name</th>
                //         <th>Description</th> 
                //         <th>Date</th>
                //         <th>Team</th>
                //         <th>Aksi</th>";
                //     echo "</tr>";

                //     while($row = $res->fetch_assoc()) {
                //         $formattgl = strftime("%d %B %Y", strtotime($row['date']));
                //         echo "<tr>
                //             <td>".$row['name']."</td>
                //             <td>".$row['description']."</td>
                //             <td>".$formattgl."</td>
                //             <td>".$row['namateam']."</td>";
                //         if ($role == 'admin') {
                //             echo "<td>
                //             <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah</a> 
                //             <a href='deleteachievement.php?idachievement=".$row['idachievement']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Achievement ini?\");' >Hapus</a>
                //             </td>";
                //         }
                //         echo "</tr>";
                //     }
                // }
                // echo "</table>";
                
                // Paging
                $jumlahhalaman = ceil($totaldata / $perhalaman);
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
                    echo "<a href='addachievement.php?'>Insert Achievement</a>";
                }
            ?> 
    </body>
</html>
