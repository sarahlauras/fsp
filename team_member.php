<?php
    require_once("classteammember.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Member</title>
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
    <h1>DAFTAR TEAM MEMBER</h1>
    <div id="kiri">
        <ul>
            <li><a href="#">Daftar Team</a></li>
            <li><a href="#">Daftar Game</a></li>
            <li><a href="#">Daftar Join Proposal</a></li>
            <li><a href="#">Daftar Event</a></li>
            <li><a href="#">Daftar Event Team</a></li>
            <li><a href="#">Daftar Achievement</a></li>
            <li><a href="#">Daftar Member</a></li>
        </ul>
    </div> 
    <div id="kanan">
        <?php
            $team_member = new TeamMember();
            $totaldata = 0;
            $perhalaman = 4;       
            $currenthalaman = 1;

            if(isset($_GET['offset'])) { 
                $offset = $_GET['offset']; 
                $currenthalaman = ($_GET['offset']/$perhalaman)+1;
            } else { $offset = 0; }

            $res = $team_member->getTeamMembers(null,null,null,null);
            $totaldata = $team_member ->getTotalData();

            $jumlahhalaman = ceil($totaldata/$perhalaman);

            //BUAT TABEL
            echo "<table border = '1'>";
            echo "
            <tr>
                <th>Team</th>
                <th>Member</th>
                <th>Description</th>
            </tr>";

            while($row = $res->fetch_assoc()){
                echo "<tr>
                    <td>".$row['fname']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['description']."</td>
                    <td><a href='editteam_member.php?idteam=".$row['idteam']."&idmember=".$row['idmember']."'>Ubah Data</a></td>
                    <td><a href='deleteteammember.php?idteam=".$row['idteam']."&idmember=".$row['idmember']."'>Hapus Data</a></td>
                </tr>";
            }
            echo "</table>";
            
            // paging
            echo "<div>Total Data: ".$totaldata."</div>";
            echo "<a href='join_proposal.php?offset=0'>First</a>";
            
            for($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i-1) * $perhalaman;
                if($currenthalaman == $i) {                
                    echo "<strong style='color:red'>$i</strong></a>";
                } else {
                    echo "<a href='team_member.php?offset=".$off."'>".$i."</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
            echo "<a href='team_member.php?offset=".$lastOffset."'>Last</a><br><br>";
        ?>
    </div> 
    <a href="insertteam_member.php">Add New Team Member</a>
</body>
</html>