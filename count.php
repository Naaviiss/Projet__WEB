<?php

	function nbEtudiant(){
		$file = "csv/id-student.csv";
			if(file_exists($file)) {
				$tab = file($file);
				$nb_ligne = count($tab);
				echo "Nombre de ligne : " .$nb_ligne;
			}
		return $nb_ligne;
	}

	function nbProf(){
		$file = "csv/id-profs.csv";
			if(file_exists($file)) {
				$tab = file($file);
				$nb_ligne = count($tab);
				echo "NOMBREEEEE ---> " .$nb_ligne;
			}
		return $nb_ligne;
	}

?>  
