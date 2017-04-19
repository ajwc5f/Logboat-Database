<html>
<head>
<title>Edit Inventory</title>

<?php
include "includes/base.php";
?>

<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>
<?php include("includes/header.php");?>
<?php //include("includes/nav.php");?>

<div id='section'>

<?php
if($_POST['updatetable']!=''){
        $_SESSION['table'] = htmlspecialchars($_POST['updatetable']);
	//echo $table;
}
if($_POST['updateid']!=''){
        $_SESSION['id'] = htmlspecialchars($_POST['updateid']);
	//echo $id;
}

//print_r($_POST); // debug
//$_POST = array();

if($_SESSION['table'] == 'ingredient') {

        $sql = "SELECT * FROM " . $_SESSION['table'] . " WHERE name = ?";

        if($stmt = mysqli_prepare($link, $sql)){

               mysqli_stmt_bind_param($stmt,'s',htmlspecialchars($_SESSION['id']));

                mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
		
                $row = mysqli_fetch_array($result);
				
				$name = $row[0];
                $inventory = $row[1];
                $lot_number = $row[2];
                $unit_id = $row[3];

				mysqli_stmt_close($stmt);

        }

	//echo "<h1>Update ingredient...</h1>";
	echo "<div class='container'>";
		echo "<br>";
		echo "<form class='form-horizontal' action='' method='POST'>";
		echo "<fieldset>";
		echo "<legend>Update Ingredient</legend>";
		if (isset($_SESSION['error']) || isset($_SESSION['success'])) {
 	        	if ($_SESSION['error']) {
                		echo "<div class='btn btn-danger col-md-4 form-control'>". $_SESSION['error']. "</div>";
                		echo "<br><br>";
                		$_SESSION['error'] = '';
        		}
        		else if($_SESSION['success']) {
                		print "<div class='btn btn-success form-control'>". $_SESSION['success']. "</div>";
                		echo "<br><br>";
                		$_SESSION['success'] = '';
        		}
		}
		echo "<div class='form-group'>";
			echo "<label class='col-md-4 control-label'>Name:</label>";
			echo "<div class='col-md-4'>";
				echo "<input class='form-control input-md' type='text' name='ind_name' value='".$name."' readonly>";
			echo "</div>";
		echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Inventory:</label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='form-control input-md' type='text' name='inventory' value='".$inventory."'>";
                        echo "</div>";
                echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Lot Number:</label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='form-control input-md' type='text' name='lot_number' value='".$lot_number."'>";
                        echo "</div>";
                echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Unit ID:</label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='form-control input-md' type='text' name='unit_id' value='".$unit_id."' readonly>";
                        echo "</div>";
                echo "</div>";	
		echo "<div class='form-group'>";
			echo "<label class='col-md-4 control-label'></label>";
			echo "<div class='col-md-4'>";
				echo "<input class='btn btn-info form-control' type='submit' name='invsubmit_ind' value='Save'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='form-group'>";
                        echo "<input type='hidden' name='updatetable' value='".$table."'>";
                        echo "<input type='hidden' name='updateid' value='".$id."'>";
                echo "</div>";

		echo "</fieldset>";
		echo "</form>";
	echo "</div>";
}
else if($_SESSION['table'] == "keg"){

        $sql = "SELECT * FROM " . $_SESSION['table'] . " WHERE keg_id = ?";

        if($stmt = mysqli_prepare($link, $sql)){

               mysqli_stmt_bind_param($stmt,'s',htmlspecialchars($_SESSION['id']));

                mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
		
                $row = mysqli_fetch_array($result);
				
				$keg_id = $row[0];
                $location = $row[1];

				mysqli_stmt_close($stmt);

        }

	echo "<div class='container'>";
                echo "<br>";
                echo "<form class='form-horizontal' action='' method='POST'>";
                echo "<fieldset>";
                echo "<legend>Update Ingredient</legend>";
                if (isset($_SESSION['error']) || isset($_SESSION['success'])) {
                        if ($_SESSION['error']) {
                                echo "<div class='btn btn-danger col-md-4 form-control'>". $_SESSION['error']. "</div>";
                                echo "<br><br>";
                                $_SESSION['error'] = '';
                        }
                        else if($_SESSION['success']) {
                                print "<div class='btn btn-success form-control'>". $_SESSION['success']. "</div>";
                                echo "<br><br>";
                                $_SESSION['success'] = '';
                        }
                }
                echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Keg ID:</label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='form-control input-md' type='text' name='keg_id' value='".$keg_id."' readonly>";
                        echo "</div>";
                echo "</div>";
                echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Location:</label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='form-control input-md' type='text' name='location' value='".$location."'>";
                        echo "</div>";
                echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'></label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='btn btn-info form-control' type='submit' name='invsubmit_keg' value='Save'>";
                        echo "</div>";
                echo "</div>";
                echo "<div class='form-group'>";
                        echo "<input type='hidden' name='updatetable' value='".$table."'>";
                        echo "<input type='hidden' name='updateid' value='".$id."'>";
                echo "</div>";

                echo "</fieldset>";
                echo "</form>";
        echo "</div>";
}

