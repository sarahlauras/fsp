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
        echo "<a href='home.php'>Back</a>";
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
                    <th>Aksi</th>
                </tr>";
            echo "</thead>";

            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td data-label='First Name'>" . $row['fname'] . "</td>
                    <td data-label='Last Name'>" . $row['lname'] . "</td>
                    <td data-label='Username'>" . $row['username'] . "</td>
                    <td data-label='Profile'>" . $row['profile'] . "</td>";
                
                    // Tampilkan password hanya jika profile = 'admin'
                    if ($row['profile'] == 'admin') {
                        echo "<td data-label='Password'>" . $row['password'] . "</td>";
                    } else {
                        echo "<td data-label='Password'>-</td>"; // Kosongkan atau tampilkan simbol
                    }
                
                    echo "<td data-label='Aksi'>
                        <a href='editmember.php?idmember=" . $row['idmember'] . "'>Ubah</a> 
                        <a href='deletemember.php?idmember=" . $row['idmember'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Member ini?\");'>Hapus</a>
                        </td>
                    </tr>";
                }

            echo "</table>";

            // paging
            //echo "<div>Total Data: " . $totaldata . "</div>";
            echo "<a href='member.php?offset=0'>First</a>";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong style='color:#DDA0DD'>$i</strong></a>";
                } else {
                    echo "<a href='member.php?offset=" . $off . "'>" . $i . "</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='member.php?offset=" . $lastOffset . "'>Last</a><br><br>";
            ?>
            <a href='insertmember.php'>Insert Member</a>
            <?php
        else:
        //     $username = $_SESSION['username'];
        //     $res = $member->getMemberById(null, $username);
        //     echo "<table border='1'>";
        //     echo "<tr>
        //                         <th>First Name</th>
        //                         <th>Last Name</th> 
        //                         <th>Username</th>
        //                         <th>Profile</th>
        //                     </tr>";

        //     while ($row = $res->fetch_assoc()) {
        //         echo "<tr>
        //                     <td>" . $row['fname'] . "</td>
        //                     <td>" . $row['lname'] . "</td>
        //                     <td>" . $row['username'] . "</td>
        //                     <td>" . $row['profile'] . "</td>
        //                 </tr>";
            
        //     }
        //     echo "</table>";
            $username = $_SESSION['username'];    
            echo "Anda tidak memiliki hak akses";
        endif;
        ?>
    </div>
</body>

</html>