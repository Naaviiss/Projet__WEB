<?php

	//on récupère les identifiants entrés par l'utilisateur
	
	$login = $_POST['nom'];
	$mdp = $_POST['mdp'];
	
	session_start ();
	
	$_SESSION['nom'] = $_POST['nom'];
	$_SESSION['mdp'] = $_POST['mdp'];

	//on créé le pattern permettant de connaître la forme du login attendue
	$pattern_prof = '/prof[0-9]{2}/';

	if (isset($login) and isset($mdp)){
		if(preg_match($pattern_prof, $login)){
			$fichier_prof = "id-profs.csv";
			if (file_exists($fichier_prof)){
				$pointeur = fopen($fichier_prof, "r");
			}

			while (!feof($pointeur)) {
				$ligne = fgetcsv($pointeur,1024,",");
				$num = count($ligne);
				if ($login === $ligne[0]){
					if ($mdp === $ligne[1]){
						header ('Location: pageprof.php');
					}
					else{
						echo "pas de chance <br/>";
					}
				}
			}
		}
		else{
			echo "Veuillez entrer un login correct";
		}
	}
?>