//echo '<meta http-equiv="refresh" content="0; URL=success.php" />';
?>

<div class="container">
<br><a href="inventory.php" >Back to Inventory</a><br>
</div>
</div>

<?php// include("includes/footer.php");?>

</body>
</html>
<?php
	if(isset($_POST['invsubmit_ind'])){
                $name = htmlspecialchars($_POST['ind_name']);
                $inventory = htmlspecialchars($_POST['inventory']);
                $unitid = htmlspecialchars($_POST['unit_id']);
                $lotnumber = htmlspecialchars($_POST['lot_number']);


                if($inventory == '' || $lotnumber == '') {
                        $_SESSION['error'] = "Error: All fields must be filled.";
                        header('Refresh:0');
                        exit();
                }
                else if(!is_numeric($inventory)) {
                        $_SESSION['error'] = "Error: Inventory must be a number.";
                        header('Refresh:0');
                        exit();
                }

                $sql = "UPDATE " . $_SESSION['table'] . " SET inventory=?,lot_number=? WHERE name=?";

                if($stmt = mysqli_prepare($link, $sql)){

                        mysqli_stmt_bind_param($stmt,'sss',$inventory,$lotnumber,$name);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        $_SESSION['success'] = "Success: Ingredient - " . $name . " - has been updated.";
			$_SESSION['table'] = '';
			$_SESSION['id'] = '';
                        header('Location:inventory.php');
                        exit();
                }
                else {
                        $_SESSION['error'] = "Error: Ingredient not successfully updated.";
                        header('Refresh:0');
                        exit();
                }
	}

	if(isset($_POST['invsubmit_keg'])){

		$keg_id = htmlspecialchars($_POST['keg_id']);
                $location = htmlspecialchars($_POST['location']);
                
		if($location == '') {
                        $_SESSION['error'] = "Error: All fields must be filled.";
                        header('Refresh:0');
                        exit();
                }

                $sql = "UPDATE " . $_SESSION['table'] . " SET location=? WHERE keg_id=?";

                if($stmt = mysqli_prepare($link, $sql)){

                        mysqli_stmt_bind_param($stmt,'ss',htmlspecialchars($location),$keg_id);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);
			
			$_SESSION['success'] = "Success: Keg with ID:" . $keg_id . " has been updated.";
                        $_SESSION['table'] = '';
                        $_SESSION['id'] = '';
                        header('Location:inventory.php');
                        exit();
                }
                else {
                        $_SESSION['error'] = "Error: Keg not successfully updated.";
                        header('Refresh:0');
                        exit();
                }
        }
?>
<?php
mysqli_close($link);

?>
