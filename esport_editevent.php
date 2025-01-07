<html>
    <head>
        <title>Edit Event</title>
        <link rel="stylesheet" type="text/css" href="sarahstyle.css">
</head>
<body>
    <?php
        require_once 'classevent.php';
        $event = new Event();
        
        echo "<a href='esport_event.php'>Back</a>";

        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        $id = $_GET["idevent"];

        if (isset($_GET["idevent"])) {
            $id = $_GET["idevent"];

            $stmt = $event->getEventById($id);

            if ($stmt && $stmt->num_rows > 0) {
                $row = $stmt->fetch_assoc(); 
            } else {
                echo "Event tidak ditemukan.";
            }
        } else {
            echo "ID event tidak ditemukan.";
        }

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