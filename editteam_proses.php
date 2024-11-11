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
            $poster = $_FILES['poster'];

            $target_dir = "teams/";
            $newPoster = $idteam.".jpg";
            $target_file = $target_dir.$newPoster;
            
            //jika ada poster baru
            if (file_exists($target_file)){
                if (unlink($target_file)) {
                    echo "File lama berhasil dihapus.<br>";
                } else {
                    echo "Gagal menghapus file lama.<br>";
                }
                

                if($poster['name']){
                    // Validasi file (Hanya JPG yang diizinkan)
                    $imageFileType = strtolower(pathinfo($poster['name'], PATHINFO_EXTENSION));
                    if ($imageFileType != "jpg") {
                        echo "Hanya file JPG yang diizinkan.";
                        exit();
                    }

                    if (move_uploaded_file($poster['tmp_name'], $target_file)) {
                        echo "File baru berhasil diupload.<br>";
                    } else {
                        echo "Gagal mengupload file.";
                        exit();
                    }
                }
            }
            $jumlah = $team->editTeam($name, $game, $idteam);
        }
        //setelah semua ter-run, form auto memindahkan user ke halalman insertmovie.php
        header("Location: editteam.php?idteam=$idteam&result=success"); 
    ?>
</body>
</html>