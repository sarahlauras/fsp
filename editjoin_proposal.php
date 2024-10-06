<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Join Proposal</title>
</head>
<body>
    <?php
        require_once 'classjoinproposal.php';
        $joinproposal = new JoinProposal();

        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }
        $id = $_GET["idjoin_proposal"];

        if (isset($_GET["idjoin_proposal"])) {
            $id = $_GET["idjoin_proposal"];

            $stmt = $joinproposal->getJoinProposal($id);

            if ($stmt && $stmt->num_rows > 0) {
                $row = $stmt->fetch_assoc(); 
            } else {
                echo "Member tidak ditemukan.";
            }
        } else {
            echo "ID member tidak ditemukan.";
        }

    ?>
    <form action="editjoin_proposal_proses.php" method="post" enctype='multipart/form-data'>
        <label for="member">Member:</label>
        <select name="idmember" id="member" value="<?php echo $row["fname"]; ?>"></select><br><br>
        <label for="team">Team:</label>
        <select name="idteam" id="team" value="<?php echo $row["name"]; ?>"></select><br><br>
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
