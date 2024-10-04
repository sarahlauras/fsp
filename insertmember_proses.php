<?php
    require_once 'classmember.php';
    $member = new Member();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($fname, $lname, $username, $password, $repassword, $profile)) {
            $arr_col = [
                'fname' => $fname,
                'lname' => $lname,
                'username' => $username,
                'password' => $password,
                'repassword' => $repassword,
                'profile' => $profile
                ];
            $last_id = $member->insertMember($arr_col);
            if ($last_id) {
                header("Location: member.php?result=success");
                exit();
            }
            else {
                echo "Error";
            }
        }
    }   
    else {
        echo "Tidak ada data";
    }
?>