<?php session_start(); ?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	</head>
	
	<body>
		<form method="post" action="connexion.php">
			<input type="text" name="nom" class="form-control input-sm chat-input" placeholder="username" />
			<br/>
			<input type="password" name="mdp" id="mdp" class="form-control input-sm chat-input" placeholder="password" />
			<br/>
			<div class="wrapper">
				<span class="group-btn">
					<input type="submit" name="ok" value="Login" class="btn btn-primary btn-md"/>
				</span>
			</div>
		</form>
	</body>
</html>