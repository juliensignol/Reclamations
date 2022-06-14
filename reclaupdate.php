<?php 
include("menu3.php"); 
require 'inc/db/php';
?>

 <title>Mise a jour des réclamations</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" integrity="sha256-rsPUGdUPBXgalvIj4YKJrrUlmLXbOb6Cp7cdxn1qeUc= sha384-6ePHh72Rl3hKio4HiJ841psfsRJveeS+aLoaEf3BWfS+gTF0XdAqku2ka8VddikM sha512-ju6u+4bPX50JQmgU97YOGAXmRMrD9as4LE05PdC3qycsGQmjGlfm041azyB1VfCXpkpt1i9gqXCT6XuxhBJtKg==" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" integrity="sha256-Sk3nkD6mLTMOF0EOpNtsIry+s1CsaqQC1rVLTAy+0yc= sha384-pPttEvTHTuUJ9L2kCoMnNqCRcaMPMVMsWVO+RLaaaYDmfSP5//dP6eKRusbPcqhZ sha512-K1qjQ+NcF2TYO/eI3M6v8EiNYZfA95pQumfvcVrTHtwQVDG+aHRqLi/ETn2uB+1JqwYqVG3LIvdm9lj6imS/pQ==" crossorigin="anonymous"></script>


<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<div class="container-fluid">
<form action="updreclamation.php" method="post"  onsubmit="return valideForm(this)" enctype="multipart/form-data">
  <?
   include('link.php');
$NUM=$_GET['NUM'];

$stmt = $pdo->prepare('SELECT * FROM RECLAMATIONS WHERE NUMERO = :NUMERO');
    $stmt->execute(array('NUMERO' => $NUM));

    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo $row->name;
    }
} catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}


