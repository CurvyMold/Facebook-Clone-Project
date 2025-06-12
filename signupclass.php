<?php
   require_once 'connect.php';
    class Signup
    {
        private $error = "";
        public function evaluate($data)
        {
           foreach ($data as $key => $value)
           {
               if (empty($value))
               {
                   $this->error = $this->error . $key . " is empty!<br>";
               }
               if ($key == "email")
               {
                   if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value))
                   {
                       $this->error = $this->error . "Invalid Email<br>";
                   }

                   $email = $data['email'];

                   // Check if email already exists
                   $email_exists_query = "SELECT COUNT(*) as count FROM users WHERE email = '$email'";
                   $DB = new database();
                   $email_exists_result = $DB->read_to_db($email_exists_query);

                   if ($email_exists_result && isset($email_exists_result[0]['count']) && $email_exists_result[0]['count'] > 0) {
                       // Email already exists, return error
                       $this->error = $this->error . "Email already in use!<br>";
                   }

               }
               if ($key == "first_name")
               {
                   if (is_numeric($value))
                   {
                       $this->error = $this->error . "Names cannot contain numbers<br>";
                   }
                   if (strstr($value, " "))
                   {
                       $this->error = $this->error . "Names cannot contain spaces<br>";
                   }
               }
               if ($key == "last_name")
               {
                   if (is_numeric($value) || strstr($value, " "))
                   {
                       $this->error = $this->error . "Names cannot contain numbers<br>";
                   }
                   if (strstr($value, " "))
                   {
                       $this->error = $this->error . "Names cannot contain spaces<br>";
                   }
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
               //no error so able to create user
               $this->create_user($data);
           }
           else
           {
               return $this->error;//error
           }


        }
        public function create_user($data)
        {

            $first_name = ucfirst($data['first_name']);
            $last_name = ucfirst($data['last_name']);
            $gender = $data['gender'];
            $email = $data['email'];
            $password = hash("sha1", $data['password']);
            $admin = "0";

            #create these
            $url_address = strtolower($first_name) . "." .strtolower($last_name);
            $userid = $this->create_userid();

            $query = "INSERT INTO users 
            (userid,first_name,last_name,gender,email,password,url_address,isAdmin) 
            VALUES
            ('$userid','$first_name','$last_name','$gender','$email','$password','$url_address','$admin')";
           // echo $query;
           $DB = new database();
           $result = $DB->save_to_db($query);

           //Test for User Creation
           //  if ($result) {
           //      return "User created successfully";
           //  }
           //  else
           //  {
           //       return "Error creating user";
           //   }
        }

        private function create_userid()
        {
            $length = rand(4,19);
            $number = "";
            for ($i=0; $i < $length  ;$i++)
            {
                $new_rand = rand(0,9);
                $number = $number . $new_rand;
            }
            return $number;
        }
    }

?>