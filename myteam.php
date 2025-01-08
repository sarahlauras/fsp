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
        <form method="GET" action="">
            <label for="team">Choose Team: </label>
            <select name="team" id="team" onchange="this.form.submit()">
                <option value="" disabled selected>Choose Team</option>
                <?php while($team = $approvedTeams->fetch_assoc()): ?>
                    <option value="<?= $team['idteam'] ?>" <?= (isset($_GET['team']) && $_GET['team'] == $team['idteam']) ? 'selected' : '' ?>>
                        <?= $team['name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </form>

        <?php
        if (isset($_GET['team'])) {
            $idteam = $_GET['team'];
            $totaldata = 0;
            $perhalaman = 4;       
            $currenthalaman = 1;

            // Offset untuk pagination
            if (isset($_GET['offset'])) {
                $offset = $_GET['offset'];
                $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
            } else {
                $offset = 0;
            }

            // Ambil total data anggota tim
            $totaldata = $teamMember->getTotalDataByTeam($idteam);
            $teamMembers = $teamMember->getTeamMembersByTeam($idteam, $offset, $perhalaman);

            $jumlahhalaman = ceil($totaldata / $perhalaman);

            echo "<table border='1'>";
            echo "<thead>";
            echo "<tr><th>Name</th></tr>";
            echo "</thead>";

            // Menampilkan anggota tim
            while ($member = $teamMembers->fetch_assoc()) {
                $sedangLogin = "";
                if ($member['idmember'] == $idmember) {
                    $sedangLogin = " (saya)";
                }
                echo "<tr><td>" . $member['fname'] . $sedangLogin . "</td></tr>";
            }

            echo "</table>";

            // Pagination
            echo "<div class='pagination'>";
            echo "<a href='myteam.php?offset=0&team=" . $_GET['team'] . "'>First</a>";

            for ($i = 1; $i <= $jumlahhalaman; $i++) {
                $off = ($i - 1) * $perhalaman;
                if ($currenthalaman == $i) {
                    echo "<strong style='color:red'>$i</strong>";
                } else {
                    echo "<a href='myteam.php?offset=" . $off . "&team=" . $_GET['team'] . "'>" . $i . "</a> ";
                }
            }
            $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
            echo "<a href='myteam.php?offset=" . $lastOffset . "&team=" . $_GET['team'] . "'>Last</a><br><br>";
            echo "</div>";
        }
        ?>
    <?php else: ?>
        <p>You have no approved teams.</p>
    <?php endif; ?>
</body>
</html>
