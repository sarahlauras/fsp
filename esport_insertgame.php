<html>
    <head>
        <title>Insert Game</title>
</head>
<body>
    <?php
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        $mysqli = new mysqli("localhost", "root","","esport");
            if($mysqli -> connect_errno) {
                echo "Koneksi database gagal: " . $mysqli->connect_error;
                exit();
            }
            else{
                echo "Koneksi database berhasil";
                echo"<br>";
            }
        
            $stmt = $mysqli->prepare("SELECT * FROM game"); #utk menghindari sql injection
            $stmt->execute();
            $res = $stmt->get_result(); #hasil dari $smt
    ?>
    <form action="esport_insertgame_proses.php" method="post">
    <label for="name">Nama: </label>
        <input  type="text" id="name" name="name"><br><br>
        <label for="sinopsis">Deskripsi: </label>
        <textarea id="description" name="description"></textarea><br><br>
        
        <input type="hidden" name="idgame" value="<?php echo $row["idgame"];?>">
        <input type="submit" value="Submit" name="btnSubmit">

    </form>
</body>
</html>