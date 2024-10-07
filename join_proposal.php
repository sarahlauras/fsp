<?php
    require_once("classjoinproposal.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Proposal</title>
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
    <h1>DAFTAR JOIN PROPOSAL</h1>
    <div id="kiri">
        <ul>
        <li><a href="team.php">Daftar Team</a></li>
            <li><a href="esport_game.php">Daftar Game</a></li>
            <li><a href="team_member.php">Daftar Team Member</a></li>
            <li><a href="esport_event.php">Daftar Event</a></li>
            <li><a href="eventteams.php">Daftar Event Team</a></li>
            <li><a href="achievement.php">Daftar Achievement</a></li>
            <li><a href="member.php">Daftar Member</a></li>
        </ul>
    </div> 
    <div id="kanan">
        <?php
            $joinproposal = new JoinProposal();
            $totaldata = 0;
            $perhalaman = 4;       
            $currenthalaman = 1;

            if(isset($_GET['offset'])) { 
                $offset = $_GET['offset']; 
                $currenthalaman = ($_GET['offset']/$perhalaman)+1;
            } else { $offset = 0; }

            $res = $joinproposal->getJoinProposal(null,$offset, $perhalaman);
            $totaldata = $joinproposal->getTotalData();

            $jumlahhalaman = ceil($totaldata/$perhalaman);

            //BUAT TABEL
            echo "<table border = '1'>";
            echo "
            <tr>
                <th>Member</th>
                <th>Team</th>
                <th>Description</th>
                <th>Status</th>
            </tr>";

            while($row = $res->fetch_assoc()){
                echo "<tr>
                    <td>".$row['fname']."</td>
                    <td>".$row['name']."</td>
                    <td>".$row['description']."</td>
                    <td>".$row['status']."</td>
                    <td><a href='editjoin_proposal.php?idjoin_proposal=".$row['idjoin_proposal']."'>Ubah Data</a></td>
                    <td><a href='deletejoin_proposal.php?idjoin_proposal=".$row['idjoin_proposal']."'>Hapus Data</a></td>
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
                    echo "<a href='join_proposal.php?offset=".$off."'>".$i."</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
            echo "<a href='join_proposal.php?offset=".$lastOffset."'>Last</a><br><br>";
        ?>
    </div> 
    <a href="insertjoin_proposal.php">Add New Join Proposal</a>
</body>
</html>