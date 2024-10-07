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

        if (isset($_GET["idachievement"])) {
            $id = $_GET["idachievement"];

            $stmt = $achievement->getAchievementById($id);

            if ($stmt && $stmt->num_rows>0) {
                $row = $stmt->fetch_assoc();
            } else {
                echo "Achievement tidak ditemukan.";
            }
        } else {
            echo "ID Achievement tidak ditemukan.";
        }
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
        </select>
        <input type="hidden" name="idachievement" value="<?php echo $row['idachievement']; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>        
</body>
</html>