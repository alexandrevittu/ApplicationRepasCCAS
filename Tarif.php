<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Tarifs</title>
  <?php
  include_once "header.php";
  include_once "fonctions/fonctions.php";
  ?>
</head>
<body>
  <div class="content-loader" style="width: 50%;margin:5% 20%;">    <!--creation du Formulaire des tarifs-->
    <h2 style="text-align:center;">Tarifs</h2>
    <hr class="style-ligne">
      <form id="tarif" method="POST">
        <label>Tarif personne imposable</label><br>
        <input type="number" name="imposable" step="0.1" id="imposable"/><br>
        <label>Tarif personne non imposable</label><br>
        <input type="number" name="nonimposable" step="0.1" id="nonimposable"/><br>
        <p><input type="submit" value="Valider"/></p>
      </form>
      <?php
      if(isset($_POST["imposable"]))    //envoie dans la BDD
      {
        ModifTarifImposable($_POST['imposable']);
        ModifTarifNonImposable($_POST['nonimposable']);
        echo'<script>';
        echo"window.setTimeout(location=('index.php'), 6)";
        echo'</script>';
      }

      ?>
      <input id="btn_tarifRetour" type="submit" onclick="history.go(-1)" value="Retour">

      <?php
      $i=0;
      $lestarifs = GetTarif();
      foreach($lestarifs as $tarif)
      {
        echo '<script>';
        if($i == 0)
        {
          echo"document.getElementById('imposable').value=".$tarif['prix'];
        }
        if($i == 1)
        {
          echo"document.getElementById('nonimposable').value=".$tarif['prix'];
        }
        echo '</script>';
        $i++;
      }
       ?>
      <hr class="style-ligne">
</div>
</body>
</html>
