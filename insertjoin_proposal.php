<?php
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
    <title>Insert Join Proposal</title>
</head>

<body>
    <?php
    require_once 'classjoinproposal.php';
    $joinproposal = new JoinProposal();

    if (isset($_GET["result"])) {
        if ($_GET["result"] == "success") {
            echo "Data berhasil ditambahkan.<br><br>";
        }
    }
    ?>
    <form action="insertjoin_proposal_proses.php" method="post" enctype='multipart/form-data'>
        <label for="member">Member:</label>
        <select name="member" id="member">
            <?php
            $resMember = $joinproposal->getMember();

            if ($role == 'member') {
                $idmember = $_SESSION["idmember"];
                $username = $_SESSION["username"];

                echo "<option value='" . $idmember . "'>" . $username . "</option>";
            }elseif ($role == 'admin') {
                while ($row = $resMember->fetch_assoc()) {
                    echo "<option value='" . $row['idmember'] . "'>" . $row['fname'] . "</option>";
                }
            }
            ?>
        </select><br><br>
        <label for="team">Team:</label>
        <select name="team" id="team">
            <?php
            $resTeam = $joinproposal->getTeam();

            while ($row = $resTeam->fetch_assoc()) {
                echo "<option value='" . $row['idteam'] . "'>" . $row['name'] . "</option>";
            }
            ?>
        </select><br><br>
        <label for="description">Description :</label>
        <input type="text" id="description" name="description"><br><br>

        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>

</html>