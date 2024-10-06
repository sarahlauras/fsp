<?php
    require_once 'classjoinproposal.php';
    $joinproposal = new JoinProposal();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($idmember, $idteam, $description, $status, $idjoin_proposal)) {
            $jumlah = $joinproposal->editJoinProposal($idmember, $idteam, $description, $status,$idjoin_proposal);

            if ($jumlah > 0) {
                header("Location: editjoin_proposal.php?idjoin_proposal=$idjoin_proposal&result=success");
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