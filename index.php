<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page de connexion</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"/>
		<link href="css/css_index.css" rel="stylesheet" id="bootstrap-css"/>
    </head>
	<body class="text-center">
		<div class="container-fluid">
			<div class="container">
				<form method="post" action="connexion.php" class="form">
				  <div class="form-group">
					<label for="exampleInputEmail1">Login</label>
					<input type="text" name="nom" class="form-control input-sm chat-input" placeholder="username" />
					<label for="exampleInputPassword1">Password</label>
					<input type="password" name="mdp" id="mdp" class="form-control input-sm chat-input" placeholder="password" />
				  </div>
				  <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
				</form>
			</div>
		</div>
	</body>
	
<footer><?php Include("footer.html"); ?></footer>

</html>
