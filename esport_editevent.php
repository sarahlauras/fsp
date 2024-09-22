<html>
    <head>
        <title>Edit Event</title>
</head>
<body>
    <?php
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        $id = $_GET["idevent"];

        //koneksi database
        $mysqli = new mysqli("localhost", "root","","esport");
        if($mysqli -> connect_errno) {
            echo "Koneksi database gagal: " . $mysqli->connect_error;
            exit();
        }
        
        $stmt = $mysqli->prepare("SELECT * FROM event WHERE idevent=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_assoc(); //untuk ngambil row pertama

    ?>
    <form action="esport_editevent_proses.php" method="post">
        <label for="name">Nama: </label>
        <input  type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br><br>
        <label for="date">Tgl. Event: </label>
        <input  type="date" id="date" name="date" value="<?php echo $row["date"]; ?>"><br><br>
        <label for="description">Deskripsi: </label>
        <textarea id="description" name="description"><?php echo $row["description"]; ?></textarea><br><br>
        
        <input type="hidden" name="idevent" value="<?php echo $row["idevent"];?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>