<?php
require 'bootstrap.php';

if (!(!empty($_SESSION['client_carte']) || (!empty($_SESSION['client_nom']) && !empty($_SESSION['client_tel'])))) {
    header('Location: index.php');
    exit;
}

// Cette fonction va récupérer toutes les informations du tableau paniers de la base de donnée pour les stocker dans la variable $liste_paniers.
$requete = $pdo->query("SELECT type, description, prix, date_retrait FROM paniers");
$liste_paniers = $requete->fetchAll();
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
              <li class="case"><a href="client-index.php">Accueil</a></li>

              <!-- FONCTION PHP QUI PERMET DE SAVOIR QUEL JOUR ON EST ET D'AFFICHER OU NON LE CONTENU -->
              <?php
              $aujourdhui = date('N');
              if ($aujourdhui == 2 || $aujourdhui == 3) {
              ?>
              <li class="case"><a href="reservation.php" class="active">Réservation</a></li>
              <?php
              } else {
              ?>
              <li class="case-indisponible"><a href="#">Réservation</a></li>
              <?php
              }
              ?>

              <li class="case"><a href="panier.php">Panier</a></li>
              <li class="case"><a href="a-propos.php">À propos</a></li>
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

      if ($aujourdhui == 2 || $aujourdhui == 3) {
    ?>
      
      <article>
        <h1>Les super paniers à réserver :</h1>
        <p>Voici nos petits bijoux de cette semaine...</p>
      </article>
      
      <div class="les-paniers">
        <?php
        // Cette fonction liste tous les paniers rentrés dans la base de donnée par l'administrateur et les propose aux clients qui peuvent réserver celui qui veulent en appuyant sur le bouton et envoie en POST
        if (count($liste_paniers) > 0) {
            foreach ($liste_paniers as $panier) { ?>
              <div class="paniers">
                <h2>Format du panier: <?php echo htmlspecialchars($panier['type']);?></h2>
                <img src="./assets/image/panier.jpg" class="image-panier">
                <p><?php echo htmlspecialchars($panier['description']); ?></p>
                <p class="price"><?php echo htmlspecialchars((string)$panier['prix']);?>€</p>
                <div class="reserver">
                  <form action="ajouter_commande.php" method="POST" onsubmit="return confirm('Voulez-vous ajouter cette réservation à votre panier ?');">
                    <input type="hidden" name="type_panier" value="<?php echo htmlspecialchars($panier['type']); ?>">
                    <input type="hidden" name="date_retrait" value="<?php echo htmlspecialchars($panier['date_retrait']); ?>"> 
                    <button type="submit" class="ajt-panier">Ajouter à mon panier</button>
                  </form>
                </div>
              </div>
      <?php } } else { ?>
          <!-- Si aucun panier n'est disponible dans la base de donnée alors ça revoit ce message là. -->
          <p>Aucun panier n'est disponible à la réservation pour le moment.</p>
      <?php } ?>
      </div>

    <?php
      } else {
    ?>

    <article class="message-fermeture">
        <h1>Réservations fermées</h1>
        <p>Petit malin ! Tu pensais y arriver en passant par là ? Bien joué mais raté ! Reviens bientôt pour réserver nos nouveaux paniers !</p>
    </article>

    <?php
      }
    ?>
    
  </main>

</body>

</html>