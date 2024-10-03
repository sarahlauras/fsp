<?php
    require_once("dbparent.php");

    class Member extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getMember() { 
            $stmt = $this->mysqli->prepare("SELECT * FROM member");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getTotalData(){
            $res = $this->getMember();
            return $res->num_rows;
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
        public function editMember($fname, $lname, $username, $password, $profile) {
            $stmt = $this->mysqli->prepare(
                "UPDATE member SET fname=?, lname=?, username=?, password=?, profile=?
                WHERE idmember=?");
            $stmt->bind_param("sssss", $fname, $lname, $username, $password, $profile, $idmember);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
        public function deleteEvent($idevent) {
            $stmt = $this->mysqli->prepare("DELETE FROM event WHERE idevent=?");
            $stmt->bind_param("i", $idevent);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }

        
    }
?>