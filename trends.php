<?php
include "includes/base.php";
if(!isset($_SESSION['LoggedIn'])) {
        $_SESSION['error'] = "Error: Please <a href='login.php'>login</a> to view trends.";
        header('Location:index.php');
        exit();
}
?>
<html>
<head>
<title>Data Trends</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="fusioncharts/js/fusioncharts.js"></script>
<script type="text/javascript" src="fusioncharts/js/fusioncharts.charts.js"></script>
<script type="text/javascript" src="fusioncharts/js/themes/fusioncharts.theme.fint.js"></script>

</head>
<body>
<?php include("includes/header.php");?>
<?php //include("includes/nav.php");?>

<div id='section'>
<br>
<p>
<!--<h2>Select which inventory to view</h2>-->
<div class='container'>
<form class="form-inline" method="POST" action="">
	<fieldset>
	<legend>Data Trends</legend>
	<div class="form-group">	
			<select name="searchselect" class='form-control'>
				<?php
					$sql = "select name from beer";
					
					if($stmt = mysqli_prepare($link, $sql)){

						mysqli_stmt_execute($stmt);

						$result = mysqli_stmt_get_result($stmt);

						if($num_rows = mysqli_num_rows($result)){
						}else{$num_rows = 0;}
						
						if($num_rows == 0){
							echo "<option value=''>None</option>";
						}
						else{
							echo "<option value='All'>All</option>";
							while($row = mysqli_fetch_array($result)){
								echo "<option value='" . $row[0] . "'>" . $row[0] ."</option>"; //values are from beer.name
							}
						}
						
						mysqli_stmt_close($stmt);
					}
				?>
				
			</select>		
	</div>
	<div class="form-group">
		<input class="btn btn-primary form-control" type="submit" name="searchsubmit" value="Display"><br>
	</div>
	</fieldset>
</form>
</div>
</p>

<p>
<?php

if(isset($_POST["searchsubmit"])){
	if(htmlspecialchars($_POST["searchselect"]) == ""){
		echo "There are no beers to analyze.";

	}else{

		$beername = htmlspecialchars($_POST["searchselect"]);
		
		if($beername == 'All'){
			$sql = "SELECT fermentation.value, fermentation.timestamp, unit.name AS unit_name FROM fermentation ";
			$sql .= "INNER JOIN unit ON fermentation.unit_id = unit.unit_id ";
			$sql .= "WHERE timestamp >= (NOW() - INTERVAL 6 MONTH) ";
			$sql .= "ORDER BY timestamp ASC ";
		}else{
			$sql = "SELECT fermentation.value, fermentation.timestamp, unit.name AS unit_name FROM fermentation ";
			$sql .= "INNER JOIN unit ON fermentation.unit_id = unit.unit_id ";
			$sql .= "WHERE timestamp >= (NOW() - INTERVAL 6 MONTH) ";
			$sql .= "AND fermentation.batch_id IN ( ";
			$sql .= "SELECT batch_id FROM batch ";
			$sql .= "WHERE batch.beer_name = ?)";
			$sql .= "ORDER BY timestamp ASC  ";
		}
		
		if($stmt = mysqli_prepare($link, $sql)){

			if($beername != 'All'){
				mysqli_stmt_bind_param($stmt,'s',$beername);
			}
			
			mysqli_stmt_execute($stmt);

			$result = mysqli_stmt_get_result($stmt);
			
			mysqli_stmt_close($stmt);

			if($num_rows = mysqli_num_rows($result)){
			}else{$num_rows = 0;}
			
			// convert to json
			$prefix = '';
			$jsondata = "[\n";
			while ( $row = mysqli_fetch_array( $result ) ) {
				$unit = $row[2];
				$jsondata .= $prefix . " {\n";
				$jsondata .= '  "label": "' . $row[1] . '",' . "\n"; //timestamp
				$jsondata .= '  "value": "' . $row[0] . '"' . "\n"; //fermentation value
				$jsondata .= " }";
				$prefix = ",\n";
			}
			$jsondata .= "\n]";
			
			//echo $jsondata;

?>

<script type="text/javascript">
FusionCharts.ready(function(){
    var revenueChart = new FusionCharts({
        "type": "line",//"column2d",
        "renderAt": "chartContainer",
        "width": "800",
        "height": "500",
        "dataFormat": "json",
        "dataSource":  {
          "chart": {
            "caption": "Fermentation Trends Over Past 6 Months",
            "subCaption": "<?php echo $beername; ?>",
            "xAxisName": "Timestamp",
            "yAxisName": "Values",// (<?php echo $unit; ?>)", 
            "theme": "fint"
         },
         "data": <?php echo $jsondata; ?>
      }

  });
revenueChart.render();
})
</script>

<div class="container" id="chartContainer"></div>

<?php
		}
	}
}
?>
</p>


</div>

<?php include("includes/footer.php");?>

</body>
</html>

<?php
mysqli_close($link);

?>
