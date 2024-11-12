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

    public function getEvent($offset = null, $limit = null, $member = null) {
        $sql = "SELECT e.*, t.name AS 'namateam' 
                FROM event e
                INNER JOIN event_teams et ON e.idevent = et.idevent
                INNER JOIN team t ON et.idteam = t.idteam";
 
        if (!is_null($member)) {
            $sql .= " INNER JOIN team_members
             ut ON ut.idteam = t.idteam 
                      WHERE ut.idmember = ?";
        }
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }

        $stmt = $this->mysqli->prepare($sql);

        if (!is_null($member) && !is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $member, $offset, $limit);
        } elseif (!is_null($member)) {
            $stmt->bind_param('i', $member);
        } elseif (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('ii', $offset, $limit);
        }
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getUserTeams($idmember) {
        $sql = "SELECT t.idteam, t.name FROM team t
                INNER JOIN team_members tm 
                ON t.idteam = tm.idteam
                WHERE tm.idmember =?";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param("i", $idmember);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function getTeam() {
        $sql = "SELECT idteam, name FROM team";
        $stmt = $this->mysqli->prepare($sql);
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
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

    public function getData($member = null, $idteam = null) {
        $sql = "SELECT COUNT(*) AS total 
                FROM event e 
                INNER JOIN event_teams et ON e.idevent = et.idevent
                INNER JOIN team t ON et.idteam = t.idteam";
        
        if (!is_null($member)) {
            $sql .= " INNER JOIN team_members tm ON tm.idteam = t.idteam 
                        WHERE tm.idmember = ?";
            if (!is_null($idteam)) {
                $sql .= " AND t.idteam = ?";
            }
        } elseif (!is_null($idteam)) {
            $sql .= " WHERE t.idteam = ?";
        }

        $stmt = $this->mysqli->prepare($sql);
        if (!is_null($member) && !is_null($idteam)) {
            $stmt->bind_param("ii", $member, $idteam);
        } elseif (!is_null($member)) {
            $stmt->bind_param("i", $member);
        } elseif (!is_null($idteam)) {
            $stmt->bind_param("i", $idteam);
        }

        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();
        return $row['total'];
    }

    public function getEventById($idevent)
    {
        $stmt = $this->mysqli->prepare("SELECT * FROM event WHERE idevent=?");
        $stmt->bind_param("i", $idevent);
        $stmt->execute();
        return $stmt->get_result(); // Mengembalikan hasil untuk di-fetch
    }

    public function getEventByTeam($idteam, $offset = null, $limit = null) {
        $sql = "SELECT e.name, e.date, e.description, t.name as namateam, e.idevent
                FROM event e
                INNER JOIN event_teams et ON e.idevent = et.idevent
                INNER JOIN team t ON et.idteam = t.idteam
                WHERE t.idteam = ?";

        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }
        $stmt = $this->mysqli->prepare($sql);

        if (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $idteam, $offset, $limit);
        }
        else {
            $stmt->bind_param("i", $idteam);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
    }

    public function getEventApprovedProposal($idmember, $offset = null, $limit = null) {
        $sql = "SELECT e.name, e.date, e.description, t.name AS namateam 
                FROM event e
                INNER JOIN event_teams et ON e.idevent = et.idevent
                INNER JOIN team t ON et.idteam = t.idteam
                INNER JOIN join_proposal jp ON jp.idteam = t.idteam 
                WHERE jp.idmember = ? AND jp.status = 'approved'";
        if (!is_null($offset) && !is_null($limit)) {
            $sql .= " LIMIT ?, ?";
        }
        $stmt = $this->mysqli->prepare($sql);
        if (!is_null($offset) && !is_null($limit)) {
            $stmt->bind_param('iii', $idmember, $offset, $limit);
        }
        else {
            $stmt->bind_param("i", $idmember);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        return $res;
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