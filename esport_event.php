<html>
    <head>
        <title>E-sport Event</title>
        
    </head>
    <body>
        <?php 
        $mysqli = new mysqli("localhost", "root","","esport");
        if($mysqli -> connect_errno) {
            echo "Koneksi database gagal: " . $mysqli->connect_error;
            exit();
        }
        else{
            echo "Koneksi database berhasil";
            echo"<br>";
        }

        $stmt = $mysqli->prepare("SELECT * FROM event"); 
        $stmt->execute();
        $res = $stmt->get_result();

        echo "<table border='1'>";
        echo "<tr>
            <th>Nama</th>
            <th>Tgl. Event</th>
            <th>Deskripsi</th>
            <th colspan='3'>Aksi</th>
        </tr>";

    while($row = $res->fetch_assoc()) {
        $formatrilis = strftime("%d %B %Y", strtotime($row['date']));
        $format_serial = "";
        echo "<tr>
        <td>".$row['name']."</td>
        <td>".$formatrilis."</td>
        <td>".$row['description']."</td>
        <td><a href='esport_editevent.php?idevent=".$row['idevent']."'>Ubah Data</a></td>
        <td><a href='esport_insertevent.php?idevent=".$row['idevent']."'>Insert Data</a></td>
        <td><a href='esport_deleteevent.php?idevent=".$row['idevent']."'>Hapus Data</a></td>
        </tr>";
    }
    

    echo "</table>";

    $mysqli->close();
        ?>

    </body>
</html>