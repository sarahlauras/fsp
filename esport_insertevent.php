<html>
    <head>
        <title>Insert Event</title>
</head>
<body>
    <?php
        echo "<a href='esport_event.php'>Back</a>";
        require_once 'classevent.php';
        $event = new Event();

        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

    ?>
    <form action="esport_insertevent_proses.php" method="post">
        <label for="name">Nama: </label>
        <input  type="text" id="name" name="name"><br><br>
        <label for="date">Tgl. Event: </label>
        <input  type="date" id="date" name="date"><br><br>
        <label for="description">Deskripsi: </label>
        <textarea id="description" name="description"></textarea><br><br>
        
        <input type="hidden" name="idevent" value="<?php echo $row["idevent"];?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>