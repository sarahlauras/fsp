<?php
    require_once ("dbparent.php");

    class Team extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function insertTeam($arr_col) { //insert
            $sql = "INSERT INTO team (idgame, name, poster)
            VALUES (?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("iss", $arr_col['idgame'], $arr_col['name'], $arr_col['poster']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getAllTeam($offset=null, $limit=null) { //tampil
            $sql = "SELECT t.idteam, t.name, t.poster, g.name as game FROM team t INNER JOIN game g ON t.idgame = g.idgame";
            if (!is_null($offset) && !is_null($limit)) {
                $sql .= " LIMIT ? OFFSET ?";
            }
            $stmt = $this->mysqli->prepare($sql);
            if (!is_null($offset) && !is_null($limit)) {
                $stmt->bind_param("ii", $limit, $offset);
            }
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getTotalData () {
            $res=$this->getAllTeam();
            return $res->num_rows;
        }

        public function getEventById($idteam) {
            $stmt = $this->mysqli->prepare("SELECT * FROM team WHERE idteam=?");
            $stmt->bind_param("i", $idteam);
            $stmt->execute();
            return $stmt->get_result(); // Mengembalikan hasil untuk di-fetch
        }

        public function getIdTeamByName($teamName) {
            $stmt = $this->mysqli->prepare("SELECT idteam FROM team WHERE name = ?");
            $stmt->bind_param("s", $teamName);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            return $row['idteam'];
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