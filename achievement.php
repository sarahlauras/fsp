<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Achievements</title>
</head>
<body>
    <?php
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }

        $stmt = $mysqli->prepare("SELECT a.idachievement, a.idteam, a.name, a.description, t.name AS team 
                                  FROM achievement a 
                                  INNER JOIN team t ON a.idteam = t.idteam");
        $stmt->execute(); 
        $res = $stmt->get_result();

        echo "<table border='1'>";
        echo "
        <tr>
            <th>Achievement Name</th>
            <th>Description</th>
            <th>Game</th>
            <th>Actions</th>
        </tr>";
        while($row = $res->fetch_assoc()){
            echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['description']."</td>
                <td>".$row['team']."</td>
                <td>
                    <a href='editachievement.php?idachievement=".$row['idachievement']."'>Edit</a> |
                    <a href='deleteachievement.php?idachievement=".$row['idachievement']."'>Delete</a>
                </td>
            </tr>";
        }
        echo "</table>";

        $mysqli->close();
    ?>
    <br>
    <a href="addachievement.php">Add New Achievement</a>
</body>
</html>