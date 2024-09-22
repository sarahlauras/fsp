<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
</head>
<body>
    <?php
        if(isset($_GET["result"])){
            if($_GET["result"] == "success"){
                //melihat di url nya apakah ada result dan bernilai succes?
                echo "Data berhasil disimpan.<br><br>";
            } 
        }
        $id = $_GET["idteam"];

        //tangkap ke database
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){ //kalau ada nilai selain 0, maka ada KEGAGALAN KONEKSI
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }
        $stmt = $mysqli->prepare("SELECT t.idteam, t.idgame, t.name, g.name AS game FROM team t INNER JOIN game g 
                                  ON t.idgame = g.idgame WHERE t.idteam = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_assoc(); //untuk ngambil data pertama
    ?>
    <form action="editteam_proses.php" method="post" enctype='multipart/form-data'>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value ="<?php echo $row["name"]; ?>"><br><br>
        <label for="genre">Game:</label>
        <select name="game" id="game">
            <?php
                // Query untuk mengambil daftar game dari tabel game
                $stmt_game = $mysqli->prepare("SELECT * FROM game");
                $stmt_game->execute();
                $result_game = $stmt_game->get_result();

                // Loop melalui semua game dan membuat opsi untuk setiap game
                while ($game_row = $result_game->fetch_assoc()) {
                    // Jika game yang diambil sama dengan game yang sedang dipilih, tambahkan atribut selected
                    $selected = ($game_row['idgame'] == $row['idgame']) ? 'selected' : '';
                    echo "<option value='".$game_row['idgame']."' ".$selected.">".$game_row['name']."</option>";
                }
                $stmt_game->close();
            ?>
        </select>

        <input type="hidden" name="idteam" value="<?php echo $row['idteam']; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>        
</body>
</html>