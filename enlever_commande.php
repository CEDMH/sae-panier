<?php
require 'bootstrap.php';

if (isset($_SESSION['client_carte']) && isset($_POST['type_panier'], $_POST['date_commande'])) {
    
    $num_carte = $_SESSION['client_carte'];
    $type_panier = $_POST['type_panier'];
    $date_commande = $_POST['date_commande'];
    
    try {

        $reqClient = $pdo->prepare("SELECT nom, prenom FROM clients WHERE num_carte_fidelite = :carte");
        $reqClient->execute([':carte' => $num_carte]);
        $client = $reqClient->fetch();

        if ($client) {
            $nom = $client['nom'];
            $prenom = $client['prenom'];
            
            $retirer_la_cmd = $pdo->prepare("DELETE FROM reservations WHERE nom = :nom AND prenom = :prenom AND type_panier = :type_panier AND date_commande = :date_commande");
            $retirer_la_cmd->execute([
                ':nom'           => $nom,
                ':prenom'        => $prenom,
                ':type_panier'   => $type_panier,
                ':date_commande' => $date_commande
            ]);

            header("Location: panier.php?status=deleted");
            exit();

        } else {

            header("Location: client-index.php?error=access_denied");
            exit();

        }

    } catch (PDOException $e) {
        die("Erreur lors de l'annulation : " . $e->getMessage());
    }

} else {

    header("Location: client-index.php");
    exit();
    
}
?>