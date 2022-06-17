<?php
require_once "PHPWord/PHPWord.php";
require 'inc/db.php';
require'link.php';
// Create a new PHPWord Object
$PHPWord = new PHPWord();
 
 if (isset($_POST['NUM'])) 
{

  try {
    

    $stmt = $pdo->prepare('SELECT * FROM RECLAMATIONS WHERE NUMERO = :NUMERO');
    $stmt->execute(array('NUMERO' => $_POST['NUM']));

    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo $row->name;
    }
} catch(PDOException $e) {
    echo  $e-->getMessage();
}
while ($donnees = mysqli_fetch_array($reponse) )
{




$PLAIG= $donnees ['PLAIGNANT'];
$NOT= $donnees ['NOTAIRE'];
$NUM= mysqli_real_escape_string($pdo,$_POST['NUM']);
setlocale(LC_TIME, "fr_FR");
$time= strftime("%d%m%y");
echo $PLAIG;

$NOT2= addslashes($NOT);

try {
$stmt = $pdo->prepare('SELECT * FROM PLAIGNANT WHERE NUMERO = :NUMERO');
    $stmt->execute(array('NUMERO' => $NUM));

    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo $row->name;
    }
} catch(PDOException $e) {
    echo  $e->getMessage();
}

while ($donnees2 = mysqli_fetch_array($reponse2) )
{
$NOT = mysqli_real_escape_string($link,$NOT);
try {
$stmt = $pdo->prepare('SELECT * FROM ETUDES WHERE NOM = :NOM');
    $stmt->execute(array('NOM' => $NOT));

    while($row = $stmt->fetch(PDO::FETCH_OBJ)) {
        echo $row->name;
    }
} catch(PDOException $e) {
    echo  $e->getMessage();
}

echo $NOT;
//boucle pour lire l'array
while ($donnees3 = mysqli_fetch_array($reponse3) )
{

$jour = array("Dimanche","Lundi","Mardi","Mercredi","Jeudi","Vendredi","Samedi");

$mois = array("","Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");

$dateDuJour = " ".date("d")." ".$mois[date("n")]." ".date("Y");




$document = $PHPWord->loadTemplate('AR/AR2ISABELLE.docx');

$document->setValue('Value1', $PLAIG);

$document->setValue('Value2', $dateDuJour);
$document->setValue('Value3', $PLAIG);
$document->setValue('Value4', $NOT);
$document->setValue('Value5',  $donnees ['DATE_DE_RECEPTION']);
$document->setValue('Value6', $NOT);
$document->setValue('Value7', $donnees ['SYNDIC']);
$document->setValue('Value8', $donnees2['CIVILITE']);
$document->setValue('Value9', $donnees2['ADRESSE']);
$document->setValue('Value10', $donnees2['CODE_POSTAL']);
$document->setValue('Value11', $donnees2['VILLE']);
$document->setValue('Value12', $donnees3['VILLE']);
$document->setValue('Value13', $NUM);
$document->setValue('Value15', $donnees2['EMAIL']);

$document->setValue('time', date('H:i'));


  if(!is_dir("Explorateur/documents/".$NUM))
                     {  
                         mkdir("Explorateur/documents/".$NUM."", 0777);//création d'un dossier si il n'existe pas
                         
                      }
$document->save("Explorateur/documents/$NUM/AR$NUM$time.docx");


}
}
}
}


header('Location:reclaupdate.php?NUM='.$NUM);

?>