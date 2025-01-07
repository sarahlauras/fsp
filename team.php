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
    echo "<a class='btnPagination' href='home.php'>Back</a>";
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

        $totaldata = $team->getTotalData();
        $resteams = $team->getAllTeam($offset, $perhalaman);

        $jumlahhalaman = ceil($totaldata / $perhalaman);

        // BUAT TABEL
        echo "<table border='1'>";
        echo "<thead>";
        echo "
            <tr>
                <th>Name</th>
                <th>Image</th>
                <th>Game</th>
                <th>Action</th>
            </tr>";
        echo "</thead>";
        while ($row = $resteams->fetch_assoc()) {
            $teamId = $row['idteam'];
            echo "<tr>
                    <td><span class='label'>Name: </span>". $row['name'] . "<br>
                    <td><span class='label'>Image: </span><img src='teams/" . $teamId . ".jpg' alt='" . $row['name'] . " Poster' width='100' height='100'>
                    
                    <form id='frmData{$teamId}' enctype='multipart/form-data'>
                        <input type='hidden' name='idteam' value='{$teamId}'>
                        <input type='file' name='photo' accept='image/jpg'>
                        <br>
                        <button type='button' class='btnupload' data-teamid='{$teamId}'>Upload</button>
                    </form>
                    
                    </td>
                    <td><span class='label'>Game: </span>" . $row['game'] . "</td>
                    <td><span class='label'>Action: </span>
                    <div class='action'>
                    <a href='editteam.php?idteam=" . $row['idteam'] . "'>Change</a>
                    <a href='deleteteam.php?idteam=" . $row['idteam'] . "' onclick='return confirm(\"Are you sure you want to delete?\");'>Delete</a></td>
                    </div>
                </tr>";
        }
        echo "</table>";

        // PAGING
        echo "<div class='pagination'>";
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
    if ($role == 'member') {
        echo "<p class='text_merah'>You not have an access</p>";
    } else {
        echo "<a href='insertteam.php'>Insert New Team</a>";
    }
    echo "</div>";
    ?>

</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $("body").on("click", ".btnupload", function () {
        var teamId = $(this).data("teamid");
        var formData = new FormData($("#frmData" + teamId)[0]); // Ambil FormData dari form dengan ID yang sesuai dengan idteam

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
                console.log(response); // Debug log
                alert(response);
                location.reload();
            },
            error: function (xhr, status, error) {
                console.error("Kesalahan AJAX:", error);
                alert("Upload gagal!");
            }
        });
    });
</script>

</html>