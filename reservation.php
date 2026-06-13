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
    <title>ACCUEIL</title>
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
    <link href="./assets/css/reservation.css" rel="stylesheet">

    <script src="assets/javascript/dm-lm.js"></script>
</head>

<body class="fond-d-ecran">

  <!-- NAV/HEADER -->
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

  <!-- QAUTRE SAUTS A LA LIGNE BRUTAUX POUR QUE LE MAIN NE SOIT PAS CACHÉ PAR LE HEADER/NAV QUI EST EN POSITION FIXE -->
  <br>
  <br>
  <br>

  <main>
    
    <!-- FONCTION PHP QUI PERMET DE SAVOIR QUEL JOUR ON EST ET D'AFFICHER OU NON LE CONTENU -->

    <?php

      $aujourdhui = date('N');

      if ($aujourdhui == 2 || $aujourdhui == 6) {
    ?>
      
      <article style="margin-top:15px;">
        <h1 style="text-align:center;">Les super paniers à réserver :</h1>
        <p style="text-align:center;">Voici nos petits bijoux de cette semaine...</p>
      </article>
      
      <div class="les-paniers">

        <div class="paniers">
          <h2>Panier 1 personne</h2>
          <img src="./assets/image/panier-m.jpg" class="image-panier">
          <p><?php
          $sql = 'SELECT description FROM paniers WHERE id = 1';
          $reponse = $pdo->query($sql); 
          $descpanier = $reponse->fetch();
          echo $descpanier['description'];
          ?></p>
          <p class="price"><?php
          $sql = 'SELECT prix FROM paniers WHERE id = 1';
          $reponse = $pdo->query($sql); 
          $descpanier = $reponse->fetch();
          echo $descpanier['prix'];
          ?>€</p>
          <div class="reserver">
            <form action="ajouter_commande.php" method="POST" onsubmit="return confirm('Vous-allez ajouter cette réservation à votre panier, cliquez ok pour continuer.');">
              <input type="hidden" name="type_panier" value="1p">
              <input type="hidden" name="date_retrait" value="2026-07-11">
              <button type="submit">Ajouter à mon panier</button>
            </form>
          </div>
        </div>

        <div class="paniers">
          <h2>Panier 2 personnes</h2>
          <img src="./assets/image/panier-l.jpg" class="image-panier">
          <p><?php
          $sql = 'SELECT description FROM paniers WHERE id = 6';
          $reponse = $pdo->query($sql); 
          $descpanier = $reponse->fetch();
          echo $descpanier['description'];
          ?></p>
          <p class="price"><?php
          $sql = 'SELECT prix FROM paniers WHERE id = 6';
          $reponse = $pdo->query($sql); 
          $descpanier = $reponse->fetch();
          echo $descpanier['prix'];
          ?>€</p>
          <div class="reserver">
            <form action="ajouter_commande.php" method="POST" onsubmit="return confirm('Vous-allez ajouter cette réservation à votre panier, cliquez ok pour continuer.');">
              <input type="hidden" name="type_panier" value="2p">
              <input type="hidden" name="date_retrait" value="2026-07-11"> 
              <button type="submit">Ajouter à mon panier</button>
            </form>
          </div>
        </div>

        <div class="paniers">
          <h2>Panier 3-4 personnes</h2>
          <img src="./assets/image/panier-xl.jpg" class="image-panier">
          <p><?php
          $sql = 'SELECT description FROM paniers WHERE id = 3';
          $reponse = $pdo->query($sql); 
          $descpanier = $reponse->fetch();
          echo $descpanier['description'];
          ?></p>
          <p class="price"><?php
          $sql = 'SELECT prix FROM paniers WHERE id = 3';
          $reponse = $pdo->query($sql); 
          $descpanier = $reponse->fetch();
          echo $descpanier['prix'];
          ?>€</p>
          <div class="reserver">
            <form action="ajouter_commande.php" method="POST" onsubmit="return confirm('Vous-allez ajouter cette réservation à votre panier, cliquez ok pour continuer.');">
              <input type="hidden" name="type_panier" value="3p">
              <input type="hidden" name="date_retrait" value="2026-07-11"> 
              <button type="submit">Ajouter à mon panier</button>
            </form>
          </div>
        </div>

      </div>

    <?php
      } else {
    ?>

    <article class="message-fermeture">
      <div class="paniers">
        <h2>Réservations fermées</h2>
        <p>Petit malin ! Tu pensais y arriver en passant par là ? Bien joué mais raté ! Reviens bientôt pour réserver nos nouveaux paniers !</p>
      </div>
    </article>

    <?php
      }
    ?>
    
  </main>

</body>

</html>