<html>
    <head>
        <title>Insert Achievement</title>
        <link rel="stylesheet" type="text/css" href="sarahstyle.css">
</head>
<body>
    <?php
        require_once 'classachievement.php';
        $achievement = new Achievement();

        echo "<a href='achievement.php'>Back</a>";

        if(isset($_GET["result"])) {    
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }
    ?>

    <form action="addachievement_proses.php" method="post" enctype='multipart/form-data'>
        <label for="name">Achievement Name</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="Name">Team:</label>
            <select name="idteam" id="team">
            <?php
            $resTeam = $achievement->getTeam();

            while($row = $resTeam->fetch_assoc()) {
                echo "<option value='".$row['idteam']."'>".$row['name']."</option>";
            }
        ?>
        </select><br><br>

        <label for="Date">Date</label>
        <input type="date" id="date" name="date" required><br><br>

        <label for="description">Description</label>
        <input type="text" id="description" name="description" required><br><br>
        
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>
