<html>
    <head>
        <title>Edit Team Member</title>
        <link rel="stylesheet" type="text/css" href="sarahstyle.css">
</head>
<body>
    <?php
        echo "<a href='team_member.php'>Back</a>";
        require_once 'classteammember.php';
        $team_member = new TeamMember();
        
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        $idTeam = $_GET["idteam"];
        $idMember = $_GET["idmember"];
        
        if (isset($_GET["idteam"]) && isset($_GET["idmember"])) {
            $idTeam = $_GET["idteam"];
            $idMember = $_GET["idmember"];

            $stmt = $team_member->getTeamMembers($idMember, $idTeam, null, null);

            if ($stmt && $stmt->num_rows > 0) {
                $row = $stmt->fetch_assoc(); 
            } else {
                echo "Team Member tidak ditemukan.";
            }
        } else {
            echo "ID Team Member tidak ditemukan.";
        }

        $members = $team_member->getMember(); 
        $teams = $team_member->getTeam(); 
    ?>
    <form action="editteam_member_proses.php" method="post" enctype='multipart/form-data'>
        <label for="team">Team:</label>
        <select name="team" id="team"  value="<?php echo $row['idteam']; ?>"> 
            <?php
                while ($team_row = $teams->fetch_assoc()) {
                    $selected = ($team_row['idteam'] == $row['idteam']) ? 'selected' : '';
                    echo "<option value='" . $team_row['idteam'] . "' " . $selected . ">" . $team_row['name'] . "</option>";
                }
            ?>
        </select><br><br>
        <label for="member">Member:</label>
        <select name="member" id="member" value="<?php echo $row['idmember']; ?>"> 
        <?php
                while ($member_row = $members->fetch_assoc()) {
                    $selected = ($member_row['idmember'] == $row['idmember']) ? 'selected' : '';
                    echo "<option value='" . $member_row['idmember'] . "' " . $selected . ">" . $member_row['fname'] . "</option>";
                }
            ?>
        </select><br><br>
        <label for="description">Description :</label>
        <input type="text" id="description" name="description" value="<?php echo $row["description"]; ?>"><br><br>
            
        <input type="hidden" name="idmember" value="<?php echo $row['idmember']; ?>">
        <input type="hidden" name="idteam" value="<?php echo $row['idteam']; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>