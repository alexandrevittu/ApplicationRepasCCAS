<?php

function connexion(){
  $dsn='mysql:dbname=transport_ccas;host=localhost';
  $username='root';
  $passwd='';

  try{
    $dbh=new PDO($dsn,$username,$passwd);
  } catch (Exception $e) {
    echo 'Connexion échouée : '.$e->getMessage();
  }
  return $dbh;
}

function AjoutAdherent($nom,$prenom,$adresse,$dateadhesion,$remarque,$impot){
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into adherents values (NULL,:nom,:prenom,:adresse,:dateadhesion,:remarque,:impot)");
  $PdoStatement->bindvalue("nom",$nom);
  $PdoStatement->bindvalue("prenom",$prenom);
  $PdoStatement->bindvalue("adresse",$adresse);
  $PdoStatement->bindvalue("dateadhesion",$dateadhesion);
  $PdoStatement->bindvalue("remarque",$remarque);
  $PdoStatement->bindvalue("impot",$impot);
  if($PdoStatement->execute()){
    $PdoStatement->closeCursor();
    $dbh=null;
    return true;
  }
  else{
    //throw new Exception("Erreur ajout d'adherent");
    return false;
  }
}
function Getidadherent($nom,$prenom)
{
  $dbh = connexion();
  try{
    $pdoStatement = $dbh->prepare("select id from adherents where nom=:nom and prenom=:prenom");
    $pdoStatement->bindvalue("nom",$nom);
    $pdoStatement->bindvalue("prenom",$prenom);
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation de l'id de l'adherent ");
  }
}
function getTrimestre()
{
  $mois = date('m');
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
  return $result;
}
function ajouttrajetcourtparadherent($idadherent,$trimestre,$nbtrajet)
{
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into tarifs values (NULL,:nbtrajet,:idadherent,2,:idtrimestre,NULL)");
  $PdoStatement->bindvalue("idadherent",$idadherent);
  $PdoStatement->bindvalue("idtrimestre",$trimestre);
  $PdoStatement->bindvalue("nbtrajet",$nbtrajet);
  if($PdoStatement->execute()){
    $PdoStatement->closeCursor();
    $dbh=null;
  }
  else{
    throw new Exception("Erreur ajout trajet cours d'adherent");
  }
}
function ajoutadhesionparadherent($idadherent,$trimestre,$date)
{
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into tarifs values (NULL,1,:idadherent,5,:idtrimestre,:date)");
  $PdoStatement->bindvalue("date",$date);
  $PdoStatement->bindvalue("idadherent",$idadherent);
  $PdoStatement->bindvalue("idtrimestre",$trimestre);
  if($PdoStatement->execute()){
    $PdoStatement->closeCursor();
    $dbh=null;
  }
  else{
    throw new Exception("Erreur ajout adhesion de l'adherent");
  }
}
function ajouttrajetmoyenparadherent($idadherent,$trimestre,$nbtrajet)
{
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into tarifs values (NULL,:nbtrajet,:idadherent,3,:idtrimestre,NULL)");
  $PdoStatement->bindvalue("idadherent",$idadherent);
  $PdoStatement->bindvalue("idtrimestre",$trimestre);
  $PdoStatement->bindvalue("nbtrajet",$nbtrajet);
  if($PdoStatement->execute()){
    $PdoStatement->closeCursor();
    $dbh=null;
  }
  else{
    throw new Exception("Erreur ajout trajet moyen d'adherent");
  }
}
function ajouttrajetlongparadherent($idadherent,$trimestre,$nbtrajet)
{
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into tarifs values (NULL,:nbtrajet,:idadherent,4,:idtrimestre,NULL)");
  $PdoStatement->bindvalue("idadherent",$idadherent);
  $PdoStatement->bindvalue("idtrimestre",$trimestre);
  $PdoStatement->bindvalue("nbtrajet",$nbtrajet);
  if($PdoStatement->execute()){
    $PdoStatement->closeCursor();
    $dbh=null;
  }
  else{
    throw new Exception("Erreur ajout trajet long d'adherent");
  }
}
function ListerAdherent(){

  $dbh = connexion();
  try {

    $pdoStatement = $dbh->prepare("select * from adherents");
    $pdoStatement->execute();

    $result = $pdoStatement->fetchAll();
    return $result;
  } catch (Exception $e) {

    throw new Exception("erreur lors de la recuperation des adhérents " . $ex);

  }

}
function dateFr($date)
{
  return strftime('%d-%m-%Y',strtotime($date));
}
function GetAdherent($id)
{
  $dbh = connexion();
  try{
    $pdoStatement = $dbh->prepare("select * from adherents where id=:id");
    $pdoStatement->bindvalue("id",$id);
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation de l'adherent ");
  }
}
function ModifAdherent($id,$nom,$prenom,$adresse,$date,$remarque)
{
  $dbh = connexion();
  $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
  $pdoStatement = $dbh->prepare("update adherents set nom =:nom,prenom =:prenom,adresse =:adresse,dateAdhesion = :dateAdhesion,remarque = :remarque where id = :id ");
  $pdoStatement->bindvalue("nom",$nom);
  $pdoStatement->bindvalue("prenom",$prenom);
  $pdoStatement->bindvalue("adresse",$adresse);
  $pdoStatement->bindvalue("dateAdhesion",$date);
  $pdoStatement->bindvalue("remarque",$remarque);
  $pdoStatement->bindvalue("id",$id);
  if($pdoStatement->execute())
  {

    $pdoStatement->closeCursor();
    $dbh=null;
  }
  else
  {
    throw new Exception("Erreur modification d'adherent");
  }
}
function SupprimerAdherent($idAdherentSupp){
  $pdo = connexion();
  $requete=$pdo->prepare("DELETE from adherents WHERE id= :idAdherentSupp ");
  $requete->bindValue(":idAdherentSupp",$idAdherentSupp);
  $requete->execute();
}
function ModifTarifNonImposable($prix)
{
  $dbh = connexion();
  $pdoStatement = $dbh ->prepare("update typerepas set prix = :prix WHERE id='2'");
  $pdoStatement->bindvalue("prix",$prix);
  if($pdoStatement->execute())
  {
    $pdoStatement->closeCursor();
    $dbh=null;
  }
  else
  {
    throw new Exception("Erreur modif prix non imposable");
  }
}
function ModifTarifImposable($prix)
{
  $dbh = connexion();
  $pdoStatement = $dbh ->prepare("update typerepas set prix = :prix WHERE id='1'");
  $pdoStatement->bindvalue("prix",$prix);
  if($pdoStatement->execute())
  {
    $pdoStatement->closeCursor();
    $dbh=null;
  }
  else
  {
    throw new Exception("Erreur modif prix imposable");
  }
}
function GetTarif()
{
  $dbh = connexion();
  try{

    $pdoStatement = $dbh->prepare("select prix from typerepas");
    $pdoStatement->execute();

    $result = $pdoStatement->fetchAll();
    return $result;

  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation des tarif repas");
  }
}

