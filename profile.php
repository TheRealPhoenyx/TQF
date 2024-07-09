<?php
// Start the session
session_start();

// Include necessary classes
include("Classes/connect.php"); // Database connection
include("Classes/login.php");   // Login functionalities
include("Classes/user.php");    // User functionalities
include("Classes/post.php");    // Post functionalities

// Check if the user is logged in
$login = new Login(); // Create a new instance of the Login class
$user_data = $login->check_login($_SESSION['tqf_userid']); // Check login status and get user data

// Handle post request if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['post_textarea'])) {
        $post_text = $_POST['post_textarea']; // Get post text from form

        // Check if there's a file uploaded
        $file_uploaded = isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK;

        // Check if it's a profile or cover photo update and create appropriate post
        if ($file_uploaded && isset($_GET['change'])) {
            $post_text = "changed their " . ($_GET['change'] === 'profile' ? "profile picture." : "cover photo.");
            $post = new Post(); // Create a new instance of the Post class
            $id = $_SESSION['tqf_userid']; // Get user ID from session
            $result = $post->create_post($id, ['post_textarea' => $post_text], $_FILES); // Create a new post

            if ($result == "") { // If no errors, redirect to profile page
                header("Location: profile.php");
                die;
            } else { // If errors occurred, display them
                echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";
                echo "<br>The following errors occurred:<br><br>";
                echo $result;
                echo "</div>";
            }
        } else {
            // Handle regular posts without profile/cover photo updates
            $post = new Post(); // Create a new instance of the Post class
            $id = $_SESSION['tqf_userid']; // Get user ID from session
            $result = $post->create_post($id, $_POST, $_FILES); // Create a new post

            if ($result == "") { // If no errors, redirect to profile page
                header("Location: profile.php");
                die;
            } else { // If errors occurred, display them
                echo "<div style='text-align: center; font-size:12px; color: white; background-color: grey;'>";
                echo "<br>The following errors occurred:<br><br>";
                echo $result;
                echo "</div>";
            }
        }
    }
}

// Collect posts for the user
$post = new Post(); // Create a new instance of the Post class
$id = $_SESSION['tqf_userid']; // Get user ID from session
$posts = $post->get_posts($id); // Get all posts for the user

// Collect friends for the user
$user = new User(); // Create a new instance of the User class
$id = $_SESSION['tqf_userid']; // Get user ID from session
$friends = $user->get_friends($id); // Get all friends for the user
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Profile | TQF</title>
    <style type="text/css">
        /* Styling for the header bar */
        #green_bar {
            height: 50px;
            background-color: #3F8147;
            color: #d9dfeb;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        /* Styling for the search box */
        #search_box {
            width: 300px;
            height: 20px;
            border-radius: 5px;
            border: none;
            padding: 4px;
            font-size: 14px;
            background-image: url(search.jpg);
            background-repeat: no-repeat;
            background-position: right;
        }

        /* Styling for the profile picture */
        #profile_pic {
            width: 150px;
            border-radius: 50%;
            border: solid 2px white;
            position: absolute;
            top: 150px;
            left: 50%;
            transform: translateX(-50%);
        }

        /* Styling for menu buttons */
        #menu_buttons {
            width: 100px;
            display: inline-block;
            margin: 5px 0;
            height: 20px;
        }

        /* Styling for the friends bar */
        #friends_bar {
            background-color: white;
            min-height: 600px;
            margin-top: 20px;
            color: #aaa;
            padding: 8px;
            text-align: center;
        }

        /* Styling for friends container */
        .friends-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: auto;
        }

        /* Styling for individual friends */
        .friend {
            width: 100px;
            margin: 10px;
            text-align: center;
        }

        /* Styling for friends images */
        .friend img {
            width: 50px;
            margin-bottom: 5px;
        }

        /* Styling for friends names */
        .friend-name {
            font-size: 12px;
            font-weight: bold;
            color: #405d9b;
        }

        /* Styling for the post textarea */
        #post_textarea {
            width: 100%;
            border: none;
            font-family: tahoma;
            font-size: 14px;
            height: 60px;
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
            width: 50px;
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

        /* Styling for the cover image */
        #cover_image {
            position: relative;
            width: 100%;
            height: 300px;
            overflow: hidden;
        }

        /* Styling for the cover image inside its container */
        #cover_image img {
            width: 100%;
            height: auto;
            object-fit: cover;
            max-height: 300px;
        }

        /* Styling for the change image button */
        #change_image {
            font-size: 12px;
            position: absolute;
            top: 250px;
            left: 50%;
            transform: translateX(-50%);
            background-color: transparent;
            padding: 5px;
            border-radius: 5px;
            cursor: pointer;
            white-space: nowrap;
        }

        /* Styling for links inside the change image button */
        #change_image a {
            text-decoration: none;
            color: #405d9b;
            padding: 5px;
        }

        /* Styling for the profile info section */
        .profile-info {
            margin-top: 20px;
            text-align: center;
        }

        /* Styling for individual items in the profile info section */
        .profile-info div {
            margin-bottom: 5px;
        }
    </style>
