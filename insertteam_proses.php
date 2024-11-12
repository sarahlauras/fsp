<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Team Proses</title>
</head>
<body>
    <?php
        require_once 'classteam.php';

        if (isset($_POST['btnSubmit'])) {
            $team = new Team();

            $idgame = $_POST['game'];
            $namegame = $_POST['name'];
 
            $arr_col = [
                'idgame' => $idgame,
                'name' => $namegame
            ];

            $last_id = $team->insertTeam($arr_col);

            if ($last_id) {
                header("Location: insertteam.php?result=success");
                exit();
            } else {
                echo "Error saat menyimpan data.";
            }
        }
    ?>
</body>
</html>
