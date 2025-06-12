<?php
        $image = "images/user_female.jpg";
        /* if(file_exists($userData['profile_image']))
                {
                   // $image = $userData['profile_image'];
                    $imageClass = new Image();
                    $image = $imageClass->getThumbProfile($userData['profile_image']);

                }
         *
         */

        if(file_exists($USER['profile_image']) && isset($USER))
        {
            // $image = $userData['profile_image'];
            $imageClass = new Image();
            $image = $imageClass->getThumbProfile($USER['profile_image']);

        }
?>
<div id = "top_bar">
    <div style="margin: auto; width: 800px; font-size: 30px;">
        <a href="index.php" style="color: white; text-decoration: none">IrataynosBook</a>  &nbsp;&nbsp; <input type="text" id="search_box" placeholder="Find Friends">
        <a href="profile.php"><img src="<?php echo $image?>" style="width: 50px; float: right"></a>

        <a href="logout.php">
                  <span style="font-size: 11px; float: right; margin: 10px; color: white;">
                      Logout
                  </span>
        </a>
    </div>
</div>