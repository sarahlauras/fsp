<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION["profile"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Esport</title>
    <link rel="stylesheet" type="text/css" href="stylehomenew.css">
</head>

<body>
    <div class="welcome-text">Welcome to <span class="bold">Esport</span></div>
    <div class="subtitle">by Kelompok PASLON</div>
    <nav>
        <ul class="menuItems">
            <li><a href='join_proposal.php'>Join Proposal</a></li>
            <li><a href='achievement.php'>Achievement</a></li>
            <li><a href='esport_event.php'>Event</a></li>

            <?php 
                if ($role !== 'admin'): ?>
                <li><a href='myteam.php'>My Team</a></li>
            <?php endif; ?>

            <?php 
                if ($role === 'admin'): ?>
                <li><a href='member.php'>Member</a></li>
                <li><a href='team.php'>Team</a></li>
                <li><a href='team_member.php'>Team Members</a></li>
                <li><a href='eventteams.php'>Event Teams</a></li>
                <li><a href='esport_game.php'>Game</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <div>
        <a href="logout.php" class="logout-button">Logout</a>
    </div>
</body>

</html>
