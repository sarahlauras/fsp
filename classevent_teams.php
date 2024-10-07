<?php
    require_once ("dbparent.php");

    class EventTeams extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function getAllEventTeams() { //tampil
            $stmt = $this->mysqli->prepare("SELECT et.idevent, e.name AS event_name, e.date AS event_date, t.name AS team_name,g.name AS game_name
                                            FROM event_teams et INNER JOIN event e ON et.idevent = e.idevent INNER JOIN team t 
                                            ON et.idteam = t.idteam
                                            INNER JOIN game g ON t.idgame = g.idgame;");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }


        public function getEventTeamById($idevent) {
            $stmt = $this->mysqli->prepare("SELECT * FROM event_teams WHERE idevent = ?");
            $stmt->bind_param("i", $idevent);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function insertEventTeams($arr_col) { //insert
            $idevent = $arr_col['idevent'];
            $idteam = $arr_col['idteam'];
            $last_insert_id = null;
            $success = false;
            for ($i = 0; $i < count($idevent); $i++) {
                $stmt = $this->mysqli->prepare("INSERT INTO event_teams(idevent, idteam) VALUES(?, ?)");
                $stmt->bind_param("ii", $idevent[$i], $idteam[$i]);
                if ($stmt->execute()) {
                    $last_insert_id = $this->mysqli->insert_id;
                    $success = true;
                } else {
                    $success = false;
                    echo "Error: " . $stmt->error; 
                }
                $stmt->close();
            }
            return ['success' => $success, 'last_id' => $last_insert_id];
        }

        public function editEvent($idevent, $idteam) {
            $stmt = $this->mysqli->prepare(
                "UPDATE event_teams SET idevent=?, idteam=?
                WHERE idevent=?");
            $stmt->bind_param("iii", $idevent, $idteam, $description, $idevent);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
    }
?>