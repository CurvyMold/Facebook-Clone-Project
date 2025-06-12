<?php

    session_start();
    //print_r($_SESSION);

    include ("/home/cb20351437/classes/autoload.php");
    //isset($_SESSION['userid'])

    //logged in check
    $login = new Login();
    $userData = $login->check_login($_SESSION['userid']);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {

        if (isset($_FILES['file']['name']) && $_FILES['file']['name'] != "")
        {
            if ($_FILES['file']['type'] == "image/jpeg")
            {
                $allowedSize = (1024 * 1024) * 3;//3Mb
                if ($_FILES['file']['size'] < $allowedSize)
                {
                    $folder ="uploads/" . $userData['userid'] . "/";//creating a personal folder for all users to stop users deleting others data

                    if (!file_exists($folder))
                    {
                        mkdir($folder, 0777, true);//the true means create all folders needed to create desired folder
                    }

                    $image = new Image();
                    $filename = $folder . $image->generateFilename(15) . ".jpg";//concat the jpg to ensure browser loads file as ana image

                    move_uploaded_file($_FILES['file']['tmp_name'], $filename);

                    $change = "profile";

                    //check if cover or profile image is getting changed
                    if (isset($_GET['change']))//if its not set then it will default to profile
                    {
                       $change = $_GET['change'];
                    }

                    //resizing depending on whether its a cover or profile
                    $image = new Image();


                    if ($change == "cover")
                    {
                        if (file_exists($userData['cover_image']))//deletes the previous file if present to conserve storage
                        {
                            unlink($userData['cover_image']);
                        }
                        $image->getResize($filename, $filename, 600, 600);//1366,488
                    }
                    else
                    {
                        if (file_exists($userData['profile_image']))//deletes the previous file if present to conserve storage
                        {
                            unlink($userData['profile_image']);
                        }
                        $image->getResize($filename, $filename, 600, 600);
                    }


                    if (file_exists($filename))
                    {
                        $userid = $userData['userid'];
                        $_POST['isProfile'] = 0;
                       //sets up the query depending on what needs to be changed
                        if ($change == "cover")
                        {
                            $query = "UPDATE users SET cover_image = '$filename' WHERE userid = '$userid' LIMIT 1";
                            $_POST['isCover'] = 1;
                        }
                        else
                        {
                            $query = "UPDATE users SET profile_image = '$filename' WHERE userid = '$userid' LIMIT 1";
                            $_POST['isProfile'] = 1;
                        }

                        $DB = new database();
                        $DB->save_to_db($query);

                        //create a post
                        $post = new Post();
                        $post -> create_post($userid, $_POST, $filename);


                        header("Location: profile.php");
                        die;
                    }
                }
                else
                {
                    echo "<div style='text-align: center; font-size: 12px; color: white; background-color: gray'>";
                    echo "<br>The following errors occured:<br><br>";
                    echo "Only images of size 3Mb or lower are allowed";
                    echo "</div>";
                }
            }
            else
            {
                echo "<div style='text-align: center; font-size: 12px; color: white; background-color: gray'>";
                echo "<br>The following errors occured:<br><br>";
                echo "Only Jpeg images are allowed";
                echo "</div>";
            }



        }
        else
        {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: gray'>";
            echo "<br>The following errors occured:<br><br>";
            echo "Please add a valid image";
            echo "</div>";
        }
    }


?>

<html>
<head>
    <title>
        IrataynosBook - Change Profile Image
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
    #post_btn{
        float: right;
        background-color: #405d9b;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;


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

    <!-- Online Section -->
    <div style="display: flex; min-height: 400px">


        <!--Post Section -->
        <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px">
            <form method="post" enctype="multipart/form-data">
                <div style="border: solid thin #aaa; padding: 10px; background-color: white;">

                    <input type="file" name="file">
                    <input id="post_btn" type="submit" value="Change">
                    <br><br>
                    <div style="text-align: center">
                        <br><br>
                        <?php
                        //check if cover or profile image is getting changed
                        if (isset($_GET['change']) && $_GET['change'] == "cover")//if its not set then it will default to profile
                        {
                            $change = "cover";
                            echo"<img src='$userData[cover_image]' style='max-width: 500px'>";
                        }
                        else
                        {
                            $change = "profile";
                            echo"<img src='$userData[profile_image]' style='max-width: 500px;'>";
                        }

                        ?>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

</body>
</html>
