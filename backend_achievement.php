<?php
    require_once("classachievement.php");

    $offset = $_POST["offset"];
    $perhalaman = 4;
    $achievement = new Achievement();
    $userRole = $_POST["role"];

    if(isset($_POST["idmember"])) {
        $member_id = $_POST["idmember"];
    }
    else {
        $member_id = null;
    }

    if(isset($_POST["idteam"])) {
   	    $selected_team = $_POST["idteam"];
    }
    else {
        $selected_team = null;
    }

    if ($selected_team) {
        $achievement = $achievement->getAchievementByTeam($selected_team, $offset, $perhalaman);
    } else {
        if ($userRole == "admin") {
            $achievement = $achievement->getAchievement($offset, $perhalaman);
        } elseif ($userRole == "member") {
            $achievement = $achievement->getAchievementApprovedProposal($member_id, $offset, $perhalaman);
        }
    }
    
    if ($achievement->num_rows > 0) {
        echo "<table border='1' id='eventTable'>";
        echo "<tr>
            <th>Name</th>
            <th>Description</th> 
            <th>Date</th>
            <th>Team</th>";
            if($userRole == 'admin'){
                echo "<th>Aksi</th>";
            }
        echo "</tr>";

        while($row = $achievement->fetch_assoc()) {
            $formattgl = strftime("%d %B %Y", strtotime($row['date']));
            echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['description']."</td>
                <td>".$formattgl."</td>
                <td>".$row['namateam']."</td>";
                if ($userRole == 'admin') {
                    echo "<td>
                    <a href='editachievement.php?idachievement=".$row['idachievement']."'>Ubah</a> 
                    <a href='deleteachievement.php?idachievement=".$row['idachievement']."' onclick='return confirm(\"Apakah Anda yakin ingin menghapus Achievement ini?\");' >Hapus</a>
                    </td>";
                }
                echo "</tr>";
        }

        echo "</table>";
    }

?>