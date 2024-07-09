</<?php
$corner_image = "images/user_male.jpg";
if(isset($user_data))
{
  $corner_image = $user_data['profile_image'];

}


 ?>

<!--Green Bar Area-->
<div id="green_bar">
    <div style="width: 800px; margin: auto; display: flex; align-items: center; justify-content: space-between;">
        <div style="font-size: 30px;">

            <a href="index.php" style="color: #d0d8e4; text-decoration: none;">The Quantum Fest</a>
            &nbsp;&nbsp;
            <input type="text" id="search_box" placeholder="Search for people or events">
        </div>
        <div style="display: flex; align-items: center;">
            <a href="logout.php" style="text-decoration: none; color: #d9dfeb;">
                <span style="font-size: 13px; margin-right: 10px;">Logout</span>
            </a>
            <a href="profile.php">

            <img src="<?php echo $corner_image ?>" style="width: 45px; float:right;">
          </a>
        </div>
    </div>
</div>
