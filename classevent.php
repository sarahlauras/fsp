<?php
require_once("dbparent.php");

class Event extends DBParent
{
    public function __constructor()
    {
        parent::__construct();
    }

    public function insertEvent($arr_col)
    { //insert
        $sql = "INSERT INTO event (name, date, description)
            VALUES (?,?,?)";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("sss", $arr_col['name'], $arr_col['date'], $arr_col['description']);
        $stmt->execute();
        return $this->mysqli->insert_id;
    }

    public function getAllEvent($username = null, $offset = null, $limit = null)
    {
        // SQL dasar
        $sql = "SELECT e.* FROM event e";

        if (!is_null($username)) {
            $sql = "SELECT e.*, m.username
            FROM event e INNER JOIN event_teams et ON e.idevent = et.idevent
            INNER JOIN team t ON et.idteam = t.idteam 
            INNER JOIN join_proposal jp ON t.idteam = jp.idteam 
            INNER JOIN member m ON jp.idmember = m.idmember WHERE status = 'approved' AND m.username = ?";
        }

        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ? OFFSET ?";
        }
        $stmt = $this->mysqli->prepare($sql);

        if (!is_null($username) && !is_null($offset) && !is_null($limit)) {
            $stmt->bind_param("sii", $username, $limit, $offset);
        } elseif (!is_null($username)) {
            $stmt->bind_param("s", $username);
        } elseif (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param("ii", $limit, $offset);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        return $result;
    }


    public function getTotalData($username = null)
    {
        if (is_null($username)) {
            // Ambil semua event
            $res = $this->getAllEvent(null, null, null);
        } else {
            // Ambil event untuk member tertentu
            $res = $this->getAllEvent($username, null, null);
        }
        return $res->num_rows;
    }

    public function getEventById($idevent)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM event WHERE idevent=?");
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        return $stmt->get_result(); // Mengembalikan hasil untuk di-fetch
    }

    public function editEvent($name, $date, $description, $idevent)
    {
        $stmt = $this->mysqli->prepare(
            "UPDATE event SET name=?, date=?, description=?
                WHERE idevent=?"
        );
        $stmt->bind_param("sssi", $name, $date, $description, $idevent);
        $stmt->execute();
        $jumlah = $stmt->affected_rows;
        $stmt->close();
        return $jumlah;
    }

    public function deleteEvent($idevent)
    {
        $stmt = $this->mysqli->prepare("DELETE FROM event WHERE idevent=?");
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        $jumlah = $stmt->affected_rows;
        $stmt->close();
        return $jumlah;
    }
}
?>