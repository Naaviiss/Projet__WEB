<?php
	//on récupère les identifiants entrés par l'utilisateur
	$login = $_POST['nom'];
	$mdp = $_POST['mdp'];

	//on créé le pattern permettant de connaître la forme du login attendue
	$pattern_admin = '/admin/';

	if (isset($login) and isset($mdp)){
		if(preg_match($pattern_admin, $login)){
			$fichier_admin = "id-admin.csv";
			if (file_exists($fichier_admin)){
				$pointeur = fopen($fichier_admin, "r");
			}

			while (!feof($pointeur)) {
				$ligne = fgetcsv($pointeur,1024,",");
				$num = count($ligne);
				if ($login === $ligne[0]){
					echo "coucou je fonctionne !<br/>";
					if ($mdp === $ligne[1]){
						echo "je peux me connecter <br/>";
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