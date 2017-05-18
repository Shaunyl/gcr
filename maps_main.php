<?php

$directory = "";

$get_maps_html = file_get_contents($directory . "get_maps.php");

// load language file ($language is defined in "base.php").

$maps_main_string_html = file_get_contents($directory . $language . "/" . "maps_main_strings.php");

eval(" ?> " . $maps_main_string_html . " <?php ");
?>

<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyA6YV1t-1ZLO_axYLJAjzphsmTn9Wwdhps&sensor=false"></script>

<a href="<?php echo($directory); ?>maps_list.php"> <div id="map-canvas" style="width:300px;height:300px;"></div> </a>

<hr />

<a href="<?php echo($directory); ?>maps_list.php"> <img src="#" alt="ponente"/> </a>

<a href="<?php echo($directory); ?>maps_list.php"> <img src="#" alt="centro"/> </a>

<a href="<?php echo($directory); ?>maps_list.php"> <img src="#" alt="levante"/> </a>

<div id="map-canvas" style="width:300px;height:300px;"></div>

<script>
	var stockholm = new google.maps.LatLng(59.32522, 18.07002);

	var parliament = new google.maps.LatLng(59.327383, 18.06747);

	var marker;

	var map;

	function toggleBounce() {

		if (marker.getAnimation() != null) {

			marker.setAnimation(null);

		} else {

			marker.setAnimation(google.maps.Animation.BOUNCE);

		}

	}

	function initialize() {

		var mapOptions = {

			zoom : 13,

			center : stockholm

		};

		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);

		marker = new google.maps.Marker({

			map : map,

			draggable : true,

			animation : google.maps.Animation.DROP,

			position : parliament

		});

		//google.maps.event.addListener(marker, 'click', toggleBounce);

	}


	google.maps.event.addDomListener(window, 'load', initialize);

</script>

-->

