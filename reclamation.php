<?php 
require 'inc/link.php';
require 'inc/db.php';
require 'inc/header.php';
require 'inc/functions.php';
logged_only();
?>
<title>Demande de réclamation</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
  <div class="container-fluid">
	<form role="form" action="newrecl.php" method="post"  enctype="multipart/form-data" onsubmit="return valideForm(this)">
		<table class="table">
    	<caption>INFOS</caption>
    		<tr><th></th></tr>
			<div class="text-center jumbotron">
		      <h1>Demande de réclamation</h1>
		        <p>
		        <p>
		        <p>
		          <h3>Afin de pouvoir traiter votre demande dans les meilleures conditions :</h3>
		          	<p>
		          		<p><h3>
Vous devez, au préalable, faire un point avec le notaire s’agissant de votre litige en lui adressant un courrier/courriel. </h3><p><h3>  <strong>La copie de cette correspondance, datée d’au moins 1 mois, doit être jointe à la réclamation au même titre que la copie de votre carte d’identité.</strong></h3><p><h3> Faute de quoi nous ne pourrons donner suite à votre demande.</h3><p><h3> Nous vous remercions pour votre compréhension. </h3>
		        <p>
		        <p>
		        <p>
		        <h3 class="text-center">Veuillez compléter le formulaire ci-dessous</h3>
			</div>
		 <tr required="required"class="active">
		  <td>
		    <div class="form-group col-lg-3">
		      <label for="sel2"><strong>NOM</strong></label>
		      <input type="text" class="form-control " id="sel2"name="NOM" readonly="readonly" required=required value="<? echo $_SESSION['auth']->NOM;?>">
		    </div>

		    <div class="form-group col-lg-3">
		      <label for="sel3"><strong>PRENOM</strong></label>
		      <input type="text" class="form-control " id="sel3"name="PRENOM" readonly="readonly" required=required value="<? echo $_SESSION['auth']->PRENOM;?>">
		    </div>
		  </td>
		</tr>
		<tr required="required"class="active">
		  <td>
		    <div class="form-group col-lg-3">
		      <label for="ville"><strong>Ville</strong></label>
		      <input class="form-control " name="VILLE" id="ville" type="text" readonly="readonly" placeholder="Ville" required=required value="<? echo $_SESSION['auth']->VILLE;?>">
		    </div>
		    <div class="form-group col-lg-3">
		      <label for="cp"><strong>Code Postal</strong></label>
		      <input class="form-control " name="CP" id="cp" type="number" readonly="readonly" placeholder="CP" min="1000" max="99999" required=required value="<? echo $_SESSION['auth']->CP;?>">
		    </div>
		  </td>
		</tr>
		<tr>
		  <td>
		    <div class="form-group col-lg-3">
		      <label for="sel2"><strong>Adresse</strong></label>
		      <input  class="form-control " name="ADRESSE" id="adresse" type="text" readonly="readonly" placeholder="Adresse" required=required value="<? echo $_SESSION['auth']->ADRESSE;?>">
		    </div>
		    <div class="form-group col-lg-3">
		      <label for="sel3"><strong>Email</strong></label>
		      <input type="email" class="form-control " id="sel3"name="EMAIL" readonly="readonly" required=required value="<? echo $_SESSION['auth']->email;?>">
		    </div>
		    <div class="form-group col-lg-3">
		      <label for="sel31"><strong>Téléphone</strong></label>
		      <input type="tel" class="form-control " id="sel31"name="TELEPHONE" readonly="readonly" required=required value="<? echo $_SESSION['auth']->TELEPHONE;?>">
		    </div>
		  </td>
		</tr>
		<tr>
		  <td>
			<div class="form-group col-lg-3">
			  <label for="sel17"><strong>NOTAIRE CONCERNE</strong></label>
			   <select  class="form-control " required=required id="sel7"name="NOTAIRE" >
			     <option value=""></option>
			     <?php                           
			        $sql = "SELECT NOM, NOM2, PRENOM FROM ETUDES  where (ACTIVITE) ='ACTIF'  ORDER BY NOM2 ASC ";
					$req = mysqli_query($link,$sql) or die('Erreur SQL : <br />'.$sql);
					while($categorie = mysqli_fetch_assoc($req)) 
					{
					echo "<option name=\"\" value=\"".htmlentities($categorie['NOM'])."\">".htmlentities($categorie['NOM2']).' '.htmlentities($categorie['PRENOM'])."</option>";
			        }
			     ?>
			</div>
		</td>
		</tr>
		<tr>
		  <td>
		  <div  class="form-group col-lg-3">
		        <label for="story">Vous devez préciser votre demande:(obligatoire)</label>
					<textarea id="EXPL"required="required" maxlength="450" name="EXPL"
		          		rows="5" cols="80"></textarea>
		  </div>
		  </td>
		</tr>
		<tr>
		<td> 
		  <div>
		    <h4>Veuillez joindre une copie de votre correspondance <strong>de plus d'un mois précédemment adressée à votre Notaire, ainsi que l'ensemble des pièces utiles à la bonne compréhension de votre dossier.</strong>En un seul fichier au format PDF. </h4>
		  </div> 
		  <div  class="form-group custom-file col-lg-3">
		        <input type="file"  class="custom-file-input" id="fileUpload" name="upl" accept=".pdf" required="true"/>
		  </div>
		  </td>
		</tr>
		<tr>
		  <td>
		    <h4>Veuillez joindre une copie de <strong>votre pièce d'identité.</strong> En un seul fichier au format PDF. </h4>
		  <div  class="form-group custom-file col-lg-3">
		        <input type="file"  class="custom-file-input" id="fileUpload2" name="uplpi" accept=".pdf" required="true"/>
		  </div>
		</td>
		</tr>
		<tr>
		  <td>
		        <div class="checkbox-inline col-lg-12 ">
		          <label for="checkbox" style="color:red;" class="checkbox"><input type="checkbox" id="checkbox" class="checkbox" name="certifie" required><h4>Je certifie qu'il n'y a pas de procédure judiciaire déjà en cours pour cette demande(médiateur du notariat, procureur ...).</h4></label>
		        </div>
		  </td>
		</tr>
		<tr>
		  <td>
		  		<div class="checkbox-inline col-lg-8 ">
		          <h4>Les informations susceptibles d'être collectées à l'ocasion de votre réclamation sont exclusivement destinées à son traitement par la Chambre Interdépartementale des Notaires d'AUVERGNE. Conformément à la loi du 6 janvier 1978 modifiée en 2004, et relative à l'informatique, aux fichiers, et aux libertés, toute personne concernée bénéficie d'un droit d'accès et de rectification de ces informations. Ce droit s'exerce à l'adresse suivante: Chambre Interdépartementale des Notaires d'Auvergne 10 rue Maréchal Foch, 63000 CLERMONT FERRAND.</h4>
		          <label for="checkbox2" class="checkbox2"><input type="checkbox" id="checkbox2" class="checkbox" name="cnil" required>Je reconnais avoir pris connaissance et en accepte les termes.</label>
      		        </div>
		  </td>
		</tr>
		  <tr>
		   <td>
		      <div class="text-center">
		        <button type="submit" class=" btn-lg btn btn-success">Envoyer votre demande de réclamation</button>
		      </div>
		   </td>
		</table>
	</form>
