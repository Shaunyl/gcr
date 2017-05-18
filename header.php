<?php
    $directory = "";

    // load language file ($language is defined in "base.php").
    $headers_string_html = file_get_contents($directory.$language."/"."header_strings.php");
    
    eval(" ?> ".$headers_string_html." <?php ");
?>

<?php
    print($header_title);
?>
<div class="topbar">
    <a href="index.php">
        <strong>Genova City Runners</strong>
        <img src="images/logreg/gcr_tree.png">
    </a>
</div>