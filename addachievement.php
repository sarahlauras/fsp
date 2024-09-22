<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Achievement</title>
</head>
<body>
    <?php
    // Check if the insertion was successful and display a message
    if(isset($_GET["result"])){
        if($_GET["result"] == "success"){
            echo "Achievement successfully added.<br><br>";
        }
    }
    ?>

    <form action="addachievement_proses.php" method="post" enctype='multipart/form-data'>
        <label for="name">Achievement Name</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description</label>
        <input type="text" id="description" name="description" required><br><br>

        <label for="Date">Date</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="Name">Team:</label>
            <select name="idteam" id="team">
                <?php
                $mysqli = new mysqli("localhost","root","","esport");
                if($mysqli->connect_errno) {
                    echo "Koneksi database gagal: ".$mysqli->connect_error;
                    exit();
                } 
        
                $stmt_achievement = $mysqli->prepare("SELECT idteam, name FROM team");
                $stmt_achievement->execute();
                $res = $stmt_achievement->get_result();

                while($row = $res->fetch_assoc()) {
                    echo "<option value='".$row['idteam']."'>".$row['name']."</option>";
                }
                ?>
        </select><br><br>

        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>
