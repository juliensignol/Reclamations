<?php
require 'inc/functions.php';
require_once 'inc/db.php';
logged_only();
if(!empty($_POST)){
    
    $errors = array();

    if(empty($_POST['NOM']) || !preg_match('/\w/', $_POST['NOM'])){
        $errors['NOM'] = "Votre Nom n'est pas valide (alphabétique)";
    } 

    if(empty($_POST['PRENOM']) || !preg_match('/\w/', $_POST['PRENOM'])){
        $errors['PRENOM'] = "Votre prénom n'est pas valide (alphabétique)";
    } 

    if(empty($_POST['EMAIL']) || !filter_var($_POST['EMAIL'], FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Votre email n'est pas valide";
    } else {
        $req = $pdo->prepare('SELECT id FROM membre WHERE email = ?');
        $req->execute([$_POST['EMAIL']]);
        $user = $req->fetch();
        if($user){
            $errors['email'] = 'Cet email est déjà utilisé pour un autre compte';
        }
    }
    
        $user_id = $_SESSION['auth']->id;
        $NOM= $_POST['NOM'];
        $PRENOM= $_POST['PRENOM'];
        $VILLE= $_POST['VILLE'];
        $CP= $_POST['CP'];
        $ADRESSE= $_POST['ADRESSE'];
        $EMAIL= $_POST['EMAIL'];
        $TELEPHONE= $_POST['TELEPHONE'];

        
        $pdo->prepare('UPDATE membre SET NOM = ?, PRENOM = ?, VILLE = ?, CP = ?, ADRESSE = ?, email = ?, TELEPHONE = ? WHERE id = ?')->execute([$NOM, $PRENOM, $VILLE, $CP, $ADRESSE, $EMAIL, $TELEPHONE, $user_id]);
        $_SESSION['flash']['success'] = "Vos informations ont bien été mises à jour";
    

}
require 'inc/header.php';
?>
    <table class="table"  >
    <caption>INFOS</caption>
    <tr><th></th></tr>
    <h1>Bonjour <?= $_SESSION['auth']->PRENOM;?> <?=$_SESSION['auth']->NOM; ?></h1>

    <form action="" method="post">
        
        <tr required="required"class="active">
          <td>
            <div class="form-group col-lg-3">
              <label for="sel2"><strong>NOM</strong></label>
              <input type="text" class="form-control " id="sel2"name="NOM" required=required value="<? echo $_SESSION['auth']->NOM;?>">
            </div>

            <div class="form-group col-lg-3">
              <label for="sel3"><strong>PRENOM</strong></label>
              <input type="text" class="form-control " id="sel3"name="PRENOM" required=required value="<? echo $_SESSION['auth']->PRENOM;?>">
            </div>
          </td>
        </tr>
        <tr required="required"class="active">
          <td>
            <div class="form-group col-lg-3">
              <label for="ville"><strong>Ville</strong></label>
              <input class="form-control " name="VILLE" id="VILLE" type="text" placeholder="Ville" required=required value="<? echo $_SESSION['auth']->VILLE;?>">
            </div>
            <div class="form-group col-lg-3">
              <label for="cp"><strong>Code Postal</strong></label>
              <input class="form-control " name="CP" id="CP" type="number" placeholder="CP" min="1000" max="99999" required=required value="<? echo $_SESSION['auth']->CP;?>">
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <div class="form-group col-lg-3">
              <label for="sel2"><strong>Adresse</strong></label>
              <input  class="form-control " name="ADRESSE" id="ADRESSE" type="text" placeholder="Adresse" required=required value="<? echo $_SESSION['auth']->ADRESSE;?>">
            </div>
            <div class="form-group col-lg-3">
              <label for="sel3"><strong>Email</strong></label>
              <input type="email" class="form-control " id="sel3" name="EMAIL" required=required value="<? echo $_SESSION['auth']->email;?>">
            </div>
            <div class="form-group col-lg-3">
              <label for="sel31"><strong>Téléphone</strong></label>
              <input type="tel" class="form-control " id="sel31" name="TELEPHONE" required=required value="<? echo $_SESSION['auth']->TELEPHONE;?>"onkeypress="return phoneNumberFormat(event, this, 2, ' ')" maxlength="15">
            </div>
            </td>
        </tr>
        <tr>
        <td>
        <button class="btn btn-primary">Modifier informations personelles</button>
        </td>
        </tr>
    </form>
    
</table>
    <form action="" method="post">
<a href="reclamation.php" class="btn btn-info">Faire une demande de réclamation</a>
</form>
<?php require 'inc/footer.php'; ?>
<script>
$("#CP").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?postcode="+$("input[name='CP']").val(),
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
        $('#VILLE').val(ui.item.city);
    }
});
$("#VILLE").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='VILLE']").val(),
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
        $('#CP').val(ui.item.postcode);
    }
});
$("#ADRESSE").autocomplete({
    source: function (request, response) {
        $.ajax({
            url: "https://api-adresse.data.gouv.fr/search/?city="+$("input[name='VILLE']").val(),
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