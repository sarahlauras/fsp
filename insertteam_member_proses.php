<?php
    require_once 'classteammember.php';
    $team_member = new TeamMember();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($team, $member, $description)) {
            $arr_col = [
                'idteam' => $team,
                'idmember' => $member,
                'description' => $description
                ];
            $last_id = $team_member->insertTeamMember($arr_col);
            if ($last_id) {
                header("Location: insertteam_member.php?result=success");
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