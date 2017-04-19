<?php
include "includes/base.php";
if(!isset($_SESSION['LoggedIn'])) {
       	$_SESSION['error'] = "Error: Please <a href='login.php'>login</a> to view inventory.";
	header('Location:index.php');
        exit();
}
?>

<html>
<head>
<title>Inventory</title>

<link rel="stylesheet" type="text/css" href="stylesheet.css">
</head>
<body>
<?php include("includes/header.php");?>
<?//php include("includes/nav.php");?>

<div id='section'>
<br>
<p>
<div class="container">
<!--<h2>Select which inventory to view</h2>-->
<form class="form-inline" method="POST" action="">
	<fieldset>
	<legend>Inventory</legend>
	<?php
	if (isset($_SESSION['error']) || isset($_SESSION['success'])) {
                       if ($_SESSION['error']) {
                                echo "<div class='btn btn-danger col-md-12 form-control'>". $_SESSION['error']. "</div>";
                                echo "<br><br>";
                                $_SESSION['error'] = '';
                        }
                        else if($_SESSION['success']) {
                                print "<div class='btn btn-success form-control'>". $_SESSION['success']. "</div>";
                                echo "<br><br>";
                                $_SESSION['success'] = '';
                        }
        }
	?>
	<div class="form-group">	
			<select name="searchselect" class='col-md-4 form-control'>
				<option value="ingredient">Ingredients</option>
				<option value="keg">Kegs</option>
			</select>
	</div>
	<div class="form-group">
		<input class="btn btn-primary form-control" type="submit" name="searchsubmit" value="Display"><br>
	</div>
	</fieldset>
</form>
	
<?php
if($_SESSION[UserType]=='admin'){
	echo '<br><a href="insertingredient.php" class="btn btn-info col-md-3">Insert into ingredients</a><br><br>';
	echo '<a href="insertkeg.php" class="btn btn-info col-md-3">Insert into kegs</a><br><br>';
}
?>
</div>
</p>

<p>
<?php

if(isset($_POST["searchsubmit"])){

	$searchinput = htmlspecialchars($_POST["searchtext"]) . "%";
	$searchtable = htmlspecialchars($_POST["searchselect"]);
	$searchfield = "";
	//$sql = "select * from " . $searchtable;

	switch($searchtable){
		case "ingredient":
			$searchfield = "ingredient.name";
			$sql = "SELECT ingredient.name AS Name, ingredient.inventory AS Inventory, ingredient.lot_number AS 'Lot Number', unit.name AS Unit FROM " . $searchtable . " "; 
			$sql .= "INNER JOIN unit ON ingredient.unit_id = unit.unit_id ";
			//$sql .= "WHERE " . $searchfield . " LIKE ? ORDER BY " . $searchfield;
			break;
		case "keg":
			$searchfield = "keg.keg_id";
			$sql = "SELECT keg.keg_id AS 'Keg ID', keg.location as Location, batch.beer_name AS Beer, keg.batch_id AS 'Batch ID' FROM " . $searchtable . " ";
			$sql .= "INNER JOIN batch ON keg.batch_id = batch.batch_id"; 
			// . " WHERE " . $searchfield . " LIKE ? ORDER BY " . $searchfield;
			break;
		default:
			$stmt = false;
			break;	
	}


	if($stmt = mysqli_prepare($link, $sql)){

		mysqli_stmt_bind_param($stmt,'s',$searchinput);

		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		if($num_rows = mysqli_num_rows($result)){
                }else{$num_rows = 0;}
                //echo $num_rows . " results<br>";


?>
<div class="container">
<?php echo $num_rows . " results<br>";?>
<table class="table table-hover">
<thead>
<tr>
<?php
		// print column names
		$field = mysqli_fetch_fields($result);
		if($_SESSION[UserType]=='admin'){ // formatting for update and delete buttons
			echo "<th></th><th></th>";
		}
		foreach($field as $val){
			echo "<th>" . $val->name . "</th>";
		}
?>
</tr>
</thead>
<tbody>
<?php
		// print each column in each row
		while($row = mysqli_fetch_array($result)){
			if($searchtable=='ingredient'){
				$editid=$row[0];
			}
			elseif($searchtable=='keg'){
				$editid=$row[0];
			}

			echo "<tr>";
			if($_SESSION[UserType]=='admin'){ // admins have permission to update and delete fields
				echo "<td class='alter'><form action='editinv.php' method='POST'><input type='hidden' name='updateid' value='".$editid."'>";
				echo "<input type='hidden' name='updatetable' value='".$searchtable."'><input class='btn btn-primary form-control editbutton' type='submit' name='updatesubmit' value='Update'></form></td>";
				echo "<td class='alter'><form action='deleteinv.php' method='POST'><input type='hidden' name='deleteid' value='".$editid."'>";
				echo "<input type='hidden' name='deletetable' value='".$searchtable."'><input class='btn btn-danger form-control editbutton' type='submit' name='deletesubmit' value='Delete'></form></td>";
			}
			foreach($field as $val){
				echo "<td>" . $row[$val->name] . "</td>";
			}
			echo "</tr>";
		}

		mysqli_stmt_close($stmt);


	}

?>
</tbody>
</table>
</div>
<?php
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
