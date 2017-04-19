
<?php
session_start();
include "includes/base.php";
?>

<html>
<head>
<title>Member Page</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>
<?php include("includes/header.php");?>
<?php include("includes/nav.php");?>

<div id='section'>
<?php
if(empty($_SESSION['Username'])){
        echo "<p>Please <a href='login.php'>Login</a> or <a href='register.php'>Register</a> to access the Member Page.</p><br><br>";
}
elseif(!empty($_SESSION['Username']) && $_SESSION['UserType'] == 'user'){

	echo "<p>This is <b>" . $_SESSION['Username'] . "</b>'s member page!<br><br><b>" . $_SESSION['Username'] . "</b> is a regular user.</p><br><br>";

}
elseif(!empty($_SESSION['Username']) && $_SESSION['UserType'] == 'admin'){

        echo "<p>This is <b>" . $_SESSION['Username'] . "</b>'s member page!<br><br><b>" . $_SESSION['Username'] . "</b> is an admin and has super privileges.</p><br><br>";

}
?>


</div>

<?php include("includes/footer.php");?>

</body>
</html>

<?php
mysqli_close($link);

?>
