<?php
    session_start();
    require('./fpdf.php');

    class PDF extends FPDF
    {
        // Tableau coloré
        function FancyTable($header, $data,$w,$numTab)
        {
            // Couleurs, épaisseur du trait et police grasse
            $this->SetFillColor(37,196,129);
            $this->SetTextColor(66,69,88);
            $this->SetDrawColor(66,69,88);
            $this->SetLineWidth(.3);
            $this->SetFont('','B');

            //définition taille et remplissage cellules
            $hcell = 10;
            $align = 'C';
            $fill = false;

            for($i=0;$i<count($header);$i++)
                if ($i == 0 and $numTab == 2)
                    $this->Cell($w,$hcell,utf8_decode($header[$i]),'R',0,'C',false);
                else
                    $this->Cell($w,$hcell,utf8_decode($header[$i]),1,0,$align,true);

            $this->Ln();

            // Restauration des couleurs et de la police
            $this->SetFillColor(198,245,251);
            $this -> SetFont('');

            $i = 0;
            foreach($data as $datum)
            {
                if($numTab == 2){
                    if($i%count($header) == 0){
                        $this->SetFont('','B');
                        $this->SetFillColor(37,196,129);
                        $this->Cell($w,$hcell,$datum,1,0,$align,true);
                    }
                    else{
                        $this -> SetFont('');
                        $this->SetFillColor(198,245,251);
                        $this->Cell($w,$hcell,$datum,1,0,$align,$fill);
                    }
                }
                else{
                    $this->Cell($w,$hcell,$datum,'LR',0,$align,$fill);
                }
                if ($i%count($header)==count($header)-1){
                    $this->Ln();
                    $fill = !$fill;
                }

                $i++;
            }
            // Trait de terminaison
            $this->Cell($w*count($header),0,'','T');
        }
    }

    $pdf = new PDF();

    //1er tableau
    // Titres des colonnes
    $header = $_SESSION["notes"];
    // Chargement des données
    $data = $_SESSION["table"];
    $pdf->AddPage('L','A4');
    $wcell = 45; //largeur des cellules

    $pdf->SetFont('Times','B',14);
    $pdf->SetTextColor(66,69,88);
    $pdf ->Cell($wcell*count($header),10,utf8_decode("Résultats du vote des étudiants"),'',0,'C'); //ajout du titre
    $pdf -> Ln(15);

    $pdf->SetFont('Times','',12);
    array_unshift($header,"");
    $pdf->FancyTable($header,$data,$wcell,2);

    $pdf -> Ln(10); //on sépare les tableau

    //2eme tableau
    // Titres des colonnes
    $header2 = $_SESSION["matieres"];
    $wcell = 46; //largeur des cellules
    $moyecart = $_SESSION["moyecart"];
    array_unshift($header2,"");
    $pdf->FancyTable($header2,$moyecart,$wcell,2);

    //2eme tableau
    $pdf->Output();

?>