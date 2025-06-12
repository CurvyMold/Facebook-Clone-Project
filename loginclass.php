<?php
session_start();
require_once 'connect.php';
    class Login
    {
        private $error = "";

        public function encript($text)
        {
            return hash("sha1", $text);
        }
        public function evaluate($data)
        {
            $email = $data['email'];
            $password = $data['password'];

            $query = "SELECT * from users WHERE email = '$email' limit 1";//not checking both pass and email because its saver from sql attack
            // echo $query;
            $DB = new database();
            $result = $DB->read_to_db($query);

            if ($result)
            {
               $row = $result[0];
               if($this->encript($password) == $row['password'])
               {
                   //create session data
                   $_SESSION['userid'] = $row['userid'];//any value assigned to session will be avaliable across the site for a logged-in user

                   /*
                    * if ($row['isAdmin'] == 1)
                       {
                           header("Location: adimin.php");
                       }
                    */


               }
               else
               {
                   $this->error .= "Wrong password or email<br>";
               }

            }
            else
            {
                $this->error .= "Wrong password or email<br>";
            }
            return $this->error;
        }
        public function check_login($id)
        {
            if (is_numeric($id))//checks if session is set and if it's a numeric value
            {

                $query = "SELECT * from users WHERE userid = '$id' limit 1";//limit 1 because we just want one record
                // echo $query;
                $DB = new database();
                $result = $DB->read_to_db($query);

                if ($result)
                {
                    $userData = $result[0];
                    return $userData;

                }
                else
                {
                    header("Location: login.php");
                    die;
                }
                //if logged in retrieves data
            }
            header("Location: login.php");
            die;
        }

    }

//check if user is logged-in

/*old code
if (isset($_SESSION['userid']) && is_numeric($_SESSION['userid']))//checks if session is set and if it's a numeric value
{
    $id = $_SESSION['userid'];
    $login = new Login();

    $result = $login->check_login($id);//check if true or false

    if ($result)
    {
        //if logged in retrieves data
        $user = new User();
        $userData = $user->getData($id);
        if (!$userData)
        {
            header("Location: login.php");
            die;
        }
    }
    else
    {
        header("Location: login.php");
        die;
    }

}
else
{
    header("Location: login.php");
    die;
}
*/
?>
