<?php
    require_once("classachievement.php");
    session_start();
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        exit();
    }

    $role = $_SESSION["profile"];
    $member = $_SESSION["idmember"]; 
?>
<html>
    <head>
        <title>Achievement</title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <h1>Achievement</h1>
            <?php
                echo "<a href='home.php'>Back</a>";
                echo "<br>";
                $achievement = new Achievement();
                $totaldata = 0;
                $perhalaman = 4;       
                $currenthalaman = 1;

                if (isset($_GET['offset'])) { 
                    $offset = $_GET['offset']; 
                    $currenthalaman = ($_GET['offset'] / $perhalaman) + 1;
                } else { 
                    $offset = 0; 
                }
                
                // if ($role == 'admin') {
                //     $res = $achievement->getAchievement($offset, $perhalaman);
                //     $totaldata = $achievement->getTotalData();
                // } else {
                //     $res = $achievement->getAchievement($offset, $perhalaman, $member);
                //     $totaldata = $achievement->getTotalData($member);
                // }
                if($role == 'member') {
                    $res = $achievement->getUserTeams($member);
                }
                else {
                    $res = $achievement->getTeam($offset, $perhalaman);
                    $totaldata = $achievement->getTotalData();
                }
                
                echo "<label for='team'>Pilih Team: </label>";
                echo "<select name='team' id='team'>";
                echo "<option value='' disabled selected>Pilih Team</option>";
                while($row = $res->fetch_assoc()) {
                    echo "<option value=".$row['idteam'].">"
                    .$row['name']."</option>";
                }
                echo "</select>";
                echo "<input type='button' id='btnsubmit' value='Pilih'/>";

                echo "<div id='eventData'></div>";
            ?>

                <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
                    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
                    crossorigin="anonymous"></script>

                <script>
                    var userRole = "<?php echo $role; ?>";
                    var member_id = "<?php echo $member; ?>";
                    var perPage = 4;
                    var currentPage = 1;
                    function loadAll(offset = 0) {
                        currentPage = (offset / perPage) + 1;
                        $.post('backend_achievement.php', {role:userRole, idmember:member_id, offset:offset, limit:perPage})
                        .done(function(data) {
                                $('#eventData').html(data)
                        });
                    }

                    $(document).ready(function() {
                        loadAll();

                        $('#btnsubmit').click(function(){
                            var selected_team = $('#team').val()
                            if(selected_team) {
                            $.post('backend_achievement.php', {idteam: selected_team, role:userRole, idmember:member_id, offset:(currentPage - 1)* perPage, limit: perPage})
                            .done(function(data) {
                                $('#eventData').html(data)
                            })
                        } else {
                            alert('Pilih team dulu')
                        }
                        });
                    });
                </script>

                <?php
                
                // Paging
                $jumlahhalaman = ceil($totaldata / $perhalaman);
                echo "<div>Total Data: ".$totaldata."</div>";
                echo "<a href='achievement.php?offset=0'>First</a>";
                
                for ($i = 1; $i <= $jumlahhalaman; $i++) {
                    $off = ($i - 1) * $perhalaman;
                    if ($currenthalaman == $i) {                
                        echo "<strong style='color:red'>$i</strong>";
                    } else {
                        echo "<a href='achievement.php?offset=".$off."'>".$i."</a> ";
                    }
                }

                $lastOffset = ($jumlahhalaman - 1) * $perhalaman;
                echo "<a href='achievement.php?offset=".$lastOffset."'>Last</a><br><br>";

                if ($role == 'admin') {
                    echo "<a href='addachievement.php?'>Insert Achievement</a>";
                }
            ?>
            <br>
            <br>
            <!-- <button type="button" id="loadmore">Load More</button>
            </div>  -->
    </body>
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <script>
        var offset = 0;
        var perhalaman = 4;

        $('body').on("click", "#loadmore", function() {
            offset += perhalaman;
            $.post("backend_achievement", {offset:offset}, function(data) {
                $('#eventData').html(data)
            });
        });
    </script> -->
</html>
