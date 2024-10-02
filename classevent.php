<?php
    require_once ("dbparent.php");

    class Event extends DBParent {
        public function __constructor() {
            parent::__construct();
        }

        public function insertEvent($arr_col) { //insert
            $sql = "INSERT INTO event (name, date, description)
            VALUES (?,?,?)";
            $stmt = $this->mysqli->prepare($sql);
            $stmt->bind_param("sss", $arr_col['name'], $arr_col['date'], $arr_col['description']);
            $stmt->execute();
            return $this->mysqli->insert_id;
        }

        public function getAllEvent() { //tampil
            $stmt = $this->mysqli->prepare("SELECT * FROM event");
            $stmt->execute();
            $result = $stmt->get_result();
            return $result;
        }

        public function getEventById($idevent) {
            $stmt = $this->mysqli->prepare("SELECT * FROM event WHERE idevent=?");
            $stmt->bind_param("i", $idevent);
            $stmt->execute();
            return $stmt->get_result(); // Mengembalikan hasil untuk di-fetch
        }

        public function editEvent($name, $date, $description, $idevent) {
            $stmt = $this->mysqli->prepare(
                "UPDATE event SET name=?, date=?, description=?
                WHERE idevent=?");
            $stmt->bind_param("sssi", $name, $date, $description, $idevent);
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