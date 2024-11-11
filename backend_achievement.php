<?php
    require_once("classachievement.php");

    $achievement = new Achievement();
   	$selected_team = $_POST["idteam"];

    $achievement = $achievement->getAchievementByTeam($selected_team);

    if ($achievement->num_rows > 0) {
        echo "<table border='1' id='eventTable'>";
        echo "<tr>
            <th>Name</th>
            <th>Description</th> 
            <th>Date</th>
            <th>Team</th>";
        echo "</tr>";
        

        while($row = $achievement->fetch_assoc()) {
            $formattgl = strftime("%d %B %Y", strtotime($row['date']));
            echo "<tr>
                <td>".$row['name']."</td>
                <td>".$row['description']."</td>
                <td>".$formattgl."</td>
                <td>".$row['namateam']."</td>";
            }
            echo "</tr>";
        }

        echo "</table>";

?>