<?php

	$directory = "";

	// load language file ($language is defined in "base.php").
	$calendar_string_html = file_get_contents($directory.$language."/"."calendar_strings.php");
	
	eval(" ?> ".$calendar_string_html." <?php ");
	
	// delete this line
	$_SESSION["s_username"] = "Mario";
?>

<link rel="stylesheet" type="text/css" href="<?php print($directory); ?>calendar/css/frontierCalendar/jquery-frontier-cal-1.3.2.css" />
<!-- Include CSS for color picker plugin (Not required for calendar plugin. Used for example.) -->
<link rel="stylesheet" type="text/css" href="<?php print($directory); ?>calendar/css/colorpicker/colorpicker.css" />
<link rel="stylesheet" type="text/css" href="<?php print($directory); ?>calendar/css/jquery-ui/smoothness/jquery-ui-1.8.1.custom.css" />
<script type="text/javascript" src="<?php print($directory); ?>calendar/js/jquery-core/jquery-1.4.2-ie-fix.min.js"></script>
<script type="text/javascript" src="<?php print($directory); ?>calendar/js/jquery-ui/smoothness/jquery-ui-1.8.1.custom.min.js"></script>
<!-- Include color picker plugin (Not required for calendar plugin. Used for example.) -->
<script type="text/javascript" src="<?php print($directory); ?>calendar/js/colorpicker/colorpicker.js"></script>
<!-- Include jquery tooltip plugin (Not required for calendar plugin. Used for example.) -->
<script type="text/javascript" src="<?php print($directory); ?>calendar/js/jquery-qtip-1.0.0-rc3140944/jquery.qtip-1.0.js"></script>
<!--
    ** jshashtable-2.1.js MUST BE INCLUDED BEFORE THE FRONTIER CALENDAR PLUGIN. **
-->
<script type="text/javascript" src="<?php print($directory); ?>calendar/js/lib/jshashtable-2.1.js"></script>
<script type="text/javascript" src="<?php print($directory); ?>calendar/js/frontierCalendar/jquery-frontier-cal-1.3.2.js"></script>


<script>
function numberToMonth(value)
{
	switch(value)
	{
		case 0:
			return "<?=$calendar_january; ?>";
		case 1:
			return "<?=$calendar_february; ?>";
		case 2:
			return "<?=$calendar_march; ?>";
		case 3:
			return "<?=$calendar_april; ?>";
		case 4:
			return "<?=$calendar_may; ?>";
		case 5:
			return "<?=$calendar_june; ?>";
		case 6:
			return "<?=$calendar_july; ?>";
		case 7:
			return "<?=$calendar_august; ?>";
		case 8:
			return "<?=$calendar_september; ?>";
		case 9:
			return "<?=$calendar_october; ?>";
		case 10:
			return "<?=$calendar_november; ?>";
		case 11:
			return "<?=$calendar_december; ?>";
	}
}
</script>

<script>

/**
 * Get the date (Date object) of the day that was clicked from the event object
 */
function myDayClickHandler(eventObj){
	var date = eventObj.data.calDayDate;
	alert("You clicked day " + date.toDateString());
};
/**
 * Get the agenda item that was clicked.
 */
function myAgendaClickHandler (eventObj){
	var agendaId = eventObj.data.agendaId;
	var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);
};
/**
 * get the agenda item that was dropped. It's start and end dates will be updated.
 */
function myAgendaDropHandler(eventObj){
	var agendaId = eventObj.data.agendaId;
	var date = eventObj.data.calDayDate;		
	var agendaItem = jfcalplugin.getAgendaItemById("#mycal",agendaId);		
	alert("You dropped agenda item " + agendaItem.title + 
		" onto " + date.toString() + ". Here is where you can make an AJAX call to update your database.");
};

/* nothing */
function myAgendaMouseoverHandler(eventObj)
{
	// nothing
}

/**
 * Do something when dragging starts on agenda div
 *
 * @param eventObj - jquery drag event object
 * @param divElm - jquery object - reference to the div element for the agenda item.
 * @param agendaItem - javascript object - agenda item data. 
 */
function myAgendaDragStart(eventObj,divElm,agendaItem){
	// dragging started
	var title = agendaItem.title;
	var startDate = agendaItem.startDate;
	var endDate = agendaItem.endDate;
	var allDay = agendaItem.allDay;
	var data = agendaItem.data;	
};

/**
 * Do something when dragging stops on agenda div
 *
 * @param eventObj - jquery drag event object
 * @param divElm - jquery object - reference to the div element for the agenda item.
 * @param agendaItem - javascript object - agenda item data. 
 */
function myAgendaDragStop(eventObj,divElm,agendaItem){
	// dragging stopped
	var title = agendaItem.title;
	var startDate = agendaItem.startDate;
	var endDate = agendaItem.endDate;
	var allDay = agendaItem.allDay;
	var data = agendaItem.data;	
};
/**
 * Custom tooltip - use any tooltip library you want to display the agenda data.
 *
 * For this example we use qTip - http://craigsworks.com/projects/qtip/
 *
 * @param divElm - jquery object for agenda div element
 * @param agendaItem - javascript object containing agenda data.
 */
