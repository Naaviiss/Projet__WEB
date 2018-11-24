<?php
if (isset($_SESSION["nom"]) and $_SESSION["role"] === "admin"){ //seul l'administrateur peut générer un pdf
        require('./fpdf.php');

        //creation de l'objet PDF
        $pdf = new FPDF('L','mm','A4'); //feuille format A4, paysage, dimensions exprimées en mm
    
        //on créée la page et on définit la police 
        $pdf -> AddPage();
        $pdf -> SetFont('Times','B',12);
        $pdf -> SetMargins(500, 5);

        //on définit les paramètres des cellules
        $wcell = 40;
        $hcell = 10;
        $border = 1;
        $ln = 0;
        $align = 'C';

        //on remplit le PDF
        $tabNotes = $_SESSION["table"];

        $pdf -> Cell(300,10,utf8_decode("Résultats du votes des étudiants"),0,1,$align);
        $pdf -> SetFont('Times','B',10);
        foreach($tabNotes as $note){
            $pdf -> Cell($wcell,$hcell,utf8_decode($note),$border,0,$align);
        }

        $pdf->Output("resultats_notes_eleves","I");

        //on redirige l'administrateur vers sa page
        //header('location: page_admin.php');
}
else{
    header ('Location: deconnexion.php');
}
?>