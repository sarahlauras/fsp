<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Join Proposal</title>
</head>
<body>
    <?php
        if(isset($_GET["result"])){
            if($_GET["result"] == "success"){
                echo "Data berhasil disimpan.<br><br>";
            } 
        }
        $id = $_GET["idjoin_proposal"];

        // Koneksi ke database
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){ 
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }

        $stmt = $mysqli->prepare("SELECT jp.idjoin_proposal, jp.idmember, m.fname, jp.idteam, t.name, jp.description, jp.status 
                                  FROM join_proposal jp 
                                  INNER JOIN member m ON m.idmember = jp.idmember 
                                  INNER JOIN team t ON t.idteam = jp.idteam 
                                  WHERE jp.idjoin_proposal = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $res = $stmt->get_result();

        $row = $res->fetch_assoc(); 
    ?>
    <form action="editjoin_proposal_proses.php" method="post" enctype='multipart/form-data'>
        <label for="member">Member:</label>
        <select name="idmember" id="member">
            <?php
                $stmt_achievement = $mysqli->prepare("SELECT * FROM member");
                $stmt_achievement->execute();
                $result_achievement = $stmt_achievement->get_result();

                while ($achievement_row = $result_achievement->fetch_assoc()) {
                    $selected = ($achievement_row['idmember'] == $row['idmember']) ? 'selected' : '';
                    echo "<option value='".$achievement_row['idmember']."' ".$selected.">".$achievement_row['fname']."</option>";
                }
                $stmt_achievement->close();
            ?>
        </select><br><br>

        <label for="team">Team:</label>
        <select name="idteam" id="team">
            <?php
                $stmt_achievement = $mysqli->prepare("SELECT * FROM team");
                $stmt_achievement->execute();
                $result_achievement = $stmt_achievement->get_result();

                while ($achievement_row = $result_achievement->fetch_assoc()) {
                    $selected = ($achievement_row['idteam'] == $row['idteam']) ? 'selected' : '';
                    echo "<option value='".$achievement_row['idteam']."' ".$selected.">".$achievement_row['name']."</option>";
                }
                $stmt_achievement->close();
            ?>
        </select><br><br>

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" value="<?php echo $row['description']; ?>"><br><br>

        <label for="status">Status:</label>
        <select id="status" name="status">
            <option value="waiting" <?php if($row['status'] == "waiting") echo 'selected'; ?>>Waiting</option>
            <option value="approved" <?php if($row['status'] == "approved") echo 'selected'; ?>>Approved</option>
            <option value="rejected" <?php if($row['status'] == "rejected") echo 'selected'; ?>>Rejected</option>
        </select><br><br>

        <input type="hidden" name="idjoin_proposal" value="<?php echo $row['idjoin_proposal']; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>
