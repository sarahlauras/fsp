<?php
    require_once("classevent.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $role = $_SESSION["profile"];
    $member = $_SESSION["idmember"]; 
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
        echo "<br>";
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

        // if ($role == "admin") {
        //     $res = $event->getAllEvent(null, $offset, $perhalaman);  // Username = null
        //     $totaldata = $event->getTotalData();
        // } else {
        //     $username = $_SESSION['username'];
        //     $res = $event->getAllEvent($username, $offset, $perhalaman);
        //     $totaldata = $event->getTotalData($username);
        // }

        if($role == 'member') {
            $res = $event->getUserTeams($member);
        }
        else {
            $res = $event->getTeam($offset, $perhalaman);
        }
        //$res = $event->getUserTeams($member);
        ?>
        <!-- <form method="POST" action="submit_event.php">
            <label for="team">Pilih Team: </label>
            <select name="team" id="team">
                <option value="" disabled selected>Pilih Team</option>
            </select>  
            <input type="button" id="btnsubmit" value="Pilih"/>               -->
        
            <?php
            echo "<form method='GET' action='esport_event.php'>";
            echo "<label for='team'>Pilih Team: </label>";
            echo "<select name='idteam' id='team'>";
            echo "<option value='' disabled selected>Pilih Team</option>";
            while($row = $res->fetch_assoc()) {
                $selected = "";
                if (isset($_GET['idteam']) && $_GET['idteam'] == $row['idteam']) {
                    $selected = "selected";
                }
                echo "<option value='".$row['idteam']."' $selected>".$row['name']."</option>";
            }
            echo "</select>";
            echo "<input type='submit' value='Pilih'/>";
            echo "</form>";

            if (isset($_GET["idteam"])) {
                $selected = $_GET["idteam"];
                if($role == 'admin') {
                    $member= null;
                    $totaldata = $event->getData($member, $selected);
                }
                else {
                    $totaldata = $event->getData($member, $selected);
                }
                $events = $event->getEventByTeam($selected, $offset, $perhalaman);
            } else {
                if ($role == "admin") {
                    $totaldata = $event->getData(); 
                    $events = $event->getEvent($offset, $perhalaman);
                } elseif ($role == "member") {
                    $totaldata = $event->getData($member);
                    $events = $event->getEventApprovedProposal($member, $offset, $perhalaman);
                }
            }
            ?>

        <?php

        echo "<table border='1'>";
        if ($role == 'member') {
            echo "<tr>
                            <th>Nama Event</th>
                            <th>Tgl. Event</th>
                            <th>Deskripsi</th>
                            <th>Team</th>
                        </tr>";
        } else {
            echo "<tr>  
                            <th>Nama Event</th>
                            <th>Tgl. Event</th>
                            <th>Deskripsi</th>
                            <th>Team</th>
                            <th>Aksi</th>
                        </tr>";
        }

        while ($row = $events->fetch_assoc()) {
            $formatrilis = strftime("%d %B %Y", strtotime($row['date']));
            $format_serial = "";

            if ($role == 'member') {
                echo "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>" . $formatrilis . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['namateam'] . "</td>
                        </tr>";
            } else {
                echo "<tr>
                            <td>" . $row['name'] . "</td>
                            <td>" . $formatrilis . "</td>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['namateam'] . "</td>
                            <td>
                            <a href='esport_editevent.php?idevent=" . $row['idevent'] . "'>Ubah</a>
                            <a href='esport_deleteevent.php?idevent=" . $row['idevent'] . "' onclick='return confirm(\"Apakah Anda yakin ingin menghapus event ini?\");'>Hapus</a>
                            </td>
                    </tr>";
            }
        }

        echo "</table>";
        // paging
        $jumlahhalaman = ceil($totaldata / $perhalaman);
        echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='esport_event.php?offset=0'>First</a>";

        for ($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i - 1) * $perhalaman;
            if ($currenthalaman == $i) {                
                echo "<strong style='color:red'>$i</strong>";
            } else {
                if (isset($_GET["idteam"])) {
                    echo "<a href='esport_event.php?offset=".$off."&idteam=".$selected."'>".$i."</a> ";
                } else {
                    echo "<a href='esport_event.php?offset=".$off."'>".$i."</a> ";
                }
            }
        }
        $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
        if (isset($_GET["idteam"])) {
            echo "<a href='esport_event.php?offset=".$lastOffset."&idteam=".$selected."'>Last</a><br><br>";
        } else {
            echo "<a href='esport_event.php?offset=".$lastOffset."'>Last</a><br><br>";
        }

        if ($role == 'admin') {
            echo "<a href='esport_insertevent.php?'>Insert Event</a>";
        }
        ?>
    </body>

</html>