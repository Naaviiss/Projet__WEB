<?php/*
    session_start();
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
        $align = 'C';

        //on remplit le PDF
        $tabNotes = $_SESSION["table"];
        $pdf -> Cell(300,10,utf8_decode("Résultats du votes des étudiants"),0,1,$align);
        $pdf -> SetFont('Times','B',10);
            foreach($tabNotes[0] as $note){
                $pdf -> Cell($wcell,$hcell,utf8_decode($note),$border,0,$align);
            }
            $pdf -> Ln();
            foreach($tabNotes[0] as $note){
                $pdf -> Cell($wcell,$hcell,utf8_decode($note),$border,0,$align);
            }

        $pdf->Output("resultats_notes_eleves","I");

        //on redirige l'administrateur vers sa page
        //header('location: page_admin.php');
    }
    else{
        //si l'utilisateur n'est pas connecté ou n'est pas un admin, on le redirige vers la déconnexion
        header('location: deconnexion.php'); 
    }
?>*/
require('fpdf.php');

class PDF extends FPDF
{
// Chargement des données
function LoadData($file)
{
    // Lecture des lignes du fichier
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tableau simple
function BasicTable($header, $data)
{
    // En-tête
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Données
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Tableau amélioré
function ImprovedTable($header, $data)
{
    // Largeurs des colonnes
    $w = array(40, 35, 45, 40);
    // En-tête
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Données
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR');
        $this->Cell($w[1],6,$row[1],'LR');
        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R');
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R');
        $this->Ln();
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}

// Tableau coloré
function FancyTable($header, $data)
{
    // Couleurs, épaisseur du trait et police grasse
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // En-tête
    $w = array(40, 35, 45, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauration des couleurs et de la police
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Données
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2],0,',',' '),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3],0,',',' '),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Trait de terminaison
    $this->Cell(array_sum($w),0,'','T');
}
}

$pdf = new PDF();
// Titres des colonnes
$header = array('Pays', 'Capitale', 'Superficie (km²)', 'Pop. (milliers)');
$data = $_SESSION["table"];
$pdf->AddPage();
$pdf->FancyTable($header,$data);
$pdf->Output();
?>