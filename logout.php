<?php
    $directory = "";
    
	include($directory . 'cookies.php');
	
    if (session_id() == '') {
    	session_start();
    }	
	
	session_unset();
	session_destroy();
	echo unsetcookies();
	// session_write_close(); ??
	header("Location: " . $directory . "login.php");
?>