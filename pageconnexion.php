<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Page de connexion</title>
		<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"/>
    </head>
	<?php Include("haut_page.html"); ?>
	<body>
		<div class="container-fluid">
			<div class="container">
				<form method="post" action="connexion.php">
				  <div class="form-group">
					<label for="exampleInputEmail1">Login</label>
					<input type="text" name="nom" class="form-control input-sm chat-input" placeholder="username" />
				  </div>
				  <div class="form-group">
					<label for="exampleInputPassword1">Password</label>
					<input type="password" name="mdp" id="mdp" class="form-control input-sm chat-input" placeholder="password" />
				  </div>
				  <button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</body>
</html>
