<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game Detail</title>
    <link rel="stylesheet" type="text/css" href="gamedetail.css">
</head>
<body>
    <a href="index.php">back</a>
    <h1>Game Details</h1>
    <?php       
    require_once 'classgame.php';
    $game = new Game();

    $totaldata = $game->getTotalData();
    $perhalaman = 4;
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;

    $resgames = $game->getAllGame($offset, $perhalaman);

    // Menampilkan data game
    echo "<div class='game-container'>";
    while ($gameRow = $resgames->fetch_assoc()) {
        echo "<div class='game-card'>";
        echo "<div class='game-card-content'>";
        echo "<h1>" . $gameRow['name'] . "</h1>";

        // Menampilkan daftar tim berdasarkan game
        echo "<p><strong>Teams:</strong></p>";
        $resteams = $game->gameDetailTeam($gameRow['name']);
        if ($resteams->num_rows > 0) {
            echo "<div class='team-list'>";
            while ($teamRow = $resteams->fetch_assoc()) {
                $teamId = $teamRow['idteam'];
                echo "<div class='team-card'>";
                echo "<img src='teams/" . $teamId . ".jpg' alt='" . $teamRow['name'] . " Poster'>";
                echo "<div class='team-info'>";
                echo "<h4>" . $teamRow['name'] . "</h4>";
                echo "</div>"; // penutup team-info
                echo "</div>"; // penutup team-card
            }
            echo "</div>"; // penutup team-list
        } else {
            echo "<p>No teams available.</p>";
        }

        // Menampilkan daftar event berdasarkan game
        echo "<p><strong>Events:</strong></p>";
        $resevents = $game->gameDetailEvent($gameRow['name']);
        if ($resevents->num_rows > 0) {
            $upcomEvent = [];
            $pastEvent = [];
            $currDate = new DateTime();

            while ($eventRow = $resevents->fetch_assoc()) {
                $eventDate = new DateTime($eventRow['date']);
                $eventInfo = "<li>" . $eventRow['name'] . " (" . $eventRow['date'] . ")</li>";
                if($eventDate >= $currDate){
                    $upcomEvent[] = $eventInfo;
                }
                else{
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
        echo "</div>"; // penutup game-card-content
        echo "</div>"; // penutup game-card
    }
    echo "</div>"; // penutup game-container
    echo"<br><br>";

    // Pagination
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
