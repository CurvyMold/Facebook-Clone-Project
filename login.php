<?php

    session_start();
    include ("/home/cb20351437/classes/connect.php");
    include ("/home/cb20351437/classes/loginclass.php");

    /*Password Hash Testing
     *  $DB = new database();
    $sql = "SELECT * FROM users";
    $result = $DB->read_to_db($sql);

    foreach ($result as $row)
    {
        $id = $row['id'];
        $password = hash("sha1", $row['password']);//sha1 is the algorithm for password hashing should return a 40 char string
        $sql = "UPDATE users SET password = '$password' WHERE id = '$id' LIMIT 1";
    }

    $DB->save_to_db($sql);
     */
    $email = "";
    $password = "";


    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $login = new Login();
        $result = $login-> evaluate($_POST);

        if ($result != "")#will only run if errors occurred
        {
            echo "<div style='text-align: center; font-size: 12px; color: white; background-color: gray'>";
            echo "<br>The following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
        else
        {

            header("Location: profile.php");#redirects to other php file if no errors
            die;#nicely tells script to end here
        }

        $password = $_POST['password'];
        $email = $_POST['email'];



        //echo"<pre>";
        // print_r($_POST);
        //  echo"<pre>";


        //echo"<pre>";
        // print_r($_POST);
        //  echo"<pre>";
    }


?>
<html xmlns="http://www.w3.org/1999/html">
 <head>
    <title>
        IrataynosBook - Log in
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
         height: 200px;
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
       <a href="help.php"><div id="signup_btn"> Help </div></a>
       <a href="signup.php"><div id="signup_btn"> Signup </div></a>


   </div>

   <div id="login_box">

       <form method="post">
           Login to IrataynosBook<br><br>
           <input name="email" value="<?php echo htmlspecialchars($email)?>" type="text" id="text" placeholder="Email"><br><br>
           <input name="password" value="<?php echo htmlspecialchars($password)?>" type="password" id="text" placeholder="Password"><br><br>

           <input type="submit" id="button" value="Log In">
           <br><br><br><br>
       </form>
   </div>
 </body>
</html>