<?php
<<<<<<< Updated upstream
require_once("classmember.php");
=======
    require_once("classmember.php");
    session_start();
    
    $role = $_SESSION["profile"];
>>>>>>> Stashed changes
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
        $member = new Member();
        $totaldata = 0;
        $perhalaman = 4;
        $currenthalaman = 1;

<<<<<<< Updated upstream
        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
            $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
        } else {
            $offset = 0;
        }
=======
            body {
                margin-left:auto;
                margin-right:auto;
                width: 1200px;
            }
        </style>
    </head>
    <body>
        <h1>DAFTAR MEMBER</h1>
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
            if ($role === 'admin'):
                $member = new Member();
                $totaldata = 0;
                $perhalaman = 4;       
                $currenthalaman = 1;
>>>>>>> Stashed changes

        $res = $member->getMember($offset, $perhalaman);
        $totaldata = $member->getTotalData();

        $jumlahhalaman = ceil($totaldata / $perhalaman);

        echo "<table border='1'>";
        echo "<tr>
                        <th>First Name</th>
                        <th>Last Name</th> 
                        <th>Username</th>
                        <th>Profile</th>
                    </tr>";

        while ($row = $res->fetch_assoc()) {
            echo "<tr>
                            <td>" . $row['fname'] . "</td>
                            <td>" . $row['lname'] . "</td>
                            <td>" . $row['username'] . "</td>
                            <td>" . $row['profile'] . "</td>
                            <td>
                                <a href='editmember.php?idmember=" . $row['idmember'] . "'>Ubah Data</a> 
                                <a href='deletemember.php?idmember=" . $row['idmember'] . "'>Hapus Data</a>
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
    </div>
</body>

<<<<<<< Updated upstream
=======
                // paging
                echo "<div>Total Data: ".$totaldata."</div>";
                echo "<a href='member.php?offset=0'>First</a>";
                
                for($i = 1; $i <= $jumlahhalaman; $i++) {
                    $off = ($i-1) * $perhalaman;
                    if($currenthalaman == $i) {                
                        echo "<strong style='color:red'>$i</strong></a>";
                    } else {
                        echo "<a href='member.php?offset=".$off."'>".$i."</a> ";
                    }
                }
                $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
                echo "<a href='member.php?offset=".$lastOffset."'>Last</a><br><br>";
            ?>
            <a href='insertmember.php'>Insert Member</a>
            <?php 
            else:
                echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
            endif; 
            ?>
        </div>    
    </body>
>>>>>>> Stashed changes
</html>