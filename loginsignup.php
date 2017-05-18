<?php
    $directory = "";

    include($directory . 'cookies.php');

    if (session_id() == '') {
        session_start();
    }

    echo getcookies();

    // This is a protected page: check if there is need to redirect..
    if (ISSET($_SESSION['s_user_id'])) {
        header("Location: " . $directory . "dashboard.php");
    }
    
    // code of page blocks
    $page_elements_name = array("header" => $directory . "header.php"
        , "navigation" => $directory . "navigation.php"
        , "main" => $directory . "loginsignup_main.php"
        , "sidebar" => $directory . "sidebar.php"
        , "footer" => $directory . "footer.php");
    
    $_SESSION["page_elements_name"] = $page_elements_name;
    $base_page = $directory . "base.php";
    
    // file_get_contents (PHP 4.3.0+): Reads entire file into a string
    $html_page = file_get_contents($base_page);
    
    // adjust directory
    $html_page = str_ireplace("\$directory = \"", "\$directory = \"" . $directory, $html_page);
    
    $stylesheet = "/gcr/css/loginsignup.css";
    if( $stylesheet != "" ) {
        // add stylesheets
        $html_page = str_ireplace("\$stylesheets = \"", "\$stylesheets = \"".
            "<link href='$directory$stylesheet' rel='stylesheet' type='text/css' />", $html_page);
    }
        
    // This function returns a string or an array with all occurrences of $stylesheets in $html replaced with the second argument..
    eval(" ?>" . $html_page . " <?php ");
?>