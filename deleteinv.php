
<?php
include "includes/base.php";
?>

<html>
<head>
<title>Delete</title>
<link rel="stylesheet" type="text/css" href="stylesheet.css">

</head>
<body>
<?php include("includes/header.php");?>
<?php include("includes/nav.php");?>

<div id='section'>

<?php

if($_POST['deletetable']!=''){
        $table = htmlspecialchars($_POST['deletetable']);
}
if($_POST['deleteid']!=''){
        $id = htmlspecialchars($_POST['deleteid']);
}

//ALTER TABLE city DROP FOREIGN KEY `city_ibfk_1`;
//ALTER TABLE city ADD CONSTRAINT `city_ibfk_1` FOREIGN KEY (`CountryCode`) REFERENCES `country` (`Code`) ON DELETE CASCADE;
//ALTER TABLE countrylanguage DROP FOREIGN KEY `countryLanguage_ibfk_1`;
//ALTER TABLE countrylanguage ADD CONSTRAINT `countryLanguage_ibfk_1` FOREIGN KEY (`CountryCode`) REFERENCES `country` (`Code`) ON DELETE CASCADE; 

if($table == "ingredient"){

	$sql = "DELETE FROM " . $table . " WHERE name = ?";

	if($stmt = mysqli_prepare($link, $sql)){

               mysqli_stmt_bind_param($stmt,'s',$id);

                mysqli_stmt_execute($stmt);

                mysqli_stmt_close($stmt);
	
		$_SESSION['success'] = "Success: Ingredient - " . $id . " - successfully deleted.";
		header("location:inventory.php");
		exit();
        }
	else {
		$_SESSION['error'] = "Error: Ingredient - " . $id . " - not successfully deleted.";
		header("location:inventory.php");
		exit();
	} 

}
else if($table == "keg"){

	$sql = "DELETE FROM " . $table . " WHERE keg_id = ?";

	if($stmt = mysqli_prepare($link, $sql)){

        	mysqli_stmt_bind_param($stmt,'s',$id);

        	mysqli_stmt_execute($stmt);

		mysqli_stmt_close($stmt);

		$_SESSION['success'] = "Success: Keg - " . $id . " - successfully deleted.";
                header("location:inventory.php");
                exit();
        }
        else {
                $_SESSION['error'] = "Error: Keg - " . $id . " - not successfully deleted.";
                header("location:inventory.php");
                exit();
	}

}

//echo '<meta http-equiv="refresh" content="1; URL=failure.php" />';
?>



</div>

<?php include("includes/footer.php");?>

</body>
</html>

<?php
mysqli_close($link);

?>
