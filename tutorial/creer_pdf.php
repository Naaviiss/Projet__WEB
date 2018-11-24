<?php
    session_start();
    require('../fpdf.php');

    class PDF extends FPDF
    {
        // Tableau coloré
        function FancyTable($header, $data)
        {
            // Couleurs, épaisseur du trait et police grasse
            $this->SetFillColor(255,0,0);
            $this->SetTextColor(255);
            $this->SetDrawColor(128,0,0);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');

            //définition taille et remplissage cellules
            $wcell = 50;
            $hcell = 10;
            $border = 1;
            $align = 'C';
            $fill = false;

            for($i=0;$i<count($header);$i++)
                $this->Cell($wcell,$hcell,utf8_decode($header[$i]),$border,0,$align);
            $this->Ln();

            // Restauration des couleurs et de la police
            $this->SetFillColor(224,235,255);
            $this->SetTextColor(0);
            $this->SetFont('');

            $border = 'LR';//on change les bordures sulement sur les côtés
            
            $i = 0;
            foreach($data as $datum)
            {

                $this->Cell($wcell,$hcell,$datum,'LR',0,$align,$fill);
                if ($i%5==4){
                    $this->Ln();
                }
                $i++;
                $fill = !$fill;
            }
            // Trait de terminaison
            $this->Cell($wcell*count($header),0,'','T');
        }
    }

    $pdf = new PDF();
    // Titres des colonnes
    $header = $_SESSION["matieres"];
    // Chargement des données
    $data = $_SESSION["table"];
    $pdf->SetFont('Arial','',14);
    $pdf->AddPage('L','A4');
    $pdf->FancyTable($header,$data);
    $pdf->Output();

?>