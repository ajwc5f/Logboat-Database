<?php ob_start(); ?>
<html>
<head>
<title>Schedule Batch</title>
<?php
include "includes/base.php";
?>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

<script type="text/javascript" src="/bower_components/jquery/jquery.min.js"></script>
  <script type="text/javascript" src="/bower_components/moment/min/moment.min.js"></script>
  <script type="text/javascript" src="/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="/bower_components/bootstrap/dist/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />


</head>
<body>
<?php include("includes/header.php");?>
<?//php include("includes/nav.php");?>

<div id='section'>
<br>
<div class="container">
<form class='form-horizontal' action="" method="POST">
<fieldset>
<legend>Schedule New Batch to be Brewed</legend>
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
<label class="col-md-4 control-label" for="sel1">Beer Name:</label>
<div class='col-md-4'>
<?php
$query = "SELECT name FROM beer ORDER BY name";

                                if($stmt = mysqli_prepare($link, $query)){

                                        mysqli_stmt_execute($stmt);

                                        $result = mysqli_stmt_get_result($stmt);
                                        //$field = mysqli_fetch_fields($result);

                                        echo "<select class='form-control input-md' name='beer_name' id='sel1'>";
                                        while($row = mysqli_fetch_assoc($result)){
                                                foreach($row as $key => $value){
                                                        echo "<option value='" . $value . "'>" . $value . "</option>";
                                                }
                                        }
                                        echo "</select>";

                                        mysqli_stmt_close($stmt);
                                }	
?>
</div>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Batch Start Date</label>
	<div class="input-group date col-md-4" id="datetimepicker1">
		<input class="form-control" type="text" name="start_date" value="" />
		<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>
	</div>
	<script type="text/javascript">
	$(function () {
        	$('#datetimepicker1').datetimepicker({
			format: "YYYY-M-DD HH:mm:ss",
			sideBySide: true,	
		});
	});
	</script>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Batch End Date:</label>
        <div class="input-group date col-md-4" id="datetimepicker2">
                <input class="form-control input-md" type="text" name="end_date" value="">
		<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                </span>	
        </div>
	<script type="text/javascript">
        $(function () {
                $('#datetimepicker2').datetimepicker({
			format: "YYYY-M-DD HH:mm:ss",
			sideBySide: true,
		});
        });
        </script>
</div>
<div class="form-group">
	<label class="col-md-4 control-label">Username:</label>
        <div class="col-md-4">
                <input class="form-control input-md" type="text" name="username" value="<?php echo $_SESSION['Username']?>" readonly>

        </div>
</div>
<div class="form-group">
	<label class='col-md-4 control-label'></label>
	<div class='col-md-4'>
		<input class="btn btn-info form-control" type="submit" name="submitnew_batch" value="Submit">
	</div>
</div>
</fieldset>
</form>
</div>
<div class="container">
<a href="schedule.php" class="col-md-4 button">Back to Batch Schedule</a><br>
</div>
</div>

<?php include("includes/footer.php");?>

</body>
</html>
<?php
if(isset($_POST['submitnew_batch'])) {
        $beername = htmlspecialchars($_POST['beer_name']);
        $startdate = htmlspecialchars($_POST['start_date']);
        $enddate = htmlspecialchars($_POST['end_date']);
        $username = htmlspecialchars($_POST['username']);
        if($beername == '' || $startdate == '' || $enddate == '' || $username == '') {
                $_SESSION['error'] = "Error: All fields must be filled.";
		header('Refresh:0');
                exit();
        }


                $sql = "INSERT INTO batch (beer_name,sched_start,sched_end,username) VALUES (?,?,?,?);";
                if($stmt = mysqli_prepare($link, $sql)){

                        mysqli_stmt_bind_param($stmt,"ssss",$beername,$startdate,$enddate,$username);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        $_SESSION['success'] = "Success: Batch has been scheduled.";
                        header('Location:schedule.php');
			exit();
                }
                else {
                        $_SESSION['error'] = "Error: Batch not successfully scheduled.";
                        header('Refresh:0');
			exit();
                }
}
?>
<?php
mysqli_close($link);

?>
