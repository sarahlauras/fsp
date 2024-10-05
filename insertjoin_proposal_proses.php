<?php
    require_once 'classjoinproposal.php';
    $joinproposal = new JoinProposal();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($member, $team, $description)) {
            $arr_col = [
                'idmember' => $member,
                'idteam' => $team,
                'description' => $description
                ];
            $last_id = $joinproposal->insertJoinProposal($arr_col);
            if ($last_id) {
                header("Location: insertjoin_proposal.php?result=success");
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