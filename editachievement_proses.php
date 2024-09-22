<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Achievement Proses</title>
</head>
<body>
    <?php
        // Koneksi ke database
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }

        if(isset($_POST['btnSubmit'])){
            // Ambil data dari form
            $name = $_POST['name'];
            $description = $_POST['description'];
            $date = $_POST['date'];
            $team = $_POST['idteam'];
            $idachievement = $_POST['idachievement'];

            // Prepare query update
            $stmt_achievement = $mysqli->prepare(
                "UPDATE achievement SET name=?, description=?, date=?, idteam=? WHERE idachievement=?"
            );

            // Cek apakah prepare() berhasil
            if($stmt_achievement === false) {
                echo "Error: " . $mysqli->error;
                exit();
            }

            // Bind parameter dan eksekusi query
            $stmt_achievement->bind_param("sssii", $name, $description, $date, $team, $idachievement);
            $stmt_achievement->execute();

            // Tutup statement
            $stmt_achievement->close();

            // Redirect setelah sukses
            header("Location: editachievement.php?idachievement=$idachievement&result=success");
            exit();
        }

        // Tutup koneksi
        $mysqli->close();
    ?>
</body>
</html>
