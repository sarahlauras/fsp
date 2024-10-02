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

        $team = new Team();
        // Ambil nilai dari form
        $idgame = $_POST['game'];
        $namegame = $_POST['name'];

        //BACA DARI DOLLAR POST
        if(isset($_POST['btnSubmit'])){
            extract($_POST); //auto membuat variable dengan nilai" yang sama

            if (isset($idgame, $namegame)) {
                $arr_col = [
                    'idgame' => $idgame,
                    'name' => $namegame
                ];
    
                $last_id = $team->insertTeam($arr_col);
    
                if ($last_id) {
                    header("Location: team.php?result=success");
                    exit();
                }
                else {
                    echo "Error";
                }
            }
        }
        //setelah semua ter-run, form auto memindahkan user ke halalman insertmovie.php
        header("Location: insertteam.php?result=success");     
                
    ?>
</body>
</html>