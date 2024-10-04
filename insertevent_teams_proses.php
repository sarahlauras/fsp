<?php
    require_once 'classevent_teams.php';

    $event_teams = new EventTeams();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($idevent, $idteam)) {
            $arr_col = [
                'idevent' => $idevent,
                'idteam' => $idteam
            ];
            var_dump($arr_col);

            $result = $event_teams->insertEventTeams($arr_col);

            if ($result['success']) {
                header("Location:eventteams.php?result=success");
                exit();
            }
            else {
                echo "Error: Data tidak berhasil dimasukkan.";
            }
        }
    }
     
    else {
        echo "Tidak ada data";
    }
    
?>