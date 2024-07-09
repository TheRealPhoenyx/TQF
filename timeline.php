<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Timeline | TQF</title>
  <style type="text/css">
    #green_bar {
      height: 50px;
      background-color: #3F8147;
      color: #d9dfeb;
    }

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

    #profile_pic {
      width: 150px;
      border-radius: 50%;
      border: solid 2px white;
    }

    #menu_buttons {
      width: 100px;
      display: inline-block;
      margin: 2px;
    }

    #friends_bar {
      min-height: 600px;
      margin-top: 20px;
      color: #405d9b;
      padding: 8px;
      text-align: center;
      font-size: 20px;

    }

    #friends_img {
      width: 50px;
      float: left;
      margin: 8px;
    }

    #friends {
      clear: both;
      font-size: 12px;
      font-weight: bold;
      color: #405d9b;
    }

    #post_textarea {
      width: 100%;
      border: none;
      font-family: tahoma;
      font-size: 14px;
      height: 60px;
    }

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

    #post_bar {
      margin-top: 20px;
      background-color: white;
      padding: 10px;
    }

    #post {
      padding: 4px;
      font-size: 13px;
      display: flex;
      margin-bottom: 20px;
    }
  </style>
</head>

<body style="font-family: tahoma;background-color: #d0d8e4;">
  <br>
  <!--Green Bar Area-->
  <div id="green_bar">
    <div style="width: 800px; margin: auto; font-size: 30px;">
      The Quantum Fest &nbsp &nbsp <input type="text" id="search_box" placeholder="Search for people or events">
      <img src="nana.jpg" style="width: 45px; float: right;">
    </div>
  </div>

  <!--Cover Area-->
  <div style="width: 800px; margin: auto; min-height: 400px;">


    <!--below cover area-->
    <div style="display: flex;">
      <!--Friends area-->
      <div style="min-height: 500px; flex: 1;">
        <div id="friends_bar">
          <img src="nana.jpg" id="profile_pic"><br>
            Jennie Cutrone<br>
        </div>
      </div>

      <!--Posts area-->
      <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
        <div style="border: solid thin #aaa; padding: 10px; background-color: white;">
          <form>
            <textarea id="post_textarea" placeholder="What's on your mind?"></textarea>
            <input id="post_button" type="submit" value="Post">
            <br>
          </form>
        </div>

        <!--posts-->
        <div id="post_bar">
          <!--Post One-->
          <div id="post">
            <div>
              <img src="user1.jpg" style="width: 60px; margin-right: 4px;">
            </div>
            <div>
              <div style="font-weight: bold; color: #405d9b;">Mark Zuckerberg </div>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
              dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex
              ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
              fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt
              mollit anim id est laborum.
              <br><br>
              <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 24 2024</span>
            </div>
          </div>

          <!--Post two-->
          <div id="post">
            <div>
              <img src="user4.jpg" style="width: 60px; margin-right: 4px;">
            </div>
            <div>
              <div style="font-weight: bold; color: #405d9b;">Jeremy Rogers </div>
              My dearest Maggie, As I sit here, penning these words, my heart swells with the love I hold for you. From
              the moment we first met under the moonlit sky, to the joyous reunion we've shared, you've been the melody
              to my soul's song. With each passing day, my love for you deepens, like roots anchoring a mighty tree. You
              are my sanctuary, my guiding light, and my eternal muse. With every beat of my heart, know that you are
              cherished beyond measure. Forever yours, Jay.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
