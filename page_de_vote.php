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
		echo "<script type='text/javascript'>document.location.replace('index.php');</script>";
	}
}
?>





<h2>Pour voter choisisser une note entre 1 et 5 puis valider</h2></hr/>

<fieldset class='field'><legend>  </legend>
<form action='' method='post'>
<table width='400'>
<tr><td>Mathématiques, ue1, prof1 </td><td><p>

       <label for="ue1">la note attribuer</label><br />
       <select name="ue1" id="ue1">
           <option value="" selected>sans avis</option>
           <option value="1">Très mécontent</option>
           <option value="2">Mécontent</option>
           <option value="3">Moyen</option>
           <option value="4">Satisfait</option>
           <option value="5">Très satisfait</option>
       </select>
</p></td>
<tr><td>Anglais, ue2, prof2 </td><td><p>

       <label for="ue2">la note attribuer</label><br />
       <select name="ue2" id="ue2">
           <option value="" selected>sans avis</option>
           <option value="1">Très mécontent</option>
           <option value="2">Mécontent</option>
           <option value="3">Moyen</option>
           <option value="4">Satisfait</option>
           <option value="5">Très satisfait</option>
       </select>
</p></td>  
<tr><td>Programmation, ue3, prof3 </td><td><p>

       <label for="ue3">la note attribuer</label><br />
       <select name="ue3" id="ue3">
           <option value="" selected>sans avis</option>
           <option value="1">Très mécontent</option>
           <option value="2">Mécontent</option>
           <option value="3">Moyen</option>
           <option value="4">Satisfait</option>
           <option value="5">Très satisfait</option>
       </select>
</p></td>
<tr><td>Algorithme, ue4, prof4 </td><td><p>

       <label for="ue4">la note attribuer</label><br />
       <select name="ue4" id="ue4">
           <option value="" selected>sans avis</option>
           <option value="1">Très mécontent</option>
           <option value="2">Mécontent</option>
           <option value="3">Moyen</option>
           <option value="4">Satisfait</option>
           <option value="5">Très satisfait</option>
       </select>
</p></td>
<tr><td>Economie, ue5, prof5 </td><td><p>

       <label for="ue5">la note attribuer</label><br />
       <select name="ue5" id="ue5">
           <option value="" selected>sans avis</option>
           <option value="1">Très mécontent</option>
           <option value="2">Mécontent</option>
           <option value="3">Moyen</option>
           <option value="4">Satisfait</option>
           <option value="5">Très satisfait</option>
       </select>
</p></td> 
<tr><td></td><td><input type='submit' name='ok' value='valider'></td>
</table>
</form>
</fieldset>






<?php
	if(isset($_POST['ok'])){
		$ue1 = $_POST['ue1'];
		$ue2 = $_POST['ue2'];
		$ue3 = $_POST['ue3'];
		$ue4 = $_POST['ue4'];
		$ue5 = $_POST['ue5'];
		$monfichier = fopen('csv/vote-'./*$_SESSION["nom"]*/'etuTEST'.'.txt', 'w');
		fputs($monfichier, $ue1.';'.$ue2.';'.$ue3.';'.$ue4.';'.$ue5);
		fclose($monfichier);
	}
?>

</body>
</html>