<html>

<head>
    <title>Insert Member</title>
</head>

<body>
    <?php
    require_once 'classmember.php';
    $member = new Member();

    if (isset($_GET["result"])) {
        if ($_GET["result"] == "success") {
            echo "Data berhasil ditambahkan.<br><br>";
        }
    }

    ?>
    <form action="insertmember_proses.php" method="post">
        <label for="name">First Name: </label>
        <input type="text" id="fname" name="fname"><br><br>
        <label for="lname">Last Name: </label>
        <input type="text" id="lname" name="lname"><br><br>
        <label for="username">Username: </label>
        <input type="text" id="username" name="username"><br><br>
        <label for="password">Password: </label>
        <input type="text" id="password" name="password"><br><br>
        <label>Re-Password</label>
        <input type="text" name="repassword"><br><br>

        <label>Profile</label>
        <select id="profile" name="profile">
            <option value="admin">Admin</option>
            <option value="member">Member</option>
        </select><br><br>
        <input type="hidden" name="idevent" value="<?php echo $row["idevent"]; ?>">
        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>

</html>