<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Facturation</title>
  <?php
    include_once "header.php";
    include_once "fonctions/fonctions.php";
    $lesAdherents = ListerAdherent();
   ?>
   <h2 style="text-align:center;">Facturation</h2>
</head>
<body>
  <div id="conteneur">
    <table class="table table-striped table-hover table-responsive no-footer table-bordered" id="example">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Prénom</th>
          <th>Adresse</th>
          <th>Nombre de repas</th>
          <th>Total</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th  style="text-align:right">Total:</th>
          <th></th>
        </tr>
      </tfoot>
  <?php
  $prix = 0;
  $prixglobal=0;
  $priximposable = GetPrixImposable();
  $prixnonumposable = GetPrixNonImposable();
  $trimestre = getTrimestre();    //recupere le trimestre en cours
  $nbrepas = Getnbrepas($trimestre);
    if($trimestre == 1)         //affiche le trimestre en cours
    {
      echo 'Trimestre actuel : Janvier/Fevrier/Mars';
    }
    elseif($trimestre == 2)
    {
      echo 'Trimestre actuel : Avril/Mai/Juin';
    }
    elseif($trimestre == 3)
    {
      echo 'Trimestre actuel : Juillet/Aout/Septembre';
    }
    elseif($trimestre == 4)
    {
      echo 'Trimestre actuel : Octobre/Novembre/Décembre';
    }
    foreach($lesAdherents as $unAdherent)
    {
      echo '<td>'.$unAdherent['nom'].'</td>';
      echo '<td>'.$unAdherent['prenom'].'</td>';
      echo '<td>'.$unAdherent['adresse'].'</td>';
      foreach($nbrepas as $nbrepasparadherent)
      {
        if($nbrepasparadherent['idAdherent'] == $unAdherent['id'])
        {
          echo '<td>'.$nbrepasparadherent['nbrepas'].'</td>';
          if($unAdherent['idTypeRepas'] == 1)
          {
            $prix = $nbrepasparadherent['nbrepas']*$priximposable['prix'];
          }
          if($unAdherent['idTypeRepas'] == 2)
          {
            $prix = $nbrepasparadherent['nbrepas']*$prixnonumposable['prix'];
          }
          echo '<td>'.$prix.'</td>';
          echo '</tr>';
        }
        $prixglobal += $prix;
      }
    }
   ?>
  </table>
  <input class="btn btn-info" onclick="window.location.href='index.php'" type="submit" value="Retour" class="buttonadherent">
</div>
</body>
</html>
<script>                                                  <!--configuration du tableau -->
  $(document).ready(function() {
    $('#example').dataTable( {
      "footerCallback": function ( tfoot, data, start, end, display ) {
          var api = this.api(), data;           <!--fonction calcul le total de tout les adherents -->

          var intVal = function ( i ) {
            return typeof i === 'string' ?        <!--test du type + convertion en int -->
              i.replace(/[\€,]/g, '')*1 :
              typeof i === 'number' ?
                i : 0;
          };

          total = api
            .column( 4 )                           <!--addition des totals de chaque adherent -->
            .data()
            .reduce( function (a, b) {
              return intVal(a) + intVal(b);
            }, 0 );

            $( api.column( 4 ).footer() ).html(       <!--affichage dans le footer a la collone numero 7 -->
              total.toFixed(2)+'€'
            );
          },

          buttons: [
            { extend: 'print', text: '<span class="glyphicon glyphicon-print"></span> Imprimer' , className: 'btn btn-info', footer:true,title: 'Facturation'},
          ],
          pagingType: "simple_numbers",
          lengthMenu:[5,10,15,20,25],         <!-- affichage possible a 5,10,15,20 et 25 par pages -->
          pageLength: 20,                     <!-- par default afficher a 20 ligne -->
          "dom": '<"top"lfi>rt<"bottom"Bp>',  <!-- Positionnement des boutons en fonction du tableau -->
          "oLanguage": {
      "sInfo": "Il y a un total de  _TOTAL_ adhérents (_START_ à _END_)"
        },
    });
  });
</script>
