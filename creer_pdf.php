<?php
    session_start();
    if (isset($_SESSION["nom"]) and $_SESSION["role"] === "admin"){ //seul l'administrateur peut générer un pdf
        require('./fpdf/fpdf.php'); 

        //creation de l'objet PDF
        $pdf = new FPDF('l','mm','A4'); //feuille format A4, paysage, dimensions exprimées en mm

        //on créée la page et on définit la police 
        $pdf -> AddPage();
        $pdf -> SetFont('Times','B',10);
        $pdf -> SetMargins(500, 5);

        //on définit les paramètres des cellules
        $wcell = 40;
        $hcell = 10;
        $border = 1;
        $ln = 0;
        $align = 'C';

        //on récupère les données pour remplir la page

        $first_doc = 1001;
	    $last_doc = 1020;
    
        //on replit la page avec les matieres
	    $matieres = array ("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
        for($i=0;$i<count($matieres);$i++){
            $pdf->Cell($wcell,$hcell,utf8_decode($matieres[$i]),$border,$ln,$align);
        }
        $pdf ->ln();
        
        //on recupère les donnees des votes
        $donnees = array();
        for($i=$first_doc; $i<=$last_doc; $i++){
            $file = "votes/vote-e".$i .".txt";
            // Si le fichier existe
            if (file_exists($file)) {
                $monfichier = fopen($file, 'r+');
                // Affichage des notes
                while ( !feof($monfichier) ){
                    $dataFile = fgetcsv($monfichier, 0, ";");
                    foreach ($dataFile as $contenu) {
                        array_push($donnees,$contenu);
                    }
                }
                fclose($monfichier);
            }
	    }
    
        $pdf->Cell($wcell,$hcell,$donnees[0],$border,$ln,$align);
        //on remplit la page avec les donnees des votes
        /*for($i=0;$i<count($donnees);$i++){
            if($i%5==4){ //fin de ligne
                $pdf->Cell($wcell,$hcell,$donnees[$i],$border,1,$align);
            }
            else{
                $pdf->Cell($wcell,$hcell,$donnees[$i],$border,$ln,$align);
            }
        }*/
		
	
        // calcul de la moyenne
        $moy=array(0,0,0,0,0);
        $nb_file=0;
        for($i=$first_doc; $i<=$last_doc; $i++){
            $file = "votes/vote-e" .$i .".txt";
            // Si le fichier existe
            if (file_exists($file)) {
                $monfichier = fopen($file, 'r+');
                // Calcul moyenne
                while (!feof($monfichier) ){
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

        // calcul de l'écart-type
        //liste des notes pour chaque matière
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
        $tab_ecarts = array();
        
        for($i=0; $i<count($matieres); $i++){
            $arr_size=count($liste_matiere[$i]); 
            $moy_liste=array_sum($liste_matiere[$i])/$arr_size;
            $ans=0; 
            foreach($liste_matiere[$i] as $element){ 
                $ans+=pow(($element-$moy_liste),2); 
            }
            $variance = $ans/$arr_size; 
            $ecart_type = sqrt($variance);
            array_push($tab_ecarts,$ecart_type);
        }
    
        //on affiche le pdf
        $pdf->Output();

        //on redirige l'administrateur vers sa page
        //header('location: page_admin.php');
    }
    else{
        //si l'utilisateur n'est pas connecté ou n'est pas un admin, on le redirige vers la déconnexion
        header('location: deconnexion.php'); 
    }
?>