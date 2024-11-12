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

            $file_extension = pathinfo($poster['name'], PATHINFO_EXTENSION);
            if ($file_extension != 'jpg') {
                echo "Hanya menerima file .jpg";
                exit();
            }
            $target_dir = "teams/";
            $posterName = ''; 
            $arr_col = [
                'idgame' => $idgame,
                'name' => $namegame,
                'poster' => $posterName
            ];

            $last_id = $team->insertTeam($arr_col);

            if ($last_id) {
                $posterName = $last_id . ".jpg"; 

                if (move_uploaded_file($poster['tmp_name'], $target_dir . $posterName)) {
                    header("Location: insertteam.php?result=success");
                    exit();
                } else {
                    echo "Gagal mengupload file.";
                }
            } else {
                echo "Error saat menyimpan data.";
            }
        }
    ?>
</body>
</html>
