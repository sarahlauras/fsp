<?php
require_once("classevent.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["profile"];
?>

<html>

<head>
    <title>E-sport Event</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

    <h1>Event</h1>
    
    <?php
    echo "<a href='home.php'>Back</a>";
    $event = new Event();
    $totaldata = 0;
    $perhalaman = 4;
    $currenthalaman = 1;

    if (isset($_GET['offset'])) {
        $offset = $_GET['offset'];
        $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
    } else {
        $offset = 0;
    }

    if ($role == "admin") {
        $res = $event->getAllEvent(null, $offset, $perhalaman);  // Username = null
        $totaldata = $event->getTotalData();
    } else {
        $username = $_SESSION['username'];
        $res = $event->getAllEvent($username, $offset, $perhalaman);
        $totaldata = $event->getTotalData($username);
    }
    $jumlahhalaman = ceil($totaldata / $perhalaman);

    echo "<table border='1'>";
    if ($role == 'member') {
        echo "<tr>
                        <th>Nama Event</th>
                        <th>Tgl. Event</th>
                        <th>Deskripsi</th>
                    </tr>";
    } else {
        echo "<tr>  
                        <th>Nama Event</th>
                        <th>Tgl. Event</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>";
    }


    while ($row = $res->fetch_assoc()) {
        $formatrilis = strftime("%d %B %Y", strtotime($row['date']));
        $format_serial = "";

        if ($role == 'member') {
            echo "<tr>
                        <td>" . $row['name'] . "</td>
                        <td>" . $formatrilis . "</td>
                        <td>" . $row['description'] . "</td>
                    </tr>";
        } else {
            echo "<tr>
                        <td>" . $row['name'] . "</td>
                        <td>" . $formatrilis . "</td>
                        <td>" . $row['description'] . "</td>
                        <td>
                        <a href='esport_editevent.php?idevent=" . $row['idevent'] . "'>Ubah</a>
                        <a href='esport_deleteevent.php?idevent=" . $row['idevent'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus event ini?\");'>Hapus</a>
                        </td>
                 </tr>";
        }
    }

    echo "</table>";
    // paging
    //echo "<div>Total Data: ".$totaldata."</div>";
    echo "<a href='esport_event.php?offset=0'>First</a>";

    for ($i = 1; $i <= $jumlahhalaman; $i++) {
        $off = ($i - 1) * $perhalaman;
        if ($currenthalaman == $i) {
            echo "<strong style='color:red'>$i</strong></a>";
        } else {
            echo "<a href='esport_event.php?offset=" . $off . "'>" . $i . "</a> ";
        }
    }
    $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
    echo "<a href='esport_event.php?offset=" . $lastOffset . "'>Last</a><br><br>";

    if ($role == 'admin') {
        echo "<a href='esport_insertevent.php?'>Insert Event</a>";
    }
    ?>
</body>

</html>