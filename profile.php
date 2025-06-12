<?php
    session_start();
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

/*
echo "<pre>";
print_r($_GET);
echo "</pre>";
*/

    include ("/home/cb20351437/classes/autoload.php");

//isset($_SESSION['userid'])

    //logged in check
    $login = new Login();
    $userData = $login->check_login($_SESSION['userid']);

    $USER = $userData;//used to keep data of original user signed in

    if (isset($_GET['id']) && is_numeric($_GET['id']))//is numeric to stop people from manually entering harmful ids
    {
        $profile = new Profile();
        $profileData = $profile->getProfile($_GET['id']);

        if (is_array($profileData))
        {
            $userData = $profileData[0];
        }
    }


    //posting will start here

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {


        $post = new Post();
        $id = $_SESSION['userid'];
        $result = $post -> create_post($id, $_POST, $_FILES);

        if ($result == "")
        {
            header("Location: profile.php");
            die;
        }
        else
        {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: gray'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
    }

        //collecting posts
    $post = new Post();
    $id = $userData['userid'];

    $posts = $post -> get_posts($id);

        //collecting friends
    $user = new User();
    //$id = $_SESSION['userid'];
    $id = $userData['userid'];

    $friends = $user -> getFriends($id);

    $imageClass = new Image();

?>
<html>
<head>
    <title>
        IrataynosBook - Profile
    </title>
</head>

<style>
    #top_bar{
        height: 50px;
        background-color: #405d9b;
        color: #d9dfeb;

    }
    #search_box{
        width: 400px;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url("images/search.png");
        background-repeat: no-repeat;
        background-position: right;

    }
    #profile_pic{
        width: 150px;
        margin-top: -175px;
        border-radius: 50%;
        border: solid 2px white;
    }
    #menu_btn{
        width: 100px;
        display: inline-block;
        margin: 2px;


    }
    #friends_pic{
        width: 75px;
        float: left;
        margin: 8px;

    }
    #friends_box{
        background-color: white;
        min-height: 400px;
        margin-top: 20px;
        color: #aaa;
        padding: 8px;

    }
    #friends{
        clear: both;
        font-size: 12px;
        font-weight: bold;
        color: #405d9b;
    }
    textarea{
        width: 100%;
        border: none;
        font-family: Tahoma;
        font-size: 14px;
        height: 60px;
    }
    #post_btn{
        float: right;
        background-color: #405d9b;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;

    }
    #post_box{
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }
    #post{
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }
</style>

<body style="font-family: Tahoma; background-color: #d0d8e4">
<br>
          <!-- Profile Section -->
    <?php include "header.php"?>

  <div id="content_box" style="width: 800px; margin: auto; min-height: 400px">
      <div style="background-color: white; text-align: center; color: #405d9b">
          <?php
          $imagecover = "images/mountain.jpg";
          if(file_exists($userData['cover_image']))
          {
              $imagecover = $imageClass->getThumbCover($userData['cover_image']);
          }
          ?>
          <img src="<?php echo $imagecover?>" style="width: 100%">

          <span style="font-size: 12px;">

              <?php
              $image = "images/user_female.jpg";
              if(file_exists($userData['profile_image']))
              {
                  $image = $imageClass->getThumbProfile($userData['profile_image']);
              }
              ?>

              <img id="profile_pic" src="<?php echo $image?>"><br>
              <a href="change.php?change=profile" style="text-decoration: none; color: #405d9b">Change Profile Image</a> ||
              <a href="change.php?change=cover" style="text-decoration: none; color: #405d9b">Change Cover Image</a>
              <!--The URL query strings are used to indentify what the user wants to change -->
          </span>
          <br><br>

          <div style="font-size: 20px">
              <?php
              echo $userData['first_name'] . " " . $userData['last_name'];
              ?>
          </div>

          <br>

          <a href="index.php"><div id="menu_btn">Timeline</div></a>
          <div id="menu_btn">About</div>
          <div id="menu_btn">Friends</div>
          <div id="menu_btn">Photos</div>
          <a href="settings.php"><div id="menu_btn">Settings</div></a>


      </div>
      <!-- Online Section -->
      <div style="display: flex; min-height: 400px">

          <!--Friends Section -->
          <div style="min-height: 400px; flex: 1;">
             <div id="friends_box">
                 Friends<br>
                 <?php

                 if ($friends)
                 {
                     foreach ($friends as $friends_ROW)//each time this is loaded row will contain the data wanted for posts
                     {

                         include ("friend.php");
                     }
                 }
                 ?>
             </div>
          </div>


          <!--Post Section -->
          <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px">
               <div style="border: solid thin #aaa; padding: 10px; background-color: white">
                   <form method="post" enctype="multipart/form-data">
                       <textarea name="post" placeholder="What's on your mind?"></textarea>
                       <input type="file" name="file">
                       <input id="post_btn" type="submit" value="Post">
                   </form>
               </div>

              <!-- See Posts -->
              <div id="post_box">
                  <?php

                  if ($posts)
                  {
                      foreach ($posts as $ROW)//each time this is loaded row will contain the data wanted for posts
                      {

                          $user = new User();
                          $ROW_USER = $user->getUser($ROW['userid']);
                          //var_dump($ROW['image']);
                          include ("post.php");
                      }
                  }
                  ?>
                  <!-- Post
                  OLD post
                  <div id="post">
                      <div>
                          <img src="images/user1.jpg" style="width: 75px; margin-right: 4px">

                      </div>
                      <div>
                          <div style="font-weight: bold;color: #405d9b">Second User Test</div>
                          Lorem Ipsum blah blah blah  Lorem Ipsum blah blah blah shush u
                          <br><br>

                          <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 1 2024</span>

                      </div>
                  </div>-->
              </div>
          </div>
      </div>
  </div>

</body>
</html>