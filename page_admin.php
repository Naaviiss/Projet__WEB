<?php
	session_start();
	if($_SESSION["nom"]==NULL or $_SESSION["role"] != "admin"){
		header ('Location: deconnexion.php');
	}
include ('count.php.php');
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
		<h1 class="txtAdmin">Bonjour <?php 
		echo ucfirst($_SESSION["nom"]);?></br></h1>
		<p class="pAdmin">Voici un tableau résumant les résultats obtenus grâce aux votes des étudiants</p>
		<div class="tbl-header">


	<?php
		/************************************************/
		/*												*/
		// 					CALCUL  					//
		/*												*/
		/************************************************/

		//Création de la première ligne pour l'ensemble des votes
		$matiere = array ("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
		$notes   = array ("Très satisfait","Satisfait","Moyen","Mécontent","Très mécontent");	
		//nombre de fichiers lu
		$nb_file=0; 
		//liste des notes pour chaque matière
		$liste_maths=array(); 
		$liste_anglais=array();
		$liste_programmation=array();
		$liste_algorithme=array();
		$liste_economie=array();
		//liste count note pour chaque note(0,1,2...) par matière
		$liste_maths2=array(1=>0,2=>0,3=>0,4=>0,5=>0); 
		$liste_anglais2=array(1=>0,2=>0,3=>0,4=>0,5=>0);
		$liste_programmation2=array(1=>0,2=>0,3=>0,4=>0,5=>0);
		$liste_algorithme2=array(1=>0,2=>0,3=>0,4=>0,5=>0);
		$liste_economie2=array(1=>0,2=>0,3=>0,4=>0,5=>0);
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
		$_SESSION["matieres"] = $matiere;

		// REMPLIR LES LISTES de notes par matière
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
		// CALCUL nb de vote par matiere
		$liste_note = array($liste_maths, $liste_anglais, $liste_programmation, $liste_algorithme, $liste_economie);
		$liste_nb_note = array($liste_maths2, $liste_anglais2, $liste_programmation2, $liste_algorithme2, $liste_economie2);
		for($j=0; $j<5; $j++){
			$listeN = $liste_note[$j]; // passe sur liste de notes de chaque matière
			$listeNbNote = $liste_nb_note[$j]; // passe sur le compte de notes de chaque matière
			for($k=0; $k<$nb_file; $k++){
				$note = $listeN[$k];
				$listeNbNote[$note] += 1;
				$liste_nb_note[$j]=$listeNbNote;
			}
		}
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


		/************************************************/
		/*												*/
		// 					AFFICHAGE  					//
		/*												*/
		/************************************************/

		/***********************************************/
		// 1er tableau avec compte des notes
		/***********************************************/
		// en tête
		echo"<table id='test' cellpadding='0' cellspacing='0' border='1'>
				<tr>";
		echo "<th></th>";//1ere case vide 
		foreach ($notes as $lign) {
			echo "<th><strong>",$lign,"</strong></th>";
		}
		echo "	</tr>
		</div>
			<div class='tbl-content'>";
		// table
		for($j=0; $j<5; $j++){
			$liste = $liste_nb_note[$j]; // passe sur chaque liste de notes de chaque matière
			echo"<tr>";
				echo"<th>".$matiere[$j]."</th>";
				array_push($tab, $matiere[$j]);
				for($k=5; $k>0; $k--){
					echo"<td>".$liste[$k] ."</td>";
					array_push($tab, $liste[$k]);
				}
			echo"</tr>";
		}
		//on créé la session pour la table avec les notes
		$_SESSION["table"] = $tab;
		//on ferme le premier tableau
		echo "
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
		foreach ($matiere as $lign) {
				echo "<th><strong>",$lign,"</strong></th>";
		}
		
		echo "				</tr>
						</thead>
				</div>
				<div class='tbl-content'>
						<tbody>"
							;
		//table
		$liste_matiere = array($liste_maths, $liste_anglais, $liste_programmation, $liste_algorithme, $liste_economie);
		
		// AFFICHAGE moyenne
		echo"<tr>
			<th>Moyenne</th>";
			array_push($moyecart,"Moyenne");
		for($i=0; $i<5; $i++){
			$moy = calculMoy($liste_matiere[$i]);
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