{
$PLAIGNANT=htmlentities($donnees['PLAIGNANT']);
$PLAIGNANT2=rawurlencode($donnees['PLAIGNANT']);

?>

<table class="table">
    	<caption>INFOS</caption>
    		<tr><th></th></tr>
<td class="text-center">
<strong>MISE A JOUR DES RECLAMATIONS</strong>
</td>
<tr>
<td>
<div class="form-group col-lg-3">
  <label for="sel1"><strong>PROCUREUR</strong></label>
<select  class="form-control " id="sel1"name="PROCUREUR">
   
		<OPTION value="<? echo $donnees ['PROCUREUR'];?>"><?echo $donnees ['PROCUREUR']; ?></OPTION>
		<OPTION VALUE="NON">NON</OPTION>
		<OPTION VALUE="RIOM">RIOM</OPTION>
		<?php
                            //Interroger la base mysqli
                            $sql = "SELECT TRIBUNAL FROM ETUDES  where (ACTIVITE) ='ACTIF'  GROUP BY TRIBUNAL ASC ";
                            $req = mysqli_query($link,$sql) or die('Erreur SQL : <br />'.$sql);
                           while($categorie = mysqli_fetch_assoc($req)) {
                                    echo "<option name=\"".htmlentities($categorie['TRIBUNAL'])."\" value=\"".htmlentities($categorie['TRIBUNAL'])."\">".htmlentities($categorie['TRIBUNAL'])."</option>\n\t\t";
                            }
                             ?>
		
		</SELECT>
	</div>

	<?php $alerte=mysqli_query ($link,"SELECT* from ALERTES  where  NUMERO like $NUM")or die ("Erreur requete : ".mysqli_error($link));
while ($donnees5 = mysqli_fetch_array($alerte) )	
{?>
<div class="form-group col-lg-3">
  <label for="sel1"><strong>NIVEAU D'IMPORTANCE</strong></label>
<select  class="form-control " id="sel1" name="ALERTE">
   
		<OPTION value="<? echo $donnees5['ALERT'];?>"><? echo $donnees5['ALERT'];?></OPTION>
		<OPTION VALUE="NORMAL">NORMAL</OPTION>
		<OPTION VALUE="A SURVEILLER">A SURVEILLER</OPTION>
		<OPTION VALUE="URGENT">URGENT</OPTION>
		<OPTION VALUE="CLOS">CLOS</OPTION>
		
		
		</SELECT>
		
	</div>
	
	<?php
}
?>
<div class=" form-group col-lg-3">
	<label for="sel250"><strong>EXPLORATEUR</strong></label>
	
<a id="sel250" class="btn text-right btn-danger form-control " href="Explorateur/index2.php?p=documents%2F<? echo $NUM;?>&orderby=date&order=desc"  onclick="open('Explorateur/index2.php?p=documents%2F<? echo $NUM;?>&orderby=date&order=desc', 'Popup', 'scrollbars=1,resizable=1,height=800,width=1400'); return false;" >Liste des fichiers disponibles</a>

	</div>
	</td>
	</tr>

	
	
<?php
$reponse2=mysqli_query ($link,"SELECT* from PLAIGNANT  where  NUMERO like $NUM")or die ("Erreur requete : ".mysqli_error($link));
while ($donnees2 = mysqli_fetch_array($reponse2) )	
{

?>

	
	<tr required="required" class="active">
	<td>
	<div class="form-group col-lg-3">
		<label for="sel3"><strong>CIVILITE</strong></label>
		<select  class="form-control " id="sel3"name="CIVILITEPLAIGNANT">
		<OPTION VALUE="<?php echo htmlentities($donnees2['CIVILITE']);?>"><?php echo htmlentities($donnees2['CIVILITE']);?></OPTION>
		<OPTION VALUE="Mademoiselle">Mademoiselle</OPTION>
		<OPTION VALUE="Madame">Madame</OPTION>
		<OPTION VALUE="Monsieur">Monsieur</OPTION>
		<OPTION VALUE="Madame, Monsieur">Madame, Monsieur</OPTION>
		<OPTION VALUE="Maître">Maître</OPTION>
		<OPTION VALUE="Consorts">Consorts</OPTION>
		</SELECT>
 	</div>
	<div class="form-group col-lg-3">
  		<label for="sel2"><strong>PLAIGNANT</strong></label>
			<input type="text" class="form-control " id="sel2"value="<?php echo htmlentities($donnees ['PLAIGNANT']);?>" name="PLAIGNANT">
	</td>
	</tr>
	
	</div>
	<tr class="active">
	<td>
	<div class="form-group col-lg-3">
 		 <label for="sel4"><strong>ADRESSE</strong></label>
			<input type="text" class="form-control " id="sel4" value="<?php echo htmlentities($donnees2 ['ADRESSE']);?>" name="ADRESSEPLAIGNANT">
	
	</div>
	<div class="form-group col-lg-3">
 		 <label for="sel5"><strong>CODE POSTAL</strong></label>
			<input type="text" class="form-control " id="sel5" value="<?php echo $donnees2 ['CODE_POSTAL'];?>" name="CODEPOSTALPLAIGNANT">
	
	</div>
	
	<div class="form-group col-lg-3">
 		 <label for="sel6"><strong>VILLE</strong></label>
			<input type="text" class="form-control " id="sel6" value="<?php echo $donnees2 ['VILLE'];?>" name="VILLEPLAIGNANT">

	</div>

	<div class="form-group col-lg-3">
 		 <label for="sel7"><strong>EMAIL</strong></label>
			<input type="email" class="form-control " id="sel7" value="<?php echo $donnees2 ['EMAIL'];?>" name="EMAILPLAIGNANT">

	</div>
	</td>
	</tr>
	
	</tr>
	<td>
	<div class="form-group col-lg-8">
 		 <label for="sel8"><strong>COMPLEMENT D'INFORMATION</strong></label>
			<input type="text" class="form-control " value="<?php echo $donnees2 ['COMPLEMENT_INFORMATION'];?>" id="sel8" name="COMPLEMENT">
	
	

	</div>
	
	
	</td>
	
	</tr>
	<tr>
	<td>
	
	<div class="form-group col-lg-3">
 		 <label for="sel59"><strong>DROIT</strong></label>
			<select  class="form-control " id="sel59"name="DROIT">
        <option value=""><?php echo htmlentities($donnees['DROIT']);?>"><?php echo htmlentities($donnees['DROIT']);?></option>
							<option value=""></option>
							<option value="">Immobilier">Immobilier</option>
							<option value="">Négo">Négo</option>
							<option value="">Famille">Famille</option>
							<option value="">Succession">Succession</option>
							<option value="">Affaires">Affaires</option>
						
				</SELECT>
	</div>
	<div class="form-group col-lg-3">
 		 <label for="sel9"><strong>OBJET DE LA RECLAMATION </strong></label>
			<input type="text" class="form-control " id="sel9"name="OBJET" value="<?php echo htmlentities($donnees['OBJET']);?>">
						
	</div>
	<div class="form-group col-lg-3">
 		 <label for="sel69"><strong>MOTIF</strong></label>
			<select  class="form-control " id="sel69"name="MOTIF">
              <option value=""><?php echo htmlentities($donnees['MOTIF']);?>"><?php echo htmlentities($donnees['MOTIF']);?></option>
							<option value=""></option>
							<option value="">Absence explication, délai, communication ou échange">Absence explication, délai, communication ou échange</option>
							<option value="">Erreur">Erreur</option>
							<option value="">Frais d’acte, solde de compte">Frais d’acte, solde de compte</option>
							<option value="">Devoir de conseil">Devoir de conseil</option>
							<option value="">Autres">Autres</option>
				</SELECT>
	</div>
	</td>
	
	</tr>

<tr>
<td>
<div class="form-group col-lg-3">
  <label for="sel10"><strong>CHOIX DU NOTAIRE</strong></label>
<select  class="form-control " id="sel10"name="NOTAIRE">
                            <option value=""><?php echo htmlentities($donnees['NOTAIRE']);?>"><?php echo htmlentities($donnees['NOTAIRE']);?></option>
							<option value=""></option>
							<option value="">AUTRES">AUTRES</option>

                            <?php
                            //Interroger la base mysqli
                            $sql = "SELECT NOM,NOM2,PRENOM FROM ETUDES  where (ACTIVITE) ='ACTIF'  ORDER BY NOM2 ASC ";
                            $req = mysqli_query($link,$sql) or die('Erreur SQL : <br />'.$sql);
                           while($categorie = mysqli_fetch_assoc($req)) {
                                    echo "<option name=\"".htmlentities($categorie['NOM'])."\" value=\"".htmlentities($categorie['NOM'])."\">".htmlentities($categorie['NOM2']).' '.htmlentities($categorie['PRENOM'])."</option>\n\t\t";
                            }
                             ?>

</div>
</td>	
</TR>



	<TR>
	<td>
		<div class="form-group col-lg-3">
  			<label for="sel11"><strong>SYNDIC</strong></label>
			<select  class="form-control " id="sel11"name="SYNDIC">
	
			<option value=""><?php echo htmlentities($donnees['SYNDIC']);?>"><?php echo htmlentities($donnees['SYNDIC']);?></option>
			<?php
                            //Interroger la base mysqli
                            $sql = "SELECT NOM FROM ETUDES  where (ACTIVITE) ='ACTIF'  AND FONCTION ='SYNDIC' ORDER BY NOM2 ASC ";
                            $req = mysqli_query($link,$sql) or die('Erreur SQL : <br />'.$sql);
                           while($categorie = mysqli_fetch_assoc($req)) {
                                    echo "<option name=\"".htmlentities($categorie['NOM'])."\" value=\"".htmlentities($categorie['NOM'])."\">".htmlentities($categorie['NOM'])."</option>\n\t\t";
                            }
                             ?>
			</SELECT>
		</div>
	</td>
	</tr>
	
	<tr>
		<td>		
			<div class="form-group  col-lg-3">
	 		 <label for="sel12"><strong>DATE DE RECEPTION DE LA RECLAMATION</strong></label>
				<input type="date"  class="form-control text-center" id="sel12" value="<?php echo $donnees['DATE_DE_RECEPTION']; ?>" name="RECEPTION">
				<input type="date"  class="form-control text-center"  value="<?php echo $donnees['DATE_DE_RECEPTION2']; ?>" name="RECEPTION2">
				<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_DE_RECEPTION3']; ?>" name="RECEPTION3">
			</div>
		
			<div class="form-group col-lg-3">
		 		 <label for="sel13"><strong>DATE DE TRANSMISSION AU NOTAIRE</strong></label>
					<input type="date"  class="form-control text-center" id="sel13" value="<?php echo $donnees['DATE_TRANSMISSION_NOTAIRE']; ?>" name="TRANSMISSION">
					<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_TRANSMISSION_NOTAIRE2']; ?>" name="TRANSMISSION2">
					<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_TRANSMISSION_NOTAIRE3']; ?>" name="TRANSMISSION3">
			</div>
	
			<div class="form-group col-lg-3">
		 		 <label for="sel14"><strong>DATE DE REPONSE DU NOTAIRE</strong></label>
					<input type="date"  class="form-control text-center" id="sel14" value="<?php echo $donnees['DATE_DE_REPONSE_NOTAIRE']; ?>" name="REPONSE">
					<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_DE_REPONSE_NOTAIRE2']; ?>" name="REPONSE2">
					<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_DE_REPONSE_NOTAIRE3']; ?>" name="REPONSE3">
			</div>
		
			<div class="form-group col-lg-3">
		 		 <label for="sel15"><strong>DATE DE REPONSE DU SYNDIC AU PLAIGNANT</strong></label>
					<input type="date"  class="form-control text-center" id="sel15" value="<?php echo $donnees['DATE_DE_REPONSE_SYNDIC']; ?>"
					name="REPONSE_SYNDIC">
					<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_DE_REPONSE_SYNDIC2']; ?>" name="REPONSE_SYNDIC2">
					<INPUT type="date"  class="form-control text-center" value="<?php echo $donnees['DATE_DE_REPONSE_SYNDIC3']; ?>" name="REPONSE_SYNDIC3">
			</div>
		</td>
	</tr>
	<tr>
		<td>
			<div class="form-group col-lg-3">
		 		 <label for="sel16"><strong>OBSERVATIONS</strong></label>
					<input type="text" class="form-control " id="sel16" placeholder="Indiquer 'CLOS' pour dossier terminé."value="<?php echo $donnees['OBSERVATIONS']; ?>" name="OBSERVATIONS">
			</div>
		</td>
	</tr>
	<tr>
		<td>
		<div class="text-center lg-9">
		<button type="submit" class="btn  btn-lg btn-primary">Enregistrer la Réclamation</button>
		
		</div>
		</td>
		

	</tr>

<?php


	}
	?>



<input type="hidden" name="NUM" value="<?php echo "".$NUM."" ?>"></input>
</form>


<?php
 $reponse3=mysqli_query ($link,"SELECT* from PLAIGNANT  where  NUMERO like $NUM")or die ("Erreur requete : ".mysqli_error($link));
$donnees3 = mysqli_fetch_array($reponse3); 
$EMAIL= $donnees3['EMAIL'];
//echo $EMAIL;
if (!empty($donnees3['EMAIL']))
{ 

echo' <form action="mailplaignant.php" method="post"  onsubmit="return valideForm(this)">
 
<input type="submit" class="text-center"  value="ENVOYER MAIL AR PLAIGNANT" >
<input type="hidden" name="EMAIL" value="'.$EMAIL.'"></input>
<input type="hidden" name="NUM" value="'.$NUM.'"></input>
</form> ';
 }
 ?>
 <form action="AR.php" method="post"  onsubmit="return valideForm(this)">
<input type="submit" class="text-center"  value="GENERER UN COURRIER PLAIGNANT" >
<input type="hidden" name="NUM" value="<?php echo $NUM;?>"></input>
</form>

 <form action="infonot.php" method="post"  onsubmit="return valideForm(this)">
<input type="submit" class="text-center"  value="GENERER COURRIER NOTAIRE" >
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
</form>

<form action="relancenot.php" method="post"  onsubmit="return valideForm(this)">
<input type="submit" class="text-center"  value="GENERER RELANCE NOTAIRE" >
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
</form>

<form action="relancenotconvocation.php" method="post"  onsubmit="return valideForm(this)">
<input type="submit" class="text-center"  value="GENERER RELANCE COMVOCATION" >
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
</form>

<form action="envoinotaire.php" method="post" enctype="multipart/form-data" onsubmit="return valideForm(this)">
<tr><td>
<input type=file name="fichier">
<button class="btn-info" type="submit" name="validnotaire" class="text-center">AJOUTER REPONSE NOTAIRE SCANNEE </button>
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
<input type="hidden" name="PLAIG" value="<?php echo htmlentities($donnees ['PLAIGNANT']); ?>"></input>
<input type="hidden" name="NOT" value="<?php echo htmlentities($donnees['NOTAIRE']); ?>"></input>
</td></tr>
</form>

<form action="envoi.php" method="post" enctype="multipart/form-data" onsubmit="return valideForm(this)">
<tr><td>
<input type=file name="fichier">
<button class="btn-info" type="submit" name="validplaignant" class="text-center"> AJOUTER RECLAMATION PLAIGNANT SCANNEE</button>
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
<input type="hidden" name="PLAIG" value="<?php echo htmlentities($donnees ['PLAIGNANT']); ?>"></input>
<input type="hidden" name="NOT" value="<?php echo htmlentities($donnees['NOTAIRE']); ?>"></input>
</td></tr>
</form>	
<form action="envoilibre.php" method="post" enctype="multipart/form-data" onsubmit="return valideForm(this)">
<tr><td>
<input type=file name="fichier">
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
<input type="text" name="NOMFICHIER" value="NOMFICHIER"></input>
<button class="btn-info" type="submit" name="validnotaire" class="text-center">  AJOUTER SCAN LIBRE</button>
<input type="hidden" name="PLAIG" value="<?php echo htmlentities($donnees ['PLAIGNANT']); ?>"></input>
<input type="hidden" name="NOT" value="<?php echo htmlentities($donnees['NOTAIRE']); ?>"></input>
</td></tr>
</form>	
<form action="mailsyndic.php" method="post" enctype="multipart/form-data" onsubmit="return valideForm(this)">
<tr><td>
<button class="btn-warning" type="submit" name="validplaignant" class="text-center"> ALERTER LE SYNDIC</button>
<input type="hidden" name="NUM" value="<?php echo $NUM ?>"></input>
<input type="hidden" name="SYNDIC" value="<?php echo htmlentities($donnees['SYNDIC']);?>"></input>
<input type="hidden" name="PLAIG" value="<?php echo htmlentities($donnees ['PLAIGNANT']); ?>"></input>
<input type="hidden" name="NOT" value="<?php echo htmlentities($donnees['NOTAIRE']); ?>"></input>
</td></tr>
</form>		



<?
}
?>
	


</div>


</table>

