<?php
    require_once 'classjoinproposal.php';

    $joinproposal = new JoinProposal();

    if(isset($_GET['idjoin_proposal'])) {
        $idjoin_proposal = $_GET['idjoin_proposal'];
        $jumlah = $joinproposal->deleteJoinProposal($idjoin_proposal);

        if ($jumlah > 0) {
            header("Location: join_proposal.php?result=success");
            exit();
        } else {
            echo "Gagal menghapus join proposal. Mungkin join proposal tidak ditemukan.";
        }
    } else {
            echo "ID join proposal tidak ditemukan.";
    }
?>