<?php

// Start the session
session_start();

// Include necessary classes
include_once("Classes/connect.php"); // Database connection
include_once("Classes/login.php");   // Login functionalities
include_once("Classes/user.php");    // User functionalities
include_once("Classes/post.php");    // Post functionalities
include_once("Classes/image.php");   // Image functionalities

// Check if the user is logged in
if (!isset($_SESSION['tqf_userid'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    die;
}

$login = new Login(); // Create a new instance of the Login class
$user_data = $login->check_login($_SESSION['tqf_userid']); // Check login status and get user data

// Handle post request if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $error = "";
    // Check if a file is uploaded
    if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "") {
        // Allowed MIME types for images
        $allowed_types = ["image/jpg", "image/jpeg", "image/png", "image/gif"];

        if (in_array($_FILES['file']['type'], $allowed_types)) {
            $allowed_size = (1024 * 1024) * 3; // Allowed file size is 3MB

            if ($_FILES['file']['size'] < $allowed_size) {
                $folder = "uploads/" . $user_data['userid'] . "/"; // Folder path for user uploads

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true); // Create the folder if it doesn't exist
                }

                $image = new Image($_FILES['file']['tmp_name']); // Create a new instance of the Image class
                $filename = $image->generate_filename(15, $folder); // Generate a filename
                move_uploaded_file($_FILES['file']['tmp_name'], $filename); // Move the uploaded file to the target location

                $change = "profile"; // Default to profile image

                // Check if changing cover image
                if (isset($_GET['change']) && $_GET['change'] == "cover") {
                    $change = "cover";
                }

                try {
                    $image->resize($filename, 800, 800); // Resize the image

                    if (file_exists($filename)) { // Check if the file exists
                        $userid = $user_data['userid']; // Get user ID

                        if ($change == "cover") {
                            $query = "UPDATE users SET cover_image = '$filename' WHERE userid = '$userid' LIMIT 1";
                            $post_content = "changed their cover photo";
                        } else {
                            $query = "UPDATE users SET profile_image = '$filename' WHERE userid = '$userid' LIMIT 1";
                            $post_content = "changed their profile picture";
                        }

                        $DB = new Database(); // Create a new instance of the Database class
                        $DB->save($query); // Save the image path to the database

                        // Create a post about the image change
                        $post = new Post();
                        $post_id = $post->create_post($userid, $post_content, $filename);

                        header("Location: profile.php"); // Redirect to profile page
                        die;
                    }
                } catch (Exception $e) { // Handle exceptions
                    echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";
                    echo "<br>The following errors occurred:<br><br>";
                    echo $e->getMessage(); // Display the error message
                    echo "</div>";
                }
            } else {
                // Display error message for large file size
                echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";
                echo "<br>The following errors occurred:<br><br>";
                echo "Only images of 3MB or lower are allowed!";
                echo "</div>";
            }
        } else {
            // Display error message for unsupported file types
            echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";
            echo "<br>The following errors occurred:<br><br>";
            echo "Only .jpg, .jpeg, .png, and .gif image formats are allowed!";
            echo "</div>";
        }
    } else {
        // Display error message for no file uploaded
        echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";
        echo "<br>The following errors occurred:<br><br>";
        echo "Please add a valid image!";
        echo "</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Change Profile Image | TQF</title>
    <style type="text/css">
        /* Styling for the header bar */
        #green_bar {
            height: 50px;
            background-color: #3F8147;
            color: #d9dfeb;
        }

        /* Styling for the search box */
        #search_box {
            width: 400px;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 4px;
            font-size: 14px;
            background-image: url(search.jpg);
            background-repeat: no-repeat;
            background-position: right;
        }

        /* Styling for the post button */
        #post_button {
            float: right;
            background-color: #3F8147;
            border: none;
            color: white;
            padding: 4px;
            font-size: 14px;
            border-radius: 2px;
            width: 55px;
        }

        /* Styling for the post bar */
        #post_bar {
            margin-top: 20px;
            background-color: white;
            padding: 10px;
        }

        /* Styling for individual posts */
        #post {
            padding: 4px;
            font-size: 13px;
            display: flex;
            margin-bottom: 20px;
        }
    </style>
</head>
<body style="font-family: tahoma; background-color: #d0d8e4;">
    <!--<br>-->
    <?php include("header.php"); // Include the header ?>
    <!-- Green Bar Area -->
    <!--  <div id="green_bar">
        <div style="width: 800px; margin: auto; font-size: 30px;">
            The Quantum Fest &nbsp &nbsp <input type="text" id="search_box" placeholder="Search for anything">
        </div>
    </div>-->
    <!-- Cover Area -->
    <div style="width: 800px; margin: auto; min-height: 400px;">
        <!-- White Bar Area -->
        <div style="display: flex;">
            <!-- Posts Area -->
            <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
                <form method="post" enctype="multipart/form-data">
                    <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
                        <input type="file" name="file">
                        <input id="post_button" type="submit" value="Change">
                        <br>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
