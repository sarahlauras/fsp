<?php
    require_once("dbparent.php");

    class Member extends DBParent {
        public function __construct() {
            parent::__construct();
        }

        public function doLogin($username, $password){
            $sql = "SELECT * FROM member WHERE username =?";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if($result->num_rows>0){
                $row = $result->fetch_assoc();

                if(password_verify($password, $row['password'])){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                return false;
            }
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