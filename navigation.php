<?php
    $directory = "";

    // load language file ($language is defined in "base.php").
    $navigation_string_html = file_get_contents($directory.$language."/"."navigation_strings.php");
    
    eval(" ?> ".$navigation_string_html." <?php ");
?>

<div class="menu" id="language_choice">
    <ul>
        <li class="home_menu_item">
            <a href="<?php print($directory); ?>index.php"><?php print($navigation_home); ?></a>
        </li>
        <li>
            <a href="<?php print($directory); ?>loginsignup.php"><?php print($navigation_login); ?></a>
        </li>
        <li>
            <a href="<?php print($directory); ?>maps.php"><?php print($navigation_maps); ?></a>
        </li>
        <li>
            <a href="?language=italian">
            <img src="<?php print($directory); ?>/gcr/images/flag_ita.gif" />
            </a>
        </li>
        <li>
            <a href="?language=english">
            <img src="<?php print($directory); ?>/gcr/images/flag_eng.gif" />
            </a>
        </li>
        <li>
            <a href="<?php print($directory); ?>users.php">Users</a> <!-- lang temp -->
            </a>
        </li>        
    </ul>
</div>