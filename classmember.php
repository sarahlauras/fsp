<?php
    require_once("dbparent.php");

    class Member extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function getMember($offset=null, $limit=null) { 
            $sql = "SELECT * FROM member";

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

        public function getMemberById($id) {
            $stmt = $this->mysqli->prepare("SELECT * FROM member WHERE idmember=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result(); 
        }

        public function getTotalData(){
            $res = $this->getMember();
            return $res->num_rows;
        }

        public function insertMember($arr_col) {
            $sql = "INSERT INTO member(fname, lname, username, password, profile) 
                    VALUES (?,?,?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $hash_password = password_hash($arr_col['password'], PASSWORD_DEFAULT);
            $stmt->bind_param("sssss", $arr_col['fname'], $arr_col['lname'], 
                              $arr_col['username'], $hash_password, $arr_col['profile']);
            $stmt->execute();
    
            return $this->mysqli->affected_rows;
        }
        public function editMember($fname, $lname, $username, $password, $profile, $idmember) {
            $stmt = $this->mysqli->prepare(
                "UPDATE member SET fname=?, lname=?, username=?, password=?, profile=?
                WHERE idmember=?");
            $stmt->bind_param("sssssi", $fname, $lname, $username, $password, $profile, $idmember);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
        public function deleteMember($idmember) {
            $stmt = $this->mysqli->prepare("DELETE FROM member WHERE idmember=?");
            $stmt->bind_param("i", $idmember);
            $stmt->execute();
            $jumlah = $stmt->affected_rows;
            $stmt->close();
            return $jumlah;
        }
        public function doLogin($username, $password){
            session_start();
            $sql = "SELECT * FROM member WHERE username = ?";
            $stmt = $this->mysqli->prepare($sql);
        
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
        
            if($result->num_rows > 0){
                $row = $result->fetch_assoc();
                if(password_verify($password, $row['password'])){
                    $_SESSION['idmember']=$row['idmember'];
                    $_SESSION['username'] = $row['username'];
                    $_SESSION['profile'] = $row['profile'];
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }
        
    }
?>