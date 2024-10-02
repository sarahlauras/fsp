<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team Proses</title>
</head>
<body>
    <?php
        require_once 'classteam.php';
        $team = new Team();

        if(isset($_POST['btnSubmit'])){
            // Ambil data dari POST secara eksplisit, hindari menggunakan extract()
            $name = $_POST['name'];
            $game = $_POST['game'];
            $idteam = $_POST['idteam'];
            
            $jumlah = $team->editTeam($name, $game, $idteam);
        }
        $mysqli->close();
        //setelah semua ter-run, form auto memindahkan user ke halalman insertmovie.php
        header("Location: editteam.php?idteam=$idteam&result=success"); 
    ?>
</body>
</html>