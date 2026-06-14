<?php
require 'bootstrap.php';
// recuperation de infos suivante stocker dans $_SESSION //
if (isset($_SESSION['client_carte']) && isset($_POST['type_panier'], $_POST['date_retrait'])) {

    $num_carte = $_SESSION['client_carte'];
    $type_panier = $_POST['type_panier'];
    $date_retrait = $_POST['date_retrait'];
// on vient recupperer le numero de carte du client //
    try {
        $reqClient = $pdo->prepare("SELECT nom, prenom FROM clients WHERE num_carte_fidelite = :carte");
        $reqClient->execute([':carte' => $num_carte]);
        $client = $reqClient->fetch();
// si tout correspond alors on "INSERT INTO" le panier que le client a selectionner avec redirection et message de succée //
        if ($client) {
            $nom = $client['nom'];
            $prenom = $client['prenom'];
            $date_commande = date('Y-m-d H:i:s');
            $date_panier = $date_retrait;
            $envoi_de_la_cmd = $pdo->prepare("INSERT INTO reservations (nom, prenom, type_panier, date_panier, date_commande, date_retrait) VALUES (:nom, :prenom, :type_panier, :date_panier, :date_commande, :date_retrait)");
            $envoi_de_la_cmd->execute([':nom' => $nom,':prenom' => $prenom,':type_panier' => $type_panier,':date_panier' => $date_panier,':date_commande' => $date_commande,':date_retrait' => $date_retrait]);
            header("Location: reservation.php?status=success");
            exit();

        } else {

            header("Location: index.php?error=client_introuvable");
            exit();

        }

    } catch (PDOException $erreur) {
        die("Erreur lors de la réservation : " . $erreur->getMessage());
    }
// redirection si on essaye de se connecter avec le liens directement //
} else {

    header("Location: index.php");
    exit();

}
?>