<?php
	session_start();
	if($_SESSION["nom"]==NULL or $_SESSION["role"] != "admin"){
		header ('Location: deconnexion.php');
	}

	require ('count.php');
?>
 

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8" />
        <title>Page de l'adminitrateur</title>
		<link href="css/csspages.css" rel="stylesheet" id="css"/>
		<link href="css/bootstrap.min.css" rel="stylesheet" id="css2"/>
		<link rel="icon" href="images/logo-uvsq.png">
	</head>
	
	<header>
		<?php Include("haut_page.html"); ?>
	</header>

	<body>
		<section>
			<!--Creation du tableau -->
			<h1 class="txtAdmin">Bonjour <?php 
			echo ucfirst($_SESSION["nom"]);?><br></h1>
			<p class="pAdmin">Voici un tableau résumant les résultats obtenus grâce aux votes des étudiants</p>
			<div class="tbl-header">


		<?php
			/************************************************/
			/*												*/
			// 					CALCUL  					//
			/*												*/
			/************************************************/

			//Création de la première ligne pour l'ensemble des votes
			$matieres = array ("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
			$notes    = array ("Très satisfait","Satisfait","Moyen","Mécontent","Très mécontent");
			//nombre de fichiers lu
			$nb_file=0; 
			/* une liste pour chaque matière 
			 * contient les notes recu par la matière */
			$liste_maths=array(); 
			$liste_anglais=array();
			$liste_programmation=array();
			$liste_algorithme=array();
			$liste_economie=array();
			/*
			* 0 = "sans avis";
			* 1 = "Très mécontent";
			* 2 = "Mécontent";
			* 3 = "Moyen";
			* 4 = "Satisfait";
			* 5 = "Très satisfait";
			*/
			// tableau avec tous les resultats qu'on enverra ensuite via une session pour le pdf
			$tab = array();
			$moyecart = array();
			//pour transmettre les matieres au PDF	
			$_SESSION["notes"] = $notes;
			$_SESSION["matieres"] = $matieres;

			// REMPLIR LES LISTES de notes 
			for($i=1001; $i<1001+nbEtudiant(); $i++){
				$file = "votes/vote-e" .$i .".txt";
				// Si le fichier existe
				if (file_exists($file)) {
					$monfichier = fopen($file, 'r');
					// Affichage des notes
					while ( !feof($monfichier) ){
						$dataFile = fgetcsv($monfichier, 0, ";");
						foreach ($dataFile as $key =>$contenu) {
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
						}
						$nb_file += 1; //on incrémente le nombre de fichiers lus
					}
					fclose($monfichier);
				}
			}
			$liste_matieres = array($liste_maths, $liste_anglais, $liste_programmation, $liste_algorithme, $liste_economie);

			// CALCUL DE LA MOYENNE PAR MATIERE
			function calculMoy($liste){
				$arr_size=count($liste); 
				$moy_liste=array_sum($liste)/$arr_size;
				return $moy_liste;
			}
			// CALCUL ECART TYPE PAR MATIERE
			function calculEcartType($liste){
				$arr_size=count($liste); 
				$moy_liste=calculMoy($liste);
				$ans=0; 
				foreach($liste as $element){ 
					$ans+=pow(($element-$moy_liste),2); 
				}
				$variance = $ans/$arr_size; 
				$ecart_type = sqrt($variance);
				return $ecart_type;
			}
			/* CALCUL le nombre de (la note demandé) DANS (liste matière demandé)
			 * $liste  = liste matière demandé
			 * $valeur = la note demandé */
			function calculNbValeur($liste, $valeur) {
				$arr = array_count_values($liste);
				if(array_key_exists($valeur, $arr)){
					return $arr[$valeur];
				}
				else{
					return 0;
				}
			}

			/************************************************/
			/*												*/
			// 					AFFICHAGE  					//
			/*												*/
			/************************************************/

			/***********************************************/
			// 1er tableau avec compte des notes
			/***********************************************/
			// En tête
			echo"<table cellpadding='0' cellspacing='0' border='1'>
					<thead>
							<tr>";
			echo "<th></th>";//1ere case vide 
			foreach ($notes as $lign) {
				echo "<th><strong>",$lign,"</strong></th>";
			}
			echo "			</tr>
					</thead>
				</table>
			</div>
			<div class='tbl-content'>
				<table cellpadding='0' cellspacing='0' border='0'>
					<tbody>";
			
			// Intérieur de la table
			for($j=0; $j<5; $j++){
				$liste=$liste_matieres[$j];
				echo"<tr>";
					echo"<th>" .$matieres[$j] ."</th>";
					array_push($tab, $matieres[$j]);
					for($k=5; $k>0; $k--){
						$val = calculNbValeur($liste_matieres[$j],$k);
						echo"<td>" .$val ."</td>";
						array_push($tab, $val);
					}
				echo"</tr>";
			}
			//on créé la session pour la table avec les notes
			$_SESSION["table"] = $tab;
			//on ferme le premier tableau
			echo "	</tbody>
				</table>
			</div>
		</section>";		

			/***********************************************/
			// 2eme tableau avec écart type et moyenne
			/***********************************************/
			// Pour la moyenne et l'écart type
			//en tete
			echo "<section>
					<!--Creation du tableau -->
					<div class='tbl-header'>
						<table cellpadding='0' cellspacing='0' border='1'>
							<thead>
								<tr>
								<th></th>"; // Ligne vide pour que tout soit aligné		
			// En tête
			foreach ($matieres as $lign) {
					echo "<th><strong>",$lign,"</strong></th>";
			}
			
			echo "				</tr>
							</thead>
						</table>
					</div>
					<div class='tbl-content'>
						<table cellpadding='0' cellspacing='0' border='0'>
							<tbody>";

			$liste_matiere = array($liste_maths, $liste_anglais, $liste_programmation, $liste_algorithme, $liste_economie);
			
			// AFFICHAGE moyenne
			echo"<tr>
				<th>Moyenne</th>";
				array_push($moyecart,"Moyenne");
			for($i=0; $i<5; $i++){
				$moy = round(calculMoy($liste_matiere[$i]),3);
				echo"<td>".$moy."</td>";
				array_push($moyecart,$moy);
			}
			echo"</tr>";

			// AFFICHAGE ecart type
			echo"<tr><th>Ecart type</th>";
			array_push($moyecart,"Ecart-type");
			for($i=0; $i<5; $i++){
				$ecart_type = round(calculEcartType($liste_matiere[$i]),3);
				echo"<td>".$ecart_type."</td>";
				array_push($moyecart,$ecart_type);
			}
			echo"</tr>";

			//on envoie le deuxieme tableau au PDF
			$_SESSION["moyecart"] = $moyecart;

			#On ferme le deuxième tableau 
			echo "     		</tbody>
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
