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
		echo "<script type='text/javascript'>document.location.replace('page_de_vote.php');</script>"; //changer le nom de la page
	}
}
?>


<h2>Pour voter choisisser une note entre 1 et 5 puis valider</h2></hr/>

<fieldset class='field'><legend>  </legend>
<form action='' method='post'>
<table width='400'>
<?php
if(file_exists('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt')){
	$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'r');
	$mesnotes = fgets($monfichier, '10');
	
}
else{
	$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'w');
	fputs($monfichier, "0;0;0;0;0");
	fclose($monfichier);
	$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'r');
	$mesnotes = fgets($monfichier, '10');
}

if ($mesnotes[0] == "0"){	
		echo "<tr><td>Mathématiques, ue1, prof1 </td><td><p>
			   <label for=\"ue1\">la note attribuer</label><br />
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

if ($mesnotes[2] == "0"){	
		echo "<tr><td>Anglais, ue2, prof2 </td><td><p>
			   <label for=\"ue2\">la note attribuer</label><br />
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

if ($mesnotes[4] == "0"){	
		echo "<tr><td>Programmation, ue3, prof3 </td><td><p>
			   <label for=\"ue3\">la note attribuer</label><br />
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

if ($mesnotes[6] == "0"){	
		echo "<tr><td>Algorithme, ue4, prof4 </td><td><p>
			   <label for=\"ue4\">la note attribuer</label><br />
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

if ($mesnotes[8] == "0"){	
		echo "<tr><td>Economie, ue5, prof5 </td><td><p>
			   <label for=\"ue5\">la note attribuer</label><br />
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
if ($mesnotes[0] == "0" or $mesnotes[2] == "0" or $mesnotes[4] == "0" or $mesnotes[6] == "0" or $mesnotes[8] == "0"){
	echo "<tr><td></td><td><input type='submit' name='ok' value='valider'></td>";
}
else {
	echo "Vous avez déjà fais tout vos votes";
}
fclose($monfichier);
?>


</table>
</form>
</fieldset>

<?php
if(isset($_POST['ok'])){
	if(isset($_POST['ue1'])){
		$ue1 = $_POST['ue1'];
	}
	else{
		$ue1 = $mesnotes[0];
	}
	if(isset($_POST['ue2'])){
		$ue2 = $_POST['ue2'];
	}
	else{
		$ue2 = $mesnotes[2];
	}
	if(isset($_POST['ue3'])){
		$ue3 = $_POST['ue3'];
	}
	else{
		$ue3 = $mesnotes[4];
	}
	if(isset($_POST['ue4'])){
		$ue4 = $_POST['ue4'];
	}
	else{
		$ue4 = $mesnotes[6];
	}
	if(isset($_POST['ue5'])){
		$ue5 = $_POST['ue5'];
	}
	else{
		$ue5 = $mesnotes[8];
	}
		$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'w');
		fputs($monfichier, $ue1.';'.$ue2.';'.$ue3.';'.$ue4.';'.$ue5);
		fclose($monfichier);
		echo "<script type='text/javascript'>document.location.replace('page_de_vote.php');</script>";
}
?>

</body>
</html>