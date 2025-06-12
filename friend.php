<div id="friends">
    <?php
    $image = "images/user_female.jpg";

    if(file_exists($friends_ROW['profile_image']))
    {
        $image = $friends_ROW['profile_image'];
    }

    ?>
    <a href="profile.php?id=<?php echo "$friends_ROW[userid]"?>" style="text-decoration: none; color: #405d9b;">
        <img id="friends_pic" src="<?php echo $image?>">
        <br>
        <?php
        echo $friends_ROW['first_name'] . " " . $friends_ROW['last_name'];
        ?>
    </a>

</div>