<html>
    <head>
        <body>
            <form action="registration_proses.php" method="post">

                <label>First Name</label>
                <input type="text" name="fname"><br><br>

                <label>Last Name</label>
                <input type="text" name="lname"><br><br>

                <label>Username </label>
                <input type="text" name="username"><br><br>

                <label>Password</label>
                <input type="password" name="password"><br><br>

                <label>Re-Password</label>
                <input type="password" name="repassword"><br><br>

                <label>Profile</label> 
                <select id="profile" name="profile">
                    <option value="admin">Admin</option>
                    <option value="member">Member</option>
                </select><br><br>

                <input type="submit" value="Submit" name="btnSubmit"><br><br>
            </form>
        </body>
    </head>
</html>