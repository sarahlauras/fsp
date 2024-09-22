<html>
    <head>
        <title>Edit Game</title>
</head>
<body>
    <?php
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        //tangkap id movie dari query string
        $id = $_GET["idgame"];

        //koneksi database
        $mysqli = new mysqli("localhost", "root","","esport");
        if($mysqli -> connect_errno) {
            echo "Koneksi database gagal: " . $mysqli->connect_error;
            exit();
        }
        
        $stmt = $mysqli->prepare("SELECT * FROM game WHERE idgame=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_assoc() //untuk ngambil row pertama

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