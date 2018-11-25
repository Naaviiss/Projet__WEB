<?php session_start();?>
<!DOCTYPE html>
<html>
    <head>
      <meta charset="utf-8" />
      <title>Page de connexion</title>
			<link href="css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"/>
			<link href="css/css_index.css" rel="stylesheet" id="bootstrap-css"/>
			<link rel="icon" href="images/logo-uvsq.png">
    </head>
	<body class="text-center">
		<div class="container-fluid">
			<div class="container">
				<h1><strong> Connectez-vous !</strong></h1>
				<form method="post" action="connexion.php" class="form">
				  <div class="form-group">
					<label for="exampleInputEmail1">Login</label>
					<?php 
						if (isset($_SESSION["erreur"])){
						?>
							<input type="text" name="nom" class="form-control is-invalid connect" placeholder="login" />
							<label for="exampleInputPassword1">Mot de passe</label>
							<input type="password" name="mdp" id="mdp" class="form-control is-invalid connect" placeholder="mot de passe" />
					<?php
						}
						else{
					?>
						<input type="text" name="nom" class="form-control input-sm chat-input connect" placeholder="login" />
						<label for="exampleInputPassword1">Mot de passe</label>
						<input type="password" name="mdp" id="mdp" class="form-control input-sm chat-input connect" placeholder="mot de passe" />
					<?php
						}//on ferme le else
					?>
				  </div>
				  <button type="submit" class="btn btn-lg btn-primary btn-block">Submit</button>
				</form>
			</div>
		</div>
	</body>
	
	<?php Include("footer.html"); ?>

</html>