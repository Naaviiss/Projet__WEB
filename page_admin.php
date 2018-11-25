<?php
	session_start();
	if($_SESSION["nom"]==NULL or $_SESSION["role"] != "admin"){
		header ('Location: deconnexion.php');
	}
?>
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Page de l'adminitrateur</title>
		<link href="css/csspages.css" rel="stylesheet" id="css"/>
		<link href="css/bootstrap.min.css" rel="stylesheet" id="css"/>
		<link rel="icon" href="images/logo-uvsq.png">
	</head>
	
	<header>
		<?php Include("haut_page.html"); ?>
	</header>

	<body>
	<section>
		<!--Creation du tableau -->
		<h1 class="txtAdmin">Bonjour <?php echo ucfirst($_SESSION["nom"]);?></br></h1>
		<p class="pAdmin">Voici un tableau résumant les résultats obtenus grâce aux votes des étudiants</p>
		<div class="tbl-header">
			<table id="test" cellpadding="0" cellspacing="0" border="0">
			<thead>
				<tr>
	<?php
		//tableau avec tous les resultats qu'on enverra ensuite via une session pour le pdf
		$tab = array();

		//indices des premiers et derniers documents

		$first_doc = 1001;
		$last_doc = 1020;
		
		//Création de la première ligne pour l'ensemble des votes
		$matiere = array ("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
		$_SESSION["matieres"] = $matiere; //pour transmettre les matieres au PDF

		foreach ($matiere as $lign) {
				echo "<th><strong>",$lign,"</strong></th>";
		}
		echo "				</tr>
						</thead>
					</table>
				</div>
				<div class='tbl-content'>
					<table cellpadding='0' cellspacing='0' border='0'>
						<tbody>"
							;
							
		
		//on récupère les connées des votes pour les afficher et calculer la moyenne
		$nb_file=0; //nombre de fichiers lu
		$moy=array(0,0,0,0,0); //tableau avec toutes les moyennes
		$liste_maths=array(); //liste des notes pour chaque matière
		$liste_anglais=array();
		$liste_programmation=array();
		$liste_algorithme=array();
		$liste_economie=array();

		for($i=$first_doc; $i<=$last_doc; $i++){
			$file = "votes/vote-e" .$i .".txt";
			// Si le fichier existe
			if (file_exists($file)) {
				$monfichier = fopen($file, 'r');
				// Affichage des notes
				while ( !feof($monfichier) ){
					echo "<tr>";
					$dataFile = fgetcsv($monfichier, 0, ";");
					foreach ($dataFile as $key =>$contenu) {
						echo "<td>",$contenu,"</td>"; //on affiche la note
						$moy[$key]= $moy[$key]+$contenu; //pour calculer les moyennes
						switch($key){ //permet d'associer les notes correspondanes à chaque matière
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
						array_push($tab,$contenu);
					}
					echo "</tr>";
					$nb_file = $nb_file + 1; //on incrémente le nombre de fichiers lus
				}
				fclose($monfichier);
			}
		}

		//on créé la session pour la table avec les notes
		$_SESSION["table"] = $tab;
		
		//On ferme le premier tableau
		echo "      	</tbody>
					</table>
				</div>
		</section>";		
			
			
		// Création de l'autre tableau  
		$moyecart = array();
		// Pour la moyenne et l'écart type
		echo "<section>
				<!--Creation du tableau -->

				<div class='tbl-header'>
					<table cellpadding='0' cellspacing='0' border='0'>
						<thead>
							<tr>
							<th></th>"; // Ligne vide pour que tout soit aligné
							
		//Toujours la ligne avec chaque matière					
		foreach ($matiere as $lign) {
				echo "<th><strong>",$lign,"</strong></th>";
		}
		
		echo "				</tr>
						</thead>
					</table>
				</div>
				<div class='tbl-content'>
					<table cellpadding='0' cellspacing='0' border='0'>
						<tbody>"
							;
		
		// CALCUL ET AFFICHAGE DE LA MOYENNE DES NOTES
		for($i=0; $i<5; $i++){
			$moy[$i]=$moy[$i]/$nb_file;
		}
		// Affiche la moyenne pour chaque matière
		echo"<tr>
			<th>Moyenne</th>";
			array_push($moyecart,"Moyenne");
		for($i=0; $i<5; $i++){
			echo"<td>".$moy[$i]."</td>";
			array_push($moyecart,$moy[$i]);
		}
		echo"</tr>";

		// calcul
		$liste_matiere = array($liste_maths, $liste_anglais, $liste_programmation, $liste_algorithme, $liste_economie);
		echo"<tr><th>Ecart type</th>";
		array_push($moyecart,"Ecart-type");
		for($i=0; $i<5; $i++){
			$arr_size=count($liste_matiere[$i]); 
			$moy_liste=array_sum($liste_matiere[$i])/$arr_size;
			$ans=0; 
			foreach($liste_matiere[$i] as $element){ 
				$ans+=pow(($element-$moy_liste),2); 
			}
			$variance = $ans/$arr_size; 
			$ecart_type = sqrt($variance);
			array_push($moyecart,round($ecart_type,3));
			echo"<td>".round($ecart_type,3)."</td>";
		}
		echo"</tr>";

		//on envoie le deuxieme tableau au PDF
		$_SESSION["moyecart"] = $moyecart;
		
		#On ferme le deuxième tableau 
		echo "      	</tbody>
						</table>
					</div>
			</section>";
		?>

		<!-- On ajoute le bouton pour créer le pdf -->
		<div class="container pdf">
			<section>
				<a class="btn btn-primary boutonPDF" href="./creer_pdf.php" role="button">Générer un PDF</a>
			</section>
		</div>
	</body>
	<?php Include("footer.html"); ?>
</html>
