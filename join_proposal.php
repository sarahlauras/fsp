<?php
require_once("classjoinproposal.php");
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["profile"];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Proposal</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
    <h1>DAFTAR JOIN PROPOSAL</h1>
    <div id="kanan">
        <?php
        echo "<a href='home.php'>Back</a>";
        $joinproposal = new JoinProposal();
        $totaldata = 0;
        $perhalaman = 4;
        $currenthalaman = 1;

        if (isset($_GET['offset'])) {
            $offset = $_GET['offset'];
            $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
        } else {
            $offset = 0;
        }


        if ($role == "admin") {
            $res = $joinproposal->getJoinProposal(null, null, $offset, $perhalaman);
            $totaldata = $joinproposal->getTotalData();
        } else {
            $username = $_SESSION["username"];
            $res = $joinproposal->getJoinProposal($username, null, $offset, $perhalaman);
            $totaldata = $joinproposal->getTotalData($username);
        }
        $jumlahhalaman = ceil($totaldata / $perhalaman);

        echo "<table border = '1'>";
        echo "<thead>";
        if($role == "admin") {
            echo "
            <tr>
                <th>Member</th>
                <th>Team</th>
                <th>Description</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>";
        echo "</thead>";
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td data-label='Member'>" . $row['fname'] . "</td>
                        <td data-label='Team'>" . $row['name'] . "</td>
                        <td data-label='Description'>" . $row['description'] . "</td>
                        <td data-label='Status'>" . $row['status'] . "</td>
                        <td data-label='Aksi'>
                            <a href='editjoin_proposal.php?idjoin_proposal=" . $row['idjoin_proposal'] . "'>Ubah</a>
                            <a href='deletejoin_proposal.php?idjoin_proposal=" . $row['idjoin_proposal'] . "'onclick='return confirm(\"Apakah Anda yakin ingin menghapus Join Proposal ini?\");'>Hapus</a>
                        </td>
                    <tr>";
            } 
        }
        else {
            echo "
            <tr>
                <th>Member</th>
                <th>Team</th>
                <th>Description</th>
                <th>Status</th>
            </tr>";
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td>" . $row['fname'] . "</td>
                    <td>" . $row['name'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['status'] . "</td>
                    <tr>";
            }
        }
        echo "</table>";


        //echo "<div>Total Data: " . $totaldata . "</div>";
        echo "<a href='join_proposal.php?offset=0'>First</a>";

        for ($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i - 1) * $perhalaman;
            if ($currenthalaman == $i) {
                echo "<strong style='color:red'>$i</strong></a>";
            } else {
                echo "<a href='join_proposal.php?offset=" . $off . "'>" . $i . "</a> ";
            }
        }
        $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
        echo "<a href='join_proposal.php?offset=" . $lastOffset . "'>Last</a><br><br>";
        ?>
    </div>
    <a href="insertjoin_proposal.php">Ajukan Join Proposal</a>
</body>

</html>