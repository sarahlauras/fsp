<?php
    require_once("dbparent.php");

    class JoinProposal extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getJoinProposal($offset = null, $limit = null) {
            $sql = "SELECT jp.idjoin_proposal, m.fname, t.name, jp.description, jp.status FROM join_proposal jp INNER JOIN
                    member m ON jp.idmember = m.idmember INNER JOIN team t ON jp.idteam = t.idteam";
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

        public function getTotalData(){
            $res = $this->getJoinProposal();
            return $res->num_rows;
        }

        public function getMember(){
            $sql = "SELECT idmember, fname FROM member";
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

        public function insertJoinProposal($arr_col) {
            $sql = "INSERT INTO join_proposal(idjoin_proposal, idmember, idteam, description, status) 
                    VALUES (?,?,?,?,'waiting')";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("iiis", $arr_col['idjoin_proposal'], $arr_col['idmember'], $arr_col['idteam'], 
                              $arr_col['description']);
            $stmt->execute();
    
            return $this->mysqli->affected_rows;
        }
    }
?>