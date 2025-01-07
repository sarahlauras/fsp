<html>
    <head>
        <title>Insert Game</title>
        <link rel="stylesheet" type="text/css" href="sarahstyle.css">
</head>
<body>
    <?php
        require_once 'classgame.php';
        $game = new Game();

        echo "<a href='esport_game.php'>Back</a>";

        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

    ?>
    <form action="esport_insertgame_proses.php" method="post">
        <label for="name">Nama: </label>
        <input  type="text" id="name" name="name"><br><br>
        <label for="description">Deskripsi: </label>
        <textarea id="description" name="description"></textarea><br><br>
        <input type="hidden" name="idgame" value="<?php echo $row["idgame"];?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>