<?php
if( !isset($directory) )
{
	$directory = "";
}

// $rate_id is the unique id of rate associated with map
if( isset($_GET["rate_id"]) )
{
	$rate_id = $_GET["rate_id"];
}
else
{
	$rate_id = rand();
}
	
$full_star_image = $directory."images/full_star.gif";
$empty_star_image = $directory."images/empty_star.gif";

// voting rate
$rate = 4;

// max rate
$max_rate = 5;

// numbers of voters
$voters = 0;

// if variable "vote" is set, add this value to 
// map rate. User voted.
if( isset($_GET["vote"]) )
{
	// TODO
	$voters++;
}

?>

<script>
if(typeof star_enlight<?php print($rate_id); ?> != 'function' )
{
	function star_enlight<?php print($rate_id); ?>(star_level)
	{
		var full_star_html = "<img src='<?php print($full_star_image); ?>' />";
		var empty_star_html = "<img src='<?php print($empty_star_image); ?>' />";
		
		
		document.getElementById("star_1_span<?php print($rate_id); ?>").innerHTML = empty_star_html;
		document.getElementById("star_2_span<?php print($rate_id); ?>").innerHTML = empty_star_html;
		document.getElementById("star_3_span<?php print($rate_id); ?>").innerHTML = empty_star_html;
		document.getElementById("star_4_span<?php print($rate_id); ?>").innerHTML = empty_star_html;
		document.getElementById("star_5_span<?php print($rate_id); ?>").innerHTML = empty_star_html;
		
		if( star_level > 4 )
		{
			document.getElementById("star_5_span<?php print($rate_id); ?>").innerHTML = full_star_html;
		}
		
		if( star_level > 3 )
		{
			document.getElementById("star_4_span<?php print($rate_id); ?>").innerHTML = full_star_html;
		}
		
		if( star_level > 2 )
		{
			document.getElementById("star_3_span<?php print($rate_id); ?>").innerHTML = full_star_html;
		}
		
		if( star_level > 1 )
		{
			document.getElementById("star_2_span<?php print($rate_id); ?>").innerHTML = full_star_html;
		}
		
		if( star_level > 0 )
		{
			document.getElementById("star_1_span<?php print($rate_id); ?>").innerHTML = full_star_html;
		}
		
	}
}

if( typeof vote != 'function' )
{	
	function vote(vote_value, rate_id)
	{
		$.ajax
		(
			{
				url: "<?php print($directory); ?>star_rate.php",
				type: 'get',
				data: "rate_id="+rate_id+"&vote="+vote_value,
				dataType: 'html',
				async: false,
				success: function(html_code)
				{
					$("div#star_rate_div"+rate_id).html(html_code);
				}
			}
		)
	}
}
	
// star level rate setting
star_enlight<?php print($rate_id); ?>(<?php print($rate); ?>);

</script>

<div id='star_rate_div<?php print($rate_id); ?>' class='star_rate_div'>
<span id='star_1_span<?php print($rate_id); ?>' onmouseover='star_enlight<?php print($rate_id); ?>(1);' onmouseup='vote(1,"<?php print($rate_id); ?>");'><img src="<?php print($empty_star_image); ?>" /></span>
<span id='star_2_span<?php print($rate_id); ?>' onmouseover='star_enlight<?php print($rate_id); ?>(2);' onmouseup='vote(2,"<?php print($rate_id); ?>");'><img src="<?php print($empty_star_image); ?>" /></span>
<span id='star_3_span<?php print($rate_id); ?>' onmouseover='star_enlight<?php print($rate_id); ?>(3);' onmouseup='vote(3,"<?php print($rate_id); ?>");'><img src="<?php print($empty_star_image); ?>" /></span>
<span id='star_4_span<?php print($rate_id); ?>' onmouseover='star_enlight<?php print($rate_id); ?>(4);' onmouseup='vote(4,"<?php print($rate_id); ?>");'><img src="<?php print($empty_star_image); ?>" /></span>
<span id='star_5_span<?php print($rate_id); ?>' onmouseover='star_enlight<?php print($rate_id); ?>(5);' onmouseup='vote(5,"<?php print($rate_id); ?>");'><img src="<?php print($empty_star_image); ?>" /></span>
<br />
<?php print($rate."/".$max_rate." (".$voters.")"); ?>
</div>