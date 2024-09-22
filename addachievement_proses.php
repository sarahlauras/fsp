<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Achievement Proses</title>
</head>
<body>
    <?php
        $mysqli = new mysqli("localhost", "root", "", "esport");

        if($mysqli->connect_errno){ 
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $date = $_POST['date'];
        $team = $_POST['idteam'];

        if(isset($_POST['btnSubmit'])){
            $stmt_achievement = $mysqli->prepare("INSERT INTO achievement (name, description, date, idteam) VALUES(?,?,?,?)");

            if ($stmt_achievement === false) {
                echo "Error: " . $mysqli->error;
                exit();
            }

            // Bind parameter
            $stmt_achievement->bind_param("sssi", $name, $description, $date, $team);

            $stmt_achievement->execute();
            
            if ($stmt_achievement->affected_rows > 0) {
                header("Location: addachievement.php?result=success");
            } else {
                echo "Gagal menyimpan data.";
            }

            $stmt_achievement->close();
        }
        
        $mysqli->close();
    ?>
</body>
</html>
