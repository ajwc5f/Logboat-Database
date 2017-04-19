
<?php

include "includes/base.php";
?>

<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>
<?php include("includes/header.php");?>
<?//php include("includes/nav.php");?>

<div id='section'>

		<br>
		<div class="container">
		<form class="form-horizontal" method="post" action="" name="loginform" id="loginform">
		<fieldset>
		<legend>Login</legend>
		<p>Thanks for visiting! Please either login below, or <a href="register.php">click here</a> to register.</p>
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
		<br>
		<div class="form-group">
			<label class="col-md-5 control-label" for="username">Username:</label>
			<div class="col-md-2">
				<input class="form-control input-md" type="text" name="username" id="username">
			</div>
		</div>
		<div class="form-group">			
			<label class="col-md-5 control-label" for="password">Password:</label>
			<div class="col-md-2">
				<input class="form-control input-md" type="password" name="password" id="password">
			</div>
		</div>
		<div class="form-group">
			<label class='col-md-5 control-label'></label>
			<div class="col-md-2">
				<input class="btn btn-info form-control" type="submit" name="login" id="login" value="Login" class="button">
			</div>
		</div>
		</fieldset>
		</form>
		</div>

</div>
<?php include("includes/footer.php");?>
</body>
</html>
<?php
if(isset($_POST['login'])) {
        if($_POST['username'] == '') {
                $_SESSION['error'] = "Error: You must provide a username to login.";
                header('Refresh:0');
                exit();
        }
        else if($_POST['password'] == '') {
                $_SESSION['error'] = "Error: You must provide a password to login.";
                header('Refresh:0');
                exit();
        }
        $sql = 'SELECT salt, hashed_password, usertype FROM user WHERE username = ?';
        if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", htmlspecialchars($_POST['username']));
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
        }
        if (mysqli_num_rows($result) == 0) {
                $_SESSION['error'] = "Error: That username does not exist. Please try again.";
                header('Refresh:0');
                exit();
        }
         else {
                $row = mysqli_fetch_assoc($result);
                $localhash = sha1( $row['salt'] . htmlspecialchars($_POST['password']) );

                if ($localhash == $row['hashed_password']){
                        //require "page1.php";
                        $_SESSION['LoggedIn'] = true;
                        $_SESSION['Username'] = $_POST['username'];
                        $_SESSION['UserType'] = $row['usertype'];
			
			$_SESSION['success'] = "Login Successful.";
                        header("Location: index.php");
                }
                else {
                        $_SESSION['error'] = "Error: Password is incorrect. Please try again.";
                        header('Refresh:0');
                        exit();
                }
                mysqli_stmt_close($stmt);
        }
}
?>
<?php
mysqli_close($link);

?>
