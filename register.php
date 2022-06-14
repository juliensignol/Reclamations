<?php
require_once 'inc/functions.php';
session_start();
if(!empty($_POST)){

    $errors = array();
    require_once 'inc/db.php';

    if(empty($_POST['NOM']) || !preg_match('/\w/', $_POST['NOM'])){
        $errors['NOM'] = "Votre Nom n'est pas valide (alphabétique)";
    } else {
        $req = $pdo->prepare('SELECT id FROM membre WHERE NOM = ?');
        $req->execute([$_POST['NOM']]);
        $user = $req->fetch();
    }
    if(empty($_POST['PRENOM']) || !preg_match('/\w/', $_POST['PRENOM'])){
        $errors['PRENOM'] = "Votre prénom n'est pas valide (alphabétique)";
    } else {
        $req = $pdo->prepare('SELECT id FROM membre WHERE PRENOM = ?');
        $req->execute([$_POST['PRENOM']]);
        $user = $req->fetch();
    }

    if(empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT id FROM membre WHERE email = ?');
        $req->execute([$_POST['email']]);
        $user = $req->fetch();
        if($user){
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $errors['password'] = "Vous devez rentrer un mot de passe valide";
    }

if(empty($errors)){

    $req = $pdo->prepare("INSERT INTO membre SET  NOM= ?, PRENOM= ?, password = ?, email = ?, confirmation_token = ?");
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $token = str_random(60);
    $req->execute([$_POST['NOM'],$_POST['PRENOM'], $password, $_POST['email'], $token]);
    $user_id = $pdo->lastInsertId();
    mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttps://extra-notaires.fr/MEMBRE/confirm.php?id=$user_id&token=$token");
    $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
    header('Location: login.php');
    exit();
}


}
?>

<?php require 'inc/header.php'; ?>

<h1>S'inscrire</h1>

<?php if(!empty($errors)): ?>
<div class="alert alert-danger">
    <p>Vous n'avez pas rempli le formulaire correctement</p>
    <ul>
        <?php foreach($errors as $error): ?>
           <li><?= $error; ?></li>
        <?php endforeach; ?>
    </ul>
</div>
<?php endif; ?>

<form action="" method="POST">

    <div class="form-group col-lg-6">
        <label for="NOM"><strong>NOM</strong></label>
        <input type="text" name="NOM" id="NOM" class="form-control"/>
    </div>

    <div class="form-group col-lg-6">
        <label for="PRENOM"><strong>PRENOM</strong></label>
        <input type="text" name="PRENOM" id="PRENOM" class="form-control"/>
    </div>
          
    <div class="form-group col-lg-4">
        <label for="ville"><strong>Ville</strong></label>
        <input class="form-control " name="VILLE" id="ville" type="text" placeholder="Ville" required=required>
    </div>

    <div class="form-group col-lg-2">
        <label for="cp"><strong>Code Postal</strong></label>
        <input class="form-control " name="cp" id="cp" type="number" placeholder="CP" min="1000" max="99999" required=required>
    </div>
          
    <div class="form-group col-lg-6">
        <label for="sel2"><strong>Adresse</strong></label>
        <input  class="form-control " name="ADRESSE" id="adresse" type="text" placeholder="Adresse" required=required>
    </div>
    
    <div class="form-group col-lg-3">
        <label for="sel31"><strong>Téléphone</strong></label>
        <input type="tel" class="form-control " id="sel31"name="TELEPHONE" required=required value=""onkeypress="return phoneNumberFormat(event, this, 2, ' ')" maxlength="15">
    </div>
          
     <div class="form-group col-lg-6">
        <label for="email"><strong>Email</strong></label>
        <input type="email" name="email" class="form-control"/>
    </div>

    <div class="form-group col-lg-6">
        <label for="password"><strong>Mot de passe</strong></label>
        <input type="password" name="password" class="form-control"/>
    </div>

    <div class="form-group col-lg-6">
        <label for="password_confirm"><strong>Confirmez votre mot de passe</strong></label>
        <input type="password" name="password_confirm" class="form-control"/>
    </div>
    
    <div class="form-group col-lg-6">
        <button type="submit" class="btn btn-primary">M'inscrire</button>
    </div>
</form>

<?php require 'inc/footer.php'; ?>
<script>
$("#cp").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='cp']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                var postcodes = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les CP dans un array pour ne pas avoir plusieurs fois le même
                    if ($.inArray(item.properties.postcode, postcodes) == -1) {
                        postcodes.push(item.properties.postcode);
                        return { label: item.properties.postcode + " - " + item.properties.city, 
                                 city: item.properties.city,
                                 citycode: item.properties.citycode,
                                 value: item.properties.postcode
                        };
                    }
                }));
            }
        });
    },
    // On remplit aussi la ville
    select: function(event, ui) {
        $('#ville').val(ui.item.city);
    }
});
$("#ville").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='ville']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                var cities = [];
                response($.map(data.features, function (item) {
                    // Ici on est obligé d'ajouter les villes dans un array pour ne pas avoir plusieurs fois la même
                    if ($.inArray(item.properties.postcode, cities) == -1) {
                        cities.push(item.properties.postcode);
                        return { label: item.properties.postcode + " - " + item.properties.city, 
                                 postcode: item.properties.postcode,
                                 citycode: item.properties.citycode,
                                 value: item.properties.city
                        };
                    }
                }));
            }
        });
    },
    // On remplit aussi le CP
    select: function(event, ui) {
        $('#cp').val(ui.item.postcode);
    }
});
$("#adresse").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='cp']").val(),
            data: { q: request.term },
            dataType: "json",
            success: function (data) {
                response($.map(data.features, function (item) {
                    return { label: item.properties.name, value: item.properties.name};
                }));
            }
        });
    }
});

</script>
<script> var num = 0;

function phoneNumberFormat(evt,id,nbr,crt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    else{
        len=id.value.length;
        mod=(len-num)%nbr;
        if(mod==0 && len!=0 && len<14) {      
            id.value=id.value+crt;
            num++;
        }
        return true;   
    }
}
</script>