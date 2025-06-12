<?php
Class Settings
{
    private $error = "";
    public function checkPass($data)
    {
        foreach ($data as $key => $value)
        {
            if (empty($value))
            {
                $this->error = $this->error . $key . " is empty!<br>";
            }
            if ($key == "password")
            {
                if (strstr($value, " "))
                {
                    $this->error = $this->error . "Passwords cannot contain spaces<br>";
                if (strlen($value) < 8)
                {
                    $this->error = $this->error . "Password must be at least 8 characters long<br>";
                }
                }
                if (!preg_match('/[0-9]/', $value))
                {
                    $this->error = $this->error . "Password must contain at least one number<br>";
                }
                if (!preg_match('/[A-Z]/', $value))
                {
                    $this->error = $this->error . "Password must contain at least one uppercase letter<br>";
                }
                if (!preg_match('/[a-z]/', $value))
                {
                    $this->error = $this->error . "Password must contain at least one lowercase letter<br>";
                }
                if (!preg_match('/[^a-zA-Z0-9]/', $value))
                {
                    $this->error = $this->error . "Password must contain at least one special character<br>";
                }

            }
            if ($key == "confirm_password")
            {
                if (strstr($value, " "))
                {
                    $this->error = $this->error . "Passwords Names cannot contain spaces<br>";
                }
                if ($value !== $data['password'])
                {
                    $this->error = $this->error . "Passwords do not match<br>";
                }
            }
        }
        if ($this->error == "")
        {
            //no error so able to change password
            $this->changePassword($data);

        }
        else
        {
            return $this->error;//error
        }
    }
    public function changePassword($data)
    {

        $password =  hash("sha1", $data['password']);
        $userid =  $_SESSION['userid'];
        $query = "UPDATE users SET password = '$password' WHERE userid = '$userid'";
        $DB = new database();
        $result = $DB->save_to_db($query);
    }
}



?>