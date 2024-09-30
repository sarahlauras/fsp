<?php
    require_once("classmember.php");

    if(isset($_POST['btnSubmit'])) {
        if($_POST['password'] == $_POST['repassword']) {
            $member = new Member();
            $member->insertMember($_POST);
            header("Location: login.php");
            exit();
        } else {
            header("Location: registration.php?error=password");
            exit();
        }
    } else {
        header("Location: registration.php");
        exit();
    }
?>