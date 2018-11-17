<!-- Visualiser bilan des votes regroupés par ue sous la forme d'un tab -->
<!-- Tab avec ; répartition des notes ; la moyenne ; l'écart type -->

<!-- RAJOUTER -->
<!-- Nom prof en colonne -->
<!-- Possibilité un tableau par prof (ex : 2notes de 3 ...) -->
<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
    <meta charset="UTF-8">
	<title>Page admin</title>
</head>
<body>
	<h1>Projet PhP</h1>
    <h3>Côté admin</h3> 


<?php
	$first_doc = 1001;
	$last_doc = 1020;
	
	// En tête
?>
	<table border='1'>
		<tr>
			<th></th>
			<th>Maths</th>
			<th>Anglais</th>
			<th>Programmation</th>
			<th>Algorithme</th>
			<th>Economie</th>
		</tr>
	<?php
	for($i=$first_doc; $i<=$last_doc; $i++){
		$file = "votes/vote-e" .$i .".txt";
		// Si le fichier existe
		if (file_exists($file)) {
			$monfichier = fopen($file, 'r+');
			// Affichage des notes
			while ( !feof($monfichier) ){
				echo "<tr>";
				$dataFile = fgetcsv($monfichier, 0, ";");
				//colonne vide gauche
				echo "<td></td>";
				foreach ($dataFile as $contenu) {
					echo "<td>",$contenu,"</td>";
				}
				echo "</tr>";
			}
			fclose($monfichier);
		}
	}
		// LIGNE MATIERE
	echo "<tr><th></th><th>Maths</th><th>Anglais</th><th>Programmation</th><th>Algorithme</th><th>Economie</th></tr>";
	// MOYENNE DES NOTES
	$moy=array(0,0,0,0,0);
	$nb_file=0;
	for($i=$first_doc; $i<=$last_doc; $i++){
		$file = "votes/vote-e" .$i .".txt";
		// Si le fichier existe
		if (file_exists($file)) {
			$monfichier = fopen($file, 'r+');
			// Calcul moyenne
			while ( !feof($monfichier) ){
				$dataFile = fgetcsv($monfichier, 0, ";");
				foreach ($dataFile as $key=>$contenu) {
					$moy[$key]= $moy[$key]+$contenu;
				}
			}
			$nb_file = $nb_file + 1;
			fclose($monfichier);
		}
	}
	for($i=0; $i<5; $i++){
		$moy[$i]=$moy[$i]/$nb_file;
	}
	// Affiche
	echo"<tr><th>Moyenne</th>";
	for($i=0; $i<5; $i++){
		echo"<td>".$moy[$i]."</td>";
	}
	echo"<tr>";

	// ECART TYPE DES NOTES
	//liste notes chaque matière
	$nb_file=0;
	$liste_maths=array();
	$liste_anglais=array();
	$liste_programmation=array();
	$liste_algorithme=array();
	$liste_economie=array();
	for($i=$first_doc; $i<=$last_doc; $i++){
		$file = "votes/vote-e" .$i .".txt";
		// Si le fichier existe
		if (file_exists($file)) {
			$monfichier = fopen($file, 'r+');
			// Remplir liste
			while ( !feof($monfichier) ){
				$dataFile = fgetcsv($monfichier, 0, ";");
				foreach ($dataFile as $key=>$contenu) {
					switch($key){
						case 0:
							array_push($liste_maths, $contenu);
							break;
						case 1:
							array_push($liste_anglais, $contenu);
							break;
						case 2:
							array_push($liste_programmation, $contenu);
							break;
						case 3:
							array_push($liste_algorithme, $contenu);
							break;
						case 4:
							array_push($liste_economie, $contenu);
							break;
					}
				}
			}
			$nb_file = $nb_file + 1;
			fclose($monfichier);
		}
	}
	// calcul
	$liste_matiere = array($liste_maths, $liste_anglais, $liste_programmation, $liste_algorithme, $liste_economie);
	echo"<tr><th>Ecart type</th>";
	for($i=0; $i<5; $i++){
		$arr_size=count($liste_matiere[$i]); 
		$moy_liste=array_sum($liste_matiere[$i])/$arr_size;
		$ans=0; 
		foreach($liste_matiere[$i] as $element){ 
			$ans+=pow(($element-$moy_liste),2); 
		}
		$variance = $ans/$arr_size; 
		$ecart_type = sqrt($variance);
		echo"<td>".round($ecart_type,3)."</td>";
	}
	echo"</tr>";


	echo "</table>";
	?>

</body>
</html>
