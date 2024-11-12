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
            // Ambil data 
            $name = $_POST['name'];
            $game = $_POST['game'];
            $idteam = $_POST['idteam'];

            $jumlah = $team->editTeam($name, $game, $idteam);
            if ($jumlah > 0) {
                header("Location: editteam.php?idteam=$idteam&result=success");
                exit();
            } else {
                echo "Tidak ada perubahan pada data tim.";
            }
        }
    ?>
</body>
</html>
