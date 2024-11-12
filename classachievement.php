<?php
require_once("dbparent.php");

class Achievement extends DBParent {
    public function __construct() {
        parent::__construct();
    }

    public function getTotalData($member = null, $idteam = null) {
        $sql = "SELECT COUNT(*) AS total FROM achievement a 
                INNER JOIN team t ON a.idteam = t.idteam";
        
        if (!is_null($member)) {
            $sql .= " INNER JOIN team_members ut ON ut.idteam = t.idteam 
                        WHERE ut.idmember = ?";
            if (!is_null($idteam)) {
                $sql .= " AND t.idteam = ?";
            }
        } elseif (!is_null($idteam)) {
            $sql .= " WHERE t.idteam = ?";
        }

        $stmt = $this->mysqli->prepare($sql);
        if (!is_null($member) && !is_null($idteam)) {
            $stmt->bind_param("ii", $member, $idteam);
        } elseif (!is_null($member)) {
            $stmt->bind_param("i", $member);
        } elseif (!is_null($idteam)) {
            $stmt->bind_param("i", $idteam);
        }

        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row['total'];
    }

    public function insertAchievement($arr_col) {
        $sql = "INSERT INTO achievement (idteam, name, date, description)
                VALUES (?,?,?,?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("isss", $arr_col['idteam'], $arr_col['name'], $arr_col['date'], $arr_col['description']);
        $stmt->execute();
        return $this->mysqli->affected_rows;
    }

    public function getTeam() {
        $sql = "SELECT idteam, name FROM team";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function getUserTeams($idmember) {
        $sql = "SELECT t.idteam, t.name FROM team t
                INNER JOIN team_members tm 
                ON t.idteam = tm.idteam
                WHERE tm.idmember =?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idmember);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function getAchievement($offset = null, $limit = null, $member = null) {
        $sql = "SELECT a.*, t.name AS 'namateam' 
                FROM achievement a 
                INNER JOIN team t ON a.idteam = t.idteam";
 
        if (!is_null($member)) {
            $sql .= " INNER JOIN team_members
             ut ON ut.idteam = t.idteam 
                      WHERE ut.idmember = ?";
        }
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }

        $stmt = $this->mysqli->prepare($sql);

        if (!is_null($member) && !is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $member, $offset, $limit);
        } elseif (!is_null($member)) {
            $stmt->bind_param('i', $member);
        } elseif (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('ii', $offset, $limit);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAchievementById($idachievement) {
        $stmt = $this->mysqli->prepare("SELECT * FROM achievement WHERE idachievement = ?");
        $stmt->bind_param("i", $idachievement);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getAchievementByTeam($idteam, $offset = null, $limit = null) {
        $sql = "SELECT a.name, a.date, a.description, t.name as namateam, a.idachievement
                FROM achievement a
                INNER JOIN team t ON a.idteam = t.idteam
                WHERE t.idteam = ?";

        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }
        $stmt = $this->mysqli->prepare($sql);

        if (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $idteam, $offset, $limit);
        }
        else {
            $stmt->bind_param("i", $idteam);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function getAchievementApprovedProposal($idmember, $offset = null, $limit = null) {
        $sql = "SELECT a.idachievement, a.name, a.description, a.date, t.name AS namateam 
                FROM achievement a 
                INNER JOIN team t ON a.idteam = t.idteam 
                INNER JOIN join_proposal jp ON jp.idteam = t.idteam 
                WHERE jp.idmember = ? AND jp.status = 'approved'";
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }
        $stmt = $this->mysqli->prepare($sql);
        if (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $idmember, $offset, $limit);
        }
        else {
            $stmt->bind_param("i", $idmember);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }
    
    public function editAchievement($name, $description, $date, $idteam, $idachievement) {
        $stmt = $this->mysqli->prepare(
            "UPDATE achievement SET name = ?, description = ?, date = ?, idteam = ?
             WHERE idachievement = ?"
        );
        $stmt->bind_param("sssii", $name, $description, $date, $idteam, $idachievement);
        $stmt->execute();
        $jumlah = $stmt->affected_rows;
        $stmt->close();
        return $jumlah;
    }
    public function deleteAchievement($idachievement) {
        $stmt = $this->mysqli->prepare("DELETE FROM achievement WHERE idachievement = ?");
        $stmt->bind_param("i", $idachievement);
        $stmt->execute();
        $jumlah = $stmt->affected_rows;
        $stmt->close();
        return $jumlah;
    }
}
?>