</div>


<script>
/**
 * Used to attach events to an element or object in a browser independent way
 * @param element
 * @param event
 * @param callbackFunction
 */
function attachEvent(element, event, callbackFunction) {
    if(element.addEventListener) {
		element.addEventListener(event, callbackFunction, false);
	}
	else if(element.attachEvent)  {
		element.attachEvent('on' + event, callbackFunction);
	}
}

/**
 * Returns true if the HTML5 File API is supported by the browser
 * @returns {*}
 */
function supportsFileAPI() {
	return window.File && window.FileReader && window.FileList && window.Blob;
}

/**
 * Method to be called upon changing the contents of a input element before uploading a file
 * @param event
 */
function preUpload(event) {

	// The file API supports the ability to reference multiple files in one <input> tag
	var file = event.target.files[0];
	console.log(file);
	var reader = new FileReader();

	attachEvent(reader, "load", (function(fileToCheck) {
		return function (evt) {
			var data = evt.target.result.substr(0, 8);
			var regex = new RegExp("%PDF-1.[0-7]");
			console.log(data);
			if(data.match(regex)) {
				alert(fileToCheck.name + " est un fichier PDF valide.");
			}
			else
			{
				alert("Votre fichier n'est pas un fichier PDF valide, votre réclamation ne pourra être validée.");
			}
		}
	})(file));

	var MBSize = file.size / 1024 / 1024;
	if(MBSize > 10) {
		if(!confirm(file.name + " fait " + MBSize + "Mo et est trop volumineux, l'envoi de ce fichier pourrait causer des problèmes de stabilité à votre navigateur.\nVoulez-vous continuer?")) {
			return;
		}
	}
	reader.readAsText(file);
}

function pageLoaded() {
	var fileInput = document.getElementById("fileUpload");
	if(supportsFileAPI()) {
		attachEvent(fileInput, "change", preUpload);
	}
	else {
		alert("Votre navigateur ne supporte pas l'API fichier HTML5 .");
	}

}
function pageLoaded2() {
	var fileInput = document.getElementById("fileUpload2");
	if(supportsFileAPI()) {
		attachEvent(fileInput, "change", preUpload);
	}
	else {
		alert("Votre navigateur ne supporte pas l'API fichier HTML5 .");
	}

}
attachEvent(window, "load", pageLoaded);
/*function verifForm(f)
{
   var pseudoOk = verifPseudo(f.pseudo);
   var mailOk = verifMail(f.email);
   
   if(pseudoOk && mailOk )
      return true;
   else
   {
      alert("Veuillez joindre uniquement des fichiers .pdf");
      return false;
   }
}*/
</script>