<?php
require 'bootstrap.php';
// recuperation de infos suivante stocker dans $_SESSION //
if (isset($_SESSION['client_carte']) && isset($_POST['type_panier'], $_POST['date_commande'])) {
    
    $num_carte = $_SESSION['client_carte'];
    $type_panier = $_POST['type_panier'];
    $date_commande = $_POST['date_commande'];
// on vient recupperer le numero de carte du client //  
    try {
        $reqClient = $pdo->prepare("SELECT nom, prenom FROM clients WHERE num_carte_fidelite = :carte");
        $reqClient->execute([':carte' => $num_carte]);
        $client = $reqClient->fetch();
// si tout correspond alors on "DELETE FROM" le panier que le client a selectionner //
        if ($client) {
            $nom = $client['nom'];
            $prenom = $client['prenom'];
            $retirer_la_cmd = $pdo->prepare("DELETE FROM reservations WHERE nom = :nom AND prenom = :prenom AND type_panier = :type_panier AND date_commande = :date_commande");
            $retirer_la_cmd->execute([':nom' => $nom,':prenom' => $prenom,':type_panier' => $type_panier,':date_commande' => $date_commande]);
            header("Location: panier.php?status=deleted");
            exit();

        } else {

            header("Location: client-index.php?error=access_denied");
            exit();

        }

    } catch (PDOException $erreur) {
        die("Erreur lors de l'annulation : " . $erreur->getMessage());
    }
// redirection si on essaye de se connecter avec le liens directement //
} else {

    header("Location: client-index.php");
    exit();
    
}
?>