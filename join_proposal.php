<?php
    require_once("classjoinproposal.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Proposal</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <?php
        //KONEKSI DATABASE
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){ //kalau ada nilai selain 0, maka ada KEGAGALAN KONEKSI
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }
        //MEMBUAT PERINTAH SELECT ALL MOVIE
        $stmt = $mysqli->prepare("SELECT jp.idjoin_proposal, m.fname, t.name, jp.description, jp.status FROM join_proposal jp INNER JOIN
                                  member m ON jp.idmember = m.idmember INNER JOIN team t ON jp.idteam = t.idteam"); //prepare mencegah sql injection
        $stmt->execute(); 
        $res = $stmt->get_result(); 

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
        $mysqli->close();
    ?>
    <a href="insertjoin_proposal.php">Add New Join Proposal</a>
</body>
</html>