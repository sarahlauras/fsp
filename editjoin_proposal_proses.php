<?php
    // Koneksi ke database
    $mysqli = new mysqli("localhost", "root", "", "esport");
    if($mysqli->connect_errno){
        echo "Koneksi database gagal: ".$mysqli->connect_error;
        exit();
    }

    if(isset($_POST['btnSubmit'])){
        // Ambil data dari form
        $member = $_POST['idmember'];
        $team = $_POST['idteam'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $id = $_POST['idjoin_proposal'];

        // Prepare query update
        $stmt = $mysqli->prepare(
            "UPDATE join_proposal SET idmember=?, idteam=?, description=?, status=? WHERE idjoin_proposal=?"
        );

        // Cek apakah prepare() berhasil
        if($stmt === false) {
            echo "Error: " . $mysqli->error;
            exit();
        }

        // Bind parameter dan eksekusi query
        $stmt->bind_param("iissi", $member, $team, $description, $status, $id);
        $stmt->execute();

        // Tutup statement
        $stmt->close();

        // Redirect setelah sukses
        header("Location: editjoin_proposal.php?idjoin_proposal=$id&result=success");
        exit();
    }

    // Tutup koneksi
    $mysqli->close();
?>