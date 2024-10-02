<?php
    require_once 'classevent.php';

    $event = new Event();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($name, $date, $description)) {
            $arr_col = [
                'name' => $name,
                'date' => $date,
                'description' => $description
            ];

            $last_id = $event->insertEvent($arr_col);

            if ($last_id) {
                header("Location: esport_event.php?result=success");
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