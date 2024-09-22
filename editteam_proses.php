<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team Proses</title>
</head>
<body>
    <?php
    //copas koneksi db
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){ //kalau ada nilai selain 0, maka ada KEGAGALAN KONEKSI
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }
        if(isset($_POST['btnSubmit'])){
            // Ambil data dari POST secara eksplisit, hindari menggunakan extract()
            $name = $_POST['name'];
            $game = $_POST['game'];
            $idteam = $_POST['idteam'];

            // Persiapkan query dengan parameter yang sesuai
            $stmt = $mysqli->prepare(
                "UPDATE team SET name=?, idgame=? WHERE idteam=?"
            );

            // Gunakan tipe data yang tepat: "s" untuk string, "i" untuk integer
            $stmt->bind_param("sii", $name, $game, $idteam); 
            $stmt->execute();

            $jumlah = $stmt->affected_rows; //jumlah data yang kena dampak, affected_rows adalah properti
            $stmt->close();
        }
        $mysqli->close();
        //setelah semua ter-run, form auto memindahkan user ke halalman insertmovie.php
        header("Location: editteam.php?idteam=$idteam&result=success"); 
    ?>
</body>
</html>