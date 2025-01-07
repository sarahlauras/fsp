<?php
require_once("classmember.php");
session_start();

$role = $_SESSION["profile"];
?>
<html>

<head>
    <title>Movie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>DAFTAR MEMBER</h1>
    <div id="kanan">
        <?php
        echo "<a class='btnPagination' href='home.php'>Back</a>";
        $member = new Member();
        if ($role == 'admin'):
            
            $totaldata = 0;
            $perhalaman = 4;
            $currenthalaman = 1;
            
            if(isset($_GET['offset'])) { 
                $offset = $_GET['offset']; 
                $currenthalaman = ($_GET['offset']/$perhalaman)+1;
            } else { $offset = 0; }

            $res = $member->getMember($offset, $perhalaman);
            $totaldata = $member->getTotalData();

            $jumlahhalaman = ceil($totaldata / $perhalaman);

            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>
                    <th>First Name</th>
                    <th>Last Name</th> 
                    <th>Username</th>
                    <th>Profile</th>
                    <th>Password</th>
                    <th>Action</th>
                </tr>";
            echo "</thead>";

            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td><span class='label'>First Name: </span>" . $row['fname'] . "</td>
                    <td><span class='label'>Last Name:  </span>" . $row['lname'] . "</td>
                    <td><span class='label'>Username: </span>". $row['username'] . "</td>
                    <td><span class='label'>Profile: </span>" . $row['profile'] . "</td>";
                
                    // Tampilkan password hanya jika profile = 'admin'
                    if ($row['profile'] == 'admin') {
                        echo "<td><span class='label'>Password: </span>" . $row['password'] . "</td>";
                    } else {
                        echo "<td><span class='label'>Password: </span>-</td>"; // Kosongkan atau tampilkan simbol
                    }
                
                    echo "<td><span class='label'>Action: </span>
                    <div class='action'>
                    <a href='esport_editmember.php?idmember=".$row['idmember']."'>Change</a>
                    <a href='esport_deletemember.php?idmember=".$row['idmember']."' onclick='return confirm(\"Are you sure you want to delete?\");' >Delete</a>
                    </div>
                    </td>
                    </tr>";
                }

            echo "</table>";

            // paging
            echo "<div class='pagination'>";
            //echo "<div>Total Data: " . $totaldata . "</div>";
            echo "<a href='member.php?offset=0'>First</a>";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong style='color:red'>$i</strong></a>";
                } else {
                    echo "<a href='member.php?offset=" . $off . "'>" . $i . "</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='member.php?offset=" . $lastOffset . "'>Last</a><br><br>";
            
            echo "<a href='insertmember.php'>Insert Member</a>";
            echo "</div>";
            ?>
            <?php
        else:
            $username = $_SESSION['username'];    
            echo "You not have an access";
        endif;
        
        ?>
    </div>
</body>

</html>