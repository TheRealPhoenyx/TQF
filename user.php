<?php
class User
{
    public function get_data($id)
    {
        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function get_user($id)
    {
        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result[0];
        } else {
            return false;
        }
    }

    public function get_friends($id)
    {
        $query = "SELECT * FROM users WHERE userid != '$id'";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result;  // Return the array of results directly
        } else {
            return false;
        }
    }


    public function get_userdata($userid) {
        $DB = new Database();
        $query = "select * from users where userid = '$userid' limit 1";
        $result = $DB->read($query);

        if($result) {
            return $result[0];
        } else {
            return false;
        }

}
}
?>
