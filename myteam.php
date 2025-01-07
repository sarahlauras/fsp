<?php
require_once("classjoinproposal.php");
require_once("classteammember.php");
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
    <a class='btnPagination' href="home.php">Back</a><br><br>

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
            $totaldata = 0;
            $perhalaman = 4;       
            $currenthalaman = 1;
            $teamMembers = $teamMember->getTeamMembersByTeam($idteam);
            $totaldata = $teamMember ->getTotalData();
            $jumlahhalaman = ceil($totaldata/$perhalaman);

            // echo "<h2>Members of Team</h2>";
            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr>
                <th>Name</th>
            </tr>";
            echo "</thead>";

            while ($member = $teamMembers->fetch_assoc()) {
                $sedangLogin = "";
                if ($member['idmember'] == $idmember) {
                    $sedangLogin = " (saya)";
                }
                echo "<tr>
                    <td><span class='label'>Name: </span>" . $member['fname'] . $sedangLogin . "</td></tr>";
            }            

            echo "</table>";
            echo "<div class='pagination'>";
            echo "<a href='myteam.php?offset=0'>First</a>";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong style='color:red'>$i</strong></a>";
                } else {
                    echo "<a href='myteam.php?offset=" . $off . "'>" . $i . "</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='myteam.php?offset=" . $lastOffset . "'>Last</a><br><br>";
            echo "</div>";
        }
        ?>
    <?php else: ?>
        <p>You have no approved teams.</p>
    <?php endif; ?>
</body>
</html>