function ajoutRepasParAdherent($idadherent,$trimestre)
{
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into repas values (NULL,:idadherent,0,:idtrimestre)");
  $PdoStatement->bindvalue("idadherent",$idadherent);
  $PdoStatement->bindvalue("idtrimestre",$trimestre);
  if($PdoStatement->execute()){
    $PdoStatement->closeCursor();
    $dbh=null;
  }
  else{
    throw new Exception("Erreur ajout repas d'aherent");
  }
}
function getTrimestreLib($idTrimestre){
  $dbh = connexion();
  try{
    $pdoStatement = $dbh->prepare("select libelle FROM trimestre WHERE id = :idTrimestre");
    $pdoStatement->bindValue("idTrimestre",$idTrimestre);
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
    $dbh = null;
  }
  catch(Exception $e)
  {
    throw new Exception("Erreur...");
  }
}
function orderTrimestre(){

  $trimestre = getTrimestre();
  $libelleTrimestre = getTrimestreLib($trimestre);
  $libelleTr = utf8_encode($libelleTrimestre['libelle']);
  $date = date('Y');

$lesTrimestres = array();

  if ($libelleTr == "Janvier/Février/Mars") {

    $lesTrimestres = array(
      1 => array(
        "libelle" => "Avril/Mai/Juin",
        "annee" => strval($date-1),
        "idTrimestre" => 2,
      ),
      2 => array(
        "libelle" => "Juillet/Aout/Septembre",
        "annee" => strval($date-1),
        "idTrimestre" => 3,
      ),
      3 => array(
        "libelle" => "Octobre/Novembre/Decembre",
        "annee" => strval($date-1),
        "idTrimestre" => 4,
      ),
      4 => array(
        "libelle" => $libelleTr,
        "annee" => $date,
        "idTrimestre" => $trimestre,
      )
    );
  }elseif ($libelleTr == "Avril/Mai/Juin") {

    $lesTrimestres = array(
      1 => array(
        "libelle" => "Juillet/Aout/Septembre",
        "annee" => strval($date-1),
        "idTrimestre" => 3,
      ),
      2 => array(
        "libelle" => "Octobre/Novembre/Decembre",
        "annee" => strval($date-1),
        "idTrimestre" => 4,
      ),
      3 => array(
        "libelle" => "Janvier/Février/Mars",
        "annee" => $date,
        "idTrimestre" => 1,
      ),
      4 => array(
        "libelle" => $libelleTr,
        "annee" => $date,
        "idTrimestre" => 2,
      )
    );
  }elseif ($libelleTr == "Juillet/Aout/Septembre") {

        $lesTrimestres = array(
          1 => array(
            "libelle" => "Octobre/Novembre/Decembre",
            "annee" => strval($date-1),
            "idTrimestre" => 4,
          ),
          2 => array(
            "libelle" => "Janvier/Février/Mars",
            "annee" => $date,
            "idTrimestre" => 1,
          ),
          3 => array(
            "libelle" => "Avril/Mai/Juin",
            "annee" => $date,
            "idTrimestre" => 2,
          ),
          4 => array(
            "libelle" => $libelleTr,
            "annee" => $date,
            "idTrimestre" => 3,
          )
        );
  }elseif ($libelleTr == "Octobre/Novembre/Décembre") {
    $lesTrimestres = array(
      1 => array(
        "libelle" => "Janvier/Février/Mars",
        "annee" => $date,
        "idTrimestre" => 1,
      ),
      2 => array(
        "libelle" => "Avril/Mai/Juin",
        "annee" => $date,
        "idTrimestre" => 2,
      ),
      3 => array(
        "libelle" => "Juillet/Aout/Septembre",
        "annee" => $date,
        "idTrimestre" => 3,
      ),
      4 => array(
        "libelle" => $libelleTr,
        "annee" => $date,
        "idTrimestre" => 4,
      )
    );
  }
  return $lesTrimestres;
}
function Getnbtrajetcours($id)
{
  $dbh = connexion();
  try
  {
    $pdoStatement = $dbh->prepare("select nbrepas,idAdherent from repas inner join adherents on repas.idAdherent = adherents.id where idTrimestre =:id");
    $pdoStatement->bindvalue("id",$id);
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
    $dbh=null;
  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation de l'adherent ");
  }
}
function ModifNbRepasParAdherent($idadherent,$trimestre,$nbrepas)
{
  $dbh = connexion();
  $pdoStatement = $dbh->prepare("update repas set nbrepas = :nbrepas WHERE idAdherent=:idadherent AND idTrimestre=:trimestre");
  $pdoStatement->bindvalue("nbrepas",$nbrepas);
  $pdoStatement->bindvalue("trimestre",$trimestre);
  $pdoStatement->bindvalue("idadherent",$idadherent);
  if($pdoStatement->execute())
  {
    $pdoStatement->closeCursor();
    $dbh=null;
  }
  else
  {
    throw new Exception("Erreur modif trajet court par adherent");
  }
}
function GetPrixImposable()
{
  $dbh = connexion();
  try
  {
    $pdoStatement = $dbh->prepare("select prix from typerepas where id =1");
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
    $dbh=null;
  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation du prix d'un trajet cours");
  }
}
function GetPrixNonImposable()
{
  $dbh = connexion();
  try
  {
    $pdoStatement = $dbh->prepare("select prix from typerepas where id =2");
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
    $dbh=null;
  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation du prix d'un trajet cours");
  }
}
function Getnbrepas($id)
{
  $dbh = connexion();
  try
  {
    $pdoStatement = $dbh->prepare("select nbrepas,idAdherent from repas where idTrimestre =:id");
    $pdoStatement->bindvalue("id",$id);
    $pdoStatement->execute();
    $result = $pdoStatement->fetchAll();
    return $result;
    $dbh=null;

  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation de l'adherent ");
  }
}
function GetnbRepasParAdherent($id,$trimestre)
{
  $dbh = connexion();
  try
  {
    $pdoStatement = $dbh->prepare("select nbrepas from repas where idTrimestre =:trimestre AND idAdherent =:id");
    $pdoStatement->bindvalue("trimestre",$trimestre);
    $pdoStatement->bindvalue("id",$id);
    $pdoStatement->execute();
    $result = $pdoStatement->fetch();
    return $result;
    $dbh=null;

  }
  catch(Exception $e)
  {
    throw new Exception("erreur lors de la recuperation de l'adherent ");
  }
}
 ?>
