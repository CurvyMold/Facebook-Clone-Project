<?php

require_once 'connect.php';
   class Post
   {
       private $error = "";
       public function create_post($userid, $data, $files)
       {
           //print_r($data['post']);
            //|| isset($data['isCover'])
           //|| isset($data['isProfile'])
           if (!empty($data['post'] || !empty($files['file']['name'])))//if not empty post
           {
               $myimage = "";
               $hasimage= 0;

               if (!empty($files['file']['name']))
               {

                       $folder = "uploads/" . $userid . "/";//creating a personal folder for all users to stop users deleting others data

                       if (!file_exists($folder))
                       {
                           mkdir($folder, 0777, true);//the true means create all folders needed to create desired folder
                           file_put_contents($folder . "blank.php" , "");//this creates a blank file which will load if people try to manipluate the site
                       }

                       $imageClass = new Image();
                       $myimage = $folder . $imageClass->generateFilename(15) . ".jpg";//concat the jpg to ensure browser loads file as ana image

                       move_uploaded_file($_FILES['file']['tmp_name'], $myimage);

                       $imageClass->cropImage($myimage, $myimage, 600, 600);
                       $hasimage= 1;
               }

               $post = "";
               if (isset($data['post']))
               {
                   $post = $data['post'];//add slashes help prevent sql injections
               }

               $postid = $this->create_postid();

               $comments= 0;
               $likes= 0;
               $query = "INSERT INTO posts (userid, postid, post, comments, likes, image,hasimage) values ('$userid', '$postid', '$post', '$comments','$likes',' $myimage','$hasimage')";

               $DB = new database();
               $DB->save_to_db($query);
           }
           else
           {
               $this->error .= "Empty Post!";
           }
           return $this->error;
       }

       private function create_postid()//creates a random number so id
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
       public function getAllPosts()
       {
           $query = "SELECT * FROM posts ORDER BY date desc ";//desc as you want the latest posts first

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

       public function get_posts($id)
       {
           $query = "SELECT * FROM posts WHERE userid = '$id' ORDER BY id desc limit 10";//desc as you want the latest posts first

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
       public function get_one_post($postid)
       {
           if (!is_numeric($postid))//check to make sure it is definately a number
           {
               return false;
           }
           $query = "SELECT * FROM posts WHERE postid = '$postid' LIMIT 1";//desc as you want the latest posts first

           $DB = new database();
           $result = $DB->read_to_db($query);

           if ($result)//if true
           {
               return $result[0];
           }
           else
           {
               return false;
           }
       }
       public function deletePost($postid)
       {
           if (!is_numeric($postid))//check to make sure it is definately a number
           {
               return false;
           }
           $query = "DELETE FROM posts WHERE postid = '$postid' LIMIT 1";//desc as you want the latest posts first

           $DB = new database();
           return $DB->save_to_db($query);

       }

       public function ownPost($postid, $userid)
       {
           if (!is_numeric($postid))//check to make sure it is definately a number
           {
               return false;
           }
           $query = "SELECT * FROM posts WHERE postid = '$postid' LIMIT 1";//Select desired post

           $DB = new database();
           $result = $DB->read_to_db($query);

           if (is_array($result))
           {
               //add admin check here
               if ($result[0]['userid'] == $userid)
               {
                   return true;
               }
           }
           return false;

       }
   }
?>