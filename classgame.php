<?php   
    require_once("dbparent.php");

    class Game extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function insertGame($arr_col) {
            $sql = "INSERT INTO game (name, description)
            VALUES (?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ss", $arr_col['name'], $arr_col['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }
        public function getTotalData(){
            $res = $this->getAllGame();
            return $res->num_rows;
        }
        public function getAllGame($offset = null, $limit = null) { 
            $sql = "SELECT * FROM game";
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
        
        public function getGameById($idgame) {
            $stmt = $this->mysqli->prepare("SELECT * FROM game WHERE idgame=?");
            $stmt->bind_param("i", $idgame);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function editGame($name, $description, $idgame) {
            $stmt = $this->mysqli->prepare(
                "UPDATE game SET name=?, description=?
                WHERE idgame=?");
            $stmt->bind_param("ssi", $name, $description, $idgame);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }

        public function deleteGame($idgame) {
            $stmt = $this->mysqli->prepare("DELETE FROM game WHERE idgame=?");
            $stmt->bind_param("i", $idgame);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
    } 

?>