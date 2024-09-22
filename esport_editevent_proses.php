<?php
    $mysqli = new mysqli("localhost", "root","","esport");
    if($mysqli -> connect_errno) {
        echo "Koneksi database gagal: " . $mysqli->connect_error;
        exit();
    }
    if($_POST['btnSubmit']) { 
        extract($_POST);

        $stmt = $mysqli->prepare(
            "UPDATE event SET name=?, date=?, description=?
            WHERE idevent=?");
        $stmt->bind_param("sssi", $name, $date, $description, $idevent);
        $stmt->execute();

        $jumlah = $stmt->affected_rows;
        $stmt->close();
    }

    $mysqli->close();
    header("Location:esport_event.php?idevent=$idevent&result=success");
?>