function myApplyTooltip(divElm,agendaItem){
    
	// Destroy current tooltip if present
	if(divElm.data("qtip")){
		divElm.qtip("destroy");
	}
	
	var displayData = "";
	
	var title = agendaItem.title;
	var startDate = agendaItem.startDate;
	var endDate = agendaItem.endDate;
	var allDay = agendaItem.allDay;
	var data = agendaItem.data;
	displayData += "<br><b>" + title+ "</b><br><br>";
	if(allDay){
		displayData += "(All day event)<br><br>";
	}else{
		displayData += "<b>Starts:</b> " + startDate + "<br>" + "<b>Ends:</b> " + endDate + "<br><br>";
	}
	for (var propertyName in data) {
		displayData += "<b>" + propertyName + ":</b> " + data[propertyName] + "<br>"
	}
	displayData += "<br /><input type='submit' value='ENJOY' />";
	displayData += "<input type='submit' value='UNPLAY' />";
	displayData += "<br /><input type='submit' value='X' onclick='$(\".qtip\").qtip(\"hide\");' />";
	divElm.qtip({
		content: displayData,
		position: {
			corner: {
				tooltip: "bottomMiddle",
				target: "topMiddle"			
			},
			adjust: { 
				mouse: true,
				x: 0,
				y: -15
			},
			target: "mouse"
		},
		show: {
			when: { 
				event: 'click', //'mouseover'
				solo: true,
			}
		},
		hide: false, /* {
			when: {
				event: 'click',
			}
		},*/
		style: {
			border: {
				width: 5,
				radius: 10
			},
			padding: 10, 
			textAlign: "left",
			tip: true,
			name: "dark"
		}
	});

};

function addItem(title, name, address, others)
{
	jfcalplugin.addAgendaItem(
		"#mycal",
		name+":"+title,
		new Date(2014,5,26,13,30,0,0),
		new Date(2014,5,26,15,0,0,0),
		false,
		{
			where: address,
			partners: others
		},
		{
			backgroundColor: "#000000",
			foregroundColor: "#FFFFFF"
		}	
	);
}

//var item = jfcalplugin.getAgendaItemByDataAttr("#mycal","fname","Santa");
//var allItemArray = jfcalplugin.getAllAgendaItems("#mycal");
//alert(allItemArray[0].title);
</script>



<h1><?=$calendar_title; ?></h1>
<div id="calendars_bottons">
	<input type="submit" value=" << " onclick="showPreviousYear();" />
	<input type="submit" value=" < " onclick="showPreviousMonth();" />
		<b id="YearAndMonth">YearAndMonth</b>
	<input type="submit" value=" > " onclick="showNextMonth();" />
	<input type="submit" value=" >> " onclick="showNextYear();" />
</div>
<div id="mycal"></div>

<script>
/**
 * Initialize with current year and date. Returns reference to plugin object.
 */
var cal_date = new Date;
cal_date.setFullYear(2013, 5);
 
var jfcalplugin = $("#mycal").jFrontierCal({
	date: cal_date,
	dayClickCallback: myDayClickHandler,
	agendaClickCallback: myAgendaClickHandler,
	agendaDropCallback: myAgendaDropHandler,
	agendaMouseoverCallback: myAgendaMouseoverHandler,
	applyAgendaTooltipCallback: myApplyTooltip,
	agendaDragStartCallback : myAgendaDragStart,
	agendaDragStopCallback : myAgendaDragStop,
	dragAndDropEnabled: true
}).data("plugin");

jfcalplugin.setAspectRatio("#mycal",0.5);

$("b#YearAndMonth").text( numberToMonth(jfcalplugin.getCurrentDate("mycal").getMonth()) + " " + jfcalplugin.getCurrentDate("mycal").getFullYear());

/*
	window.print("
	var date = eventObj.data.calDayDate;
	alert("You clicked day " + date.toDateString());s
*/

function showPreviousMonth()
{
	jfcalplugin.showPreviousMonth("mycal");
	$("b#YearAndMonth").text( numberToMonth(jfcalplugin.getCurrentDate("mycal").getMonth()) + " " + jfcalplugin.getCurrentDate("mycal").getFullYear());

}

function showNextMonth()
{
	jfcalplugin.showNextMonth("mycal");
	$("b#YearAndMonth").text( numberToMonth(jfcalplugin.getCurrentDate("mycal").getMonth()) + " " + jfcalplugin.getCurrentDate("mycal").getFullYear());

}

function showPreviousYear()
{
	previousYear = jfcalplugin.getCurrentDate("mycal").getFullYear() - 1;
	actualMonth = jfcalplugin.getCurrentDate("mycal").getMonth();
	
	jfcalplugin.showMonth("mycal", new String(previousYear), new String(actualMonth));
	$("b#YearAndMonth").text( numberToMonth(jfcalplugin.getCurrentDate("mycal").getMonth()) + " " + jfcalplugin.getCurrentDate("mycal").getFullYear());
}

function showNextYear()
{
	nextYear = jfcalplugin.getCurrentDate("mycal").getFullYear() + 1;
	actualMonth = jfcalplugin.getCurrentDate("mycal").getMonth();
	
	jfcalplugin.showMonth("mycal", new String(nextYear), new String(actualMonth));
	$("b#YearAndMonth").text( numberToMonth(jfcalplugin.getCurrentDate("mycal").getMonth()) + " " + jfcalplugin.getCurrentDate("mycal").getFullYear());
}
</script>

<script>
addItem("corsa veloce", "Mario", "Corso Italia", "Pippo, Pluto, Paperino");
addItem("corsa veloce", "Luigi", "Corso Italia", "Giovanni, Lorenzo");
addItem("corsa veloce", "Antonio", "Corso Italia", "Grazia, Graziella");
</script>





