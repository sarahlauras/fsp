<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
</head>
<body>
    <?php
        require_once 'classteam.php';
        $team = new Team();
        $res = $team->getAllTeam();

        //BUAT TABEL
        echo "<table border = '1'>";
        echo "
        <tr>
            <th>Name</th>
            <th>Game</th>
        </tr>";
        while($row = $res->fetch_assoc()){
            echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['game']."</td>
                <td><a href='editteam.php?idteam=".$row['idteam']."'>Ubah Data</a></td>
                <td><a href='deleteteam.php?idteam=".$row['idteam']."'onclick='return confirm(\"Apakah Anda yakin ingin menghapus Team ini?\");'>Hapus Data</a></td>
            </tr>";
        }
        echo "</table>";
    ?>
    <a href="insertteam.php">Add New Team</a>
</body>
</html>