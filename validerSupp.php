<?php
include_once('fonctions/fonctions.php');

$id = $_POST['id'];
try {
    SupprimerAdherent($id);
    $_SESSION['nbLigne'] = -2;
    echo 'Suppression Réussie';
    echo '<script>location.reload()</script>';
    header('Location: ListeAdherents.php');
    exit();

} catch (Exception $e) {
    echo $e->getMessage();
}
