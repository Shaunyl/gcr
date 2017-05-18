<?php

    $directory = "";

    // load language file ($language is defined in "base.php").
    $main_string_html = file_get_contents($directory.$language."/"."main_strings.php");

    eval(" ?> ".$main_string_html." <?php ");
?>

<?php
    print($main_title);
?>