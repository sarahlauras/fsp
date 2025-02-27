<?php
    require_once("dbparent.php");

    class JoinProposal extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getJoinProposal($username = null, $id = null, $offset = null, $limit = null) {
            $sql = "SELECT jp.*, m.fname, t.name 
                    FROM join_proposal jp 
                    INNER JOIN member m ON jp.idmember = m.idmember 
                    INNER JOIN team t ON jp.idteam = t.idteam";
        
            if (!is_null($username)) {
                $sql .= " WHERE m.username = ?";
            } elseif (!is_null($id)) {
                $sql .= " WHERE jp.idjoin_proposal = ?";
            }
        
            if (!is_null($offset) && !is_null($limit)) {
                $sql .= " LIMIT ?, ?";
            }
        
            $stmt = $this->mysqli->prepare($sql);
        
            if (!is_null($username) && !is_null($offset) && !is_null($limit)) {
                $stmt->bind_param('sii', $username, $offset, $limit);
            } elseif (!is_null($username)) {
                $stmt->bind_param('s', $username);
            } elseif (!is_null($id) && !is_null($offset) && !is_null($limit)) {
                $stmt->bind_param('iii', $id, $offset, $limit);
            } elseif (!is_null($id)) {
                $stmt->bind_param('i', $id);
            } elseif (!is_null($offset) && !is_null($limit)) {
                $stmt->bind_param('ii', $offset, $limit);
            }
        
            $stmt->execute();
            $res = $stmt->get_result();
            return $res;
        }

        public function getTotalData($username = null) {
            if (is_null($username)) {
                // Ambil semua join proposal
                $res = $this->getJoinProposal(null, null, null, null);
            } else {
                // Ambil join proposal untuk member tertentu
                $res = $this->getJoinProposal($username, null, null, null);
            }
            
            return $res->num_rows;
        }
        public function getMember(){
            $sql = "SELECT idmember, fname FROM member WHERE profile = 'member'";
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

        public function editJoinProposal($idmember, $idteam, $description, $status, $idjoin_proposal){
            $stmt = $this->mysqli->prepare("UPDATE join_proposal SET idmember=?, idteam=?, description=?, status=?
                                             WHERE idjoin_proposal=?");
            $stmt->bind_param("iissi", $idmember, $idteam, $description, $status, $idjoin_proposal);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }

        public function deleteJoinProposal($idjoin_proposal) {
            $stmt = $this->mysqli->prepare("DELETE FROM join_proposal WHERE idjoin_proposal=?");
            $stmt->bind_param("i", $idjoin_proposal);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }

        public function getApprovedTeams($idmember) {
            $sql = "SELECT jp.idteam, t.name 
                    FROM join_proposal jp
                    INNER JOIN team t ON jp.idteam = t.idteam
                    WHERE jp.idmember = ? AND jp.status = 'approved'";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("i", $idmember);
            $stmt->execute();
            return $stmt->get_result();
        }
    }
?>