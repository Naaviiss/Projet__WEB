<?php
    session_start();
    if (isset($_SESSION["nom"]) and $_SESSION["role"] === "admin"){ //seul l'administrateur peut générer un pdf
        require_once('tcpdf_include.php');

      /*  //creation de l'objet PDF
        $pdf = new FPDF('L','mm','A4'); //feuille format A4, paysage, dimensions exprimées en mm
    
        //on créée la page et on définit la police 
        $pdf -> AddPage();
        $pdf -> SetFont('Times','B',12);
        $pdf -> SetMargins(500, 5);

        //on définit les paramètres des cellules
        $wcell = 40;
        $hcell = 10;
        $border = 1;
        $align = 'C';

        //on remplit le PDF
        $tabNotes = $_SESSION["table"];
        $pdf -> Cell(300,10,utf8_decode("Résultats du votes des étudiants"),0,1,$align);
        $pdf -> SetFont('Times','B',10);
            foreach($tabNotes[0] as $note){
                $pdf -> Cell($wcell,$hcell,utf8_decode($note),$border,0,$align);
            }
            $pdf->Ln();
        
            foreach($tabNotes[1] as $note){
                $pdf -> Cell($wcell,$hcell,utf8_decode($note),$border,0,$align);
            }

        $pdf->Output("resultats_notes_eleves","I");*/

        // extend TCPF with custom functions
        class MYPDF extends TCPDF {
            // Colored table
            public function ColoredTable($header,$data) {
                // Colors, line width and bold font
                $this->SetFillColor(255, 0, 0);
                $this->SetTextColor(255);
                $this->SetDrawColor(128, 0, 0);
                $this->SetLineWidth(0.3);
                $this->SetFont('', 'B');
                // Header
                $w = array(40, 35, 40, 45);
                $num_headers = count($header);
                for($i = 0; $i < $num_headers; ++$i) {
                    $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', 1);
                }
                $this->Ln();
                // Color and font restoration
                $this->SetFillColor(224, 235, 255);
                $this->SetTextColor(0);
                $this->SetFont('');
                // Data
                $fill = 0;
                foreach($data as $row) {
                    $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
                    $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
                    $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
                    $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
                    $this->Ln();
                    $fill=!$fill;
                }
                $this->Cell(array_sum($w), 0, '', 'T');
            }
        }

        $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Groupe Matrice Gauss');
        $pdf->SetTitle('RESULTATS_VOTES_ETUDIANTS');

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

        // set font
        $pdf->SetFont('helvetica', '', 12);

        // add a page
        $pdf->AddPage();

        // data
        $tabNotes = $_SESSION["table"];
        $header = $tabNotes[0];
        unset($tabNotes[0]);

        // print colored table
        $pdf->ColoredTable($header, $data);

        // close and output PDF document
        $pdf->Output('resultats_votes', 'I');

        //on redirige l'administrateur vers sa page
        //header('location: page_admin.php');
    }
    else{
        //si l'utilisateur n'est pas connecté ou n'est pas un admin, on le redirige vers la déconnexion
        header('location: deconnexion.php'); 
    }
?>