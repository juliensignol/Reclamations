<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<div class="container-fluid">
<?php
require 'link.php';
require 'fonctions.php';


                
$NOM= addslashes($_POST['NOM']);
$PRENOM = addslashes($_POST['PRENOM']);
$NOTAIRE= addslashes($_POST['NOTAIRE']);
$ADRESSE= addslashes($_POST['ADRESSE']);
$CP= addslashes($_POST['CP']);
$VILLE= addslashes($_POST['VILLE']);
$EMAIL= addslashes($_POST['EMAIL']);
$TELEPHONE= addslashes($_POST['TELEPHONE']);
$EXPL= $_POST['EXPL'];
$DATE_DEPOT= date('Y-m-d');
              
    try {


    $stmt = $pdo->prepare("SELECT * FROM RECLTEMP WHERE NOM = :NOM AND PRENOM = :PRENOM AND NOTAIRE = :NOTAIRE AND VALIDE LIKE 'valide'");
    $stmt->execute(array(':NOM' => $NOM,
                         ':PRENOM' => $PRENOM));

    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo '<div class="jumbotron "><p><p><p><h2>Vous avez déjà déposé un dossier de demande de réclamation avec les mêmes informations( Nom, Prénom et Notaire concerné).Votre dossier est déjà en cours de traitement, veuillez patienter, nous vous tiendrons informé dès que possible.</h2></div>';
    }
} 
catch(PDOException $e) {
    echo 'ERROR: ' . $e->getMessage();
}
try {
                $pdo = $pdo->prepare("
                    INSERT INTO RECLTEMP(NOM,PRENOM,NOTAIRE,EMAIL,TELEPHONE,EXPL,DATE_DEPOT)
                    VALUES (:nom, :prenom, :adresse, :ville, :cp, :pays, :mail)
                ");
                $pdo->execute(array(
                                    ':NOM' => $NOM,
                                    ':PRENOM' => $PRENOM,
                                    ':NOTAIRE' => $NOTAIRE,
                                    ':EMAIL' => $EMAIL,
                                    ':TELEPHONE' => $TELEPHONE,
                                    ':EXPL' => $EXPL,
                                    ':DATE_DEPOT' => $DATE_DEPOT));
                echo '<div class="jumbotron"><p><p><p><h2>Votre demande de réclamation est enregistrée. Après un examen attentif de votre dossier, vous recevrez par courriel une réponse de notre part concernant sa prise en charge ou son rejet.</h2><p> <h3><strong>Nous vous précisons cependant que le délai de traitement peut être plus ou moins long en fonction de différents facteurs.</strong> </h3><p><h3>Le suivi sera effectué par courriel (verifiez votre dossier spam),<strong>jamais par téléphone.</strong></h3><p><h3> Nous vous remercions pour votre compréhension.</h3></div>';
                $donnees=mysqli_insert_id($link);
	$NUM= $donnees;
//echo $NUM;
	//Envoi du mail au destinataire
	$expediteur="ci.auvergne@notaires.fr";
	$destinataire="$EMAIL";
	$nomDestinataire= "Réclamations";
	$adresseReponse="$expediteur";
	$objet= "Une demande de réclamation pour ".$PRENOM." ".$NOM." contre Me ".$NOTAIRE." est arrivée.";
	$corps= '<a href="https://extra-notaires.fr/REA/updaterecltemp.php?NUM='.$NUM.'">'.$NUM.'</a>';


            }
                  
catch(PDOException $e){
                echo "Erreur : " . $e->getMessage();
            } 	

 mysqli_close($link);
?>

