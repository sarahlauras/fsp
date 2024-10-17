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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="stylehome.css">
</head>

<body>
    <div>Wellcome to</div>
    <p data-item='Esport'>Esport</p>
    <section>
        <div>by Kelompok PASLON</div>
        <nav>
            <ul class="menuItems">
                <?php if ($role === 'admin'): ?>
                    <li><a href='member.php' data-item='Member'>Member</a></li>
                    <li><a href='team.php' data-item='Team'>Team</a></li>
                    <li><a href='team_member.php' data-item='Team Members'>Team Members</a></li>
                    <li><a href='esport_event.php' data-item='Event'>Event</a></li>
                    <li><a href='eventteams.php' data-item='Event Teams'>Event Teams</a></li>
                    <li><a href='esport_game' data-item='Game'>Game</a></li>
                <?php endif; ?>

                <li><a href='join_proposal.php' data-item='Join Proposal'>Join Proposal</a></li>
                <li><a href='achievement.php' data-item='Achievement'>Achievement</a></li>
                <li><a href='esport_event.php' data-item='Event'>Event</a></li>
            </ul>
        </nav>
    </section>
    <footer>
        <div class="footer-copyright text-center">&copy; Developed with ❤️</i> by
            <a href="https://grohit.com/" class="white-text" target="_blank">G Rohit</a>. <a
                href="https://codepen.io/grohit/" target="_blank">Check my other pens </a>
        </div>

    </footer>
</body>

</html>