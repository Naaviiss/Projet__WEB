<?php 
	//Création de la session
	session_start();
	if($_SESSION["nom"]==NULL or $_SESSION["role"] != "prof"){
		header ('Location: deconnexion.php');
	}
	else{
?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Page des professeurs</title>
		<link href="css/csspages.css" rel="stylesheet" id="css"/>
		<link href="css/bootstrap.min.css" rel="stylesheet" id="css"/>
		<link rel="icon" href="images/logo-uvsq.png">
    </head>

	<header><?php Include("haut_page.html"); ?></header>
	<body>
	<section>

		<!--Creation du tableau -->

	  <div class="tbl-header">
		<table cellpadding="0" cellspacing="0" border="0">
		  <thead>
			<tr>
<?php
		#Création des différentes matières
		$matiere = array (1 => "Mathématiques","Anglais","Programmation","Algorithme","Economie");
		#On choisit la matière en question suivant le professeur qui s'est connecté
		$n_matiere = $_SESSION['nom']{strlen($_SESSION['nom'])-1}; 
		
		$un = 0;
		$deux = 0;
		$trois = 0;
		$quatre = 0;
		$cinq = 0;
		
		#Creation de la première ligne avec la matiere en question
		echo "<th>",$matiere[$n_matiere],"</th>";

		#Pour la premiÃ¨re ligne avec tous les votes possibles.
		$ligne = array("Très mécontent","Mécontent","Moyen","Satisfait","Très satisfait");
		
		foreach ($ligne as $lign) {
				echo "<th><strong>",$lign,"</strong></th>";
		}

		echo "				</tr>
					</thead>
				</table>
			</div>
			<div class='tbl-content'>
				<table cellpadding='0' cellspacing='0' border='0'>
					<tbody>
						<tr>";
						
		#Creation de la deuxième ligne avec le nombre de votes 
		echo "<td><strong> Nombre de votes</strong></td>";
		
		
		#On va aller voir dans chaque fichier
		$variable="votes/vote-e10";
		for ($i=0;$i<99;$i++){
			if ($i < 10){
				$file = $variable."0".$i.".txt";
			}
			else{
				$file = $variable.$i.".txt";
			}
			#Vérifier si le fichier existe bien
			#Sinon on ne fait rien
			if (file_exists($file)) {
				$monfichier = fopen($file, 'r+');

				while ( !feof($monfichier) ){
					$data = fgetcsv($monfichier, 0, ";");
					#On regarde à quel niveau (1 à 5) la valeur correspond
					#Or n_matiere va de 1 à 5 mais data va de 0 à 4.
					#donc pour rétablir, n_matiere - 1
					switch($data[$n_matiere-1]){
						case 1:{
								$un=$un+1;
								break;
						}
						case 2:{
								$deux=$deux+1;
								break;
						}
						case 3:{
								$trois=$trois+1;
								break;
						}
						case 4:{
								$quatre=$quatre+1;
								break;
						}
						case 5:{
								$cinq=$cinq+1;
								break;
						}
					}
				}
				fclose($monfichier);
			}		
		}#Fin du FOR
		
		echo "<td><strong>".$un."</strong></td>";
		echo "<td><strong>".$deux."</strong></td>";
		echo "<td><strong>".$trois."</strong></td>";
		echo "<td><strong>".$quatre."</strong></td>";
		echo "<td><strong>".$cinq."</strong></td>";
		echo "</tr>";
		
		#On ferme le tableau 
		echo "      	</tbody>
					</table>
				</div>
		</section>";
	}	
?>
</body>
<?php Include("footer.html"); ?>

</html>
