<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
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
        $stmt = $mysqli->prepare("SELECT t.idteam, t.name, g.name as game FROM team t INNER JOIN game g ON t.idgame = g.idgame"); //prepare mencegah sql injection
        $stmt->execute(); 
        $res = $stmt->get_result(); //res = result untuk menampung value hasil

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
                <td><a href='deleteteam.php?idteam=".$row['idteam']."'>Hapus Data</a></td>
            </tr>";
        }
        echo "</table>";
        $mysqli->close();
    ?>
    <a href="insertteam.php">Add New Team</a>
</body>
</html>