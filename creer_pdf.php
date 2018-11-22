<?php
    session_start();
    if (isset($_SESSION["nom"]) and $_SESSION["role"] === "admin"){ //seul l'administrateur peut générer un pdf
        // require('./fpdf/mc_pdf.php');  
        
        $tabNotes = $_SESSION["table"];

        //creation de l'objet PDF
        $pdf = new new PDF_MC_Table();

        //  //on créée la page et on définit la police 
        $pdf -> AddPage();
        $pdf -> SetFont('Times','B',10);
        $pdf -> SetMargins(500, 5);

        //on remplit le PDF
        $tabNotes = $_SESSION["table"];
        $pdf->SetWidths(array(30,50,30,40));

        for($i=0;$i<count($tabNotes);$i++)
            $pdf->Row($tabNotes[$i]);
        $pdf->Output();

        // for($i=0;$i<count($tabNotes);$i++){
        //     $pdf->Row($tabNotes[$i]);
        // }
            
        // $pdf -> Output();
        //on remplit le pdf
        // for($i=0;$i<count($matieres);$i++){
        //     $pdf->Cell($wcell,$hcell,utf8_decode($matieres[$i]),$border,$ln,$align);
        // }
        // $pdf -> Output();

        //on remplit la page avec les donnees des votes
        // for($i=0;$i<count($donnees);$i++){
        //     if($i%5==4){ //fin de ligne
        //         $pdf->Cell($wcell,$hcell,$donnees[$i],$border,1,$align);
        //     }
        //     else{
        //         $pdf->Cell($wcell,$hcell,$donnees[$i],$border,$ln,$align);
        //     }
        // }

        //on redirige l'administrateur vers sa page
        //header('location: page_admin.php');
    }
    else{
        //si l'utilisateur n'est pas connecté ou n'est pas un admin, on le redirige vers la déconnexion
        header('location: deconnexion.php'); 
    }
?>