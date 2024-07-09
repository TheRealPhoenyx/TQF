<?php

class Login
{
    private $error = "";

    public function evaluate($data)
    {
        global $DB;

        $email = addslashes($data['email']);
        $password = addslashes($data['password']);

        // Insert into the database
        $query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
        $result = $DB->read($query);

        if ($result) {
            $row = $result[0];

            if ($password == $row['password']) {
                // Create session data
                $_SESSION['tqf_userid'] = $row['userid'];
            } else {
                $this->error .= "Wrong password. <br>";
            }
        } else {
            $this->error .= "No such email was found<br>";
        }

        return $this->error;
    }

    public function check_login($id)
    {
        if (is_numeric($id)) {
            global $DB;

            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
            $result = $DB->read($query);

            if ($result) {
                $user_data = $result[0];
                return $user_data;
            } else {
                header("Location: login.php");
                die;
            }
        } else {
            header("Location: login.php");
            die;
        }
    }
}

?>
