<html>
<head>
    <title>
        IrataynosBook - Profile
    </title>
</head>

<style>
    #top_bar{
        height: 50px;
        background-color: #405d9b;
        color: #d9dfeb;

    }
    #search_box{
        width: 400px;
        height: 20px;
        border-radius: 5px;
        border: none;
        padding: 4px;
        font-size: 14px;
        background-image: url("images/search.png");
        background-repeat: no-repeat;
        background-position: right;

    }
    #profile_pic{
        width: 150px;
        border-radius: 50%;
        border: solid 2px white;
    }
    #menu_btn{
        width: 100px;
        display: inline-block;
        margin: 2px;


    }
    #friends_pic{
        width: 75px;
        float: left;
        margin: 8px;

    }
    #friends_box{
        min-height: 400px;
        margin-top: 20px;
        color: #405d9b;
        padding: 8px;
        text-align: center;
        font-size: 20px;

    }
    #friends{
        clear: both;
        font-size: 12px;
        font-weight: bold;
        color: #405d9b;
    }
    textarea{
        width: 100%;
        border: none;
        font-family: Tahoma;
        font-size: 14px;
        height: 60px;
    }
    #post_btn{
        float: right;
        background-color: #405d9b;
        border: none;
        color: white;
        padding: 4px;
        font-size: 14px;
        border-radius: 2px;
        width: 50px;

    }
    #post_box{
        margin-top: 20px;
        background-color: white;
        padding: 10px;
    }
    #post{
        padding: 4px;
        font-size: 13px;
        display: flex;
        margin-bottom: 20px;
    }
</style>

<body style="font-family: Tahoma; background-color: #d0d8e4">
<br>
<!-- Profile Section -->
<div id = "top_bar">
    <div style="margin: auto; width: 800px; font-size: 30px;">
        IrataynosBook &nbsp;&nbsp; <input type="text" id="search_box" placeholder="Find Friends">
        <img src="images/selfie.jpg" style="width: 50px; float: right">
    </div>
</div>

<div id="content_box" style="width: 800px; margin: auto; min-height: 400px">

    <!-- Online Section -->
    <div style="display: flex; min-height: 400px">

        <!--Friends Section -->
        <div style="min-height: 400px; flex: 1;">
            <div id="friends_box">
                <img src="images/selfie.jpg" id="profile_pic"><br>
                Mary Bunda
            </div>
        </div>


        <!--Post Section -->
        <div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px">
            <div style="border: solid thin #aaa; padding: 10px; background-color: white">
                <textarea placeholder="What's on your mind?"></textarea>
                <input id="post_btn" type="submit" value="Post">
                <br><br>
            </div>

            <!-- See Posts -->
            <div id="post_box">
                <!-- Post -->
                <div id="post">
                    <div>
                        <img src="images/user1.jpg" style="width: 75px; margin-right: 4px">

                    </div>
                    <div>
                        <div style="font-weight: bold;color: #405d9b">First User Test</div>
                        Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails
                        <br><br>

                        <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 1 2024</span>

                    </div>
                </div>
                <div id="post">
                    <div>
                        <img src="images/user1.jpg" style="width: 75px; margin-right: 4px">

                    </div>
                    <div>
                        <div style="font-weight: bold;color: #405d9b">Second User Test</div>
                        Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails Lorem Ipsum blah blah blah shush u stink of cheese and your feet are broken with yellow toe nails
                        <br><br>

                        <a href="">Like</a> . <a href="">Comment</a> . <span style="color: #999;">April 1 2024</span>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

</body>
</html>