<?php


class Profile
{
    public function getProfile($id)
    {
        $id = addslashes($id);
        $DB = new database();
        $query = "SELECT * FROM users WHERE userid = '$id' LIMIT 1";
          return $DB->read_to_db($query);
    }
}
?>
