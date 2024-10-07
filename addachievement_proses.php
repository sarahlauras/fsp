<?php

    require_once 'classachievement.php';

    $achievement = new Achievement();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($name, $idteam, $date, $description)) {
            $arr_col = [
                'name' => $name,
                'idteam' => $idteam,
                'date' => $date,
                'description' => $description,
            ];

            $last_id = $achievement->insertAchievement($arr_col);

            if ($last_id) {
                header("Location: achievement.php?result=success");
                exit();
            }
            else {
                echo "tetot";
            }
        }
    }   
    else {
        echo "Tidak ada data!!";
    }
    
?>