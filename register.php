<html>
<?php
include("includes/base.php");
ob_start();
?>
        <head>
                <title>Register</title>
                 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"><!-- Latest compiled and minified CSS -->
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"><!-- Optional theme -->
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script><!-- Latest compiled and minified JavaScript -->
                <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
        </head>
        <body>
	<?php include("includes/header.php");?>
	<div id="section">
	<br>
	<div class="container">
                <form class="form-horizontal" method="post" action="" name="registerform" id="registerform">
                <fieldset>
                <legend>Register</legend>
		<p>Please enter your details below to register.</p>
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
                        <div class="col-md-3">
                                <input class="form-control input-md" type="text" name="username" id="username">
                        	<span class="help-block">Must be less than 20 characters.</span> 
			</div>
			
                </div>
                <div class="form-group">
                        <label class="col-md-5 control-label" for="password">Password:</label>
                        <div class="col-md-3">
                                <input class="form-control input-md" type="password" name="password" id="password">
                        </div>
                </div>
                <div class="form-group">
                        <label class="col-md-5 control-label">Confirm Password:</label>
                        <div class="col-md-3">
                                <input class="form-control input-md" type="password" name="confirm_password" id="confrim_password">
                        </div>
                </div>
                <div class="form-group">
			<label class='col-md-5 control-label'></label>
                        <div class="col-md-3">
                                <input class="btn btn-info form-control" type="submit" name="register" id="register" value="Register" class="button">
                        </div>
                </div>
                </fieldset>
                </form>
   	</div>
	</div>
</body>
</html>
<?php
	if(isset($_POST['register'])) {
                $username = htmlspecialchars($_POST['username']);
                $password = htmlspecialchars($_POST['password']);
                $conf_password = htmlspecialchars($_POST['confirm_password']);

                $query = "SELECT username FROM user";

                if($stmt = mysqli_prepare($link, $query)){

                        mysqli_stmt_execute($stmt);

                        $result = mysqli_stmt_get_result($stmt);
                        while($row = mysqli_fetch_assoc($result)){
                                foreach($row as $key => $value) {
                                        if ($username == $value) {
                                                $_SESSION['error'] = "Error: That username is already taken.";
                                                header('Refresh:0');
                                                exit();
                                        }
                                }
                        }
                        mysqli_stmt_close($stmt);
                }

                if($username == ''){
                        $_SESSION['error'] = "Error: Username cannot be empty.";
                        header('Refresh:0');
                        exit();
                }
                else if(strlen($username) > 20) {
                        $_SESSION['error'] = "Error: Username cannot be more than 20 characters.";
                        header('Refresh:0');
                        exit();
                }
                else if($password == ''){
                        $_SESSION['error'] = "Error: Password cannot be empty.";
                        header('Refresh:0');
                        exit();
                }
                else if($conf_password == ''){
                        $_SESSION['error'] = "Error: Password confirmation cannot be left blank.";
                        header('Refresh:0');
                        exit();
                }
		else if($password != $conf_password){
                        $_SESSION['error'] = "Error: Passwords do not match.";
                        header('Refresh:0');
                        exit();
                }
                else{
                        $insert_query = "INSERT INTO user (username,salt,hashed_password,usertype) VALUES (?,?,?,'user')";

                        mt_srand();
                        $salt = mt_rand();
                        $pwhash = sha1($salt . $password);

                        if($stmt = mysqli_prepare($link, $insert_query)){
                                mysqli_stmt_bind_param($stmt,"sss",htmlspecialchars($username),htmlspecialchars($salt),htmlspecialchars($pwhash));
                                if(mysqli_stmt_execute($stmt)) {
                                        $_SESSION['success'] = "Success: Your account has been created. Please login below.";
                                        header('location:login.php');
                                        exit();
                                }
                                else {
                                        $_SESSION['error'] = "Error: Query not executed";
                                        header('Refresh:0');
                                        exit();
                                }
                                mysqli_stmt_close($stmt);
                        }
                }
	}
?>
<?php
        mysqli_close($link);
?>

