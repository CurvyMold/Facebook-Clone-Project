<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
    session_start();
    //print_r($_SESSION);

    include ("/home/cb20351437/classes/autoload.php");
    //isset($_SESSION['userid'])

    //logged in check
    $login = new Login();
    $userData = $login->check_login($_SESSION['userid']);
    $post = new Post();

    $error = "";
    if (isset($_GET['id']))
    {
        $ROW = $post->get_one_post($_GET['id']);

        if (!$ROW)//if row is false
        {
            $error = "No Such Post was found";
        }
        else
        {
           if ($ROW['userid'] != $_SESSION['userid'] || )
           {
               $error = "Access Denied!";
           }
        }
    }
    else
    {
        $error = "No Such Post was found";
    }
    //if something was posted
    if ($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $post->deletePost($_POST['postid']);
        header("Location: profile.php");
        die;
    }

?>

<html>
<head>
    <title>
        IrataynosBook - Delete Post
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

        <!--Post Section -->
        <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px">
            <div style="border: solid thin #aaa; padding: 10px; background-color: white">
                <form method="post">



                    <?php
                    if ($error != "")
                    {
                        echo $error;
                    }
                    else
                    {
                        echo "<b>Are you sure you want to delete this post?</b><br><hr>";
                        $user = new User();
                        $ROW_USER = $user->getData($ROW['userid']);
                        include("postdelete.php");
                         echo "<hr>";
                         echo "<input name='postid' type='hidden' value='$ROW[postid]'>";
                         echo "<input id='post_btn' type='submit' value='Delete'>";

                    }
                    ?>
                    <br>
                </form>

            </div>
        </div>
    </div>
</div>

</body>
</html>