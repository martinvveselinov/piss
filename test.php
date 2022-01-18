<?php

$dataPoints = array( 
	array("id"=>"2", "y"=>12.55),
	array("id"=>"3", "y"=>8.47),
	array("id"=>"4", "y"=>6.08),
	array("id"=>"5", "y"=>4.29),
	array("id"=>"6", "y"=>4.59),
    array("id"=>"0", "y"=>14.59)
)
 
?>
<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function() {
 
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Оценки"
	},
	subtitles: [{
		text: "ПИСС 2022"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexid: "{id} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
var chart2 = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Оценки"
	},
	subtitles: [{
		text: "ПИСС 2022"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexid: "{id} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart2.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>               