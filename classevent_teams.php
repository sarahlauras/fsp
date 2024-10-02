<?php
    require_once ("dbparent.php");

    class Pemain extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function getEvent($idevent) {
            //query pemain
            $stmt = $this->mysqli->prepare("SELECT et.idevent, e.name AS event_name, e.date AS event_date, t.name AS team_name
                                            FROM event_teams et INNER JOIN event e ON et.idevent = e.idevent
                                            INNER JOIN team t ON et.idteam = t.idteam WHERE et.idevent = ?;");
            $stmt->bind_param("i", $idevent);
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }
    }
?>