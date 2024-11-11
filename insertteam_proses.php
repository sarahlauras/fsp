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
            $poster = $_FILES['poster'];

            $posterName = $namegame . ".jpg";
            $target_dir = "teams/";

            if (isset($idgame, $namegame)) {
                if (move_uploaded_file($_FILES['poster']['tmp_name'], $target_dir . $posterName)) {
                    // Data yang akan disimpan ke database
                    $arr_col = [
                        'idgame' => $idgame,
                        'name' => $namegame,
                        'poster' => $posterName
                    ];

                    $last_id = $team->insertTeam($arr_col);

                    if ($last_id) {
                        header("Location: team.php?result=success");
                        exit();
                    } else {
                        echo "Error saat menyimpan data.";
                    }
                } else {
                    echo "Gagal mengupload file.";
                }
            } else {
                echo "Data idgame atau namegame tidak lengkap.";
            }
        }
    ?>
</body>
</html>
