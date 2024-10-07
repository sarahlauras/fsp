<html>
    <head>
        <title>Edit Game</title>
</head>
<body>
    <?php
        require_once 'classgame.php';
        $game = new Game();
        
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        $id = $_GET["idgame"];

        if (isset($_GET["idgame"])) {
            $id = $_GET["idgame"];

            $stmt = $game->getGameById($id);

            if ($stmt && $stmt->num_rows>0) {
                $row = $stmt->fetch_assoc();
            } else {
                echo "Game tidak ditemukan.";
            }
        } else {
            echo "ID Game tidak ditemukan.";
        }
        

    ?>
    <form action="esport_editgame_proses.php" method="post">
        <label for="name">Nama: </label>
        <input  type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br><br>
        <label for="sinopsis">Deskripsi: </label>
        <textarea id="description" name="description"><?php echo $row["description"]; ?></textarea><br><br>
        
        <input type="hidden" name="idgame" value="<?php echo $row["idgame"];?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>