<?php

class Signup
{
    private $error = "";

    public function evaluate($data)
    {
        foreach ($data as $key => $value) {
            // Check if the field is empty
            if (empty($value)) {
                $this->error .= $key . " is empty! <br>";
            }

            // Validate email
            if ($key == "email" && !empty($value)) {
                if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->error .= "Invalid email address! <br>";
                }
            }

            // Ensure first name is not numeric and does not contain spaces
            if ($key == "first_name" && !empty($value)) {
                if (is_numeric($value)) {
                    $this->error .= "First name cannot be numeric! <br>";
                }
                if (strstr($value, " ")) {
                    $this->error .= "First name cannot contain spaces! <br>";
                }
            }

            // Ensure last name is not numeric and does not contain spaces
            if ($key == "last_name" && !empty($value)) {
                if (is_numeric($value)) {
                    $this->error .= "Last name cannot be numeric! <br>";
                }
                if (strstr($value, " ")) {
                    $this->error .= "Last name cannot contain spaces! <br>";
                }
            }
        }

        if ($this->error == "") {
            // No error
            $this->create_user($data);
            return "";
        } else {
            return $this->error;
        }
    }

    public function create_user($data)
    {
        $firstname = ucfirst($data['first_name']);
        $lastname = ucfirst($data['last_name']);
        $gender = $data['gender'];
        $email = $data['email'];
        $password = $data['password'];

        // Create URL address
        $url_address = strtolower($firstname) . "." . strtolower($lastname);
        $userid = $this->create_userid();

        // Insert into the database
        $query = "INSERT INTO users (userid, first_name, last_name, gender, email, password, url_address)
                  VALUES ('$userid', '$firstname', '$lastname', '$gender', '$email', '$password', '$url_address')";

        // Assuming $DB is a global variable for the database connection
        global $DB;
        $DB->save($query);

        // Redirect to login page after successful sign-up
        header("Location: login.php");
        exit;
    }

    private function create_userid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number .= $new_rand;
        }
        return $number;
    }
}

?>
