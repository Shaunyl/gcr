<?php
    $directory = "";

    // load language file ($language is defined in "base.php").
    $footer_string_html = file_get_contents($directory.$language."/"."footer_strings.php");
    
    eval(" ?> ".$footer_string_html." <?php ");
?>

<?php
    print($footer_title);
?>
<div class="bottombar">&nbsp;</div>