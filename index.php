<?php
    require_once("classteam.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #E6E6FA; 
            color: #4B0082; 
            margin: 0px auto;
            padding: 0;
            line-height: 1.6;
        }
        body h1 {
            text-align: center;
        }
        header {
            background-color: #8A2BE2;
            color: white;
            display: flex;
            align-items: center;
            padding: 15px;
        }
        header h1 {
            font-size: 32px;
            margin: 0;
            flex-grow: 1;
            text-align: left;
        }
        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin-left: 20px;
        }
        h1 {
            font-size: 32px;
            margin: 0;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
            background-color: #D8BFD8; 
            border-radius: 8px;
            overflow: hidden;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #9370DB;
        }

        th {
            background-color: #8A2BE2;
            color: white;
            font-weight: 600;
            text-align: center;
            padding: 12px;
        }

        tr:nth-child(even) {
            background-color: #DDA0DD; 
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        a.button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #8A2BE2;
            color: white;
            border-radius: 4px;
            margin-top: 10px;
            transition: background-color 0.3s ease;
        }

        a.button:hover {
            background-color: #6A5ACD;
        }
        
        /* .pagination a {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 5px;
            border: 1px solid #8A2BE2;
            color: #8A2BE2;
            border-radius: 4px;
            transition: background-color 0.3s, color 0.3s;
        }

        .pagination a:hover {
            background-color: #8A2BE2;
            color: white;
        }

        .pagination strong {
            color: #FF69B4; 
            padding: 8px 12px;
        } */
    </style>
</head>
<body>
    <header>
        <h1>Home</h1>
        <a href="login.php">Login</a>
        <a href="">Game Detail</a>
        <a href="">Team Detail</a>
    </header>
    <h1>Daftar Tim</h1>
    <?php 
        $team = new Team();
        $totaldata = 0;
        $perhalaman = 5;       
        $currenthalaman = 1;

        if(isset($_GET['offset'])) { 
            $offset = $_GET['offset']; 
            $currenthalaman = ($_GET['offset']/$perhalaman)+1;
        } else { $offset = 0; }

        $res = $team->getAllTeam($offset, $perhalaman);
        $totaldata = $team ->getTotalData();

        $jumlahhalaman = ceil($totaldata/$perhalaman);

        echo "<table border='1'>";
        echo "<tr>
        <th>Nama Tim</th>
        <th>Nama Game</th>
        </tr>";

        while($row = $res->fetch_assoc()) {
            echo "<tr>
            <td>".$row['name']."</td>
            <td>".$row['game']."</td>
            </tr>";
        }

        echo "</table>";
        echo "<a href='index.php?offset=0'>First</a>";

        for ($i = 1; $i <= $jumlahhalaman; $i++) {
            $off = ($i - 1) * $perhalaman;
            if ($currenthalaman == $i) {
                echo "<strong style='color:red'>$i</strong></a>";
            } else {
                echo "<a href='index.php?offset=" . $off . "'>" . $i . "</a> ";
            }
        }
        $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
        echo "<a href='index.php?offset=" . $lastOffset . "'>Last</a><br><br>";
        
    ?>
</body>
</html>