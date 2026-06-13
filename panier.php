<?php
require 'bootstrap.php';

if (!(!empty($_SESSION['client_carte']) || (!empty($_SESSION['client_nom']) && !empty($_SESSION['client_tel'])))) {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PANIER</title>
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
    
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/panier.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
</head>

<body class="fond-d-ecran">

  <nav class="header">
    <ul id="menu-burger">
      <li>
        <details class="dropdown">
          <summary>
            
          </summary>
            <ul dir="ltr">
              <li class="case"><a href="client-index.php" class="active">Accueil</a></li>

              <!-- FONCTION PHP QUI PERMET DE SAVOIR QUEL JOUR ON EST ET D'AFFICHER OU NON LE CONTENU -->
              <?php
              $aujourdhui = date('N');
              if ($aujourdhui == 2 || $aujourdhui == 6) {
              ?>
              <li class="case"><a href="reservation.php">Réservation</a></li>
              <?php
              } else {
              ?>
              <li class="case-indisponible"><a href="#">Réservation</a></li>
              <?php
              }
              ?>

              <li class="case"><a href="panier.php">Panier</a></li>
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

  <main>
    <?php

      if (isset($_SESSION['client_carte'])) {
          $num_carte = $_SESSION['client_carte'];
          
          try {

              $reqClient = $pdo->prepare("SELECT nom, prenom FROM clients WHERE num_carte_fidelite = :carte");
              $reqClient->execute([':carte' => $num_carte]);
              $client = $reqClient->fetch();

              if ($client) {

                  $reqRes = $pdo->prepare("SELECT type_panier, date_commande, date_retrait 
                                          FROM reservations 
                                          WHERE nom = :nom AND prenom = :prenom 
                                          ORDER BY date_commande DESC");
                  $reqRes->execute([
                      ':nom'    => $client['nom'],
                      ':prenom' => $client['prenom']
                  ]);

                  $mes_reservations = $reqRes->fetchAll();

                  echo "<br>
                        <article id=titre-top>
                          <h1>Mes réservations :</h1>
                        </article>";
                  if (count($mes_reservations) > 0) {
                      foreach ($mes_reservations as $res) {
                          echo "<div class=reservation-clients>";
                          echo "<h2>Panier réservé : </h2><p>Panier pour " . htmlspecialchars($res['type_panier']) . "</p>";
                          echo "<h2>Date de commande : </h2><p> " . htmlspecialchars($res['date_commande']) . "</p>";
                          echo "<h2>Date de retrait prévue : </h2><p> " . htmlspecialchars($res['date_retrait']) . "</p>";
                          echo "<div class=reserver>
                                <form action=enlever_commande.php method=POST onsubmit=\"return confirm('Êtes-vous sûr de vouloir annuler cette réservation ?');\">
                                <input type='hidden' name='type_panier' value='" . htmlspecialchars($res['type_panier']) . "'>
                                <input type='hidden' name='date_commande' value='" . htmlspecialchars($res['date_commande']) . "'>
                                <button type=submit>Retirer</button>
                                </form>
                                </div>";
                          echo "</div>";
                      }
                  } else {
                      echo "<p style=text-align:center>Vous n'avez pas encore fait de réservation.</p>";
                  }
              }
          } catch (PDOException $e) {
              echo "Erreur d'affichage : " . $e->getMessage();
          }
      }
    ?>

    <div class="boutons">
      <button id="paiement">Payer</button>
      <a href="client-index.php" id="retour">Retour à l'accueil</a>
    </div>

  </main>

</body>

</html>