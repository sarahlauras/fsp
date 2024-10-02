<?php
    require_once ("dbparent.php");

    class Event extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        // public function getEvent($keyword_judul, $limit=null) {
        //     $sql = "SELECT * FROM movie WHERE judul LIKE ?";
            
        //     if(!is_null($offset)) {
        //         $sql .= " LIMIT ?,?";
        //     }

        //     $stmt = $this->mysqli->prepare($sql);
        //     $keyword = "%{$keyword_judul}%";
        //     if(!is_null($offset)) {
        //         $stmt->bind_param("sii", $keyword, $offset, $limit);
        //     } else {
        //         $stmt->bind_param("s", $keyword);
        //     }

        //     $stmt->execute();
        //     $result = $stmt->get_result();
        //     return $result;
        // }

        // public function getTotalData ($keyword_judul) {
        //     $res=$this->getMovie($keyword_judul);
        //     return $res->num_rows;
        // }

        public function insertEvent($arr_col) {
            $sql = "INSERT INTO event (name, date, description)
            VALUES (?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss", $arr_col['name'], $arr_col['date'], $arr_col['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getAllEvent() {

        }
    }
?>