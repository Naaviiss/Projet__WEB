<?php
    session_start();
    require('./fpdf.php');

    class PDF extends FPDF
    {
        // Tableau coloré
        function FancyTable($header, $data)
        {
            // Couleurs, épaisseur du trait et police grasse
            $this->SetFillColor(37,196,129);
            $this->SetTextColor(66,69,88);
            $this->SetDrawColor(66,69,88);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');

            //définition taille et remplissage cellules
            $wcell = 55;
            $hcell = 10;
            $border = 1;
            $align = 'C';
            $fill = false;

            for($i=0;$i<count($header);$i++)
                $this->Cell($wcell,$hcell,utf8_decode($header[$i]),$border,0,$align,true);
            $this->Ln();

            // Restauration des couleurs et de la police
            $this->SetFillColor(198,245,251);
            $this -> SetFont('');

            $border = 'LR';//on change les bordures sulement sur les côtés
            
            $i = 0;
            foreach($data as $datum)
            {

                $this->Cell($wcell,$hcell,$datum,'LR',0,$align,$fill);
                if ($i%5==4){
                    $this->Ln();
                    $fill = !$fill;
                }
                $i++;
            }
            // Trait de terminaison
            $this->Cell($wcell*count($header),0,'','T');
        }
    }

    $pdf = new PDF();

    //1er tableau
    // Titres des colonnes
    $header = $_SESSION["matieres"];
    // Chargement des données
    $data = $_SESSION["table"];
    $pdf->AddPage('L','A4');

    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(66,69,88);
    $pdf ->Cell($wcell*count($header),10,utf8_decode("Résultats du vote des étudiants"),'',0,'C'); //ajout du titre
    $pdf -> Ln(15);

    $pdf->SetFont('Times','',12);
    $pdf->FancyTable($header,$data);

    //2eme tableau
    $pdf->Output();

?>