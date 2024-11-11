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
            $poster = $_FILES['poster'];

            $target_dir = "teams/";
            $newPoster = $idteam . ".jpg";
            $target_file = $target_dir . $newPoster;

            // Cek apakah file poster baru ada
            if($poster['name']) {
                $imageFileType = strtolower(pathinfo($poster['name'], PATHINFO_EXTENSION));
                if ($imageFileType != "jpg") {
                    echo "Hanya file JPG yang diizinkan.";
                    exit();
                }

                // Hapus file lama jika ada
                if (file_exists($target_file)) {
                    if (unlink($target_file)) {
                        echo "File lama berhasil dihapus.<br>";
                    } else {
                        echo "Gagal menghapus file lama.<br>";
                    }
                }

                // Upload file baru
                if (move_uploaded_file($poster['tmp_name'], $target_file)) {
                    echo "File baru berhasil diupload.<br>";
                } else {
                    echo "Gagal mengupload file.";
                    exit();
                }
            } else {
                // Jika tidak ada file yang di-upload, gunakan file lama
                echo "Tidak ada file yang di-upload, foto lama tetap digunakan.<br>";
            }
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
