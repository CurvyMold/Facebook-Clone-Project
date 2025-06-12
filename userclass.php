<?php
    class User
    {
        public function getAllUsers()
        {
            $query = "SELECT * FROM users";
            $DB = new database();
            $result = $DB->read_to_db($query);

            if ($result) {
                return $result;
            } else {
                return false;
            }
        }

        public function getData($id)
        {
            $query = "SELECT * from users WHERE userid = '$id' limit 1";
            $DB = new database();
            $result = $DB->read_to_db($query);

            if($result)
            {
                $row = $result[0];//assign first row of the array to row and return it
                return $row;
            }
            else
            {
                return false;
            }

        }
        public function getUser($id)
        {
            $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
            $DB = new database();
            $result = $DB->read_to_db($query);

            if ($result)
            {
                return $result[0];
            }
            else
            {
                return false;
            }

        }
        public function getFriends($id)
        {
            $query = "SELECT * FROM users WHERE userid != '$id' ";//not equal to since you are not your own friend
            $DB = new database();
            $result = $DB->read_to_db($query);

            if ($result)
            {
                return $result;
            }
            else
            {
                return false;
            }
        }
        public function deleteUser($userid)
        {
            if (!is_numeric($userid))//check to make sure it is definately a number
            {
                return false;
            }

            $query = "DELETE FROM users WHERE userid = '$userid'";
            $DB = new database();
            $DB->save_to_db($query);

            return true;

        }
        public function resetUserPassword($userid)
        {
            if (!is_numeric($userid))//check to make sure it is definately a number
            {
                return false;
            }
            $password = hash("sha1", 'password');
            $query = "UPDATE users SET password = '$password' WHERE userid = '$userid'";
            $DB = new database();
            $DB->save_to_db($query);

            return true;

        }


        /*public function deleteUserPosts($userid)
        {
            if (!is_numeric($userid))//check to make sure it is definately a number
            {
                return false;
            }
            $query = "DELETE * FROM posts WHERE userid = '$userid'";

            $DB = new database();
            return $DB->save_to_db($query);

        }*/
    }

?>