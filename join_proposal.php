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
        echo "<a class='btnPagination' href='home.php'>Back</a>";
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
                <th>Action</th>
            </tr>";
        echo "</thead>";
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                        <td><span class='label'>Member: </span>". $row['fname'] . "</td>
                        <td><span class='label'>Team: </span>" . $row['name'] . "</td>
                        <td><span class='label'>Description:</span>" . $row['description'] . "</td>
                        <td><span class='label'>Status: </span>" . $row['status'] . "</td>
                        <td><span class='label'>Action: </span>
                        <div class='action'>
                            <a href='editjoin_proposal.php?idjoin_proposal=" . $row['idjoin_proposal'] . "'>Change</a>
                            <a href='deletejoin_proposal.php?idjoin_proposal=" . $row['idjoin_proposal'] . "'onclick='return confirm(\"Are you sure you want to delete?\");'>Delete</a>
                        </div>
                        </td>
                    <tr>";
            } 
        }
        else {
            echo "<thead>";
            echo "
            <tr>
                <th>Member</th>
                <th>Team</th>
                <th>Description</th>
                <th>Status</th>
            </tr>";
            echo "</thead>";
            while ($row = $res->fetch_assoc()) {
                echo "<tr>
                    <td><span class='label'>Member: </span>". $row['fname'] . "</td>
                        <td><span class='label'>Team: </span>" . $row['name'] . "</td>
                        <td><span class='label'>Description:</span>" . $row['description'] . "</td>
                        <td><span class='label'>Status: </span>" . $row['status'] . "</td>
                    <tr>";
            }
        }
        echo "</table>";

        echo "<div class='pagination'>";
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
        echo "<a href='insertjoin_proposal.php'>Ajukan Join Proposal</a>";
        echo "</div>";
        ?>
    </div>
    
</body>

</html>