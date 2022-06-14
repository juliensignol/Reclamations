<?php
require 'inc/db.php';
$user_id = $_SESSION['auth']->id;
if(isset($_POST['view'])){
 
    if($_POST["view"] != '')
    {
       $stmt=$pdo->prepare("update notifications set status = 1 where status = 0");
       $stmt->execute();
    }
    //Fetching the rows from database
    $stmt1=$pdo->prepare("SELECT * inner join membre FROM notifications where membre.id=$user.id ORDER BY notifications.id DESC LIMIT 5");
    $stmt1->execute();
 
$output = '';
    if($stmt1->rowCount() > 0)
    {
    while($row = $stmt1->fetch(PDO::FETCH_ASSOC))
    {
      $output .= '
      <li>
      <a href="#">
      <strong>'.$row["subject"].'</strong><br />
      <small><em>'.$row["comment"].'</em></small>
      </a>
      </li>
      ';
    }
    }
    else{
        $output .= '<li><a href="#" class="text-bold text-italic">Aucune notification</a></li>';
    }
    $stmt2=$pdo->prepare("SELECT * FROM notifications WHERE status = 0");
    $stmt2->execute();
    $count = $stmt2->rowCount();
    $data = array(
       'notification' => $output,
       'nouvelles notifications'  => $count
    );
    echo json_encode($data);
    }
?>