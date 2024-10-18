<?php
    require_once ("classevent.php");
    require_once ("classteam.php");

    $event = new Event();
    $team = new Team();

    echo "<a href='eventteams.php'>Back</a>";
?>

<html>
    <head>
    <title>Event Teams</title>
    </head>
    <style>
         table, th, td {
                border: 1px solid #ddd;
                border-collapse: collapse;
        }

        table {
            width: 500px;
            border-collapse: collapse;
            margin: 20px 0;
            font-family: Arial, sans-serif;
            font-size: 16px;
            color: #333;
        }
        th {
                background-color: #0044cc; 
                color: #fff; 
                padding: 12px 15px;
                text-align: left;
                border-bottom: 2px solid #0033aa; 
            }

            td {
                background-color: #f9f9f9; 
                padding: 12px 15px;
                border-bottom: 1px solid #ddd; 
            }
    </style>
    <body>
        <form method="post" action="insertevent_teams_proses.php">
            <label for="event">Pilih Event dan Team</label>
            <?php
                $resEvent = $event->getAllEvent();
            ?>
            <select name="event" id="event">
                    <option value="">Pilih Event</option>
                    <?php
                        while($row = $resEvent->fetch_assoc()) {
                            echo "<option value=".$row['idevent'].">"
                                .$row['name']."</option>";
                        }
                    ?>
            </select>
            <?php
                $resTeam = $team->getAllTeam();
            ?>
            <select name="team" id="team">
                    <option value="">Pilih Team</option>
                    <?php
                        while($row = $resTeam->fetch_assoc()) {
                            echo "<option value=".$row['idteam'].">"
                                .$row['name']."</option>";
                        }
                    ?>
            </select>

            <button name="btnAddEventTeams" id="btnAddEventTeams" type="button">Tambah Event Teams</button><br><br>

            <table>
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Teams</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="eventTeamsTable">
                <tr><td colspan="3">Belum Ada Event Teams</td></tr>
            </tbody>
        </table>
        <input type="submit" value="Submit" name="btnSubmit">
        </form>
    </body>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
    integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
    crossorigin="anonymous"></script>
    <script>
        var jumlaheventteams = 0;
        $("#btnAddEventTeams").on("click", function() {
            var eventvalue = $('#event').val();
            var eventlabel = $('#event option:selected').text();
            var teamvalue = $('#team').val();
            var teamlabel = $('#team option:selected').text();

            // Memastikan pengguna memilih event dan team
            if (eventvalue == "" || teamvalue == "") {
                alert("Silakan pilih event dan team.");
                return;
            } else {
                var html = '<tr>';
                html += '<td><input type="hidden" name="idevent[]" value="' + eventvalue + '"/>' + eventlabel + '</td>';
                html += '<td><input type="hidden" name="idteam[]" value="' + teamvalue + '"/>' + teamlabel + '</td>';
                html += '<td><button type="button" class="removeeventteambtn">X</button></td>';
                html += '</tr>';
                if(jumlaheventteams == 0) {
                    $("tbody").html(html);
                } else {
                    $("tbody").append(html);
                }
                jumlaheventteams++;
                eventvalue = $('#event').val("");
                teamvalue = $('#team').val("");
            }
        });

        $("body").on("click", ".removeeventteambtn", function() {
            console.log("remove");
            jumlaheventteams--;
            $(this).parent().parent().remove();
            if(jumlaheventteams == 0) {
                $("tbody").html('<tr id="noEventTeams"><td colspan="3">Belum Ada Event Teams</td></tr>');
            }
        });

        //$(document).ready(function() {
        //    alert("ready");
        //});
    </script>
</html>