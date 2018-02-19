<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Repas CCAS</title>
  <?php
  include_once "header.php";
  ?>
</head>
<body>
  <div id="centrerAccueil">

  <div id="adherent">
    <fieldset>
      <legend><span class="glyphicon glyphicon-user"></span>&nbsp; Adhérent :</legend>
        <form  action="AjoutAdherent.php">
          <button class="btn btn-info" type="submit" id="accueil"> <span class="glyphicon glyphicon-plus"></span> &nbsp; Ajout d'un adhérent</button>
        </form>
        <form  action="ListeAdherents.php">
          <button class="btn btn-info" type="submit" id="accueil"> <span class="glyphicon glyphicon-th-list"></span> &nbsp; Liste des adhérents</button>
        </form>
    </fieldset>
  </div>

  <div id="facturation">
  <fieldset>
    <legend><span class="glyphicon glyphicon-euro" ></span> &nbsp; Facturation :</legend>
      <form action="Tarif.php">
        <button class="btn btn-info" type="submit" id="accueil"> <span class="glyphicon glyphicon-euro" ></span> &nbsp; Tarifs</button>
      </form>
      <form action="Trimestre.php" method="POST">
        <button class="btn btn-info" type="submit" id="accueil"> <span class=" glyphicon glyphicon-option-horizontal" ></span> &nbsp; Trimestres</button>
      </form>
      <form action="Facturation.php">
        <button class="btn btn-info" type="submit" id="accueil"> <span class="glyphicon glyphicon-shopping-cart" ></span> &nbsp; Facturation</button>
      </form>
  </fieldset>
</div>
</div>
</body>
</html>
