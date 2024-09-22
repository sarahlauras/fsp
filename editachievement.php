<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Team</title>
</head>
<body>
    <?php
        if(isset($_GET["result"])){
            if($_GET["result"] == "success"){
                echo "Data berhasil disimpan.<br><br>";
            } 
        }
        $id = $_GET["idachievement"];

        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }
        $stmt = $mysqli->prepare("SELECT a.idachievement, a.idteam, a.name, a.description, a.date, t.name AS team 
                                  FROM achievement a INNER JOIN team t ON a.idteam = t.idteam WHERE a.idachievement= ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_assoc();
    ?>
    <form action="editachievement_proses.php" method="post" enctype='multipart/form-data'>
        <label for="name">Achievement Name</label>
        <input type="text" id="name" name="name" value ="<?php echo $row['name'];?>" required><br><br>

        <label for="description">Description</label>
        <input type="text" id="description" name="description" value ="<?php echo $row['description'];?>" required><br><br>

        <label for="Date">Date</label>
        <input type="date" id="date" name="date" value ="<?php echo $row['date'];?>" required><br><br>

        <label for="Name">Team</label>
            <select name="idteam" id="team" value ="<?php echo $row['team'];?>">
            <?php
                $stmt_achievement = $mysqli->prepare("SELECT * FROM team");
                $stmt_achievement->execute();
                $result_achievement = $stmt_achievement->get_result();

                while ($achievement_row = $result_achievement->fetch_assoc()) {
                    $selected = ($achievement_row['idteam'] == $row['idteam'])? 'selected' : '';
                    echo "<option value='".$achievement_row['idteam']."' ".$selected.">".$achievement_row['name']."</option>";
                }
                $stmt_achievement->close();
            ?>
        </select>

        <input type="hidden" name="idachievement" value="<?php echo $row['idachievement']; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>        
</body>
</html>