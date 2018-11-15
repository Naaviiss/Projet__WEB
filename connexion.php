<?php
	session_start ();

	//on récupère les identifiants entrés par l'utilisateur
	$login = $_POST['nom'];
	$mdp = $_POST['mdp'];

	//on créé les pattern permettant de connaître la forme du login attendue
	$pattern_prof = '/prof[0-9]{2}/';
	$pattern_admin = '/admin/';
	$pattern_student = '/e[0-9]{4}/';

	if (isset($login) and isset($mdp)){ //si les identifiants sont entrés

		if(preg_match($pattern_prof, $login)){ //on teste si c'est un prof qui se connecte
			$fichier_prof = "csv/id-profs.csv";
			if (file_exists($fichier_prof)){
				$pointeur = fopen($fichier_prof, "r");
			}

			while (!feof($pointeur)) {
				$ligne = fgetcsv($pointeur,1024,",");
				$num = count($ligne);
				if ($login === $ligne[0]){
					if ($mdp === $ligne[1]){
						header('Location: pageprof.php');
					}
					else{
						echo ("pas de chance ");
					}
				}
			}
			$_SESSION["nom"] = $login; //on lance une session
		}

		else if(preg_match($pattern_student, $login)){ //on teste si c'est un éleve qui se connecte
			$fichier_student = "csv/id-student.csv";
			if (file_exists($fichier_student)){
				$pointeur = fopen($fichier_student, "r");
			}

			while (!feof($pointeur)) {
				$ligne = fgetcsv($pointeur,1024,",");
				$num = count($ligne);
				if ($login === $ligne[0]){
					echo "coucou je fonctionne !";
					if ($mdp === $ligne[1]){
						echo "je peux me connecter ";
					}
					else{
						echo "pas de chance loser ";
					}
				}
			}
			$_SESSION["nom"] = $login; //on lance une session
		}

		else if(preg_match($pattern_admin, $login)){ //on teste si c'est un admin qui se connecte
			$fichier_admin = "csv/id-admin.csv";
			if (file_exists($fichier_admin)){
				$pointeur = fopen($fichier_admin, "r");
			}

			while (!feof($pointeur)) {
				$ligne = fgetcsv($pointeur,1024,",");
				$num = count($ligne);
				if ($login === $ligne[0]){
					echo "coucou je fonctionne !";
					if ($mdp === $ligne[1]){
						echo "je peux me connecter";
					}
					else{
						echo "pas de chance ";
					}
				}
			}
			$_SESSION["nom"] = $login; //on lance une session
		}

		else{
			echo "Veuillez entrer un login correct";
		}
	}
?>