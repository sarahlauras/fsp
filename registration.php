<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" type="text/css" href="loginregis.css"> 
</head>
<body>
    <form action="registration_proses.php" method="post">

        <label>First Name</label>
        <input type="text" name="fname" required>

        <label>Last Name</label>
        <input type="text" name="lname" required>

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label>Re-Password</label>
        <input type="password" name="repassword" required>

        <input type="submit" value="Submit" name="btnSubmit">
    </form>
</body>
</html>
