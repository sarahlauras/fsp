<?php
    require_once("classmember.php");

    if(isset($_POST['btnLogin'])){
        $member = new Member();
        if($member->doLogin($_POST["username"], $_POST["password"])){
            header("Location: home.php");
            exit();
        }else{
            header("Location: login.php?error=loginfailed");
            exit();
        }        
    }else{
        header("Location: login.php");
        exit();
    }
?>