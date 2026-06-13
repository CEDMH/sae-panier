<?php
require 'bootstrap.php';

if (empty($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin-login.php');
    exit;
}


// ============ NOMBRE DE PANIERS PAR MOIS ============ //
$requete1 = $pdo->prepare("
    SELECT 
    DATE_FORMAT(date_retrait, '%Y-%m') AS mois,
    DATE_FORMAT(date_retrait, '%M %Y') AS mois_label,
    COUNT(*) AS nombre
    FROM reservations
    GROUP BY mois
    ORDER BY mois ASC
");
$requete1->execute();
$paniers_par_mois = $requete1->fetchAll();

// ============ MOYENNE DE PANIERS PAR MOIS ============ //
$total_paniers = array_sum(array_column($paniers_par_mois, 'nombre'));
$total_mois    = count($paniers_par_mois);
$moyenne       = $total_mois > 0 ? round($total_paniers / $total_mois, 1) : 0;

// ============ MOIS LE PLUS RENTABLE ============ //
$mois_max = null;
$max      = 0;
foreach ($paniers_par_mois as $mois) {
    if ($mois['nombre'] > $max) {
        $max      = $mois['nombre'];
        $mois_max = $mois['mois_label'];
    }
}

// ============ ON PRÉPARE LES DONNÉES POUR LE JS ============ //
$labels  = array_column($paniers_par_mois, 'mois_label');
$valeurs = array_column($paniers_par_mois, 'nombre');

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
    <link href="./assets/css/admin-index.css" rel="stylesheet">

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
              <li class="case"><a href="admin-index.php" class="active">Accueil</a></li>
              <li class="case"><a href="admin-reservations.php">Paniers</a></li>
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
      <h1>Statistiques</h1>
      <p>Vous pouvez voir les statistiques des ventes de paniers.</p>
    </article>

    <section>
      <h2>Résumé</h2>
      <p>Moyenne de paniers retirés par mois : <strong><?php echo $moyenne ?></strong></p>
      <p>Mois le plus rentable : <strong><?php echo htmlspecialchars($mois_max) ?></strong> avec <strong><?php echo $max ?></strong> paniers</p>
    </section>

    <section>
      <h2>Paniers retirés par mois</h2>
      <canvas id="graphique-barres"></canvas>
    </section>

    <section>
      <h2>Répartition par mois</h2>
      <canvas id="graphique-camembert"></canvas>
    </section>

    <script>
      const labels  = <?php echo json_encode($labels) ?>;
      const valeurs = <?php echo json_encode($valeurs) ?>;
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="assets/javascript/statistiques.js"></script>

  </main>

</body>

</html>