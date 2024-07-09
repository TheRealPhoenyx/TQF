<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "quantumfest_db";

    function connect()
    {
        $connection = mysqli_connect($this->host, $this->username, $this->password, $this->db);

        if (mysqli_connect_errno()) {
            die("Database connection failed: " . mysqli_connect_error());
        }

        return $connection;
    }

    function read($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if ($result == false) {
            return false;
        } else {
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            return $data;
        }
    }

    function save($query)
    {
        $conn = $this->connect();
        $result = mysqli_query($conn, $query);

        if ($result == false) {
            return false;
        } else {
            return true;
        }
    }
}

$DB = new Database();
//$data = $DB->read($query);

//echo "<pre>";
//print_r($data);
//echo "</pre>";
?>
