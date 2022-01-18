<?php
require 'keeper.php';
    require 'db_setup.php';
    try {
      $conn = new PDO(
        "mysql:host=$serverName;dbname=$database;",
        $user,
        $pass
      );
    } catch (PDOException $e) {
      die("Error connecting to SQL Server: " . $e->getMessage());
    }
    // избираме id, заглавие и описание на проекта от базата
    $sql = "SELECT id ,grade FROM Projects";
    $result = $conn->query($sql);
    $projects = $result->fetchAll();

    $conn = null;
	$grades = array(
		array("grade"=>"2", "cnt"=>0),
		array("grade"=>"3", "cnt"=>0),
		array("grade"=>"4", "cnt"=>0),
		array("grade"=>"5", "cnt"=>0),
		array("grade"=>"6", "cnt"=>0),
		array("grade"=>"0", "cnt"=>0)
	);
	$total = 0;
	foreach ($projects as $project) {
		foreach($grades as &$grade){
			if($project['grade'] == $grade['grade']){
				$grade['cnt'] += 1;
			}
		}
	}
	echo "<br>";
	echo "<br>";
	echo "<br>";
	foreach($grades as $grade){
		$total += $grade['cnt'];
	}
	$percents = array();
	//$i = 0;
	$dataPoints = array( 
		array("label"=>"2", "y"=>0),
		array("label"=>"3", "y"=>0),
		array("label"=>"4", "y"=>0),
		array("label"=>"5", "y"=>0),
		array("label"=>"6", "y"=>0),
		array("label"=>"0", "y"=>0)
	);
	for($i = 0; $i < 6; ++$i)
	{
		$dataPoints[$i]['y'] = round(100*($grades[$i]['cnt']/$total), 2);
	}
	
	print_r($dataPoints);
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
		indexid: "{label} ({y})",
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