<?php
    $directory = "";

    // load language file ($language is defined in "base.php").
    $sidebar_string_html = file_get_contents($directory.$language."/"."sidebar_strings.php");
    
    eval(" ?> ".$sidebar_string_html." <?php ");
?>

<?php
    print($sidebar_title);
?>

<br/> <br/> <a href='<?php print($directory); ?>maps.php'>m a p s</a>