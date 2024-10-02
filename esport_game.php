<html>
    <head>
        <title>E-Sport Game</title>
        
    </head>
    <body>
        <?php 
        $mysqli = new mysqli("localhost", "root","","esport");
        if($mysqli -> connect_errno) {
            echo "Koneksi database gagal: " . $mysqli->connect_error;
            exit();
        }

        $stmt = $mysqli->prepare("SELECT * FROM game"); 
        $stmt->execute();
        $res = $stmt->get_result();

        echo "<table border='1'>";
        echo "<tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th colspan='2'>Aksi</th>
        </tr>";

    while($row = $res->fetch_assoc()) {
        echo "<tr>
        <td>".$row['name']."</td>
        <td>".$row['description']."</td>
        <td><a href='esport_editgame.php?idgame=".$row['idgame']."'>Ubah Data</a></td>
        <td><a href='esport_deletegame.php?idgame=".$row['idgame']."'>Hapus Data</a></td>
        </tr>";
    }

    echo "</table>";

    $mysqli->close();
        ?>

    <a href='esport_insertgame.php'>Insert Game</a>
    </body>
</html>