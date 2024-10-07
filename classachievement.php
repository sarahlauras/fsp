<?php   
    require_once("dbparent.php");

    class Achievement extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function insertAchievement($arr_col) {
            $sql = "INSERT INTO achievement (name, description, date, idteam)
            VALUES (?,?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("ssdi", $arr_col['name'], $arr_col['description'],$arr_col['date'], $arr_col['idteam']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getAllAchievement() {
            $stmt = $this->mysqli->prepare("SELECT * FROM achievement");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getAchievementById($idachievement) {
            $stmt = $this->mysqli->prepare("SELECT * FROM achievement WHERE idachievement=?");
            $stmt->bind_param("i", $idachievement);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function editAchievement($name, $description, $team) {
            $stmt = $this->mysqli->prepare(
                "UPDATE achievement SET name=?, description=?, date=?, idteam=?
                WHERE idachievement=?");
            $stmt->bind_param("ssdi", $name, $description, $date, $idteam);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }

        public function deleteAchievement($idachievement) {
            $stmt = $this->mysqli->prepare("DELETE FROM achievement WHERE idachievement=?");
            $stmt->bind_param("i", $idachievement);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
    } 

?>