<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Join Proposal</title>
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

        <form action="insertjoin_proposal_proses.php" method="post" enctype='multipart/form-data'>
            <label for="member">Member:</label>
            <select name="member" id="member"> 
                <?php
                $mysqli = new mysqli("localhost","root","","esport");
                if($mysqli->connect_errno) {
                    echo "Koneksi database gagal: ".$mysqli->connect_error;
                    exit();
                } 
        
                $stmt = $mysqli->prepare("SELECT idmember, fname FROM member");
                $stmt->execute();
                $res = $stmt->get_result();

                while($row = $res->fetch_assoc()) {
                    echo "<option value='".$row['idmember']."'>".$row['fname']."</option>";
                }
                ?>
            </select><br><br>
            <label for="team">Team:</label>
            <select name="team" id="team"> 
                <?php
                $mysqli = new mysqli("localhost","root","","esport");
                if($mysqli->connect_errno) {
                    echo "Koneksi database gagal: ".$mysqli->connect_error;
                    exit();
                } 
        
                $stmt = $mysqli->prepare("SELECT idteam, name FROM team");
                $stmt->execute();
                $res = $stmt->get_result();

                while($row = $res->fetch_assoc()) {
                    echo "<option value='".$row['idteam']."'>".$row['name']."</option>";
                }
                ?>
            </select><br><br>
            <label for="description">Description :</label>
            <input type="text" id="description" name="description"><br><br>
            
            <input type="submit" value="Submit" name="btnSubmit">
        </form>
</body>
</html>