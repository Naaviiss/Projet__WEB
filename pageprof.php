<!doctype html>
<html lang="fr">
<head>
<meta charset="UTF-8">

<form name="form" action="" method="post">
<input type='submit' name='dec' id='dec' value='Deconnection'>
</form>
</html>
<?php
	#Création de la session
	session_start();
	
	#Création des différentes matières
	$matiere = array ("Mathématique","Anglais","Programmation","Algorithme","Economie");
	
	#On choisit la matière en question suivant le professeur qui s'est connecté
	$n_matiere = $_SESSION['nom']{strlen($_SESSION['nom'])-1}; 

	#ON PEUT SUREMENT FAIRE MIEUX MAIS LA JE VOIS PAS 
 	$un = array();
	$deux = array();
	$trois = array();
	$quatre = array();
	$cinq = array();
	
		
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
		$file = $variable.$i.".txt";
		
		#Vérifier si le fichier existe bien
		#Sinon on ne fait rien
		if (file_exists($file)) {
			$monfichier = fopen($file, 'r+');

			while ( !feof($monfichier) ){
				$data = fgetcsv($monfichier, 0, ";");
				#On regarde à quel niveau (1 à 5) la valeur correspond
				switch($data[$n_matiere]){
					case 1:{
							array_push($un, $data);
							break;
					}
					case 2:{
							array_push($deux, $data);
							break;
					}
					case 3:{
							array_push($trois, $data);
							break;
					}
					case 4:{
							array_push($quatre, $data);
							break;
					}
					case 5:{
							array_push($cinq, $data);
							break;
					}
				}
			}
			fclose($monfichier);
		}		
	}#Fin du FOR
	
	#ON PEUT SUREMENT FAIRE MIEUX MAIS JE VOIS PAS POUR L INSTANT 
	echo "<td><strong>", number_format(count($un)),"</strong></td>";
	echo "<td><strong>", number_format(count($deux)),"</strong></td>";
	echo "<td><strong>", number_format(count($trois)),"</strong></td>";
	echo "<td><strong>", number_format(count($quatre)),"</strong></td>";
	echo "<td><strong>", number_format(count($cinq)),"</strong></td>";
	echo "</tr>";		

	
	#On ferme le tableau 
	echo "</table>";
	echo "</div>";	
?>

<?php
if(isset($_POST['dec'])){
	$dec = $_POST['dec'];
	if($dec=="Deconnection"){
		unset($_SESSION["nom"]);
		session_destroy();
		header ('Location: testpourconnexionprof.html');
	}
}
?>