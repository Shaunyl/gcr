<?php

	$directory = "";

	$get_maps_html = file_get_contents($directory."get_maps.php");

	// load language file ($language is defined in "base.php").
	$maps_main_list_string_html = file_get_contents($directory.$language."/"."maps_main_list_strings.php");
	
	eval(" ?> ".$maps_main_list_string_html." <?php ");
?>

<noscript>
Please enable JavaScript to view the 
<a href="http://disqus.com/?ref_noscript">comments powered by Disqus.</a>
</noscript>

<div id='maps_add_event'>
</div>
<div id='maps_div'>
</div>
<div id='altitude_div'>
</div>
<div id='maps_links'>
</div>
<div id='maps_comments'>
	<div id="disqus_thread">
		<script id='disqusScript'></script>
	</div>
</div>
<div id='links_footer'>
</div>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
var current_page = 0;
var total_page = 0;
var start_page = 1;
var maps_key = "AIzaSyA6YV1t-1ZLO_axYLJAjzphsmTn9Wwdhps";
	
//load google visualization library, version 1
google.load("visualization", "1", {packages:["corechart"]});

$('#maps_add_event').html( "<input type=\"button\" value=\"X\" class=\"close_button\" onclick=\"$('#maps_add_event').hide();\" /><br /><form>user name <input type=\"text\" /><br />event title <input type=\"text\" /><br />from <input type=\"text\" /><br />to <input type=\"text\" /><br />where <input type=\"text\" /><br /><input type=\"submit\" value=\"create event\" /></form>" );
</script>

<script>
function change_map(address)
{
	map_code = "<iframe width='600' height='450' frameborder='0' style='border:0' src='https://www.google.com/maps/embed/v1/directions?key="+maps_key+"&"+address+"' ></iframe>";
	
	
	$("div#maps_div").html(map_code);
}

function draw_graph(points_array) 
{
	chartArray = new Array();
	
	chartArray.push(["Point", "Altitude"]);
	for(i=0; i<points_array.length; i++)
	{
		chartArray.push([i, points_array[i]]);
	}
	
	var data = google.visualization.arrayToDataTable
		(
			chartArray
		);

	var options = {
	  title: 'Altitude',
	  curveType: 'function',
	  legend: { position: 'bottom'}
	};

	var chart = new google.visualization.LineChart(document.getElementById('altitude_div'));
	chart.draw(data, options);
}

function create_altitude_graph(address)
{
	altitude_url = "get_site.php?site=https://maps.googleapis.com/maps/api/elevation/json";
	
	//altitude_data = "path=44.3833919,9.032622|44.3800027,9.0515369&samples=40&key=";
	altitude_data = address;
	
	$.ajax
		({
			type: "GET",
			url: altitude_url,
			data: altitude_data,
			crossDomain: true,
			dataType: "json",
			success: function(json) 
			{
				var altitude_array = new Array();
				for(i=0; i<json.results.length; i++)
				{
					altitude_array.push( json.results[i].elevation );
				}
				
				draw_graph(altitude_array);
			},
			error: function(json)
			{
				alert("NOT ok");
			}
		});
}

</script>

<script>
function stars_rate_image(rate_id)
{
	var html = "";
	
	$.ajax
	(
		{
			url: "<?php print($directory); ?>star_rate.php?",
			type: 'get',
			data: "rate_id="+rate_id,
			dataType: 'html',
			async: false,
			success: function(html_code)
			{
				html = html_code;
			}
		}
	)

	return html;
}

function maps_links_loader(page)
{
	$.ajax
	({
		url: "<?php print($directory); ?>get_maps.php",
		type: "GET",
		dataType: "json",
		data: "maps_page="+page,
		success: function(obj) 
		{
			var table = "<table>";
			
			current_page = obj.current_page;
 			total_page = obj.total_page;
			
			for( i=0; i<obj.maps_links.length; i++ )
			{
			
				table += "<tr>";
				table += "<td>";
				table += obj.maps_links[i].name;
				table += "</td>";
				table += "<td>";
				table += "<a onclick=\"change_map("+obj.maps_links[i].link_map+");create_altitude_graph("+obj.maps_links[i].link_altitude+"); create_disqus('"+obj.maps_links[i].name+"');\"><?php print($open_map); ?></a>";
				table += "</td>";
				table += "<td>";
				table += obj.maps_links[i].length;
				table += "</td>";
				table += "<td>";
				table += stars_rate_image(obj.maps_links[i].name);
				table += " - "+obj.maps_links[i].vote;
				table += "</td>";
				table += "<td>";
				table += obj.maps_links[i].description;
				table += "</td>";
				table += "<td>";
				table += obj.maps_links[i].comments;
				table += "</td>";
				table += "<td>";
				table += "<input type='submit' value='<?=$add_event; ?>' onclick='$(\"#maps_add_event\").show();' />";
				table += "</td>";
				table += "</tr>";
			}
			
			table += "</table>";
			
			$("div#maps_links").html(table);
			
			create_links_footer(start_page, total_page, current_page, "links_footer", "maps_links_loader");
		},
		error: function(request, status, errors)
		{
			alert("maps_links_loader error");
		}
	})
}
</script>

<script>
function create_links_footer(start, length, current, component_name, function_name)
{
	var links = "";
	for( i=start; i<start+length; i++ )
	{
		if( i == current )
		{
			links += " - <b>"+i+"</b> - ";
		}
		else
		{
			links += "<a onclick='"+function_name+"("+i+");'>";
			links += " - "+i+" - ";
			links += "</a>";
		}
	}
	$("#"+component_name).html(links);
	//maps_links_loader(2);
}
</script>

<script>
maps_links_loader(1);
</script>

<script>
create_links_footer(start_page, total_page, current_page, "links_footer", "maps_links_loader");
</script>

<script>

/*
function disqus_reset(identifier)
{
	return "DISQUS.reset({reload: true,config: function (){this.page.identifier = \""+identifier+"\";this.page.url = window.location.href + '/#!' + "+identifier+";}});";
}
*/


function initialize_disqus() 
{
	var disqus_shortname = 'createmysite2'; // required: replace example with your forum shortname
	var disqus_identifier = '';
	var disqus_url = '';
	var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
	
	// it hides disqus div, it was created for initialization
	$("div#disqus_thread").hide();
	
	dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
}

function create_disqus(identifier)
{
	/* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        //var disqus_shortname = 'createmysite2'; // required: replace example with your forum shortname
		disqus_identifier = identifier;
		disqus_url = window.location.href + '/#!' + identifier;

		// it shows disqus div (it has been hidden by initialize_disqus function)
		$("div#disqus_thread").show();
		
        /* * * DON'T EDIT BELOW THIS LINE * * */
		if( window.DISQUS )
		{
			DISQUS.reset(
				{
					reload: true,
					config: function()
					{
						this.page.identifier = disqus_identifier;
						this.page.url = disqus_url;
					}
				}
			);
		}
		else
		{
			/*
			 (function() {
				var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
				dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
				(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			})();
			*/
			/*
			var dsq = document.createElement('script'); 
			dsq.type = 'text/javascript'; 
			dsq.async = true;
			dsq.src = 'http://' + disqus_shortname + '.disqus.com/embed.js';
			dsq.innerHTML = disqus_reset(identifier);
			$('script[src="' + dsq.src + '"]').remove();
			(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
			*/
		}
}
</script>

<script>
initialize_disqus();
</script>

