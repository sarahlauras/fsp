<?php
    require_once 'classmember.php';
    $member = new Member();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($fname, $lname, $username, $password, $profile, $idmember)) {
            $jumlah = $member->editMember($fname, $lname, $username, $password,$profile, $idmember);

            if ($jumlah > 0) {
                header("Location: editmember.php?idmember=$idmember&result=success");
                exit();
            } else {
                echo "Tidak ada perubahan yang dilakukan.";
            }
        } else {
            echo "Semua field harus diisi."; 
        }
    }  
    
    else {
        echo "Tidak ada data";
    }
?>