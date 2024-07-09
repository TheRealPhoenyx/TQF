<?php

// Include or require image.php only once
include_once("Classes/image.php");

class Post
{
    private $error = "";

    public function create_post($userid, $data, $files)
    {
        if (!empty($data['post_textarea']) || !empty($files['file']['name'])) {
            $myimage = "";
            $has_image = 0;

            if (!empty($files['file']['name'])) {
                $image_handler = new Image($files['file']['tmp_name']); // Create a new instance of the ImageHandler class
                $folder = "uploads/" . $userid . "/"; // Folder path for user uploads

                // Create folder if not exists
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }

                $myimage = $image_handler->generate_filename(15, $folder); // Generate filename
                move_uploaded_file($files['file']['tmp_name'], $myimage); // Move uploaded file

                $image_handler->resize($myimage, 800, 800); // Resize image

                $has_image = 1;
            }

            $post = addslashes($data['post_textarea']);
            $postid = $this->create_postid();
            $DB = new Database();
            $query = "INSERT INTO posts (userid, postid, post, image, has_image) VALUES ('$userid', '$postid', '$post', '$myimage', '$has_image')";
            $DB->save($query);
        } else {
            $this->error .= "Please type something to post! <br>";
        }
        return $this->error;
    }

    public function create_profile_image_post($userid, $content)
    {
        $postid = $this->create_postid();
        $DB = new Database();
        $query = "INSERT INTO posts (userid, postid, post, has_image) VALUES ('$userid', '$postid', '$content', '0')";
        $DB->save($query);
    }

    public function get_posts($id)
    {
        $query = "SELECT * FROM posts WHERE userid = '$id' ORDER BY id DESC";
        $DB = new Database();
        $result = $DB->read($query);

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    private function create_postid()
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
