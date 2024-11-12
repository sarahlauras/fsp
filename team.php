<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Team</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>Team</h1>
    <?php
    echo "<a href='home.php'>Back</a>";
    session_start();
    $role = $_SESSION["profile"];
    if ($role == 'admin') {
        require_once 'classteam.php';
        $team = new Team();
        $totaldata = 0;
        $perhalaman = 4;
        $currenthalaman = 1;

        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
            $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
        } else {
            $offset = 0;
        }

        // $res = $event_teams->getAllTeam(null,null);
        $totaldata = $team->getTotalData();
        $resteams = $team->getAllTeam($offset, $perhalaman);

        $jumlahhalaman = ceil($totaldata / $perhalaman);

        //BUAT TABEL
        echo "<table border = '1'>";
        echo "
            <tr>
                <th>Name</th>
                <th>Game</th>
                <th>Aksi</th>
            </tr>";
        while ($row = $resteams->fetch_assoc()) {
            $teamId = $row['idteam'];
            echo "<tr>
                    <td>" . $row['name'] . "<br>
                    <img src='teams/" . $teamId . ".jpg' alt='" . $row['name'] . " Poster' width='100' height='100'>
                    <form id='frmData' enctype='multipart/form-data'>
                        <input type='hidden' name='idteam' value='" . $teamId . "'>
                        <input type='file' name='photo' accept='image/jpg'>
                        <br>
                        <button type='button' id='btnupload' data-teamid='" . $teamId . "'>Upload</button>
                        </form>
                    </td>
                    <td>" . $row['game'] . "</td>
                    <td>
                    <a href='editteam.php?idteam=" . $row['idteam'] . "'>Ubah</a>
                    <a href='deleteteam.php?idteam=" . $row['idteam'] . "'onclick='return confirm(\"Apakah Anda yakin ingin menghapus Team ini?\");'>Hapus</a></td>
                    <input type='hidden' name='idteam' value='<?php echo $teamId; ?>'>
                </tr>";
        }
        echo "</table>";

        // paging
        //echo "<div>Total Data: ".$totaldata."</div>";
        echo "<a href='team.php?offset=0'>First</a>";

        for ($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i - 1) * $perhalaman;
            if ($currenthalaman == $i) {
                echo "<strong style='color:red'>$i</strong></a>";
            } else {
                echo "<a href='team.php?offset=" . $off . "'>" . $i . "</a> ";
            }
        }
        $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
        echo "<a href='team.php?offset=" . $lastOffset . "'>Last</a><br><br>";
    }
    ?>
    <?php
    if ($role == 'member') {
        echo "<p class='text_merah'>Anda tidak memiliki akses</p>";
    } else {
        echo "<a href='insertteam.php'>Insert New Team</a>";
    }
    ?>
    
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $("body").on("click", "#btnupload", function () {
        var formData = new FormData($("#frmData")[0]); // Ambil FormData dari form dengan id frmData

        $.ajax({
            url: 'uploadgambar.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            enctype: 'multipart/form-data',
            processData: false,
            success: function (response) {
                alert(response); 
                location.reload(); 
            }
        });
    });
</script>


</html>