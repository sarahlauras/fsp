<?php
    require_once 'classgame.php';

    $game = new Game();
    if(isset($_POST['btnSubmit'])) { 
        extract($_POST);
        if (isset($name, $description)) {
            $arr_col = [
                'name' => $name,
                'description' => $description
            ];

            $last_id = $game->insertGame($arr_col);

            if ($last_id) {
                header("Location: esport_game.php?result=success");
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