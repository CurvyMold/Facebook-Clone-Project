<?php

    session_start();

    if (isset($_SESSION['userid']))
    {
        $_SESSION['userid'] = NULL;//removes abilty to backspace into someone elses profile
        unset($_SESSION['userid']);
    }


    header("Location: login.php");
    die;
?>