<html>
    <head>
        <title>E-sport Event</title>
        
    </head>
    <body>
        <?php 
        require_once 'classevent.php';
        $event = new Event();

        $totaldata = 0;
        $perhalaman = 4;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = ($_GET['offset']/$perhalaman)+1;
        } else { $offset = 0; }

        $res = $event->getAllEvent($offset, $perhalaman);
        $totaldata = $event ->getTotalData();

        $jumlahhalaman = ceil($totaldata/$perhalaman);
        
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
    // paging
    echo "<div>Total Data: ".$totaldata."</div>";
    echo "<a href='esport_event.php?offset=0'>First</a>";
    
    for($i = 1; $i <= $jumlahhalaman; $i++) {
        $off = ($i-1) * $perhalaman;
        if($currenthalaman == $i) {                
            echo "<strong style='color:red'>$i</strong></a>";
        } else {
            echo "<a href='esport_event.php?offset=".$off."'>".$i."</a> ";
        }
    }
    $lastOffset = ($jumlahhalaman - 1)*$perhalaman;
    echo "<a href='esport_event.php?offset=".$lastOffset."'>Last</a><br><br>";
        ?>
    <a href='esport_insertevent.php?'>Insert Data</a>
    </body>
</html>