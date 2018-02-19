<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ajout d'un adherent</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <?php
  include_once "header.php";
  include_once "fonctions/fonctions.php";
  ?>
  <script>
  $( function() {
    $( "#dialog-confirm" ).dialog({  //Popup customisé qui s'affiche lors de la validation
      resizable: false,
      closeOnEscape: false,
      dialogClass: "noclose",
      draggable:false,
      height: "auto",
      width: 400,
      modal: true,
      buttons: {
        "Oui": function() {
          $( this ).dialog( "close" );
        },
        "Non": function() {
          $( this ).dialog( "close" );
          window.location.replace("index.php");
        }
      }
    }).prev(".ui-dialog-titlebar").css("background","#66C2E2");;
  } );
  </script>
</head>


<script>
  $( function() {
    $( "#datepicker" ).datepicker({               //traduction du datapicker(calendrier)
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
<script>
function surligne(champ, erreur)                /***Ces fonctions permettent de verifier les données saisies dans le formulaire en javascript***/
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
    var dateOk = verifDate(f.date);
    var adresseOk = verifChamp(f.adresse);
    if (nomOk && prenomOk && adresseOk && dateOk) {
      return true;
    }else {
      alert("Veuillez remplir correctement tous les champs ...");
      return false;
    }
}
$(function()
{
  $('#ajoutadherent').submit(function(){  //fonction permmettant d'eviter d'appuyer plusieurs fois sur valider afin d'eviter d'ajouter la bdd plusieurs adherents qui ont les memes données
    $("input[type='submit']", this)
      .val("Please Wait...")
      .attr('disabled', 'disabled');
    return true;
  });
});
</script> <!-- ici-->


<body>
  <div id="conteneur">                    <!--formulaire d'ajout d'adherent -->
    <h2 style="text-align:center;">Ajout d'adhérents</h2>
    <hr class="style-ligne">
    <form id="ajoutadherent" method="POST" onsubmit="return verifForm(this)" autocomplete="off">
      <label for="fnom">Nom</label><br>
      <input type="text" name="nom" id="fnom" onblur="verifNom(this)" required /><br>
      <label for="fprenom">Prénom</label><br>
      <input type="text" name="prenom" id="fprenom" onblur="verifPrenom(this)" required /><br>
      <label for="fnom">Adresse</label><br>
      <input type="text" name="adresse" id="fadresse" onblur="verifChamp(this)" required /><br>
      <label for="fnom">Date d'adhésion</label><br>
      <input type="text" id="datepicker" name="date" onblur="verifDate(this)" required><br>
      <label for="fnom">Remarques</label><br>
      <!-- <input type="text" name="remarque" id="fremarque" /><br> -->
      <textarea name="remarque" id="fremarque" form="ajoutadherent" rows="4" cols="50"/></textarea><br>
      <input type="radio" name="impot" value="1" required> Imposable<br>
      <input type="radio" name="impot" value="2" required> Non imposable<br>
      <p><input class="" type="submit" value="Valider" id="test"/><br>
    </form>
    <?php
    if(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["adresse"]) && isset($_POST["date"]) &&  isset($_POST["remarque"]))
    {
     if($_POST["nom"]==NULL || $_POST["prenom"]==NULL || $_POST["adresse"]==NULL)             //regarde si le formulaire n'est pas vide
     {
       echo"<script>alert('Saisir les champs obligatoire (Nom,prenom,adresse,date)');history.go(-1);</script>";
     }
     else
     {
       $dateactuel = date_create(date('Y-m-d'));
       $datesaisie = date_create(($_POST["date"]));
       var_dump($_POST['impot']);
       $diff = date_diff($datesaisie,$dateactuel);
       $nb= (int)$diff->format('%R%a');
       if((int)$nb>=0)                        //verifie si la date n'est pas suppérieur a celle du jour
       {
         if(AjoutAdherent(($_POST["nom"]),($_POST["prenom"]),($_POST["adresse"]),($_POST["date"]),($_POST["remarque"]),($_POST["impot"])) == false)
         {
           echo"<script>alert('L\'adhérent que vous voulez ajouter existe dêja !');</script>";
         }
         else {




           //ajoute l'adherent
         $id = Getidadherent($_POST["nom"],$_POST["prenom"]);
         $trimestre = getTrimestre();
         $nbtrajet =0;
         for($i=1;$i<=4;$i++)     //ajoute des trajet court,moyen,long avec nbtrahet=0 pour chaque adherent crée pour chaque trimestre
         {
           ajouttrajetcourtparadherent($id['id'],$i,$nbtrajet);
           ajouttrajetmoyenparadherent($id['id'],$i,$nbtrajet);
           ajouttrajetlongparadherent($id['id'],$i,$nbtrajet);
         }
         ajoutadhesionparadherent($id['id'],$trimestre,date('y-m-d'));
         ?>
         <div id="dialog-confirm" title="Ajout d'adhérents">
           <p><span class="ui-icon ui-icon-check" style="margin-right:15px;"></span>L'adherent <?php echo $_POST['nom'].' '.$_POST['prenom']?> a été ajouté.</br> Voulez-vous ajouter un autre adhérent ?</p>
         </div>
         <?php
       }
       }
       else
       {
         $nom = $_POST['nom'];
         $prenom = $_POST['prenom'];
         $adresse = $_POST['adresse'];
         $remarques = $_POST['remarque'];
        echo"<script>alert('Date supérieure à celle d\'aujourd\'hui');document.getElementById('fnom').value='".$nom."';document.getElementById('fprenom').value='".$prenom."';document.getElementById('fadresse').value='".$adresse."';document.getElementById('fremarque').value='".$remarques."';</script>";
       }
     }
    }
  ;

  ?>


  <input  id="btn_ajout" class="" onclick="window.location.href='index.php'" type="submit" value="Retour" class="buttonadherent">
  <hr class="style-ligne">
</div>
</body>
</html>
