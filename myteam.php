<?php
require_once("JoinProposal.php");
require_once("TeamMember.php");
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$idmember = $_SESSION["idmember"];
$joinProposal = new JoinProposal();
$teamMember = new TeamMember();

// Ambil tim yang disetujui untuk anggota saat ini
$approvedTeams = $joinProposal->getApprovedTeams($idmember);
?>

<html>
<head>
    <title>My Teams</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h1>My Teams</h1>
    <a href="home.php">Back</a><br><br>

    <?php if ($approvedTeams->num_rows > 0): ?>
        <form method="POST" action="">
            <label for="team">Pilih Team: </label>
            <select name="team" id="team" onchange="this.form.submit()">
                <option value="" disabled selected>Pilih Team</option>
                <?php while($team = $approvedTeams->fetch_assoc()): ?>
                    <option value="<?= $team['idteam'] ?>" <?= (isset($_POST['team']) && $_POST['team'] == $team['idteam']) ? 'selected' : '' ?>>
                        <?= $team['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <?php
        if (isset($_POST['team'])) {
            $idteam = $_POST['team'];
            $teamMembers = $teamMember->getTeamMembersByTeam($idteam);
            echo "<h2>Members of Team</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Name</th></tr>";

            while ($member = $teamMembers->fetch_assoc()) {
                echo "<tr><td>" . $member['fname'] . "</td></tr>";
            }

            echo "</table>";
        }
        ?>
    <?php else: ?>
        <p>You have no approved teams.</p>
    <?php endif; ?>
</body>
</html>
