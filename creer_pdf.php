<?php
    session_start();
    if (isset($_SESSION["nom"]) and $_SESSION["role"] === "admin"){ //seul l'administrateur peut générer un pdf
        header('Content-type: application/pdf');
        require('./fpdf/fpdf.php');  

        //on récupère les données pour remplir la page
        $matieres = array ("Mathématiques","Anglais","Programmation","Algorithmique","Economie");
        
        $first_doc = 1001;
	    $last_doc = 1020;
        //on recupère les donnees des votes
        $donnees = array();
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
                    $dataFile = fgetcsv($monfichier, 0, ";");
                    foreach ($dataFile as $key =>$contenu) {
                        array_push($donnees,$contenu); //on conserve la note
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
                    }
                    echo "</tr>";
                    $nb_file = $nb_file + 1; //on incrémente le nombre de fichiers lus
                }
                fclose($monfichier);
            }
        }
		
        for($i=0; $i<5; $i++){
            $moy[$i]=$moy[$i]/$nb_file;
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

        //on remplit le pdf
        for($i=0;$i<count($matieres);$i++){
            $pdf->Cell($wcell,$hcell,utf8_decode($matieres[$i]),$border,$ln,$align);
        }
        $pdf -> Output();

        //on remplit la page avec les donnees des votes
        for($i=0;$i<count($donnees);$i++){
            if($i%5==4){ //fin de ligne
                $pdf->Cell($wcell,$hcell,$donnees[$i],$border,1,$align);
            }
            else{
                $pdf->Cell($wcell,$hcell,$donnees[$i],$border,$ln,$align);
            }
        }

        //on redirige l'administrateur vers sa page
        //header('location: page_admin.php');
    }
    else{
        //si l'utilisateur n'est pas connecté ou n'est pas un admin, on le redirige vers la déconnexion
        header('location: deconnexion.php'); 
    }
?>