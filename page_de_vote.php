<?php
session_start();
if($_SESSION["nom"]==NULL or $_SESSION["role"] == "prof"  or $_SESSION["role"] == "admin"){  //si l'utilisateur est connecter ou est bien un élève
	header ('Location: pageconnexion.php');
}
?>
<html>

    <head>
        <meta charset="utf-8" />
        <title>Page des professeurs</title>
		<link href="css/css.css" rel="stylesheet" id="css"/>
		<link rel="icon" href="images/logo-uvsq.png">
    </head>
	
	<header>
		<?php Include("haut_page.html"); ?>
	</header>
	
	<body>
	<div class="container-fluid">
		<div class="container">
				<h1>Bonjour <?php echo $_SESSION["nom"];?></br></h1>
				

				<?php 
				
					function toString($val) #retourne un string contenant l'avis
					{
						if($val=="0"){
							return "sans avis";
						}
						if($val=="1"){
							return "Très mécontent";
						}
						if($val=="2"){
							return "Mécontent";
						}
						if($val=="3"){
							return "Moyen";
						}
						if($val=="4"){
							return "Satisfait";
						}
						if($val=="5"){
							return "Très satisfait";
						}
					}
								
					if(file_exists('votes/vote-'.$_SESSION["nom"].'.txt')) {
						$monfichier = fopen('votes/vote-'.$_SESSION["nom"].'.txt', 'r');
						$mesnotes = fgets($monfichier, '10');
						if(!(in($mesnotes[0]) and in($mesnotes[2]) and in($mesnotes[4]) and in($mesnotes[6]) and in($mesnotes[8]) and $mesnotes[1]==";" and $mesnotes[3]==";" and $mesnotes[5]==";" and $mesnotes[7]==";")) {
							#si le fichier n'es pas bien forme ou contient une valeur non valide, le reinitialise
							fclose($monfichier);
							$monfichier = fopen('votes/vote-'.$_SESSION["nom"].'.txt', 'w');
							fputs($monfichier, "0;0;0;0;0");
							fclose($monfichier);
							$monfichier = fopen('votes/vote-'.$_SESSION["nom"].'.txt', 'r');
							$mesnotes = fgets($monfichier, '10');
						}
					}
					else{
						$monfichier = fopen('votes/vote-'.$_SESSION["nom"].'.txt', 'w');
						fputs($monfichier, "0;0;0;0;0");
						fclose($monfichier);
						$monfichier = fopen('votes/vote-'.$_SESSION["nom"].'.txt', 'r');
						$mesnotes = fgets($monfichier, '10');
					}
				
				
					if ($mesnotes[0] == "0" or $mesnotes[2] == "0" or $mesnotes[4] == "0" or $mesnotes[6] == "0" or $mesnotes[8] == "0"){ #si il manque un champs a renseigner affiche le bouton
						echo "<h2>Pour voter, choisissez un avis puis validez</h2></br/>";
					}
					else {
						echo "<h3>Vous avez déjà voté pour toutes les matières<h3></br>";
					}
				?>
				
				<fieldset class='field'><legend>  </legend>
					<form action='' method='post'>
						<table width='400'>

							<?php
								
								function Select($ue) #retourne le select pour le bonne ue
								{
									return "<label for=\"$ue\">la note attribuée</label><br />
										<select name=\"$ue\" id=\"$ue\">
												<option value=\"0\" selected>sans avis</option>
												<option value=\"1\">Très mécontent</option>
												<option value=\"2\">Mécontent</option>
												<option value=\"3\">Moyen</option>
												<option value=\"4\">Satisfait</option>
												<option value=\"5\">Très satisfait</option>
										</select>";
								}
								
								
								if ($mesnotes[0] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner
									echo "<tr><td>Mathématiques </td><td><p>".Select("ue1")."</p></td>";
								}	
								else{ #sinon affiche la note
									echo "Mathématiques                   : ".toString($mesnotes[0])."</br>";
								}
								
								if ($mesnotes[2] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner
									echo "<tr><td>Anglais </td><td><p>".Select("ue2")."</p></td>";
								}	
								else{ #sinon affiche la note
									echo "Anglais                   : ".toString($mesnotes[2])."</br>";
								}
								
								if ($mesnotes[4] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner
									echo "<tr><td>Programmation </td><td><p>".Select("ue3")."</p></td>";
								}	
								else{ #sinon affiche la note
									echo "Programmation                   : ".toString($mesnotes[4])."</br>";
								}
								
								if ($mesnotes[6] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner	
									echo "<tr><td>Algorithme </td><td><p>".Select("ue4")."</p></td>";
								}	
								else{ #sinon affiche la note
									echo "Algorithme                   : ".toString($mesnotes[6])."</br>";
								}
								
								if ($mesnotes[8] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner	
									echo "<tr><td>Economie </td><td><p>".Select("ue5")."</p></td>";
								}
								else{ #sinon affiche la note
									echo "Economie                   : ".toString($mesnotes[8])."</br>";
								}
								
								if ($mesnotes[0] == "0" or $mesnotes[2] == "0" or $mesnotes[4] == "0" or $mesnotes[6] == "0" or $mesnotes[8] == "0"){ #si il manque un champs a renseigner affiche le bouton
									echo "<tr><tr><td></td><td><input type='submit' name='ok' value='Valider'></td>";
								}
								fclose($monfichier);
							?>

						</table>
					</form>
				</fieldset>

				<?php
					function in($val) {
						#fonction permettant de verifier si une valeur est bien dans le tableau ["0","1","2","3","4","5"]
						#retourne vrai si la valeur est dans le tableau et faux sinon
						#cette fonction sera utiliser pour verifier la validiter d'une valeur donne par le select
						if($val=="0" or $val=="1" or $val=="2" or $val=="3" or $val=="4" or $val=="5"){
							return True;
						}
						return False;
					}


					if(isset($_POST['ok'])){ #fait des actions lorsque le bouton est utiliser
						if(isset($_POST['ue1'])){ #verifie si ue1 a ete renseigner
							if(in($_POST['ue1'])){ #verifie que la valeur rentrer par le select est bien une valeur acceptable
								$ue1 = $_POST['ue1'];
							}
							else{ #sinon concerve la valeur deja inscrite
								$ue1 = $mesnotes[0];
							}
						}
						else{ #sinon concerve la valeur deja inscrite
							$ue1 = $mesnotes[0];
						}
						
						if(isset($_POST['ue2'])){ #verifie si ue2 a ete renseigner
							if(in($_POST['ue2'])){ #verifie que la valeur rentrer par le select est bien une valeur acceptable
								$ue2 = $_POST['ue2'];
							}
							else{ #sinon concerve la valeur deja inscrite
								$ue2 = $mesnotes[2];
							}
						}
						else{ #sinon concerve la valeur deja inscrite
							$ue2 = $mesnotes[2];
						}
						
						if(isset($_POST['ue3'])){ #verifie si ue3 a ete renseigner
							if(in($_POST['ue3'])){ #verifie que la valeur rentrer par le select est bien une valeur acceptable
								$ue3 = $_POST['ue3'];
							}
							else{ #sinon concerve la valeur deja inscrite
								$ue3 = $mesnotes[4];
							}
						}
						else{ #sinon concerve la valeur deja inscrite
							$ue3 = $mesnotes[4];
						}
						
						if(isset($_POST['ue4'])){ #verifie si ue4 a ete renseigner
							if(in($_POST['ue4'])){ #verifie que la valeur rentrer par le select est bien une valeur acceptable
								$ue4 = $_POST['ue4'];
							}
							else{ #sinon concerve la valeur deja inscrite
								$ue4 = $mesnotes[6];
							}
						}
						else{ #sinon concerve la valeur deja inscrite
							$ue4 = $mesnotes[6];
						}
						
						if(isset($_POST['ue5'])){ #verifie si ue5 a ete renseigner
							if(in($_POST['ue5'])){ #verifie que la valeur rentrer par le select est bien une valeur acceptable
								$ue5 = $_POST['ue5'];
							}
							else{ #sinon concerve la valeur deja inscrite
								$ue5 = $mesnotes[8];
							}
						}
						else{ #sinon concerve la valeur deja inscrite
							$ue5 = $mesnotes[8];
						}
						
						$monfichier = fopen('votes/vote-'.$_SESSION["nom"].'.txt', 'w'); #ouverture du fichier selon l'eleve connecter
						fputs($monfichier, $ue1.';'.$ue2.';'.$ue3.';'.$ue4.';'.$ue5); #ecrit dans le fichier les notes
						fclose($monfichier);
						header ('Location: page_de_vote.php'); #on recharge la page pour afficher les changements
					}
				?>
			</div>
		</div>
</body>
	<footer><?php Include("footer.html"); ?></footer>

</html>
