<?php
include_once "header.php";
include_once "fonctions/fonctions.php";
$lesAdherents = ListerAdherent();
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Liste des adherent</title>
  <style type="text/css">
  #dis{
    display:none;
  }
</style>
<script language="javascript" type="text/javascript">

  $(document).ready(function() {
    $('#example').DataTable({
      pagingType: "simple_numbers",
      lengthMenu:[5,10,15,20,25],       //affichage par default a 20 puis selection possible a 5,10,15,20,25
      pageLength: 20,
      // fixedHeader: true,
      "oLanguage": {
  "sInfo": "Il y a un total de  _TOTAL_ adhérents (_START_ à _END_)"
    },
    });



    $( "#formSupp" ).submit(function( event ) {
      if (confirm("Etes vous sur de vouloir supprimmer cet adherent ?")==true) {    //confirmation de suppresion de l'adherent
        window.location = 'validerSupp.php';
        $(document).on('submit', '#formSupp', function () {

          $.post("validerSupp.php", $(this).serialize())
          .done(function (data) {
            $("#dis").fadeOut();
            $("#dis").fadeIn('slow', function () {
              if (data === "Suppression Réussie") {
                $("#dis").html('<div class="alert alert-info">' + data + '</div>');
              } else {
                $("#dis").html('<div class="alert alert-danger">' + data + '</div>');
              }
              $("#formSupp")[0].reset();
            });
          });
          return false;
        });
      }
      event.preventDefault();
    });
  } );

  </script>
</head>

<body>
  <h2 style="text-align:center;">Liste des adhérents</h2>
  <div class="content-loader">          <!--Creation du tableau-->
      <div id="dis"></div>
      <table onload="location.reload();" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-hover table-responsive no-footer table-bordered" id="example">
        <thead>
          <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Adresse</th>

            <th>Remarques</th>
            <th>Imposable</th>
            <th>Modifier/Supprimer</th>
          </tr>
        </thead>
        <tbody>
          <div>
            <?php
            foreach($lesAdherents as $unAdherent){

              $dnow = $unAdherent['dateAdhesion'];
              $dafter = date("Y-m-d");
              $date1=date_create($dnow);
              $date2=date_create($dafter);
              $diff=date_diff($date1,$date2);
              $difference = (int)$diff->format('%R%a');
              $id=$unAdherent['id'];                        //recuperation des adhrents + calcul leur date

              $d = date_parse_from_format("Y-m-d", $dnow);
              $mois = $d["month"];
              $annee = $d["year"];
              $anneMtn = date("Y");
              $anneeMtnint = (int)$anneMtn;
              $result;
              if($mois>=01 && $mois<=03)
              {
                $result = 1;
              }
              elseif($mois>=04 && $mois<=06)
              {
                $result = 2;
              }
              elseif($mois>=10 && $mois<=12)
              {
                $result = 4;
              }
              else
              {
                $result = 3;
              }

              $leTrimestre = getTrimestre();

              //affichage des adherents avec une couleur particuliére selon leur date d'adhesion
              if ($difference > 365) {

                echo '<tr style=background-color:#C63632;>';
                echo '<td>'.$unAdherent['nom'].'</td>';
                echo '<td>'.$unAdherent['prenom'].'</td>';
                echo '<td>'.$unAdherent['adresse'].'</td>';
                //echo '<td>'.dateFr($unAdherent['dateAdhesion']).'</td>';
                echo '<td>'.$unAdherent['remarque'].'</td>';
                if($unAdherent['idTypeRepas'] == 1)
                {
                  echo '<td>Impossable</td>';
                }
                else {
                  echo '<td>Non impossable</td>';

                }
                echo '<td>'.'<div id=conteneurBtn><form action="ModifAdherent.php" id="modifadherent" method="POST"><input type="hidden" name="id" value='.$id.'><input class="btn btn-info" id="btn-view" type="submit" value="Modifier"/></form><form id="formSupp" method="POST" ><input type="hidden" name="id" value='.$id.'><button class="btn btn-danger" type="submit" id="btn-view" onclick="">Supprimer</button></form></td>';
                echo '</tr>';

              }else if (($result == $leTrimestre) && ($annee < $anneeMtnint)) {

                echo '<tr style=background-color:#f0ad4e;>';
                echo '<td>'.$unAdherent['nom'].'</td>';
                echo '<td>'.$unAdherent['prenom'].'</td>';
                echo '<td>'.$unAdherent['adresse'].'</td>';
                //echo '<td>'.dateFr($unAdherent['dateAdhesion']).'</td>';
                echo '<td>'.$unAdherent['remarque'].'</td>';
                if($unAdherent['idTypeRepas'] == 1)
                {
                  echo '<td>Impossable</td>';
                }
                else {
                  echo '<td>Non impossable</td>';

                }
                echo '<td>'.'<div id=conteneurBtn><form action="ModifAdherent.php" id="modifadherent" method="POST"><input type="hidden" name="id" value='.$id.'><input class="btn btn-info" id="btn-view" type="submit" value="Modifier"/></form><form id="formSupp" method="POST" ><input type="hidden" name="id" value='.$id.'><button class="btn btn-danger" type="submit" id="btn-view" onclick="">Supprimer</button></form></td>';
                echo '</tr>';

              }
              else{
                echo '<tr>';
                echo '<td>'.$unAdherent['nom'].'</td>';
                echo '<td>'.$unAdherent['prenom'].'</td>';
                echo '<td>'.$unAdherent['adresse'].'</td>';
                //echo '<td>'.dateFr($unAdherent['dateAdhesion']).'</td>';
                echo '<td>'.$unAdherent['remarque'].'</td>';
                if($unAdherent['idTypeRepas'] == 1)
                {
                  echo '<td>Impossable</td>';
                }
                else {
                  echo '<td>Non impossable</td>';

                }
                echo '<td><div id=conteneurBtn><form action="ModifAdherent.php" id="modifadherent" method="POST"><input type="hidden" name="id" value='.$id.'><input class="btn btn-info" id="btn-view" type="submit" value="Modifier"/></form><form id="formSupp" method="POST" id=suppAdherent ><input type="hidden" name="id" value='.$id.'><button class="btn btn-danger" type="submit" id="btn-view" onclick="">Supprimer</button></form></td>';
                echo '</tr>';
              }
            }

            if (isset($_SESSION['retour'])) {
              $_SESSION['retour'] = -2;
            }

            ?>
          </div>
        </tbody>
      </table>
      <form action="index.php" id="annulerfacturation">
        <input class="btn btn-info" type="submit" value="Retour">
      </form>

  </div>

</body>
</html>
