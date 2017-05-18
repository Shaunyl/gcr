<?php 
    function setcookies ($expire) {
        setcookie('user_id', $_SESSION['s_user_id'], time() + $expire * 60, '/');
        setcookie('username', $_SESSION['s_username'], time() + $expire * 60, '/');
    }
    
    function unsetcookies () {
        setcookie("user_id", "", 1, '/');
        setcookie("username", "", 1, '/');
    }
    
    function getcookies () {
        if (ISSET($_COOKIE['user_id'])) {
            $_SESSION['s_user_id'] = $_COOKIE['user_id'];
            $_SESSION['s_username'] = $_COOKIE['username'];
            $_SESSION['s_rememberme'] = true;
        } else {
            $_SESSION['s_rememberme'] = false;
        }
    }
?>