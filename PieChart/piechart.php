<?php
//връзка с базата данни 
require 'db_setup_2.php';
try {
	$conn = new PDO(
	    "mysql:host=$serverName;dbname=$database;",
		$user,
		$pass
	  );
} catch (PDOException $e) {
	echo "Error: " . $e->getMessage();
}

// избираме id на проекта и grade от базата
$sql = "SELECT id ,grade FROM projectgrades";
$result = $conn->query($sql);
$grades = $result->fetchAll();

$conn = null;

//променлива за броя на 2/3/4/5/6
$gradesCount = array(0,0,0,0,0);
$gradesNum = 0;
$gradesPercent = array(0.0,0.0,0.0,0.0,0.0);
//var_dump($grades);
//if (is_array($grades))
		
//Принтирам идта на проекти и техните оценки	
foreach ($grades as $row) {
	//echo "id = " . $row['id'] . " => grade = " . $row['grade'] ;
	//echo "<br>";
	$index = (int)$row["grade"];

	//index-2 зашото почваме от индекс 0, а нямаме оценки 0 и 1
	$gradesCount[$index-2]++;
	$gradesNum++;
}
//echo "End result: " ;
//var_dump($gradesCount);
//echo "<br>";
echo "Total grades: " . $gradesNum . "<br>";
	
//Цикъл за смятане на процентите за всяка една оценка, използвам функция round(num,2), за да закръгля до 2ри знак след запетайката
for($index = 0; $index < 5 ; $index++) {
	$gradesPercent[$index] = round( ( ($gradesCount[$index] * 100) / $gradesNum ) , 2);
	//echo ($index + 2) . " = " . $gradesPercent[$index] . "<br>";
}
  
$dataPoints = array( 
	array("label"=>"2", "y"=>$gradesPercent[0]),
	array("label"=>"3", "y"=>$gradesPercent[1]),
	array("label"=>"4", "y"=>$gradesPercent[2]),
	array("label"=>"5", "y"=>$gradesPercent[3]),
	array("label"=>"6", "y"=>$gradesPercent[4])
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
		text: "Оценки от проекти"
	},
	subtitles: [{
		text: "Писс 2022"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();
 
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>     