<div id='wrap'>
<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button tpe="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
	
      			<a class="navbar-brand" href="index.php">
        			<img alt="Brand" src="images/logo.png">
      			</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
                        	<li>
					<a href="index.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span>	Home </a>
				</li>
                        	<li>
					<a href="inventory.php"><span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>	Inventory</a>
				</li>
                        	<li>
					<a href="schedule.php"><span class="glyphicon glyphicon-calendar"  aria-hidden="true"></span>	Schedule</a>
				</li>
                        	<li>
					<a href="trends.php"><span class="glyphicon glyphicon-signal" aria-hidden="true"></span>	Trends</a>
				</li>
                	</ul>
	
			<ul id="logininput" class="nav navbar-nav navbar-right">
			<?php

				if(!empty($_SESSION['LoggedIn']) && !empty($_SESSION['Username'])){
        				echo "<li><a href='' class='inactivelink'>Logged in as <b>". $_SESSION['Username']."</b>.</a></li> ";
        				echo "<li><a href='logout.php'> Logout</a></li>";
				}
				else{
        				echo "<li><a href='login.php'>Login</a></li>";
        				echo "<li><a href='register.php'>Register</a></li>";
				}
			?>	
			</ul>
		</div>
	</div>
</nav>
