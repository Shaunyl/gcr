var dataValues = [9.9, 11.5, 15.2, 21.2]; //temp
var dataValues2 = [17.1, 14.6, 15.1, 12.9, 16.9]; //temp

function drawSeriesChart(id, title, domainLabel, yAxisLabel, seriesColor, seriesName, values) {
    $('#' + id).highcharts({
    	title: { text: title},

        tooltip: {
            formatter: function () {
	            return '<b>'+ Highcharts.numberFormat(this.y, 1, '.', '') +'</b> ' + domainLabel +
	        		' (<b>'+ this.x + '</b>)'; }
        },

        xAxis: {
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dic'],
            title: {
            	text: 'Timeline'
            }},
        
        yAxis: {
        	title: {
        		text: yAxisLabel
        	}},

        series: [{
            data: values,
            color: seriesColor,
            name: seriesName }]
    });
}

drawSeriesChart('chart-total-distance', 'Covered Distance', 'km', 'Distance (km)', null, 'So Far', dataValues);
drawSeriesChart('chart-average-speed', 'Average Speed', 'km/h', 'Speed (km/h)', null, 'Per Month', dataValues2);

var chart = $('#chart-total-distance').highcharts();

chart.addSeries({
	type: 'column',
	name: 'Per Month',
	data: [0, 1.6, 3.7, 6]
});