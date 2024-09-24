<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Join Proposal Proses</title>
</head>
<body>
    <?php
        //copas koneksi db
        $mysqli = new mysqli("localhost", "root", "", "esport");
        if($mysqli->connect_errno){ //kalau ada nilai selain 0, maka ada KEGAGALAN KONEKSI
            echo "Koneksi database gagal: ".$mysqli->connect_error;
            exit();
        }
        // Ambil nilai dari form
        $idmember = $_POST['member'];
        $idteam = $_POST['team'];
        $description = $_POST['description'];

        //BACA DARI DOLLAR POST
        if(isset($_POST['btnSubmit'])){
            extract($_POST); //auto membuat variable dengan nilai" yang sama

            $stmt = $mysqli->prepare("INSERT INTO join_proposal(idmember, idteam, description, status) VALUES(?,?,?, 'waiting')");
            $stmt->bind_param("iis", $idmember, $idteam, $description); //harus sama persis sama di form
            $stmt->execute();
            $jumlah = $stmt->affected_rows; //jumlah data yang kena dampak, affected_rows adalah properti
            $last_id = $stmt->insert_id; //karna id auto increment

            $stmt->close();

            if ($stmt->affected_rows > 0) {
                // Berhasil disimpan
                header("Location: insertjoin_proposal.php?result=success");
            } else {
                echo "Gagal menyimpan data.";
            }
        }
        //TUTUP KONEKSI 
        $mysqli->close();
        //setelah semua ter-run, form auto memindahkan user ke halalman insertmovie.php
        header("Location: insertjoin_proposal.php?result=success");     
    ?>
</body>
</html>