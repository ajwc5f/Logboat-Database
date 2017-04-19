<html>
<head>
<title>Insert Keg</title>

<?php
include "includes/base.php";
?>

<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>
<?php include("includes/header.php");?>
<?php //include("includes/nav.php");?>

<div id='section'>

<div class="container">
<br>
<form class='form-horizontal' action="" method="POST">
<fieldset>
<legend>Update Keg Inventory</legend>
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
        <label class="col-md-4 control-label">Keg ID:</label>
        <div class="col-md-4">
                <input class='form-control input-md' type="text" name="keg_id" value="">

        </div>
</div>
<div class="form-group">
        <label class="col-md-4 control-label">Location:</label>
        <div class="col-md-4">
                <input class="form-control input-md" type="text" name="location" value="">

        </div>
</div>
<div class="form-group">
        <label class="col-md-4 control-label">Batch ID:</label>
        <div class="col-md-4">
                <input class="form-control input-md" type="text" name="batch_id" value="">

        </div>
</div>
<div class='form-group'>
	<label class='col-md-4 control-label'></label>
	<div class="col-md-4">
        	<input class="btn btn-info form-control" type="submit" name="submitnew_keg" value="Submit">
	</div>
</div>
</fieldset>
</form>
</div>
<div class="container">
<a href="inventory.php" class="button">Back to Inventory</a><br>
</div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>
<?php
if(isset($_POST['submitnew_keg'])) {
        $kegid = htmlspecialchars($_POST['keg_id']);
        $location = htmlspecialchars($_POST['location']);
        $batchid = htmlspecialchars($_POST['batch_id']);
        if($kegid == '' || $location == '' || $batchid == '') {
                $_SESSION['error'] = "Error: All fields must be filled.";
                header('Refresh:0');
                exit();
        }
        else if(!is_numeric($kegid)) {
                $_SESSION['error'] = "Error: Keg ID  must be a number.";
                header('Refresh:0');
                exit();
        }
        else if(!is_numeric($batchid)){
                $_SESSION['error'] = "Error: Batch ID must be a number.";
                header('Refresh:0');
                exit();
        }
	$query = "SELECT keg_id FROM keg WHERE keg_id = ". $kegid;

        if($stmt = mysqli_prepare($link, $query)){
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 1) {
                        $_SESSION['error'] = "Error: A keg with that ID already exists. Please update it instead.";
                        mysqli_stmt_close($stmt);
                        header('Refresh:0');
                        exit();
                }
                mysqli_stmt_close($stmt);
        }
	$query = "SELECT batch_id FROM batch WHERE batch_id = ". $batchid;

        if($stmt = mysqli_prepare($link, $query)){
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                if(mysqli_num_rows($result) == 0) {
                        $_SESSION['error'] = "Error: That Batch ID doesn't exist.";
                        mysqli_stmt_close($stmt);
                        header('Refresh:0');
                        exit();
                }
                mysqli_stmt_close($stmt);
        }
	$sql = "INSERT INTO keg (keg_id,location,batch_id) VALUES (?,?,?)";
                if($stmt = mysqli_prepare($link, $sql)){

                        mysqli_stmt_bind_param($stmt,"sss",$kegid,$location,$batchid);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        $_SESSION['success'] = "Success: Keg has been added.";
                        //require "insertingredient.php";
                        header('Refresh:0');
                        exit();
                }
                else {
                        $_SESSION['error'] = "Error: Keg not successfully added.";
                        //require "insertingredient.php";
                        header('Refresh:0');
                        exit();
                }	
}
	
	
?>
<?php
mysqli_close($link);

?>
