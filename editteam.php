<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
</head>
<body>
    <?php
        require_once 'classteam.php';
        $team = new Team();

        if(isset($_GET["result"])){
            if($_GET["result"] == "success"){
                //melihat di url nya apakah ada result dan bernilai succes?
                echo "Data berhasil disimpan.<br><br>";
            } 
        }
        $idteam = $_GET["idteam"];

        $stmt = $team->getEventById($idteam);

        if ($stmt && $stmt->num_rows > 0) {
            $row = $stmt->fetch_assoc(); 
        } else {
            echo "Team tidak ditemukan.";
        }
    ?>
    <form action="editteam_proses.php" method="post" enctype='multipart/form-data'>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" value ="<?php echo $row["name"]; ?>"><br><br>
        <label for="game">Game:</label>
        <select name="game" id="game">
            <?php
                // Query untuk mengambil daftar game dari tabel game
                $stmt_game = $team->getGames();
                while ($game_row = $stmt_game->fetch_assoc()) {
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