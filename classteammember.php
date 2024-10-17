<?php
require_once("dbparent.php");

class TeamMember extends DBParent
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getTeamMembers($idmember = null, $idteam = null, $offset = null, $limit = null) {
        $sql = "SELECT tm.*, m.*, t.* FROM team_members tm INNER JOIN member m ON tm.idmember = m.idmember
                INNER JOIN team t ON tm.idteam = t.idteam";
    
        if (!is_null($idmember) || !is_null($idteam)) {
            $sql .= " WHERE";
            if (!is_null($idmember)) {
                $sql .= " tm.idmember = ?";
            }
            if (!is_null($idteam)) {
                if (!is_null($idmember)) {
                    $sql .= " AND"; 
                }
                $sql .= " tm.idteam = ?";
            }
        }
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }
        $stmt = $this->mysqli->prepare($sql);
        
        if (!is_null($idmember) && !is_null($idteam) && !is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iiii', $idmember, $idteam, $offset, $limit);
        } elseif (!is_null($idmember) && !is_null($idteam)) {
            $stmt->bind_param('ii', $idmember, $idteam);
        } elseif (!is_null($idmember) && !is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $idmember, $offset, $limit);
        } elseif (!is_null($idteam) && !is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $idteam, $offset, $limit);
        } elseif (!is_null($idmember)) {
            $stmt->bind_param('i', $idmember);
        } elseif (!is_null($idteam)) {
            $stmt->bind_param('i', $idteam);
        } elseif (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('ii', $offset, $limit);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }
    
    public function getTotalData(){
        $res = $this->getTeamMembers(null,null,null,null);
        return $res->num_rows;
    }

    public function getMember(){
        $sql = "SELECT idmember, fname FROM member WHERE profile ='member'";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }
    

    public function getTeam(){
        $sql = "SELECT idteam, name FROM team";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function insertTeamMember($arr_col) {
        $sql = "INSERT INTO team_members(idteam, idmember, description) 
                VALUES (?,?,?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("iis", $arr_col['idteam'], $arr_col['idmember'], $arr_col['description']);
        $stmt->execute();
        return $this->mysqli->affected_rows;
    }

    public function editTeamMember($newIdteam, $newIdmember, $description, $idteam = null, $idmember = null) {
        $sql = "UPDATE team_members SET description=?";
        if (!is_null($newIdteam)) {
            $sql .= ", idteam=?";
        }
        if (!is_null($newIdmember)) {
            $sql .= ", idmember=?";
        }
        $sql .= " WHERE idteam=? AND idmember=?";
        $stmt = $this->mysqli->prepare($sql);
    
        if (!is_null($newIdteam) && !is_null($newIdmember)) {
            $stmt->bind_param('siiii', $description, $newIdteam, $newIdmember, $idteam, $idmember);
        } elseif (!is_null($newIdteam)) {
            $stmt->bind_param('siii', $description, $newIdteam, $idteam, $idmember);
        } elseif (!is_null($newIdmember)) {
            $stmt->bind_param('siii', $description, $newIdmember, $idteam, $idmember);
        } else {
            $stmt->bind_param('sii', $description, $idteam, $idmember);
        }
        $stmt->execute();
        $jumlah = $stmt->affected_rows;
        $stmt->close();
        return $jumlah;
    }

    public function deleteTeamMember($idteam, $idmember) {
        $stmt = $this->mysqli->prepare("DELETE FROM team_members WHERE idteam=? AND idmember=?");
        $stmt->bind_param("ii", $idteam, $idmember);
        $stmt->execute();
        $jumlah = $stmt->affected_rows;
        $stmt->close();
        return $jumlah;
    }
}
?>