<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Detail</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php
    require_once 'classteam.php';

    $team = new Team();

    $totaldata = $team->getTotalData();
    $perhalaman = 4;
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

    $resteams = $team->getAllTeam($offset, $perhalaman);

    // Menampilkan data Team
    echo "<div class='team-container'>";
    while ($teamRow = $resteams->fetch_assoc()) {
        echo "<div class='team-card'>";
        echo "<div class='team-card-content'>";
        echo "<h1>" . $teamRow['name'] . "</h1>";

        // Menampilkan daftar member berdasarkan team
        echo "<p><strong>Members:</strong></p>";
        $resmembers = $team->memberDetailTeam($teamRow['name']);
        if ($resmembers->num_rows > 0) {
            echo "<ul>";
            while ($membersRow = $resmembers->fetch_assoc()) {
                echo "<li>" . $membersRow['fname'] . " " . $membersRow['lname'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No members available.</p>";
        }

        // Menampilkan daftar achievement berdasarkan team
        echo "<p><strong>Achievement:</strong></p>";
        $resachievement = $team->teamDetailAchievement($teamRow['name']);
        if ($resachievement->num_rows > 0) {
            echo "<ul>";
            while ($achievementRow = $resachievement->fetch_assoc()) {
                echo "<li>" . $achievementRow['name'] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No achievements available.</p>";
        }

        // Menampilkan daftar event berdasarkan team
        echo "<p><strong>Events:</strong></p>";
        $resevents = $team->teamDetailEvent($teamRow['name']);
        if ($resevents->num_rows > 0) {
            $upcomEvent = [];
            $pastEvent = [];
            $currDate = new DateTime();

            while ($eventRow = $resevents->fetch_assoc()) {
                $eventDate = new DateTime($eventRow['date']);
                $eventInfo = "<li>" . $eventRow['name'] . " (" . $eventRow['date'] . ")</li>";
                if ($eventDate >= $currDate) {
                    $upcomEvent[] = $eventInfo;
                } else {
                    $pastEvent[] = $eventInfo;
                }
            }

            if (!empty($upcomEvent)) {
                echo "<p><strong>Upcoming Events:</strong></p><ul>" . implode('', $upcomEvent) . "</ul>";
            } else {
                echo "<p>No upcoming events.</p>";
            }

            if (!empty($pastEvent)) {
                echo "<p><strong>Past Events:</strong></p><ul>" . implode('', $pastEvent) . "</ul>";
            } else {
                echo "<p>No past events.</p>";
            }
        } else {
            echo "<p>No events available.</p>";
        }
        echo "</div>"; // Penutup team-card-content
        echo "</div>"; // Penutup team-card
    }
    echo "</div>"; // Penutup team-container

    // Pagination di bagian bawah
    $jumlahhalaman = ceil($totaldata / $perhalaman);
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $jumlahhalaman; $i++) {
        $offsetValue = ($i - 1) * $perhalaman;
        echo "<a href='?offset=$offsetValue'>Page $i</a> ";
    }
    echo "</div>";
?>
</body>
</html>
