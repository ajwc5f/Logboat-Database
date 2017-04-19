<?php
include "includes/base.php";
?>
<html>
<head>
<title>Insert Ingredient</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>
<?php include("includes/header.php");?>
<?//php include("includes/nav.php");?>

<div id='section'>
<br>
<div class="container">
<form class='form-horizontal' action="" method="POST">
<fieldset>
<legend>Insert into Ingredient Inventory</legend>
<?php
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
?>
<div class="form-group">
	<label class="col-md-4 control-label">Name:</label>
	<div class="col-md-4">
		<input class='form-control input-md' type="text" name="name" value="<?php echo $_POST['name']?>">

	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Inventory:</label>
	<div class="col-md-4">
		<input class="form-control input-md" type="text" name="inventory" value="">

	</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Lot Number:</label>
        <div class="col-md-4">
                <input class="form-control input-md" type="text" name="lot_number" value="">

        </div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Unit ID:</label>
        <div class="col-md-4">
                <input class="form-control input-md" type="text" name="unit_id" value="">

        </div>
</div>
<div class="form-group">
	<label class='col-md-4 control-label'></label>
	<div class='col-md-4'>
		<input class="btn btn-info form-control" type="submit" name="submitnew_ind" value="Submit">
	</div>
</div>
</fieldset>
</form>
</div>
<div class="container">
<a href="inventory.php" class="col-md-4 btn-btn info">Back to Inventory</a><br>
</div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>
<?php
if(isset($_POST['submitnew_ind'])) {
        $name = htmlspecialchars($_POST['name']);
        $inventory = htmlspecialchars($_POST['inventory']);
        $unitid = htmlspecialchars($_POST['unit_id']);
        $lotnumber = htmlspecialchars($_POST['lot_number']);
        if($name == '' || $inventory == '' || $unitid == '' || $lotnumber == '') {
                $_SESSION['error'] = "Error: All fields must be filled.";
                //require "insertingredient.php";
		header('Refresh:0');
                exit();
        }
        else if(!is_numeric($inventory)) {
                $_SESSION['error'] = "Error: Inventory must be a number.";
                //require "insertingredient.php";
                header('Refresh:0');
		exit();
        }
        else if(!is_numeric($unitid)){
                $_SESSION['error'] = "Error: Unit ID must be a number.";
                //require "insertingredient.php";
                header('Refresh:0');
		exit();
        }

        $query = "SELECT unit_id FROM unit WHERE unit_id = ". $unitid;

        if($stmt = mysqli_prepare($link, $query)){
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 0) {
                        $_SESSION['error'] = "Error: That unit ID doesn't exist.";
			mysqli_stmt_close($stmt);
                        //require "insertingredient.php";
                        header('Refresh:0');
			exit();
		}
                mysqli_stmt_close($stmt);
        }


                $sql = "INSERT INTO ingredient (name,inventory,lot_number,unit_id) VALUES (?,?,?,?);";
                if($stmt = mysqli_prepare($link, $sql)){

                        mysqli_stmt_bind_param($stmt,"ssss",$name,$inventory,$lotnumber,$unitid);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        $_SESSION['success'] = "Success: Ingredient has been added.";
                        //require "insertingredient.php";
                        header('Refresh:0');
			exit();
                }
                else {
                        $_SESSION['error'] = "Error: Ingredient not successfully added.";
                        //require "insertingredient.php";
                        header('Refresh:0');
			exit();
                }
}
?>
<?php
mysqli_close($link);

?>
