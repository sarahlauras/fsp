<?php
    require_once("dbparent.php");

    class JoinProposal extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getJoinProposal($offset = null, $limit = null) {
            $sql = "SELECT * FROM join_proposal";
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
        

        public function insertMember($arr_col) {
            $sql = "INSERT INTO member(idmember, fname, lname, username, password, profile) 
                    VALUES (?,?,?,?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $hash_password = password_hash($arr_col['password'], PASSWORD_DEFAULT);
            $stmt->bind_param("isssss", $arr_col['idmember'], $arr_col['fname'], $arr_col['lname'], 
                              $arr_col['username'], $hash_password, $arr_col['profile']);
            $stmt->execute();
    
            return $this->mysqli->affected_rows;
        }
        
    }
?>