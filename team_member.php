<?php
    require_once("classteammember.php");
    session_start();
    
    $role = $_SESSION["profile"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team Member</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>DAFTAR TEAM MEMBER</h1>
    <div id="kanan">
        <?php
        if ($role == 'admin'):
            $team_member = new TeamMember();
            $totaldata = 0;
            $perhalaman = 4;       
            $currenthalaman = 1;

            if(isset($_GET['offset'])) { 
                $offset = $_GET['offset']; 
                $currenthalaman = ($_GET['offset']/$perhalaman)+1;
            } else { $offset = 0; }

            $res = $team_member->getTeamMembers(null,null,$offset,$perhalaman);
            $totaldata = $team_member ->getTotalData();

            $jumlahhalaman = ceil($totaldata/$perhalaman);

            //BUAT TABEL
            echo "<table border = '1'>";
            echo "
            <tr>
                <th>Team</th>
                <th>Member</th>
                <th>Description</th>
                <th>Aksi</th>
            </tr>";

            while($row = $res->fetch_assoc()){
                echo "<tr>
                    <td>".$row['fname']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['description']."</td>
                    <td>
                    <a href='editteam_member.php?idteam=".$row['idteam']."&idmember=".$row['idmember']."'>Ubah</a>
                    <a href='deleteteammember.php?idteam=".$row['idteam']."&idmember=".$row['idmember']."'onclick='return confirm(\"Apakah Anda yakin ingin menghapus Team Member ini?\");'>Hapus</a>
                    </td>
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
    <a href="insertteam_member.php">Insert New Team Member</a>
    <?php
        else:
            echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
        endif; 
    ?>
</body>
</html>