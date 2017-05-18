<?php

	if( isset($_GET["maps_page"]) )
	{
		// request number
		$maps_page = $_GET["maps_page"];
	}
	else
	{
		// default value, if not specified
		$maps_page = 1;
	}
	
	if( isset($_GET["maps_page_size"]) )
	{
		// numbers of lines to read for every request
		$maps_page_size = $_GET["maps_page_size"];
	}
	else
	{
		// default value, if not specified
		$maps_page_size = 10;
	}

	if( $maps_page == 1 )
	{
?>

{
"maps_links" :
[
	{"name": 1, "link_map":"'origin=passeggiata+anita+garibaldi+genova&destination=passeggiata+anita+garibaldi+13+genova&mode=walking'", "link_altitude": "'path=44.3833919,9.032622|44.3800027,9.0515369&samples=40&key='", "length":1, "vote":1, "description": 1, "comments": 1},
	{"name": 2, "link_map":"'origin=corso+guglielmo+marconi+10-r+genova&destination=corso+italia+42+genova&mode=walking'", "link_altitude": "'path=44.396207,8.9441013|44.3912067,8.9670624&samples=40&key='", "length":2, "vote":2, "description": 2, "comments": 2},
	{"name": 3, "link_map":"'origin=piazza+montano+genova&destination=via+antonio+cantore+14+genova&mode=walking'", "link_altitude": "'path=44.4131457,8.887841|44.4132546,8.8888962&samples=40&key='", "length":3, "vote":3, "description": 3, "comments": 3}
],

"current_page" : 1,

"total_page" : 2
}

<?php	
	}
	else
	{
?>
{
"maps_links" :
[
	{"name": 4, "link_map":"'origin=via+pegli+69+genova&destination=via+ronchi+53+genova&mode=walking'", "link_altitude": "'path=44.4248519,8.7991484|44.4235833,8.8164555&samples=40&key='", "length":4, "vote":4, "description": 4, "comments": 4}
],

"current_page" : 2,

"total_page" : 2
}

<?php
	}
	
?>