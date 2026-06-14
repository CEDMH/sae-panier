<?php
require 'bootstrap.php';

//Vérifie la session admin ou pas
if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}

//Sélectionne dans la BDD les infos des reservations et fusionne le prénom et le nom du client avec celui inscrit sur la réserv et les classes par ordre ascendant //
$sql = "SELECT reservations.nom, reservations.prenom, reservations.type_panier, reservations.date_commande, reservations.date_retrait, clients.num_carte_fidelite 
        FROM reservations 
        LEFT JOIN clients ON reservations.nom = clients.nom AND reservations.prenom = clients.prenom
        ORDER BY reservations.nom ASC";
// le tout mit dans $reservations sous forme d'un tableau //
$reservations = $pdo->query($sql)->fetchAll();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GESTION RESERVATION</title>
    <link rel="icon" type="image/png" sizes="32x32" href="./assets/icons/favicon-32x32.png">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="./assets/icons/apple-touch-icon-180x180.png">

    <link href="assets/pico-main/css/pico.sand.css" rel="stylesheet">

    <link href="assets/font-awesome/css/fontawesome.css" rel="stylesheet">
    <link href="assets/font-awesome/css/brands.css" rel="stylesheet">
    <link href="assets/font-awesome/css/regular.css" rel="stylesheet">
    <link href="assets/font-awesome/css/solid.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sansita:ital,wght@0,400;0,700;0,800;0,900;1,400;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Martel:wght@200;300;400;600;700;800;900&display=swap" rel="stylesheet">
    
    <link href="./assets/css/style.css" rel="stylesheet">
    <link href="./assets/css/admin-reservation.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
    <script src="assets/javascript/reserv-retir.js"></script>
</head>

<body class="fond-d-ecran">

  <nav class="header">
    <ul id="menu-burger">
      <li>
        <details class="dropdown">
          <summary>
            
          </summary>
            <ul dir="ltr">
              <li class="case"><a href="admin-index.php">Accueil</a></li>
              <li class="case"><a href="admin-panier.php">Paniers</a></li>
              <li class="case"><a href="admin-reservations.php" class="active">Réservations</a></li>
              <li class="case"><a href="admin-cartes.php">Cartes</a></li>
              <li class="case"><a href="admin-statistiques.php">Statistiques</a></li>
              <li class="deco"><a href="./back/deconnexion.php">Déconnexion</a></li>
              <!-- LES TROIS BOUTONS DU NIGHT MOD, LIGHT MOD ET DYSLEXIC MOD -->
              <li><button onclick="modeJour()"><i class="fa-solid fa-sun"></i></button> <button onclick="modeNuit()"><i class="fa-solid fa-moon"></i></button> <button onclick="modeDys()"><i class="fa-solid fa-universal-access"></i></button></li>
            </ul>
        </details>
      </li>
    </ul>
    <ul>
      <li class="lecoindessaveurs"><img src="assets/image/titre.png" id="titre"></li>
    </ul>
    <ul>
      <li><img src="assets/image/logo.png" id="logo"></li>
    </ul>
  </nav>

  <!-- TROIS SAUTS A LA LIGNE BRUTAUX POUR QUE LE MAIN NE SOIT PAS CACHÉ PAR LE HEADER/NAV QUI EST EN POSITION FIXE -->
  <br>
  <br>
  <br>
  <br>

  <main>

      <article>
        <h1>Les réservations en cours :</h1>
        <p>Ici vous pouvez consulter toutes les réservations effectuées par vos clients et cocher s'ils ont récupéré ou non leur commandes.</p>
      </article>
      <div class="conteneur-tableau">
<!-- TABLEAU LISTE LES RESERV ET MR GRENIER PEUT COCHER RETIRE OU PAS GRACE A AU SCRIPT JS -->
        <table role="grid" class="tableau">
            <thead>
                <tr>
                  <th>Nom / Prénom</th>
                  <th>N° Carte Fidélité</th>
                  <th>Format / Type Panier</th>
                  <th>Date Retrait Prévue</th>
                  <th class="cellule-statut">Statut (cliquez pour changer)</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($reservations) > 0){
                     foreach ($reservations as $reserv => $res){ ?>
                        <tr>
                          <td><?php echo htmlspecialchars($res['nom']); ?> <?php echo htmlspecialchars($res['prenom']); ?></td>
                          <td><?php echo htmlspecialchars($res['num_carte_fidelite'] ?? 'Pas de carte'); ?></td>
                          <td><?php echo htmlspecialchars($res['type_panier']); ?></td>
                          <td><?php echo htmlspecialchars($res['date_retrait']); ?></td>
                          <td class="cellule-statut">
                              <button type="button" onclick="changerLeStatut(<?php echo $reserv; ?>)" id="btn-statut-<?php echo $reserv; ?>" class="btn-statut non-retire">Non retiré</button>
                          </td>
                        </tr>
                    <?php }} ?>
            </tbody>
        </table>
      </div>
    </main>

</body>

</html>