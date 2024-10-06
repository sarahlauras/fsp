<?php
    require_once 'classjoinproposal.php';
    $joinproposal = new JoinProposal();

    if($_POST['btnSubmit']) { 
        extract($_POST);
        if (isset($fname, $name, $description, $idjoin_proposal)) {
            $jumlah = $joinproposal->editJoinProposal($fname, $name, $description, $idjoin_proposal);

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