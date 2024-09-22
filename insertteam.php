<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Team</title>
</head>
<body>
    <?php //akan mereturn saat $_GET ada dan tidak null
        if(isset($_GET["result"])){
            if($_GET["result"] == "success"){
                //melihat di url nya apakah ada result dan bernilai succes?
                echo "Data berhasil disimpan.<br><br>";
            } 
        }
    ?>

        <form action="insertteam_proses.php" method="post" enctype='multipart/form-data'>
            <label for="name">Name</label>
            <input type="text" id="name" name="name"><br><br>
            <label for="genre">Game:</label>
            <select name="game" id="game">
                <?php
                $mysqli = new mysqli("localhost","root","","esport");
                if($mysqli->connect_errno) {
                    echo "Koneksi database gagal: ".$mysqli->connect_error;
                    exit();
                } 
        
                $stmt = $mysqli->prepare("SELECT idgame, name FROM game");
                $stmt->execute();
                $res = $stmt->get_result();

                while($row = $res->fetch_assoc()) {
                    echo "<option value='".$row['idgame']."'>".$row['name']."</option>";
                }
                ?>
            <input type="submit" value="Submit" name="btnSubmit">
        </form>
</body>
</html>