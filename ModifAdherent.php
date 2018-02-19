<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Modification d'un adherent</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<?php
include_once "header.php";
include_once "fonctions/fonctions.php";

#recuperation de l'adherent
$ladherent = GetAdherent($_POST['id']);
$remarque=htmlspecialchars($ladherent['remarque']);
?>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>      <!-- traduction du calendrier -->
$( function() {
  $( "#datepicker" ).datepicker({
    altField: "#datepicker",
    closeText: 'Fermer',
    prevText: 'Précédent',
    nextText: 'Suivant',
    currentText: 'Aujourd\'hui',
    monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
    monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
    dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
    dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
    dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
    weekHeader: 'Sem.',
    dateFormat: 'yy-mm-dd'
  });
});

</script>

<body>
  <div id="conteneur">
    <hr class="style-ligne">
    <form id="ajoutadherent" method="POST" action="ModifAdherent.php" onsubmit="return verifForm(this)">
      <input type="hidden" name="id" id="id" value="<?php echo$ladherent['id']?>"/></br>
      <label for="fnom">Nom</label><br>
      <input type="text" name="nom" id="fnom" onblur="verifNom(this)" value="<?php echo$ladherent['nom']?>"/></br>
      <label for="fprenom">Prénom</label></br>
      <input type="text" name="prenom" id="fprenom" onblur="verifPrenom(this)" value="<?php echo$ladherent['prenom']?>"/></br>
      <label for="fadresse">Adresse</label></br>
      <input type="text" name="adresse" id="fadresse" onblur="verifChamp(this)" value="<?php echo$ladherent['adresse']?>"/></br>
      <label for="datepicker">Date d'adhésion</label></br>
      <input type="text" name="dateAdhesion" id="datepicker" onblur="verifDate(this)" value="<?php echo$ladherent['dateAdhesion']?>"/></br>
      <label for="fremarque">Remarque</label></br>
      <textarea name="remarque" id="fremarque" form="ajoutadherent" rows="4" cols="50" /><?php echo $remarque?></textarea><br>
      <?php
      if($ladherent['idTypeRepas']==1)
      {
        echo "<input type='radio' name='impot' value='1' checked> Imposable<br>";
        echo "<input type='radio' name='impot' value='2'> Non imposable<br>";
      }
      else {
        echo "<input type='radio' name='impot' value='1' > Imposable<br>";
        echo "<input type='radio' name='impot' value='2' checked> Non imposable<br>";
      }
       ?>
      <input class="" type="submit" value="Modifier"/></br>
    </form>
    <?php
    if(isset($_POST['nom']))
    {
      ModifAdherent($_POST["id"],($_POST["nom"]),($_POST["prenom"]),($_POST["adresse"]),($_POST["dateAdhesion"]),($_POST["remarque"]));
      header('Location: index.php');
    }
     ?>

      <form action="ListeAdherents.php">
        <input id="btn_ajout" type="submit" value="Annuler" class="buttonannulmodif"/>
        <hr class="style-ligne"/>
      </form>

  </div>
  <script>
  function surligne(champ, erreur)

  {
     if(erreur){

        champ.style.backgroundColor = "#fba";

     }else{

        champ.style.backgroundColor = "";}
  }

  function verifDate(champ){

  var dateSaisie = new Date(champ.value);
  if (dateSaisie != "") {
    surligne(champ,false);
    return true;
  }else {
    surligne(champ,true);
    return false;
  }
}

  function verifNom(champ){
    if (champ.value == "" || isNaN(champ.value) == false ) {
      surligne(champ,true);
      return false;
    }else {
      surligne(champ,false);
      return true;
    }
  }

  function verifPrenom(champ){
    if (champ.value == "" || isNaN(champ.value) == false ) {
      surligne(champ,true);
      return false;
    }else {
      surligne(champ,false);
      return true;
    }
  }

  function verifChamp(champ){
    if (champ.value == "") {
      surligne(champ,true);
      return false;
    }else {
      surligne(champ,false);
      return true;
    }
  }

  function verifForm(f){
      var nomOk = verifNom(f.nom);
      var prenomOk = verifPrenom(f.prenom);
      var dateOk = verifDate(f.dateAdhesion);
      var adresseOk = verifChamp(f.adresse);
      if (nomOk && prenomOk && adresseOk && dateOk) {
        return true;
      }else {
        alert("Veuillez remplir correctement tous les champs ...");
        return false;
      }
  }
  </script> <!-- ici-->
</body>
</html>
