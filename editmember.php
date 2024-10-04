<html>
    <head>
        <title>Edit Member</title>
</head>
<body>
    <?php

        require_once 'classmember.php';
        $member = new Member();
        
        if(isset($_GET["result"])) {
            if($_GET["result"] == "success") {
                echo "Data berhasil ditambahkan.<br><br>";
            }
        }

        $id = $_GET["idmember"];

        if (isset($_GET["idmember"])) {
            $id = $_GET["idmember"];

            $stmt = $member->getMemberById($id);

            if ($stmt && $stmt->num_rows > 0) {
                $row = $stmt->fetch_assoc(); 
            } else {
                echo "Member tidak ditemukan.";
            }
        } else {
            echo "ID member tidak ditemukan.";
        }

    ?>
    <form action="editmember_proses.php" method="post">
        <label for="fname">First Name: </label>
        <input  type="text" id="fname" name="fname" value="<?php echo $row["fname"]; ?>"><br><br>
        <label for="lname">Last Name: </label>
        <input  type="text" id="lname" name="lname" value="<?php echo $row["lname"]; ?>"><br><br>
        <label for="username">Username: </label>
        <input type="username" name="username" value="<?php echo $row["username"]; ?>"><br><br>
        <label for="password">Password: </label>
        <input type="password" name="password" value="<?php echo $row["password"]; ?>"><br><br>
        <label>Profile</label>
        <select id="profile" name="profile">
            <option value="admin" <?php if($row['profile'] == "admin") echo 'selected'; ?>>Admin</option>
            <option value="member" <?php if($row['profile'] == "member") echo 'selected'; ?>>Member</option>
        </select><br><br>
        
        <input type="hidden" name="idmember" value="<?php echo $row["idmember"];?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>