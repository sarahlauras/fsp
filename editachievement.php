<html>
<head>
    <title>Edit Achievement</title>
    <link rel="stylesheet" type="text/css" href="sarahstyle.css">
</head>
<body>
    <?php
        require_once 'classachievement.php';
        $achievement = new Achievement(); 
        
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        if (isset($_GET["idachievement"])) {
            $id = $_GET["idachievement"]; 

            $stmt = $achievement->getAchievementById($id); 

            if ($stmt && $stmt->num_rows > 0) {
                $row = $stmt->fetch_assoc(); 
            } else {
                echo "Achievement tidak ditemukan.";
                exit;
            }
        } else {
            echo "ID Achievement tidak ditemukan.";
            exit;
        }
    ?>
    <form action="editachievement_proses.php" method="post">
        <label for="name">Nama </label>
        <input type="text" id="name" name="name" value="<?php echo $row["name"]; ?>"><br><br>
        
        <label for="description">Description </label>
        <textarea id="description" name="description"><?php echo $row["description"]; ?></textarea><br><br>
        
        <label for="date">Date </label>
        <input type="date" id="date" name="date" value="<?php echo $row["date"]; ?>"><br><br>

        <label for="team">Team:</label>
        <select name="idteam" id="team">
            <?php
            $resTeam = $achievement->getTeam();

            while($rowTeam = $resTeam->fetch_assoc()) {
                $selected = ($row['idteam'] == $rowTeam['idteam']) ? 'selected' : '';
                echo "<option value='".$rowTeam['idteam']."' $selected>".$rowTeam['name']."</option>";
            }
            ?>
        </select><br><br>

        <input type="hidden" name="idachievement" value="<?php echo $row["idachievement"];?>"> 

        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>
