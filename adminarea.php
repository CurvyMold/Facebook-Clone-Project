<?php
session_start();

include ("/home/cb20351437/classes/autoload.php");

$login = new Login();
$userData = $login->check_login($_SESSION['userid']);

/*Check if the user is an admin*/
if ($userData['isAdmin'] != 1) {
    // Redirect to the home page or display an error message
    header("Location: login.php");
    exit;
}

// Get all posts and all users
$post = new Post();
$posts = $post->getAllPosts();

$user = new User();
$users = $user->getAllUsers();

// Handle post or user deletion
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['postid'])) {
        // Delete post
        $post->deletePost($_POST['postid']);
    }
    /*
    if (isset($_POST['userid'])) {
        // Delete user
        $user->deleteUser($_POST['userid']);
        //$user->deleteUserPosts($_POST['userid']);
    }
    if (isset($_POST['reset_password'])) {
        // Reset password to 'password'
        $user->resetUserPassword($_POST['userid']);
    }*/

    if (isset($_POST['userid'])) {
        // Delete user
        if (isset($_POST['reset_password'])) {
            // Reset password to 'password'
            $user->resetUserPassword($_POST['userid']);
        } else {
            // Delete user
            $user->deleteUser($_POST['userid']);
            //$user->deleteUserPosts($_POST['userid']);
        }
    }

    // Redirect to prevent form resubmission
    header("Location: adminarea.php");
    //    exit;

}
?>
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
<html>
<head>
    <title>IrataynosBook - Admin Panel</title>
    <!-- Include any necessary stylesheets -->
</head>
<body>
<!-- Header section -->
<?php include "header.php"?>

<!-- Admin Panel -->
<div id="admin_panel" style="width: 800px; margin: auto; min-height: 400px">
    <h2>Admin Panel</h2>

    <div id="content_box" style="width: 800px; margin: auto; min-height: 400px">
        <div style="background-color: white; text-align: center; color: #405d9b">
                <span style="font-size: 12px;">
                  <?php
                  $image = "images/user_female.jpg";
                  ?>
                  <img id="profile_pic" src="<?php echo $image?>"><br>
                </span>
                <br><br>

                <div style="font-size: 20px">
                    <?php
                    echo "Admin";
                    ?>
                </div>
        </div>
        <!-- Online Section -->
        <div style="display: flex; min-height: 400px">
            <!--Post Section -->
            <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px">


                <!-- Display all posts-->
                <div id="post_box">
                    <hr><br> <h3>All Posts</h3>
                    <?php
                    if ($posts)
                    {
                        foreach ($posts as $ROW)//each time this is loaded row will contain the data wanted for posts
                        {

                            $user = new User();
                            $ROW_USER = $user->getUser($ROW['userid']);
                            //var_dump($ROW['image']);
                            include ("adminposts.php");

                            echo "<form method='post' style='display: inline; float: right;'>
                                  <input type='hidden' name='postid' value='$ROW[postid]'>
                                  <button type='submit'>Delete</button>
                                  </form>";
                            echo "<br><br><hr>";
                        }
                    }
                    ?>
                </div>
                <div id="post_box">
                    <h3>All Users</h3>
                    <?php
                    if ($users)
                    {
                        foreach ($users as $ROW)//each time this is loaded row will contain the data wanted for users
                        {
                            $user = new User();
                            $ROW_USER = $user->getUser($ROW['userid']);
                            //var_dump($ROW['image']);
                            include ("adminposts.php");

                            echo "<form method='post' style='display: inline; float: right;'>
                                  <input type='hidden' name='userid' value='$ROW[userid]'>
                                  <button type='submit'>Delete</button>
                                  </form>";
                            echo "<form method='post' style='display: inline; float: right;'>
                                  <input type='hidden' name='userid' value='$ROW[userid]'>
                                  <button type='submit' name='reset_password'>Reset Password</button>
                                  </form>";
                            echo "<br><br><hr>";
                        }
                    }
                    ?>

                </div>
            </div>
        </div>

       <!-- <h3>All Users</h3>-->
        <?php /* if (!empty($users)): ?>
            <ul>
                <?php foreach ($users as $user): ?>
                    <li>
                        <?php echo $user['username']; ?>
                        <!-- Form to delete user -->
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="userid" value="<?php echo $user['userid']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No users found.</p>
        <?php endif; */?>
   </div>
</div>
</body>
</html>
