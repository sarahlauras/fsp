<?php
    require_once 'classmember.php';

    $member = new Member();

    if(isset($_GET['idmember'])) {
        $idmember = $_GET['idmember'];
        $jumlah = $member->deleteMember($idmember);

        if ($jumlah > 0) {
            header("Location: member.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus member. Mungkin member tidak ditemukan.";
        }
    } else {
            echo "ID member tidak ditemukan.";
    }
    
?>
