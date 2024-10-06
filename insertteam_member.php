<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Team Member</title>
</head>
<body>
    <?php
        require_once 'classteammember.php';
        $team_member = new TeamMember();

        if (isset($_GET["result"])) {
            if ($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }
    ?>
    <form action="insertteam_member_proses.php" method="post" enctype='multipart/form-data'>
        <label for="team">Team:</label>
        <select name="team" id="team"> 
        <?php
            $resTeam = $team_member->getTeam();

            while($row = $resTeam->fetch_assoc()) {
                echo "<option value='".$row['idteam']."'>".$row['name']."</option>";
            }
        ?>
        </select><br><br>
        <label for="member">Member:</label>
        <select name="member" id="member"> 
        <?php
            $resMember = $team_member->getMember();
            while($row = $resMember->fetch_assoc()) {
                echo "<option value='".$row['idmember']."'>".$row['fname']."</option>";
            }
        ?>
        </select><br><br>
        <label for="description">Description :</label>
        <input type="text" id="description" name="description"><br><br>
            
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>