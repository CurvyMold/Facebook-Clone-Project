<?php
//Check if user is logged in and has admin role
// This code should be placed at the beginning of the admin page
session_start();

//if (!isset($_SESSION['user_id']) || $_SESSION['isAdmin'] !== '1') {
    // Redirect non-admin users to a login page or display an error message
  // header("Location: login.php");
  //  exit();
//}

// Include necessary files and initialize database connection
include ("/home/cb20351437/classes/autoload.php");
$db = new Database();

// Handle password reset action
if (isset($_POST['reset_password'])) {
    $user_id = $_POST['user_id']; // Assuming user_id is passed via POST
    $new_password = generate_random_password(); // Function to generate a random password
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Update the user's password in the database
    $db->save_to_db("UPDATE users SET password = '$hashed_password' WHERE id = $user_id");
    // Send the new password to the user via email or display it on the admin page
}

// Handle user deletion action
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id']; // Assuming user_id is passed via POST

    // Delete the user from the database
    $db->save_to_db("DELETE FROM users WHERE id = $user_id");
    // Optionally, delete associated data like posts
    // $db->query("DELETE FROM posts WHERE user_id = $user_id");
}

// Handle post deletion action
if (isset($_POST['delete_post'])) {
    $post_id = $_POST['post_id']; // Assuming post_id is passed via POST

    // Delete the post from the database
    $db->save_to_db("DELETE FROM posts WHERE id = $post_id");
}

// Retrieve users and posts from the database
$users = $db->read_to_db("SELECT * FROM users");
$posts = $db->read_to_db("SELECT * FROM posts");

// Display the admin page HTML

?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
</head>
<body>
<h1>Welcome to the Admin Page</h1>

<h2>Password Reset</h2>
<form method="post">
    <select name="user_id">
        <?php foreach ($users as $user): ?>
            <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
        <?php endforeach; ?>
    </select>
    <button type="submit" name="reset_password">Reset Password</button>
</form>

<h2>User Management</h2>
<ul>
    <?php foreach ($users as $user): ?>
        <li>
            <?php echo $user['username']; ?>
            <form method="post">
                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                <button type="submit" name="delete_user">Delete User</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>

<h2>Post Management</h2>
<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <?php echo $post['title']; ?>
            <form method="post">
                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                <button type="submit" name="delete_post">Delete Post</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>
