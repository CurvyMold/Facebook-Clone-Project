<?php

    session_start();
    //print_r($_SESSION);

    include ("/home/cb20351437/classes/autoload.php");
    //isset($_SESSION['userid'])

    //logged in check
    $login = new Login();
    $userData = $login->check_login($_SESSION['userid']);

    // Get all posts and all users
    $post = new Post();
    $posts = $post->getAllPosts();

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {


        $post = new Post();
        $id = $_SESSION['userid'];
        $result = $post -> create_post($id, $_POST, $_FILES);

        if ($result == "")
        {
            header("Location: index.php");//redirect to prevent form resubmission
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
        min-height: 400px;
        margin-top: 20px;
        color: #405d9b;
        padding: 8px;
        text-align: center;
        font-size: 20px;

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
<?php
include "header.php";
$image = "images/user_female.jpg";

if(file_exists($userData['profile_image']))
{
    $image = $userData['profile_image'];
}
?>

<div id="content_box" style="width: 800px; margin: auto; min-height: 400px">

    <!-- Online Section -->
    <div style="display: flex; min-height: 400px">

        <!--Friends Section -->
        <div style="min-height: 400px; flex: 1;">
            <div id="friends_box">
                <img src="<?php echo $image?>" id="profile_pic"><br>
                <a href="profile.php" style="text-decoration: none; color: #405d9b"> <?php echo $userData['first_name'] . "<br> " . $userData["last_name"]?> </a>
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
                <!-- Post -->

                <?php
                if ($posts)
                {
                    foreach ($posts as $ROW)//each time this is loaded row will contain the data wanted for posts
                    {

                        $user = new User();
                        $ROW_USER = $user->getUser($ROW['userid']);
                        //var_dump($ROW['image']);
                        include ("adminposts.php");
                    }
                }
                ?>










                <!--
                <div id="post">
                    <div>
                        <img src="<?php //echo $image?>" style="width: 75px; margin-right: 4px">

                    </div>
                    <div>
                        <div style="font-weight: bold;color: #405d9b">First User Test</div>
                        Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails
                        <br><br>

                        <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 1 2024</span>

                    </div>
                </div>
                <div id="post">
                    <div>
                        <img src="images/user1.jpg" style="width: 75px; margin-right: 4px">

                    </div>
                    <div>
                        <div style="font-weight: bold;color: #405d9b">Second User Test</div>
                        Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails
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