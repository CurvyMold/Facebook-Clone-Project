
<div id="post">
    <div>
        <?php
        $image = "images/user_female.jpg";

        if(file_exists($ROW_USER['profile_image']))
        {
            $image = $ROW_USER['profile_image'];
        }
        ?>

        <img src="<?php echo $image?>" style="width: 75px; margin-right: 4px; border-radius: 50%">

    </div>
    <div style="width: 100%">
        <div style="font-weight: bold;color: #405d9b;">
            <?php
            echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name'];
            ?>
        </div>
        <?php echo htmlspecialchars($ROW['post']); ?><!--tells the html to treat any js as literally instead of code input -->
        <br><br>

        <?php
        if ($ROW['image'] != "")
        {
            echo "<img src='$ROW[image]'";
        }
        ?>

        <br><br>

        <a href="">Like</a> . <a href="">Comment</a> .
        <span style="color: #999;">
            <?php
            echo $ROW['date']
            ?>
        </span>
        <span style=" color: #999;float: right;">

            <?php
            $post = new Post();
            if ($post->ownPost($ROW['postid'], $_SESSION['userid']))
            {
                echo "<a href='edit.php' style='color: #999; text-decoration: none;'>Edit</a>
                    .
                  <a href='delete.php?id=$ROW[postid]' style='color: #999; text-decoration: none;'>Delete</a>";
            }
            ?>



        </span>
    </div>
</div>