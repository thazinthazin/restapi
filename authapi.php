<?php
    //https://docs.moodle.org/dev/Authentication_API
    require('../config.php');
    require_once('lib.php');
    //require_once('../lib/moodlelib.php');
    $user = false;
    
    if(isset($_POST['username']) && isset($_POST['password']))
    {
        //$user = authenticate_user_login($_POST['username'], $_POST['password'],false,0);
        //$2y$10$5YGkXvoVOuWzTmWbCWsPg.kQ/n.aJVOgcCRWVOMxjWPUmJiUMK/D.
        //$2y$10$5DOWMgER2VUNUm7IcWVXz.V0aIf35oae8dYevIeHwGOBihVsBiMO6
        $password = $_POST['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        echo $_POST['username'] . '<br />';
        echo $hash . '<br />';
        if(password_verify($password, "$2y$10$5DOWMgER2VUNUm7IcWVXz.V0aIf35oae8dYevIeHwGOBihVsBiMO6")){
            //success
            echo "OK";
        }
        else{
            //failed
            echo "Failed";
        }
    }
    else
    {
        echo "<form action='authapi.php' method='post'>";
        echo "<input type='text' name='username' />";
        echo "<input type='text' name='password' />";
        echo "<input type='submit' value='Submit' />";
        echo "</form>";
    }
    
