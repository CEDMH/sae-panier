<?php
require 'bootstrap.php';

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}


// requete sql qui va chercher la date de retrait pour l'organiser en année/mois et le mettre dans mois //
// inversement ou on organise en mois/année et on le met dans mois_pannier //
// on conpte aussi toute les ligne de reservation pour le mettre dans nombre //
$requete1 = $pdo->prepare("
    SELECT 
    DATE_FORMAT(date_retrait, '%Y-%m') AS mois,
    DATE_FORMAT(date_retrait, '%M %Y') AS mois_panier,
    COUNT(*) AS nombre
    FROM reservations
    GROUP BY mois
    ORDER BY mois ASC
");
$requete1->execute();
$paniers_mois = $requete1->fetchAll();

// on effectue la moyenne en commancant par additioner toute la colonne 'nombre' et $total_panier //
// on compte le total de $paniers_par_mois //
// puis dans $moyenne on verrifi si il y a au moins 1 reservation et on calcule la moyenne en arrodisant // 
$total_paniers = array_sum(array_column($paniers_mois, 'nombre'));
$total_mois    = count($paniers_mois);
$moyenne       = $total_mois > 0 ? round($total_paniers / $total_mois, 1) : 0;

// on definit $mois_max  et $max à 0 //
// puis on parcourt $panier_mois pour que si le 'nombre' de panier est plus haut que $max on met a jour $max et $mois-max //
$mois_max = null;
$max      = 0;
foreach ($paniers_mois as $mois) {
    if ($mois['nombre'] > $max) {
        $max      = $mois['nombre'];
        $mois_max = $mois['mois_panier'];
    }
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STATISTIQUES</title>
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
    <link href="./assets/css/statistiques.css" rel="stylesheet">

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
              <li class="case"><a href="admin-index.php">Accueil</a></li>
              <li class="case"><a href="admin-reservations.php">Paniers</a></li>
              <li class="case"><a href="admin-reservations.php">Réservations</a></li>
              <li class="case"><a href="admin-cartes.php">Cartes</a></li>
              <li class="case"><a href="admin-statistiques.php" class="active">Statistiques</a></li>
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
      <h1>Statistiques</h1>
      <p>Vous pouvez voir les statistiques des ventes de paniers.</p>
    </article>
<!-- On affiche la moyenne qui est $moyenne -->
    <section>
      <h2>Moyenne de paniers retirés par mois</h2>
      <p>La moyenne est de : <strong><?php echo $moyenne ?></strong></p>
    </section>
<!-- On affiche le mois le plus retable qui est $mois_max avec le nombre de panier ($max) -->      
    <section>
      <h2>Mois le plus rentable</h2>
      <p>Le mois le plus rentable est : <strong><?php echo htmlspecialchars($mois_max) ?></strong> avec <strong><?php echo $max ?></strong> paniers</p>
    </section>
<!-- On parcourt le tableau $panier_mois pour en afficher la date et le nombre de paniers -->
    <section>
      <h2>Nombre de paniers par mois</h2>
      <?php foreach ($paniers_mois as $mois): ?>
        <p><?php echo htmlspecialchars($mois['mois_panier']) ?> : <strong><?php echo $mois['nombre'] ?></strong> paniers</p>
      <?php endforeach; ?>
    </section>

  </main>

</body>

</html>