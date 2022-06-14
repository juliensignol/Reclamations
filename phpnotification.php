<?php
require 'inc/db.php';
require 'inc/functions.php';
logged_only();
if(isset($_POST["post"]))
{
 
   $subject=$_POST['subject'];
   $comment=$_POST['comment'];
   $status = 0;
     
    $sql="INSERT INTO notifications(subject,comment,status)VALUES('$subject','$comment','$status')";
    $stmt=$pdo->prepare($sql);
    $stmt->execute();
     
     
}
 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<title>Notifications</title>
 
  
<style>
.container{
    width:40%;
    height:30%;
    padding:20px;
    margin-top: 5%;
}
</style>
</head>
 
<body>
    <div class="container">
        <nav class="navbar navbar-inverse">
               <div class="container-fluid">
                    <div class="navbar-header">
                     <a class="navbar-brand" style="color: white;">Messages en attente</a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                     <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="label label-pill label-danger count" style="border-radius:10px;"></span> <span class="glyphicon glyphicon-bell" style="font-size:20px;color: white;"></span></a>
                      <ul class="dropdown-menu"></ul>
                     </li>
                    </ul>
               </div>
          </nav>
        <br />
        <div id="show_notification"></div>
        <form method="post" action="#">
               <div id="error_div"></div>
               <div class="form-group">
                <label>Entrez un sujet</label>
                <input type="text" name="subject" id="subject" class="form-control">
               </div>
               <div class="form-group">
                <label>Entrer votre message</label>
                <textarea name="comment" id="comment" class="form-control" rows="5"></textarea>
               </div>
               <div class="form-group">
                <button type="button" class="btn btn-primary" name="post" id="post">Enregistrer</button>
               </div>
        </form>
    </div>
 
 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" integrity="sha256-cCueBR6CsyA4/9szpPfrX3s49M9vUU5BgtiJj06wt/s= sha384-nrOSfDHtoPMzJHjVTdCopGqIqeYETSXhZDFyniQ8ZHcVy08QesyHcnOUpMpqnmWq sha512-qzrZqY/kMVCEYeu/gCm8U2800Wz++LTGK4pitW/iswpCbjwxhsmUwleL1YXaHImptCHG0vJwU7Ly7ROw3ZQoww==" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
    $('#post').click(function(){
        //alert('ok');
        var subject = $('#subject').val();
        var comment = $('#comment').val();
        if(subject=='' || comment==''){
 
           $('#error_div').html('<div class="alert alert-danger"><strong>Merci de remplir les champs obligatoires.</strong></div>');
        }
        else{
             $.ajax({
 
              url:"phpnotification.php",
              method:"POST",
              data:{'subject':subject,'comment':comment,'post':1},
              dataType:"html"
               
             })
             .done(function(data){
                 
                load_unseen_notification();
                $('#show_notification').html('<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>Succès!</strong>Message ajouté.</div>');
                $('#subject').val('');
                $('#comment').val('');
                $('#error_div').html('');
  
             })
            .fail(function(xhr,textStatus,errorThrown,data)
                {
                 
                alert(errorThrown);
                 
                });
        }
 
    });
});
    function load_unseen_notification(view = '')
        {
         $.ajax({
          url:"fetchnotification.php",
          method:"POST",
          data:{view:view},
          dataType:"json",
          success:function(data)
          {
           $('.dropdown-menu').html(data.notification);
           if(data.unseen_notification > 0)
           {
            $('.count').html(data.unseen_notification);
           }
          }
         });
        }
    load_unseen_notification();
    $(document).on('click', '.dropdown-toggle', function(){
         $('.count').html('');
         load_unseen_notification('yes');
        });
        setInterval(function(){
         load_unseen_notification();
        }, 5000);
 
</script>

 
</body>
</html>