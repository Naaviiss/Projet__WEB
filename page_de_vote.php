<?php
session_start();
if($_SESSION["nom"]==NULL)
	//echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
echo "<h1>Bonjours ".$_SESSION["nom"]."</br></h1>";
?>
<html>

<head>
<title>Page de vote</title>
</head>

<body>
<form name="form" action="" method="post">
<input type='submit' name='dec' id='dec' value='deconection'>
</form>

<?php

if(isset($_POST['dec'])){
	$dec = $_POST['dec'];
	
	if($dec=="deconection"){
		unset($_SESSION["nom"]);
		unset($_SESSION["admin"]);
		session_destroy();
		header ('Location: page_de_vote.php'); //changer le nom de la page
	}
}
?>


<h2>Pour voter choisisser une note puis valider</h2></hr/>

<fieldset class='field'><legend>  </legend>
<form action='' method='post'>
<table width='400'>

<?php

function toString($val) 
{	#retourne un string contenant l'avis
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

if(file_exists('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt')){
	$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'r');
	$mesnotes = fgets($monfichier, '10');
	if(!(in($mesnotes[0]) and in($mesnotes[2]) and in($mesnotes[4]) and in($mesnotes[6]) and in($mesnotes[8]) and $mesnotes[1]==";" and $mesnotes[3]==";" and $mesnotes[5]==";" and $mesnotes[7]==";")){
		#si le fichier n'es pas bien forme ou contient une valeur non valide, le reinitialise
		fclose($monfichier);
		$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'w');
		fputs($monfichier, "0;0;0;0;0");
		fclose($monfichier);
		$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'r');
		$mesnotes = fgets($monfichier, '10');
	}
}
else{
	$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'w');
	fputs($monfichier, "0;0;0;0;0");
	fclose($monfichier);
	$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'r');
	$mesnotes = fgets($monfichier, '10');
}

if ($mesnotes[0] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner
		echo "<tr><td>Mathématiques, ue1, prof1 </td><td><p>
			   <label for=\"ue1\">la note attribuée</label><br />
			   <select name=\"ue1\" id=\"ue1\">
					<option value=\"0\" selected>sans avis</option>
					<option value=\"1\">Très mécontent</option>
					<option value=\"2\">Mécontent</option>
					<option value=\"3\">Moyen</option>
					<option value=\"4\">Satisfait</option>
					<option value=\"5\">Très satisfait</option>
			   </select>
		</p></td>";
}	
else{ #sinon affiche la note
	echo "Mathématiques, ue1, prof1 : ".toString($mesnotes[0])."</br>";
}
if ($mesnotes[2] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner
		echo "<tr><td>Anglais, ue2, prof2 </td><td><p>
			   <label for=\"ue2\">la note attribuée</label><br />
			   <select name=\"ue2\" id=\"ue2\">
					<option value=\"0\" selected>sans avis</option>
					<option value=\"1\">Très mécontent</option>
					<option value=\"2\">Mécontent</option>
					<option value=\"3\">Moyen</option>
					<option value=\"4\">Satisfait</option>
					<option value=\"5\">Très satisfait</option>
			   </select>
		</p></td>";
}	
else{ #sinon affiche la note
	echo "Anglais, ue2, prof2       : ".toString($mesnotes[2])."</br>";
}
if ($mesnotes[4] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner
		echo "<tr><td>Programmation, ue3, prof3 </td><td><p>
			   <label for=\"ue3\">la note attribuée</label><br />
			   <select name=\"ue3\" id=\"ue3\">
					<option value=\"0\" selected>sans avis</option>
					<option value=\"1\">Très mécontent</option>
					<option value=\"2\">Mécontent</option>
					<option value=\"3\">Moyen</option>
					<option value=\"4\">Satisfait</option>
					<option value=\"5\">Très satisfait</option>
			   </select>
		</p></td>";
}	
else{ #sinon affiche la note
	echo "Programmation, ue3, prof3 : ".toString($mesnotes[4])."</br>";
}
if ($mesnotes[6] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner	
		echo "<tr><td>Algorithme, ue4, prof4 </td><td><p>
			   <label for=\"ue4\">la note attribuée</label><br />
			   <select name=\"ue4\" id=\"ue4\">
					<option value=\"0\" selected>sans avis</option>
					<option value=\"1\">Très mécontent</option>
					<option value=\"2\">Mécontent</option>
					<option value=\"3\">Moyen</option>
					<option value=\"4\">Satisfait</option>
					<option value=\"5\">Très satisfait</option>
			   </select>
		</p></td>";
}	
else{ #sinon affiche la note
	echo "Algorithme, ue4, prof4    : ".toString($mesnotes[6])."</br>";
}
if ($mesnotes[8] == "0"){ #affiche le sondage pour cette matiere que si elle na pas encore été renseigner	
		echo "<tr><td>Economie, ue5, prof5 </td><td><p>
			   <label for=\"ue5\">la note attribuée</label><br />
			   <select name=\"ue5\" id=\"ue5\">
					<option value=\"0\" selected>sans avis</option>
					<option value=\"1\">Très mécontent</option>
					<option value=\"2\">Mécontent</option>
					<option value=\"3\">Moyen</option>
					<option value=\"4\">Satisfait</option>
					<option value=\"5\">Très satisfait</option>
			   </select>
		</p></td>";
}
else{ #sinon affiche la note
	echo "Economie, ue5, prof5      : ".toString($mesnotes[8])."</br>";
}	
if ($mesnotes[0] == "0" or $mesnotes[2] == "0" or $mesnotes[4] == "0" or $mesnotes[6] == "0" or $mesnotes[8] == "0"){ #si il manque un champs a renseigner affiche le bouton
	echo "<tr><td></td><td><input type='submit' name='ok' value='valider'></td>";
}

fclose($monfichier);
?>

</table>
</form>
</fieldset>

<?php

function in($val) 
{	#fonction permettant de verifier si une valeur est bien dans le tableau ["0","1","2","3","4","5"]
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
		$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'w'); #ouverture du fichier selon l'eleve connecter
		fputs($monfichier, $ue1.';'.$ue2.';'.$ue3.';'.$ue4.';'.$ue5); #ecrit dans le fichier les notes
		fclose($monfichier);
		header ('Location: page_de_vote.php');; #on recharge la page pour afficher les changements
}
?>

</body>
</html>