<?php   
    require_once("dbparent.php");

    class Achievement extends DBParent {
        public function __constructor() {
            parent::__construct();
        }
        
        public function getTotalData(){
            $res = $this->getAchievement();
            return $res->num_rows;
        }
        public function insertAchievement($arr_col){
            $sql = "INSERT INTO achievement (idteam, name, date, description)
            VALUES (?,?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("isss", $arr_col['idteam'], $arr_col['name'],$arr_col['date'], $arr_col['description']);
            $stmt->execute();

            return $this->mysqli->affected_rows;
        }
        public function getTeam(){
            $sql = "SELECT idteam, name FROM team";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }
        public function getAchievement($offset=null, $limit=null) { 
            $sql = "SELECT a.*, t.name AS 'namateam' FROM achievement a INNER JOIN team t WHERE a.idteam=t.idteam";

            if (!is_null($offset) && !is_null($limit)) {
                $sql .= " LIMIT ?, ?";
            }
            $stmt = $this->mysqli->prepare($sql);
            if (!is_null($offset) && !is_null($limit)) {
                $stmt->bind_param('ii', $offset, $limit);
            }
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function getAchievementById($idachievement) {
            $stmt = $this->mysqli->prepare("SELECT * FROM achievement WHERE idachievement=?");
            $stmt->bind_param("i", $idachievement);
            $stmt->execute();
            return $stmt->get_result();
        }

        public function editAchievement($name, $description,$date, $idteam, $idachievement) {
            $stmt = $this->mysqli->prepare(
                "UPDATE achievement SET name=?, description=?, date=?, idteam=?
                WHERE idachievement=?");
            $stmt->bind_param("sssii", $name, $description, $date, $idteam, $idachievement);
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