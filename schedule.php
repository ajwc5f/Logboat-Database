<?php
include "includes/base.php";
if(!isset($_SESSION['LoggedIn'])) {
        $_SESSION['error'] = "Error: Please <a href='login.php'>login</a> to view the schedule.";
        header('Location:index.php');
        exit();
}
?>

<html>
<head>
<title>CS3380 Project</title>

<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
<!--<link href="bower_components/angular-bootstrap-calendar/dist/css/angular-bootstrap-calendar.min.css" rel="stylesheet">
<script src="bower_components/angular-bootstrap-calendar/dist/js/angular-bootstrap-calendar-tpls.min.js"></script>
<link rel="stylesheet" href="schedule.css">-->
</head>
<body>
<?php include("includes/header.php");?>
<?//php include("includes/nav.php")?>

<div id='section'>
<!--<script src="schedule.js"></script>-->
<br>
<div class="container">
<!--<h2>Select which inventory to view</h2>-->
<form class="form-horizontal" method="POST" action="">
        <fieldset>
        <legend>Batch Scheduling</legend>
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
	if($_SESSION[UserType]=='admin'){
        	echo "<a href='insertbatch.php' class='btn btn-info'>Insert New Batch into Schedule</a><br><br>";
	}	
        ?>
	</fieldset>
</form>
</div>
<?php
$sql = "SELECT batch.batch_id AS 'Batch ID', beer.name AS 'Beer Name', batch.sched_start AS 'Batch Start Date', batch.sched_end AS 'Batch End Date', batch.username AS 'Scheduled By' FROM batch";
$sql .= " INNER JOIN beer ON batch.beer_name = beer.name ";

if($stmt = mysqli_prepare($link, $sql)){

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
                        $editid=$row[0];

                        echo "<tr>";
                        if($_SESSION[UserType]=='admin'){ // admins have permission to update and delete fields
                                echo "<td class='alter'><form action='editbatch.php' method='POST'><input type='hidden' name='updateid' value='".$editid."'>";
                                echo "<input type='hidden' name='updatetable' value='batch'><input class='btn btn-primary form-control editbutton' type='submit' name='updatesubmit' value='Update'></form></td>";
                                echo "<td class='alter'><form action='deletebatch.php' method='POST'><input type='hidden' name='deleteid' value='".$editid."'>";
                                echo "<input type='hidden' name='deletetable' value='batch'><input class='btn btn-danger form-control editbutton' type='submit' name='deletesubmit' value='Delete'></form></td>";
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
</div>

<?php include("includes/footer.php");?>

</body>
</html>

<?php
mysqli_close($link);

?>