</head>

<body style="font-family: tahoma;background-color: #d0d8e4;">
    <br>
    <?php include("header.php"); // Include the header ?>
    <!-- Cover Area -->
    <div style="width: 800px; margin: auto; min-height: 300px; position: relative;">
        <div style="background-color: white; text-align: center; color: #405d9b;">

            <div id="cover_image">
                <!-- Fetch and display the cover image from the database -->
                <a href="view_image.php?path=<?php echo $user_data['cover_image'] ?: 'images/first_cover.jpg'; ?>">
                    <img src="<?php echo $user_data['cover_image'] ?: 'images/first_cover.jpg'; ?>" alt="Cover Photo">
                </a> <!-- Display cover image -->
            </div>

            <span id="change_image">
                <br><br><br><br> <a href="change_profile_image.php?change=profile">Change Profile Image</a> |
                <a href="change_profile_image.php?change=cover">Change Cover Photo</a>
            </span>

            <?php
            $image = "images/user_male.jpg"; // Default image

            if ($user_data['gender'] == 'Female') {
                $image = "images/user_female.jpg";
            }

            if (file_exists($user_data['profile_image'])) {
                $image = $user_data['profile_image'];
            }
            ?>
            <a href="view_image.php?path=<?php echo $image; ?>">
                <img id="profile_pic" src="<?php echo $image ?> "> <!-- Display profile image -->
            </a>

            <div class="profile-info">
                <br>
                <div style="font-size: 20px;"><?php echo isset($user_data['first_name']) && isset($user_data['last_name']) ? $user_data['first_name'] . " " . $user_data['last_name'] : ''; ?></div>
                <br>
                <a href="index.php">
                    <div id="menu_buttons">Timeline</div>
                </a>
                <div id="menu_buttons">About</div>
                <div id="menu_buttons">Friends</div>
                <div id="menu_buttons">Photos</div>
                <div id="menu_buttons">Settings</div>
                <div id="menu_buttons">VR Events</div>
                <div id="menu_buttons">AR Events</div>
            </div>
        </div>

        <!-- Below cover area -->
        <div style="display: flex;">
            <!-- Friends area -->
            <div style="min-height: 400px; flex: 1;">
                <div id="friends_bar">
                    Friends<br>
                    <div class="friends-container">
                        <?php
                        if (isset($friends) && !empty($friends)) {
                            foreach ($friends as $friend) {
                                $friend_user_data = $user->get_user($friend['userid']); // Updated method call to get_user
                                $friend_image = "images/user_male.jpg"; // Default image

                                if ($friend_user_data['gender'] == 'Female') {
                                    $friend_image = "images/user_female.jpg";
                                }

                                if (file_exists($friend_user_data['profile_image'])) {
                                    $friend_image = $friend_user_data['profile_image'];
                                }
                        ?>
                                <div class="friend">
                                    <a href="profile.php?id=<?php echo $friend_user_data['userid']; ?>">
                                        <img src="<?php echo $friend_image; ?>" title="<?php echo $friend_user_data['first_name'] . ' ' . $friend_user_data['last_name']; ?>">
                                    </a><br>
                                    <a href="profile.php?id=<?php echo $friend_user_data['userid']; ?>" style="font-size: 12px; color: #000;"><?php echo $friend_user_data['first_name'] . ' ' . $friend_user_data['last_name']; ?></a>
                                </div>
                        <?php
                            }
                        } else {
                            echo "No friends to display.";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- Posts area -->
            <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
                <div style="border: solid thin #aaa; padding: 10px; background-color: white;">

                    <form method="post" enctype="multipart/form-data">
                        <textarea id="post_textarea" name="post_textarea" placeholder="What's on your mind?"></textarea>
                        <input type="file" name="file">
                        <input id="post_button" type="submit" value="Post"><br><br>
                    </form>
                </div> <!-- Corrected closing </div> tag -->

                <!-- Display posts -->
                <div id="post_bar">
                    <?php
                    if (isset($posts) && !empty($posts)) {
                        foreach ($posts as $post) {
                            $user_data = $user->get_user($post['userid']); // Updated method call to get_user
                            $post_image = $post['image'] ?: 'images/user_male.jpg';
                    ?>
                            <div id="post">
                                <div>
                                    <img src="<?php echo $user_data['profile_image'] ?: 'images/user_male.jpg'; ?>" style="width: 75px; margin-right: 4px;">
                                </div>
                                <div style="display: flex; flex-direction: column;">
                                    <div style="font-weight: bold; color: #405d9b;">
                                        <?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?>
                                    </div>
                                    <div>
                                        <?php echo isset($post['post']) ? $post['post'] : ''; ?>
                                    </div>
                                    <?php if ($post['has_image']) : ?>
                                        <a href="view_image.php?path=<?php echo $post['image']; ?>">
                                            <img src="<?php echo $post_image; ?>" style="width: 80%; margin-top: 10px;">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No posts to display.";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
