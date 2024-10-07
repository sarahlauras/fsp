<?php
    require_once 'classachievement.php';

    $achievement = new Achievement();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($name, $description, $date, $idTeam)) {
            $arr_col = [
                'name' => $name,
                'description' => $description,
                'date' => $date,
                'team' => $idTeam
            ];

            $last_id = $achievement->insertAchievement($arr_col);

            if ($last_id) {
                header("Location: achievement.php?result=success");
                exit();
            }
            else {
                echo "Error!!";
            }
        }
    }   
    else {
        echo "Tidak ada data!!";
    }
    
?>