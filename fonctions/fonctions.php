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

function AjoutAdherent($nom,$prenom,$adresse,$dateadhesion,$remarque){
  $dbh= connexion();
  $PdoStatement = $dbh ->prepare("insert into adherents values (NULL,:nom,:prenom,:adresse,:dateadhesion,:remarque,1)");
  $PdoStatement->bindvalue("nom",$nom);
  $PdoStatement->bindvalue("prenom",$prenom);
  $PdoStatement->bindvalue("adresse",$adresse);
  $PdoStatement->bindvalue("dateadhesion",$dateadhesion);
  $PdoStatement->bindvalue("remarque",$remarque);
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
 ?>
