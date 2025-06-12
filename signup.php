<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    include ("/home/cb20351437/classes/connect.php");
    include ("/home/cb20351437/classes/signupclass.php");

    $first_name = "";
    $last_name = "";
    $gender = "";
    $email = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $signup = new Signup();
        $result = $signup-> evaluate($_POST);

        if ($result != "")#will only run if errors occurred
        {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: gray'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
        else
        {
           header("Location: login.php");#redirects to other php file if no errors
           die;#nicely tells script to end here
        }

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $gender = $_POST['gender'];
        $email = $_POST['email'];



        //echo"<pre>";
       // print_r($_POST);
      //  echo"<pre>";
    }


?>

<html>
<head>
    <title>
        IrataynosBook - Signup
    </title>
</head>
<style>
    #bar{
        height: 100px;
        background-color: #3c5a99;
        color: #d9dfeb;
        padding: 4px;

    }
    #signup_btn{
        background-color: #42b72a;
        width: 70px;
        text-align: center;
        padding: 4px;
        border-radius: 4px;
        float: right;
    }
    #login_box{
        background-color: white;
        width: 800px;
        height: auto;
        margin: auto;
        margin-top:50px;
        padding: 10px;
        padding-top: 50px;
        text-align: center;
        font-weight: bold;
    }
    #text{
        height: 40px;
        width: 300px;
        border-radius: 4px;
        border: solid 1px #ccc;
        padding: 4px;
        font-size: 14px;
    }
    #button{
        width: 300px;
        height: 40px;
        border-radius: 4px;
        border: none;
        background-color: #3c5a99;
        color: white;
    }

</style>
<body style="font-family: Tahoma;background-color: #e9ebee;">
    <div id="bar">
        <div style="font-size: 40px;"> IrataynosBook </div>
        <a href="login.php"><div id="signup_btn"> Log In </div></a>

    </div>

    <div id="login_box">
        Signup to IrataynosBook<br><br>

        <form method="post" action="">


            <input value="<?php echo htmlspecialchars($first_name)?>"  name="first_name" type="text" id="text" placeholder="First Name"><br><br>
            <input value="<?php echo htmlspecialchars($last_name)?>" name="last_name" type="text" id="text" placeholder="Last Name"><br><br>

            <span style="font-weight: normal">Gender:</span><br><br>
            <select name="gender" id="text">
                <option><?php echo $gender?></option>
               <option>Male</option>
               <option>Female</option>
               <option>Other</option>
            </select><br><br>
            <input <?php echo htmlspecialchars($email)?> name="email" type="text" id="text" placeholder="Email"><br><br>

            <input name="password" type="password" id="text" placeholder="Password"><br><br>
            <input name="confirm password" type="password" id="text" placeholder="Confirm Password"><br><br>

            <input type="submit" id="button" value="Sign Up">
            <br><br><br><br>
        </form>
    </div>
</body>
</html>