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

?>  
