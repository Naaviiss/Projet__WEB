<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Concours Web 2019 | Groupe 1</title>
	<link rel="shortcut icon" href="images/uvsq-logo.jpg">
	<!-- Stylesheets nécessaires -->
	<link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/font-awesome.min.css">
	<!-- Custom styles for our template -->
	<link rel="stylesheet" href="css/bootstrap-theme.css" media="screen" >
	<link rel="stylesheet" href="css/main.css">

</head>

<body class="home">
	<!-- Fixed navbar -->
	<div class="navbar navbar-inverse navbar-fixed-top headroom" >
		<div class="container">
			<div class="navbar-header">
				<!-- Button for smallest screens -->
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
				<a class="navbar-brand" href="index.html"><img src="images/uvsq-logo2.jpg" alt="Progressus HTML5 template"></a>
			</div>
			<div class="navbar-collapse collapse">
				<ul class="nav navbar-nav pull-right">
					<li><a class="btn" href="deconnexion.php">SE DECONNECTER</a></li>
				</ul>
			</div><!--/.nav-collapse -->
		</div>
	</div> 
	<!-- /.navbar -->

	<!-- Header -->
	<header id="head">
		<div class="container">
			<div class="row">
				<h1 class="lead">Ressources</h1>
			</div>
		</div>
	</header>
	<!-- /Header -->

	<!-- Intro -->
	<div class="container text-center jumbotron ">
<?php
//$connexion = mysqli_connect("localhost","g1","mdp01")
//or die ("Tu es nul. Recommence.");
$connexion = mysqli_connect("localhost","root","")
or die ("Tu es nul. Recommence.");

$bd="WebContest";

mysqli_select_db($connexion,$bd)
or die ("Toujours pas.");

$requete="select id,nom,jour,personne from Ressource";
$resultat=mysqli_query($connexion,$requete);
echo "<body>";
echo "<h1> Voici la table des ressources.</h1>";
echo "<center><table border='1' cellpadding='5' cellpacing='9'>";

echo "<tr><td>L'ID de la ressource</td><td>Le nom de la ressource</td><td>La date de reservation</td><td>Nom du chercheur</td></tr>";

while($ligne=mysqli_fetch_row($resultat)){
	echo "<tr>";
	for ($i =0;$i<4;$i++){
		  $test = $ligne[0];
		//La ligne sur la date
		if ($i ==2 || $i==3){
			//Est-ce que la date est renseignée?
			if ($ligne[2] != null){
				//Si un chercheur a reservé
				echo "<td>".$ligne[$i]."</td>";
			}
			else{
				echo "<td> Vide </td>";
			}

		}
		else{
			echo "<td>".$ligne[$i]."</td>";
		}
	}
	if ($ligne[2] == null){
			//Si pas reservé
		echo "<td>
				<a href='reservation.php?id=".$test."'>Reservez</a>
			</td>";			
	}

	echo "</tr>";

}
echo"</table>";

$ligne = null;
$requete="select * from Ressource where personne = $id";
$resultat=mysqli_query($connexion,$requete);
echo "<h1> Voici la table des ressources réservées par ".$id."</h1>";
echo "<center><table border='1' cellpadding='5' cellpacing='9'>";
while($ligne=mysqli_fetch_row($resultat)){
	echo "<tr>";
	for ($i =0;$i<3;$i++){
			echo "<td>".$ligne[$i]."</td>";
		}
	echo "</tr>";
}
echo "</table>
</center>";

mysqli_close($connexion);?>

	</div>
	<!-- /Intro-->
	
	<!-- Social links. @TODO: replace by link/instructions in template -->
	<section id="social">
		<div class="container">
			<div class="wrapper clearfix">
				<!-- AddThis Button BEGIN -->
				<div class="addthis_toolbox addthis_default_style">
				<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
				<a class="addthis_button_tweet"></a>
				<a class="addthis_button_linkedin_counter"></a>
				<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
				</div>
				<!-- AddThis Button END -->
			</div>
		</div>
	</section>
	<!-- /social links -->


	<footer id="footer" class="top-space">

		<div class="footer1">
			<div class="container">
				<div class="row">
					
					<div class="col-md-6 widget">
						<h3 class="widget-title">Contact</h3>
						<div class="widget-body">
							<p>
								Tél : 01 39 25 48 33<br>
								Chef de service scolarité : <a href="mailto:#">veronique.ronsse@iut-velizy.uvsq.fr</a><br><br>
								10-12 Avenue de l'Europe, 78140 Vélizy-Villacoublay
							</p>	
						</div>
					</div>

					<div class="col-md-6 widget">
						<h3 class="widget-title">Concours web 2019</h3>
						<div class="widget-body">
							<p>Marion ARMENGAUD<br>Florian MARQUES<br>Ludivine DUCAMP<br>Hugo HAMEL<br>Nancy CASSAND</p>
						</div>
					</div>

				</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

		<div class="footer2">
			<div class="container">
				<div class="row">
					
					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="simplenav">
								<b><a href="deconnexion.php">SE DECONNECTER</a></b>
							</p>
						</div>
					</div>

					<div class="col-md-6 widget">
						<div class="widget-body">
							<p class="text-right">
								Copyright &copy; 2019, Groupe 1</a> 
							</p>
						</div>
					</div>

				</div> <!-- /row of widgets -->
			</div>
		</div>

	</footer>	
		




	<!-- JavaScript libs are placed at the end of the document so the pages load faster -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script src="http://netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
	<script src="js/headroom.min.js"></script>
	<script src="js/jQuery.headroom.min.js"></script>
	<script src="js/template.js"></script>
</body>
</html>