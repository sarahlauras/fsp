<html>
    <head>
        <title>E-sport Event</title>
        
    </head>
    <body>
        <?php 
        require_once 'classevent.php';
        $event = new Event();
        $res = $event->getAllEvent();

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
        <td><a href='esport_deleteevent.php?idevent=".$row['idevent']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus event ini?\");'>Hapus Data</a></td>
        </tr>";
    }
    
    echo "</table>";

        ?>
    <a href='esport_insertevent.php?'>Insert Data</a>
    </body>
</html>