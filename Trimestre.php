<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Trimestre</title>
  <?php
    include_once "header.php";
    include_once "fonctions/fonctions.php";
   ?>
</head>
<body>
  <?php
    $trimestre = getTrimestre();
    $libelleTrimestre = getTrimestreLib($trimestre);
    $libelleTr = utf8_encode($libelleTrimestre['libelle']);

    $triTrimestre = orderTrimestre();
    $n1 = $triTrimestre[1]['idTrimestre'];
    $n2 = $triTrimestre[2]['idTrimestre'];
    $n3 = $triTrimestre[3]['idTrimestre'];
    $n4 = $triTrimestre[4]['idTrimestre'];
  ?>

  <div id="conteneur">
  <h2 style="text-align:center;">Trimestre</h2>
    <form method="POST" id="listetrimestre" style="text-align:center;">  <!--liste déroulante des trimestre-->
      <select id="selecttrimestre" name="trimestre" style="text-align:center;">
        <option value=<?php echo $n1; ?>><?php echo $triTrimestre[1]['libelle'].' '.$triTrimestre[1]['annee'] ?>
        <option value=<?php echo $n2; ?>><?php echo $triTrimestre[2]['libelle'].' '.$triTrimestre[2]['annee'] ?>
        <option value=<?php echo $n3; ?>><?php echo $triTrimestre[3]['libelle'].' '.$triTrimestre[3]['annee'] ?>
        <option value=<?php echo $n4; ?>><?php echo $triTrimestre[4]['libelle'].' '.$triTrimestre[4]['annee'] ?>
      </select>
      <input class="btn btn-info" id="btnenvoyer" type="submit" value="Envoyer">
    </form>
  </div>
  <script > <!--affichage du tableau avec DataTable -->
      $(document).ready(function() {
        $('#example').DataTable({

        pagingType: "simple_numbers",
        lengthMenu:[5,10,15,20,25],
        pageLength: 20,

        });
      } );
      document.getElementById("selecttrimestre").selectedIndex = "3";
   </script>
   <?php
   if(isset($_POST['trimestre']))  //creation du tableau
   {

     echo"<div class='content-loader' style='width: 70%;margin:5% 13%;'>";
     echo "<table class='table table-striped table-hover table-responsive no-footer table-bordered' id='example'>";
     echo "<thead>";
     echo "<tr><th>Nom</th><th>Prénom</th><th>Adresse</th><th>Ajout</th></tr></thead>";

     $lesAdherents = ListerAdherent();

     foreach($lesAdherents as $unAdherent)
     {
       $id=$unAdherent['id'];
       echo '<tr>';
       echo '<td>'.$unAdherent['nom'].'</td>';
       echo '<td>'.$unAdherent['prenom'].'</td>';
       echo '<td>'.$unAdherent['adresse'].'</td>';
       echo '<td><form action="addrepas.php"  method="POST"><input type="hidden" name="prenom" value='.$unAdherent['prenom'].'><input type="hidden" name="nom" value='.$unAdherent['nom'].'><input type="hidden" name="id" value='.$id.'><input type="hidden" name="trimestre" value='.$_POST["trimestre"].'><button class="btn btn-info" id="btn-view" type="submit"><span class=" glyphicon glyphicon-plus" ></span> &nbsp;Ajout</button></form></td>';
     }
   }
   if(isset($_POST['trimestre']) && $_POST['trimestre']==1)
   {
     $libelleTrimestre = getTrimestreLib($_POST['trimestre']);
     $libelleTr = utf8_encode($libelleTrimestre['libelle']);
     echo"<h4>Trimestre selectionné : ".$libelleTr." </h4>";
     echo "<script>";
     echo "document.getElementById('selecttrimestre').style.display = 'none';";
     echo "document.getElementById('btnenvoyer').style.display = 'none';";
     echo'</script>';
   }
   elseif(isset($_POST['trimestre']) && $_POST['trimestre']==2)
   {
     $libelleTrimestre = getTrimestreLib($_POST['trimestre']);
     $libelleTr = utf8_encode($libelleTrimestre['libelle']);
     echo"<h4>Trimestre selectionné : ".$libelleTr." </h4>";
     echo "<script>";
     echo "document.getElementById('selecttrimestre').style.display = 'none';";
     echo "document.getElementById('btnenvoyer').style.display = 'none';";
     echo'</script>';
  }
  elseif(isset($_POST['trimestre']) && $_POST['trimestre']==3)
  {
    $libelleTrimestre = getTrimestreLib($_POST['trimestre']);
    $libelleTr = utf8_encode($libelleTrimestre['libelle']);
    echo"<h4>Trimestre selectionné : ".$libelleTr." </h4>";
    echo "<script>";
    echo "document.getElementById('selecttrimestre').style.display = 'none';";
    echo "document.getElementById('btnenvoyer').style.display = 'none';";
    echo'</script>';
  }
  elseif(isset($_POST['trimestre']) && $_POST['trimestre']==4)
  {
    $libelleTrimestre = getTrimestreLib($_POST['trimestre']);
    $libelleTr = utf8_encode($libelleTrimestre['libelle']);
    echo"<h4>Trimestre selectionné : ".$libelleTr." </h4>";
    echo "<script>";
    echo "document.getElementById('selecttrimestre').style.display = 'none';";
    echo "document.getElementById('btnenvoyer').style.display = 'none';";
    echo'</script>';
  }
  echo '</table>';
  if(isset($_POST['nbrepas']))
  {
    ModifNbRepasParAdherent($_POST['id'],$_POST['trimestre'],$_POST['nbrepas']);
  }
  ?>
    <form style="text-align:center;">
      <input   class="btn btn-info" onclick="window.location.href='trimestre.php'" type="submit" value="Retour" id="btnretoureee"> <!-- Boutton annuler -->
      <input  class="btn btn-info" onclick="window.location.href='index.php'" type="button"  value="Accueil">
    </form>
</body>
</html>
