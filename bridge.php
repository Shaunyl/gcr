<?php 
    $directory = "";
    
    if (session_id() == '') {
        session_start();
    } 
    
    include($directory . "dbuser.php");
    include($directory . "cookies.php");
    // include($directory . "dblayer.php");
    $func = $_POST['func'];
    if ($func) {  
        switch ($func) {
            case 'updateUsername':      
                $username = $_POST['username'];
                
                if ($username != $_SESSION['s_username']) {
                    foreach ($dbuser -> existUser($username) as $user) {
                        echo false;
                        exit();
                    }
                    $isValid = $dbuser -> updateUsername($username, $_SESSION['s_user_id']);
                    if ($isValid) {
                        session_regenerate_id();
                        $_SESSION['s_username'] = $username;
                        session_write_close();
                        if($_SESSION['s_rememberme'] == true) {
                            echo setcookies(60);
                        }
                        
                        echo true;
                    } else {
                        echo false;
                    }
                }
                break;
            case 'updateProfile':
                $website = $_POST['website'];
                $location = $_POST['location'];
                $age = $_POST['age'];
                $realname = $_POST['realname'];
                $gender = $_POST['gender'];
                $isValid = $dbuser -> updateProfile($website, $location, $age, $realname, $gender, $_SESSION['s_user_id']);
                if ($isValid) {
                    echo true;
                } else {
                    echo false;
                }   
                break;
            case 'getBirth':
                $birth = '';
                foreach ($dbuser -> getBirth($_SESSION['s_user_id']) as $tuple) {
                    $birth = $tuple['birth'];
                }
                
                echo $birth;
                break;
            case 'updateAboutMe':
                $aboutme = $_POST['aboutme'];
                
                $isValid = $dbuser -> updateAboutMe($aboutme, $_SESSION['s_user_id']);
                if ($isValid) {
                    echo true;
                } else {
                    echo false;
                }   
                break;
            default:
                //function not found, error or something
                break;
        }
    }
?>