<html>
    <head>
        <body>
            <form action="registration_proses.php" method="post">
                <label>Member ID</label>
                <input type="text" name="idmember"><br><br>

                <label>First Name</label>
                <input type="text" name="fname"><br><br>

                <label>Last Name</label>
                <input type="text" name="lname"><br><br>

                <label>Username </label>
                <input type="text" name="username"><br><br>

                <label>Password</label>
                <input type="text" name="password"><br><br>

                <label>Re-Password</label>
                <input type="text" name="repassword"><br><br>

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