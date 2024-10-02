<?php
    require_once ("dbparent.php");

    class Team extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function insertTeam($arr_col) { //insert
            $sql = "INSERT INTO team (idgame, name)
            VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("is", $arr_col['idgame'], $arr_col['name']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getAllTeam() { //tampil
            $stmt = $this->mysqli->prepare("SELECT t.idteam, t.name, g.name as game FROM team t INNER JOIN game g ON t.idgame = g.idgame");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getEventById($idteam) {
            $stmt = $this->mysqli->prepare("SELECT * FROM team WHERE idteam=?");
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            return $stmt->get_result(); // Mengembalikan hasil untuk di-fetch
        }

        public function getGames() {
            $stmt = $this->mysqli->prepare("SELECT * FROM game");
            $stmt->execute();
            return $stmt->get_result(); // Mengembalikan hasil query
        }

        public function editEvent($name, $game, $idteam) {
            $stmt = $this->mysqli->prepare(
                "UPDATE team SET name=?, idgame=? WHERE idteam=?");
            $stmt->bind_param("sii", $name, $game, $idteam);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }

        public function deleteTeam($idteam) {
            $stmt = $this->mysqli->prepare("DELETE FROM team WHERE idteam = ?");
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
    }
?>