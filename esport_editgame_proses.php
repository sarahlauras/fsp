<?php
    $mysqli = new mysqli("localhost", "root","","esport");
    if($mysqli -> connect_errno) {
        echo "Koneksi database gagal: " . $mysqli->connect_error;
        exit();
    }
    if($_POST['btnSubmit']) { 
        extract($_POST);

        $stmt = $mysqli->prepare(
            "UPDATE game SET name=?, description=?
            WHERE idgame=?");
        $stmt->bind_param("ssi", $name, $description, $idgame);
        $stmt->execute();

        $jumlah = $stmt->affected_rows;
        $stmt->close();
    }

    $mysqli->close();
    header("Location:esport_editgame.php?idgame=$idgame&result=success");
?>