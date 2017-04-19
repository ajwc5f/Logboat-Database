<?php ob_start(); ?>
<html>
<head>
<title>Edit Batch</title>

<?php
//ini_set('display_errors', 1);
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
<?php //include("includes/nav.php");?>

<div id='section'>

<?php
if($_POST['updatetable']!=''){
        $_SESSION['table'] = htmlspecialchars($_POST['updatetable']);
}
if($_POST['updateid']!=''){
        $_SESSION['id'] = htmlspecialchars($_POST['updateid']);
}

	$sql = "SELECT * FROM " . $_SESSION['table'] . " WHERE batch_id = ?";

        if($stmt = mysqli_prepare($link, $sql)){

               mysqli_stmt_bind_param($stmt,'s',htmlspecialchars($_SESSION['id']));

                mysqli_stmt_execute($stmt);

				$result = mysqli_stmt_get_result($stmt);
		
                $row = mysqli_fetch_array($result);
				
		$batch_id = $row[0];
                $beer_name = $row[1];
                $sched_start = $row[2];
                $sched_end = $row[3];
		$username = $row[4];

		mysqli_stmt_close($stmt);

        }

	echo "<div class='container'>";
		echo "<br>";
		echo "<form class='form-horizontal' action='' method='POST'>";
		echo "<fieldset>";
		echo "<legend>Update Batch</legend>";
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
			echo "<label class='col-md-4 control-label'>Batch ID:</label>";
			echo "<div class='col-md-4'>";
				echo "<input class='form-control input-md' type='text' name='batch_id' value='".$batch_id."' readonly>";
			echo "</div>";
		echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Beer Name:</label>";
                        echo "<div class='col-md-4'>";
				$query = "SELECT name FROM beer ORDER BY name";

                                if($stmt = mysqli_prepare($link, $query)){

                                        mysqli_stmt_execute($stmt);

                                        $result = mysqli_stmt_get_result($stmt);
                                        //$field = mysqli_fetch_fields($result);

                                        echo "<select class='form-control input-md' name='beer_name' id='sel1'>";
                                        while($row = mysqli_fetch_assoc($result)){
                                                foreach($row as $key => $value){
                                                        if($value == $beer_name) {
								echo "<option value='" . $value . "' selected>" . $value . "</option>";
							}
							else {
								echo "<option value='" . $value . "'>" . $value . "</option>";
							}
						}			
                                       	}
                                        echo "</select>";

                                        mysqli_stmt_close($stmt);
                                }
                        echo "</div>";
                echo "</div>";
		echo "<div class='form-group'>";
        		echo "<label class='col-md-4 control-label'>Batch Start Date:</label>";
        		echo "<div class='input-group date col-md-4' id='datetimepicker3'>";
                		echo "<input class='form-control' type='text' name='start_date' value='" . $sched_start . "' />";
                		echo "<span class='input-group-addon'>";
                        		echo "<span class='glyphicon glyphicon-calendar'></span>";
                		echo "</span>";
        		echo "</div>";
        	echo '<script type="text/javascript">';
        	echo '$(function () {';
                	echo '$("#datetimepicker3").datetimepicker({';
				echo 'format: "YYYY-MM-DD HH:mm:ss",';
				echo 'sideBySide: true,';
			echo '});';
        	echo '});';
        	echo '</script>';
		echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Batch End Date:</label>";
                        echo "<div class='input-group date col-md-4' id='datetimepicker4'>";
                                echo "<input class='form-control' type='text' name='end_date' value='" . $sched_end . "' />";
                                echo "<span class='input-group-addon'>";
                                        echo "<span class='glyphicon glyphicon-calendar'></span>";
                                echo "</span>";
                        echo "</div>";
                echo '<script type="text/javascript">';
                echo '$(function () {';
                        echo '$("#datetimepicker4").datetimepicker({';
				echo 'format: "YYYY-MM-DD HH:mm:ss",';
				echo 'sideBySide: true,';
			echo '});';
                echo '});';
                echo '</script>';
                echo "</div>";
		echo "<div class='form-group'>";
                        echo "<label class='col-md-4 control-label'>Username:</label>";
                        echo "<div class='col-md-4'>";
                                echo "<input class='form-control input-md' type='text' name='username' value='".$username."' readonly>";
                        echo "</div>";
                echo "</div>";	
		echo "<div class='form-group'>";
			echo "<label class='col-md-4 control-label'></label>";
			echo "<div class='col-md-4'>";
				echo "<input class='btn btn-info form-control' type='submit' name='submit_batch' value='Save'>";
			echo "</div>";
		echo "</div>";
		echo "<div class='form-group'>";
                        echo "<input type='hidden' name='updatetable' value='".$table."'>";
                        echo "<input type='hidden' name='updateid' value='".$id."'>";
                echo "</div>";

		echo "</fieldset>";
		echo "</form>";
	echo "</div>";

?>

<div class="container">
<br><a href="schedule.php">Back to Batch Schedule</a><br>
</div>
</div>

<?php// include("includes/footer.php");?>

</body>
</html>
<?php
	if(isset($_POST['submit_batch'])){
                $batch_id = htmlspecialchars($_POST['batch_id']);
                $beer_name = htmlspecialchars($_POST['beer_name']);
                $start_date = htmlspecialchars($_POST['start_date']);
                $end_date = htmlspecialchars($_POST['end_date']);
		$username = htmlspecialchars($_POST['username']);


                if($beer_name == '' || $start_date == '') {
                        $_SESSION['error'] = "Error: All fields must be filled.";
                        header('Refresh:0');
                        exit();
                }
		
                $sql = "UPDATE " . $_SESSION['table'] . " SET beer_name=?,sched_start=?,sched_end=? WHERE batch_id=?";

                if($stmt = mysqli_prepare($link, $sql)){

                        mysqli_stmt_bind_param($stmt,'ssss',$beer_name,$start_date,$end_date,$batch_id);

                        mysqli_stmt_execute($stmt);

                        mysqli_stmt_close($stmt);

                        $_SESSION['success'] = "Success: Batch with ID " . $batch_id . " has been updated.";
			$_SESSION['table'] = '';
			$_SESSION['id'] = '';
                        header('Location:schedule.php');
			exit();
                }
                else {
                        $_SESSION['error'] = "Error: Batch not successfully updated.";
                        header('Refresh:0');
                        exit();
                }
	}
?>
<?php
ob_end_flush();
mysqli_close($link);
?>
