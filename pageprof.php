<?php 
	//Création de la session
	session_start();
?>

<!doctype html>
<html lang="fr">
	<head>
	<meta charset="UTF-8">
	</head>
	<body>
		<form name="form" action="deconnexion.php" method="post">
			<input type='submit' name='dec' id='dec' value='Deconnexion'>
		</form>
	</body>
</html>
<?php
	if (isset($_SESSION["nom"])){ //si l'utilisateur est connecté
		#Création des différentes matières
		$matiere = array (1 => "Mathématique","Anglais","Programmation","Algorithme","Economie");
		#On choisit la matière en question suivant le professeur qui s'est connecté
		$n_matiere = $_SESSION['nom']{strlen($_SESSION['nom'])-1}; 
		
		$un = 0;
		$deux = 0;
		$trois = 0;
		$quatre = 0;
		$cinq = 0;
		
			
		#Creation du tableau 
		echo "<div id='droite'><table border='1' cellpadding='8'>";
		echo "<tr>";
		
		#Creation de la première ligne avec la matiere en question
		echo "<td><font color=\"blue\"><strong>",$matiere[$n_matiere],"</strong></font></td>";
		
		#Pour la première ligne avec tous les votes possibles.
		$ligne = array(1,2,3,4,5);
		foreach ($ligne as $lign) {
				echo "<td><strong>",$lign,"</strong></td>";
		}
		echo "</tr>";
		
		#Creation de la deuxième ligne avec le nombre de votes 
		echo "<td><strong> Nombre de votes</strong></td>";
		
		
		#On va aller voir dans chaque fichier
		$variable="vote-e10";
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
		echo "</table>";
		echo "</div>";
	}	
	else{
		header('location: pageconnexion.php');
	}
?>
