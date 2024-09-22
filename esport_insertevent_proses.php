<?php
    $mysqli = new mysqli("localhost", "root","","esport");
    if($mysqli -> connect_errno) {
        echo "Koneksi database gagal: " . $mysqli->connect_error;
        exit();
    }
    if($_POST['btnSubmit']) { 
        extract($_POST);

        $stmt = $mysqli->prepare(
            "INSERT INTO event(name, date, description)
            VALUES(?,?,?)");
        $stmt->bind_param("sss", $name, $date, $description);
        $stmt->execute();

        $jumlah = $stmt->affected_rows;
        $last_id = $mysqli->insert_id;


        $stmt->close();
    }

    $mysqli->close();
    header("Location:esport_event.php?result=success");
?>