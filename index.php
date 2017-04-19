<?php
include "includes/base.php";
?>

<html>
<head>
<title>CS3380 Project</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>
<body>
<?php include("includes/header.php");?>
<?//php include("includes/nav.php")?>

<div id='section'>
<div class='container'>
<br>
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
<?php

if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION['UserType']=='user')
{

        ?>

                <h1>User Area</h1>
                <p>Welcome, <b><?php echo  $_SESSION['Username'] ?></b>.</p>

                <?php
}
elseif(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username']) && $_SESSION['UserType']=='admin')
{

        ?>

                <h1>Admin Area</h1>
                <p>Welcome, Admin! You have super privileges.</p>

                <?php
}
else {
?>
	<h2>CS3380: Logboat Project Homepage</h2>
	<p>Please login.</p>
<?php
}
?>

</div>
</div>
<?php include("includes/footer.php");?>

</body>
</html>

<?php
mysqli_close($link);

?>
