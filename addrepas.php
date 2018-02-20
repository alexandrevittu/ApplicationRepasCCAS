<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>add repas</title>
  <?php
    include_once "header.php";
    include_once "fonctions/fonctions.php";
   ?>
</head>
<body>
  <?php
    $ladherent = GetAdherent($_POST['id']);   //recuperation de l'adherent et du trimestre
    $idadherent =$_POST['id'];
    $trimestre =$_POST['trimestre'];
    $libelleTrimestre = getTrimestreLib($_POST['trimestre']);
   ?>
  <div id="conteneur">
  <!--Creation du formulaire -->
    <form action="Trimestre.php" id="ajouttrajet" method="POST">
      <h4><strong><?php echo "Nom : ".$_POST['nom']."<br> Prenom : ".$_POST['prenom'] ?><strong></h4>
        <hr class="style-ligne">
        <h4><?php echo utf8_encode($libelleTrimestre['libelle']); ?> </h4>
        <input type="hidden" name="id" id="id" value="<?php echo$idadherent?>"/></br>
        <input type="hidden" name="trimestre" id="trimestre" value="<?php echo$trimestre?>"/></br>
        <label for="repas">Nombre de repas : </label></br>
        <input type="number" min="0" name="nbrepas" id="nbrepas"/></br>
        <input  id="testbtn" class="btn btn-info" type="button" value="Valider">
    </form>
    <form action="Trimestre.php" method="POST">
      <?php
      echo '<input type="hidden" name="trimestre" value='.$trimestre.'>';
      ?>
      <br><button class="btn btn-info" type="submit">Retour</button>
    </form>
    <hr class="style-ligne">
</div>
<?php
  $nbrepas = Getnbtrajetcours($trimestre);
  echo"<script>document.getElementById('nbrepas').value=".$nbrepas['nbrepas']."</script>";

 ?>
</body>
</html>
<script>
  $(function() {
   $("#testbtn").click(function(){              //fenetre de dialog
     if(confirm("Êtes vous sûr de vouloir ajouter ces trajets ?")==true)
     {
        $("#ajouttrajet").submit();
     }
     else {
     }
   });
  });
  </script>
