<?php
    require_once 'classmember.php';
    $member = new Member();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($fname, $lname, $username, $profile)) {
            $jumlah = $member->editMember($fname, $lname, $username, $profile);

            if ($jumlah > 0) {
                header("Location: editmember.php?result=success");
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