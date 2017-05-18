<?php

// variable for all parameters used with get request

$parameters = "";

$site = "";

$html_code = "";

foreach ($_GET as $key => $parameter) {

    if ($key == "site") {

        $site = $parameter;

    } else {

        if ($parameters != "") {

            $parameters .= "&";

        } else {

            $parameters .= "?";

        }

        $parameters .= $key . "=" . $parameter;

    }

}

if ($site != "") {

    $html_code = file_get_contents($site . $parameters);

    print($html_code);

}
?>